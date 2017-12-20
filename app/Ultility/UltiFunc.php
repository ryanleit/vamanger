<?php
namespace App\Ultility;

use App\Menu;
use App\Restaurant;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UltiFunc{
    
    public function __construct()
    {
        
    }
    /**
     * 
     * @param type $request
     * @return type
     */
    public static function getLatLng($request){
         
        $data = [0=>"",1=>"",2=>NULL];
        
        $latlng = $request->get('latlng');
        
        if($latlng){
            $arr = explode("_", $latlng);
            if(count($arr) == 2){
                $data[0] = $arr[0];
                $data[1] = $arr[1];
            }           
        }
       
        if(empty($data[0]) || empty($data[1])){
         
            $latLng = $request->cookie('latlng');

            if(!empty($latLng)){
                $arr = explode("_", $latLng);
                if(count($arr) == 2){
                    $data[0] = $arr[0];
                    $data[1] = $arr[1];
                }           
            }
        }else{
            $cookie = cookie('latlng', $data[0]."_".$data[1],43200, '/', null, false, false);   
            $data[2] = $cookie;
        }
        
        return $data;
    }
    /**
     * Timezones list with GMT offset
     *
     * @return array
     * @link http://stackoverflow.com/a/9328760
     */
    public static function tz_list() {
      $zones_array = array();
      $timestamp = time();
      foreach(timezone_identifiers_list() as $zone) {
        date_default_timezone_set($zone);
        $zones_array[$zone] = 'UTC/GMT ' . date('P', $timestamp) .' - ' . $zone;
        
      }
      return $zones_array;
    }
    /**
     * @Desc upload file
     * 
     * @author Dzung Le <john.doe@example.com>
     * 
     * @param type $file
     * @param type $destinationPath
     * @param type $fileName
     * 
     * @return boolean result upload

     */

    public static function uploadImage($file,$destinationPath,$fileName)
    {
        try {            
            //Move file to destinationPath
            $file->move(public_path().$destinationPath, $fileName);
            
            //Change permission
            $fullFilePath = public_path().$destinationPath.$fileName;
            chmod($fullFilePath, 0777);     
            
        } catch (Exception $exc) {
            return false;
            //return $exc->getTraceAsString();
        }
        
        return true;
    }
    /**
     * @Desc upload file
     * 
     * @author Dzung Le <john.doe@example.com>
     * 
     * @param type $file
     * @param type $destinationPath
     * @param type $fileName
     * 
     * @return boolean result upload

     */

    public static function storeImage($file,$destinationPath,$fileName)
    {
        $store = false;
        try {  
            $store = Storage::disk('public')->put($destinationPath.$fileName, File::get($file));            
            
        } catch (Exception $exc) {
            return false;
            //return $exc->getTraceAsString();
        }
        
        return $store;
    }
     public static function deleteImage($fileName)
    {
        $delete = false;
        try {  
            $delete = Storage::disk('public')->delete($fileName);            
            
        } catch (Exception $exc) {
            return false;
            //return $exc->getTraceAsString();
        }
        
        return $delete;
    }
    
    /**
     * 
     * @param type $request
     * @return type
     */
    public static function getRestosFromGoogle($lat,$lng,$page_token) {
        
        $next_page = '';
        $restaurants = [];
                   
        if(!empty($page_token)){
            $data_query = [
                'pagetoken'=>$page_token,
                'key' =>'AIzaSyAeWXXFUIv-_Fp-YVZlxERrxdadDfwr0pQ',
            ];
        }else{
            $data_query = [
                'location'=> implode(",", [$lat,$lng]),
                //'radius' =>'1000',
                'rankby'=>'distance',
                'type' =>'restaurant',
                'key' =>'AIzaSyAeWXXFUIv-_Fp-YVZlxERrxdadDfwr0pQ',
            ];
        }
        $client = new Client();

        $res = $client->request('GET', 'https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
            'verify' => false,
            'query' => $data_query
        ]);
        
        if($res->getStatusCode() == 200){
            $resultBody = $res->getBody();            
            $result = json_decode($resultBody,true);

            if(isset($result['results']) && count($result['results']) > 0){
                if(isset($result['next_page_token'])){
                    $next_page = $result['next_page_token'];
                }

                foreach($result['results'] as $data){                         
                    $restaurants[] = self::getRestoDetail($data, $lat, $lng);
                }
            }
        }
        
        return ['restaurants'=>$restaurants,'next_page'=>$next_page];
    }
    /**
     * 
     * @param type $id
     * @param type $lat
     * @param type $lng
     */
    public static function getRestoDetailGoogle($id,$lat,$lng) {
        $restaurant = [];
        
        $now = date('Y-m-d',time());
        $restaurantObj = Restaurant::withCount(   
            ['menus' => function ($query) use($now){
                $query->where('status', Constant::ACTIVE_STATUS)
                    ->where('menus.from_date','<=',$now)
                    ->where('menus.to_date','>=',$now);        
            }])->find($id);
        if($restaurantObj){
            $restaurant['id'] = $restaurantObj->id;
            $restaurant['name'] = $restaurantObj->name;
            $restaurant['address'] = $restaurantObj->address;
            $restaurant['phone'] = $restaurantObj->phone;
            $restaurant['lat'] = $restaurantObj->lat;
            $restaurant['lng'] = $restaurantObj->lng;
            $restaurant['place_id'] = $restaurantObj->id;
            $restaurant['google_id'] = $restaurantObj->google_id; 
            $restaurant['deleted'] = $restaurantObj->deleted_at;
            $restaurant['menus_count'] = empty($restaurantObj->menus_count)?0:$restaurantObj->menus_count;
            $distanceInfo = UltiFunc::getDistanceBetweenPointsNew($lat, $lng, $restaurantObj->lat, $restaurantObj->lng);
            $restaurant['distance'] = round($distanceInfo['kilometers'],4); 
        }else{
            $client = new Client();
           //https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJN1t_tDeuEmsRUsoyG83frY4&key=YOUR_API_KEY
            $res = $client->request('GET', 'https://maps.googleapis.com/maps/api/place/details/json', [
                'verify' => false,
                'query' => [
                    'placeid'=>$id,
                    'key' =>'AIzaSyAeWXXFUIv-_Fp-YVZlxERrxdadDfwr0pQ',
                ]
            ]);
            if($res->getStatusCode() == 200){

                $resultBody = $res->getBody();            

                $result = json_decode($resultBody,true);

                if(isset($result['result']) && count($result['result']) > 0){
                    $data = $result['result'];                                                

                    $restaurant['name'] = $data['name'];
                    $restaurant['address'] = $data['formatted_address'];
                    $restaurant['phone'] = isset($data['international_phone_number'])?preg_replace('/\s+/', '', trim($data['international_phone_number'])):'';
                    $restaurant['lat'] = $data['geometry']['location']['lat'];
                    $restaurant['lng'] = $data['geometry']['location']['lng'];
                    $restaurant['id'] = NULL;  
                    $restaurant['google_id'] = $data['id'];  
                    $restaurant['place_id'] = $data['place_id'];
                    $restaurant['deleted'] = NULL;
                    $restaurant['menus_count'] = 0;
                    $distanceInfo = UltiFunc::getDistanceBetweenPointsNew($lat, $lng, $restaurant['lat'], $restaurant['lng']);
                    $restaurant['distance'] = round($distanceInfo['kilometers'],4);                    
                }
            }
        }
        
        return $restaurant;
    }
    /**
     * 
     * @return type
     */
    public static function getInitRestoDetail() {
        $restaurant = [];
        
        $restaurant['name'] = "";
        $restaurant['address'] = "";
        $restaurant['lat'] = "";
        $restaurant['lng'] = "";
        $restaurant['id'] = "";
        $restaurant['google_id'] = "";
        $restaurant['phone'] = "";
        $restaurant['place_id'] = "";
        $restaurant['deleted'] = NULL;
        
        return $restaurant;
    }
    /**
     * 
     * @param type $data
     */
    public static function getRestoDetail($data, $lat, $lng){
        $restaurant = [];
        $phone = isset($data['international_phone_number'])?preg_replace('/\s+/', '', trim($data['international_phone_number'])):'';
        
        $restaurantObj = self::getResto($data['id'], NULL);
        if(!$restaurantObj){
            $restaurant['id'] = NULL;
            $restaurant['name'] = $data['name'];
            $restaurant['address'] = $data['vicinity'];
            $restaurant['phone'] = $phone;
            $restaurant['lat'] = $data['geometry']['location']['lat'];
            $restaurant['lng'] = $data['geometry']['location']['lng'];
            $restaurant['google_id'] = $data['id'];
            $restaurant['place_id'] = $data['place_id'];
            $restaurant['menus_count'] = empty($restaurantObj->menus_count)?0:$restaurantObj->menus_count;
            $distanceInfo = self::getDistanceBetweenPointsNew($lat, $lng, $restaurant['lat'], $restaurant['lng']);
            $restaurant['distance'] = round($distanceInfo['kilometers'],4);
        }else{
            $restaurant['id'] = $restaurantObj->id;
            $restaurant['name'] = $restaurantObj->name;
            $restaurant['address'] = $restaurantObj->address;
            $restaurant['phone'] = $restaurantObj->phone;
            $restaurant['lat'] = $restaurantObj->lat;
            $restaurant['lng'] = $restaurantObj->lng;
            $restaurant['menus_count'] = empty($restaurantObj->menus_count)?0:$restaurantObj->menus_count;
            $distanceInfo = self::getDistanceBetweenPointsNew($lat, $lng, $restaurantObj->lat, $restaurantObj->lng);
            $restaurant['distance'] = round($distanceInfo['kilometers'],4);
            $restaurant['google_id'] = $data['id'];
            $restaurant['place_id'] = $data['place_id'];
        }
        
        return $restaurant;
    }
   
    /**
     * 
     * @param type $phone
     * @return type
     */
    public static function getResto($google_id, $phone) { 
        
        $now = date('Y-m-d',time());
        $query = Restaurant::withCount(   
            ['menus' => function ($query) use($now){
                $query->where('status', Constant::ACTIVE_STATUS)
                    ->where('menus.from_date','<=',$now)
                    ->where('menus.to_date','>=',$now);        
            }])->where('google_id',$google_id);
        
        if(!empty($phone)){
           $query = $query->orWhere('phone',$phone);        
        }
        
        $restaurant = $query->first();      
        
        return $restaurant;        
    }
     /**
     * 
     * @param type $num
     * @return type
     */
    public static function tofloat($num) {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
            ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }

        return floatval(
            preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
        );
    }    
     /*
    Description: Distance calculation from the latitude/longitude of 2 points
    Author: Rajesh Singh (2014)
    Website: http://AssemblySys.com

    If you find this script useful, you can show your
    appreciation by getting Rajesh a cup of coffee ;)
    PayPal: rajesh.singh@assemblysys.com

    As long as this notice (including author name and details) is included and
    UNALTERED, this code is licensed under the GNU General Public License version 3:
    http://www.gnu.org/licenses/gpl.html
    */

   public static function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
	// Calculate the distance in degrees
	$degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
 
	// Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
	switch($unit) {
		case 'km':
			$distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
			break;
		case 'mi':
			$distance = $degrees * 69.05482; // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
			break;
		case 'nmi':
			$distance =  $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
	}
	return round($distance, $decimals);
    }
    /**
     * 
     * @param type $latitude1
     * @param type $longitude1
     * @param type $latitude2
     * @param type $longitude2
     * @return type
     */
    public static function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2){
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);$miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        
        return compact('miles','feet','yards','kilometers','meters');
    }
}