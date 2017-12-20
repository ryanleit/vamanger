<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\ACLHelper;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;

class LocationControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /* setting client country */
        $country = $request->session()->get('country');
        
        if(empty($country)){
            $position = Location::get($request->ip());

            if(!empty($position->countryCode)){
                $country = strtolower($position->countryCode);
            }else{
                $acceptLanguage = $request->getDefaultLocale(); 
                $country = strtolower(strtolower($acceptLanguage));            
            }
            
            $country = $request->session()->put('country',$country);
        }
        
        $locale = $request->session()->get('locale');
        $test = false;
        if ($test && in_array($locale ,['en','fr'])) {
            app()->setLocale($locale);
        }else{
            $locale = $this->getBrowserLocale();
            $request->session()->put('locale',$locale);
            app()->setLocale($locale);
        }
        return $next($request);
    }
    /**
     * 
     * @return type
     */
    function getBrowserLocale()
    {
        $lang = 'fr';
        
        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
            // Credit: https://gist.github.com/Xeoncross/dc2ebf017676ae946082
            $websiteLanguages = ['EN', 'FR'];
            // Parse the Accept-Language according to:
            // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4
            preg_match_all(
               '/([a-z]{1,8})' .       // M1 - First part of language e.g en
               '(-[a-z]{1,8})*\s*' .   // M2 -other parts of language e.g -us
               // Optional quality factor M3 ;q=, M4 - Quality Factor
               '(;\s*q\s*=\s*((1(\.0{0,3}))|(0(\.[0-9]{0,3}))))?/i',
               $_SERVER['HTTP_ACCEPT_LANGUAGE'],
               $langParse);
       
            $langs = $langParse[1]; // M1 - First part of language
            $quals = $langParse[4]; // M4 - Quality Factor

            $numLanguages = count($langs);
            $langArr = array();

            for ($num = 0; $num < $numLanguages; $num++)
            {
               $newLang = strtoupper($langs[$num]);
               $newQual = isset($quals[$num]) ?
                  (empty($quals[$num]) ? 1.0 : floatval($quals[$num])) : 0.0;

               // Choose whether to upgrade or set the quality factor for the
               // primary language.
               $langArr[$newLang] = (isset($langArr[$newLang])) ?
                  max($langArr[$newLang], $newQual) : $newQual;
            }

            // sort list based on value
            // langArr will now be an array like: array('EN' => 1, 'ES' => 0.5)
            arsort($langArr, SORT_NUMERIC);
            
            // The languages the client accepts in order of preference.
            $acceptedLanguages = array_keys($langArr);
            
            // Set the most preferred language that we have a translation for.
            foreach ($acceptedLanguages as $preferredLanguage)
            {
                if (in_array($preferredLanguage, $websiteLanguages))
                {
                  // $_SESSION['lang'] = $preferredLanguage;
                   $lang =  strtolower($preferredLanguage);
                   return $lang;
                }
            }
        }
        
        return $lang;
    }
}
