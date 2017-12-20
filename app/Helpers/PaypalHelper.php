<?php  
namespace App\Helpers;

use Log;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;

use App\Models\Package;

/**
 * @Desc Paypal related functions
 * @author Hung <hung@magiclabs.vn>
 */
class PaypalHelper
{
	/**
	 * Helper method for getting an APIContext for all calls
	 * @param string $clientId Client ID
	 * @param string $clientSecret Client Secret
	 * @return PayPal\Rest\ApiContext
	 */
	public static function getApiContext($clientId, $clientSecret, $config)
	{
	    // #### SDK configuration
	    // Register the sdk_config.ini file in current directory
	    // as the configuration source.
	    /*
	    if(!defined("PP_CONFIG_PATH")) {
	        define("PP_CONFIG_PATH", __DIR__);"word_wrap": false
	    }*/
	    


	    // ### Api context
	    // Use an ApiContext object to authenticate
	    // API calls. The clientId and clientSecret for the
	    // OAuthTokenCredential class can be retrieved from
	    // developer.paypal.com

	    $apiContext = new ApiContext(
	        new OAuthTokenCredential(
	            $clientId,
	            $clientSecret
	        )
	    );

	    // Comment this line out and uncomment the PP_CONFIG_PATH
	    // 'define' block if you want to use static file
	    // based configuration

	    $apiContext->setConfig($config);

	    // Partner Attribution Id
	    // Use this header if you are a PayPal partner. Specify a unique BN Code to receive revenue attribution.
	    // To learn more or to request a BN Code, contact your Partner Manager or visit the PayPal Partner Portal
	    // $apiContext->addRequestHeader('PayPal-Partner-Attribution-Id', '123123123');

	    return $apiContext;
	}

	public static function createPayment($apiContext, $userId, $packageId, $priceType)
	{
            
                $package = Package::queryByLanguage()->where('id', '=', $packageId)->first()->toArray();
                $priceDiscount = $priceType*(1-$package['discount']/100);
                
                $exchangeRate = config('magic_config.magic_settings.exchange_rate');
                //convert from VND to USD                
                $priceValue = round($priceDiscount/$exchangeRate,2);
            
		// ### Payer
		// A resource representing a Payer that funds a payment
		// For paypal account payments, set payment method
		// to 'paypal'.
		$payer = new Payer();
		$payer->setPaymentMethod("paypal");

		
                
		// ### Itemized information
		// (Optional) Lets you specify item wise
		// information
		$item = new Item();
		$item->setName($package['package_langs'][0]['name'])
		      ->setCurrency('USD')
		      ->setQuantity(1)
		      ->setPrice($priceValue);
		$itemList = new ItemList();
		$itemList->setItems(array($item));

		// ### Additional payment details
		// Use this optional field to set additional
		// payment information such as tax, shipping
		// charges etc.
		$details = new Details();
		$details->setShipping(0.0)
		        ->setTax(0.0)
		        ->setSubtotal($priceValue);

		// ### Amount
		// Lets you specify a payment amount.
		// You can also specify additional details
		// such as shipping, tax.
		$amount = new Amount();
		$amount->setCurrency('USD')
		       ->setTotal($priceValue)
		       ->setDetails($details);

		// ### Transaction
		// A transaction defines the contract of a
		// payment - what is the payment for and who
		// is fulfilling it. 
		$transaction = new Transaction();
		$transaction->setAmount($amount)
		            ->setItemList($itemList)
		            ->setDescription(json_encode([
		            	"package_id" => $packageId, 
                                "price_type" =>$priceType,
		            	//"number_of_property" => $package->number_of_property
	            	]))
		            ->setInvoiceNumber(uniqid());

		// ### Redirect urls
		// Set the urls that the buyer must be redirected to after 
		// payment approval/ cancellation.
		// $baseUrl = getBaseUrl();
		$baseUrl = "http://".$_SERVER['SERVER_NAME'];
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl("$baseUrl/paypal/execute/$userId/true")
		             ->setCancelUrl("$baseUrl/paypal/execute/$userId/false");

		// ### Payment
		// A Payment Resource; create one using
		// the above types and intent set to 'sale'
		$payment = new Payment();
		$payment->setIntent("sale")
		        ->setPayer($payer)
		        ->setRedirectUrls($redirectUrls)
		        ->setTransactions(array($transaction));

		// var_dump($payment->getTransactions()[0]->getItemList()->getItems()[0]->getPrice()); die;

		// ### Create Payment
		// Create a payment by calling the 'create' method
		// passing it a valid apiContext.
		// (See bootstrap.php for more on `ApiContext`)
		// The return object contains the state and the
		// url to which the buyer must be redirected to
		// for payment approval
		try {
		    $payment->create($apiContext);
		} catch (\Exception $ex) {                   
                    /* write log for debug */                    
                    \Illuminate\Support\Facades\Log::emergency($ex->getMessage());
                    return NULL;
		}

		// ### Get redirect url
		// The API response provides the url that you must redirect
		// the buyer to. Retrieve the url from the $payment->getApprovalLink()
		// method
		$approvalUrl = $payment->getApprovalLink();

		return $approvalUrl;
	}       
}
?>