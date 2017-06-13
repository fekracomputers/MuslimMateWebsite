<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App ;

class HomeController extends Controller
{
    public function index($lang="eng"){
        $azkar = DB::select('SELECT AzkarTypes.*, count(Azkar.TypeID) as counter
        FROM AzkarTypes
        LEFT JOIN Azkar ON Azkar.TypeID = AzkarTypes.ZekrTypeID
        GROUP BY AzkarTypes.ZekrTypeID, AzkarTypes.ZekrTypeName');
        $events = collect($this->getIslamicEvents($lang));
        $geoplugin = new \geoPlugin();
        $geoplugin->locate();
        $city = $geoplugin->city ;
        $country = $geoplugin->countryName ;
        $lat = $geoplugin->latitude ;
        $long = $geoplugin->longitude ;
        $prayerTime = $this->getPrayerTimes($lat , $long,'null');
        $prayerName = getPrayerLan($lang);
        $prayer = $prayerTime['times'];
        $myear = date("Y") ;
        $mday = date("d") ;
        $mMonth = date("m") ;

        $hgDate = new \HGDate();
        $hgDate->setGregorian($myear, $mMonth, $mday);
        $hgDate->toHijri();
        $year = $hgDate->getYear();
        $month = hijriMonth($hgDate->getMonth(),$lang);
        $day = $hgDate->getDay();
        $mMonth = MiladyMonth(date("m"),$lang);

        $nextPrayer = $this->NextPrayer($lat , $long);
        $nextName = getPrayerName($nextPrayer[1], $lang);
        $nextEvent = $this->NextEvent($lang);

        $title = getTitle($lang);
        $dir = getDirection($lang);

        $today = $lang == 'ar' ? 'اليوم' : "Today's" ;

        return view('home',compact('azkar','events','prayer','lat','long','city','country','lang','title','dir'
        ,'today','year','month','day','mMonth','mday','myear','nextPrayer','nextEvent','prayerName','nextName')) ;
    }

    public function EventsMuslim($lang){
        $title = getTitle($lang);
        $dir = getDirection($lang);
        $events = collect($this->getIslamicEvents($lang));
        $nextEvent = $this->NextEvent($lang);

        return view('events',compact('events' ,'title','dir','lang','nextEvent'));
    }

    public function Map($lang){
        $geoplugin = new \geoPlugin();
        $geoplugin->locate();
        $lat = $geoplugin->latitude ;
        $long = $geoplugin->longitude ;
        $title = getTitle($lang);
        $dir = getDirection($lang);
        return view('map',compact('lat','long','title','dir','lang'));
    }

    public function Calendar($lang){
        $title = getTitle($lang);
        $dir = getDirection($lang);

        return view('calendar',compact('title','dir','lang'));
    }

    public function Azkar($lang){
        $azkar = DB::select('SELECT AzkarTypes.*, count(Azkar.TypeID) as counter
        FROM AzkarTypes
        LEFT JOIN Azkar ON Azkar.TypeID = AzkarTypes.ZekrTypeID
        GROUP BY AzkarTypes.ZekrTypeID, AzkarTypes.ZekrTypeName');
        $title = getTitle($lang);
        $dir = getDirection($lang);

        return view('azkar',compact('azkar','title','dir','lang'));
    }

    public function Prayer($lang){
        $geoplugin = new \geoPlugin();
        $geoplugin->locate();
        $city = $geoplugin->city ;
        $country = $geoplugin->countryName ;
        $lat = $geoplugin->latitude ;
        $long = $geoplugin->longitude ;
        $prayerTime = $this->getPrayerTimes($lat , $long,'null');
        $prayer = $prayerTime['times'];
        $myear = date("Y") ;
        $mday = date("d") ;
        $mMonth = MiladyMonth(date("m"),$lang);

        $nextPrayer = $this->NextPrayer($lat , $long);
        $title = getTitle($lang);
        $dir = getDirection($lang);
        $nextName = getPrayerName($nextPrayer[1], $lang);
        $prayerName = getPrayerLan($lang);


        return view('prayer',compact('lang','prayerName','nextName','city','country','prayerTime','lat','long','prayer','myear','mday','mMonth','nextPrayer','title','dir'));
    }

    public function Weather($lang){
        $geoplugin = new \geoPlugin();
        $geoplugin->locate();
        $city = $geoplugin->city ;
        $country = $geoplugin->countryName ;
        $lat = $geoplugin->latitude ;
        $long = $geoplugin->longitude ;
        $title = getTitle($lang);
        $dir = getDirection($lang);

        return view('weather',compact('city','country','lat','long','title','dir','lang'));
    }

    public function getAzkar($id){
        $azkar = DB::table('Azkar')->where('TypeID',$id)->get();
        return json_encode($azkar) ;
    }
    
    public function getIslamicEvents($lang="en"){
        $title = getEventLan($lang);
        $dates = [];
        /* Islamic New Year Event */
        $myear = date("Y") ;
        $mday = date("d") ;
        $mMonth = date("m") ;
        $hgDate = new \HGDate();
        $hgDate->setGregorian($myear, $mMonth, $mday);
        $hgDate->toHijri();


        $year = $hgDate->getYear();
        $month = '1';
        $day = '1';
        $hgDate = new \HGDate();
        $hgDate->setHijri($year, $month, $day);
        $date = [];
        $date['hyear'] = $year;
        $date['hmonth'] = hijriMonth($month, $lang);
        $date['hday'] = $day;

        $hgDate->toGregorian();

        $date['gyear'] = $hgDate->getYear();
        $date['gmonth'] = MiladyMonth($hgDate->getMonth(), $lang);
        $date['gday'] = $hgDate->getDay();
        $date['name'] = $title[0] ;
        array_push($dates , $date);

        /* Eid Al-Adha Event*/

        /* Islamic New Year Event */
        $month = '3';
        $day = '12';
        $hgDate = new \HGDate();
        $hgDate->setHijri($year, $month, $day);
        $date = [];
        $date['hyear'] = $year;
        $date['hmonth'] = hijriMonth($month, $lang);
        $date['hday'] = $day;

        $hgDate->toGregorian();

        $date['gyear'] = $hgDate->getYear();
        $date['gmonth'] = MiladyMonth($hgDate->getMonth(), $lang);
        $date['gday'] = $hgDate->getDay();
        $date['name'] = $title[1] ;
        array_push($dates , $date);

        /* Eid Al-Adha Event*/

        /*Ramdhan Event */
        $month = '9';
        $day = '1';
        $hgDate = new \HGDate();
        $hgDate->setHijri($year, $month, $day);
        $date = [];
        $date['hyear'] = $year;
        $date['hmonth'] = hijriMonth($month, $lang);
        $date['hday'] = $day;

        $hgDate->toGregorian();

        $date['gyear'] = $hgDate->getYear();
        $date['gmonth'] = MiladyMonth($hgDate->getMonth(), $lang);
        $date['gday'] = $hgDate->getDay();
        $date['name'] = $title[2] ;
        array_push($dates , $date);

        /*End Ramdhan Event*/

        /*Laylat al Kadr Event */
        $month = '9';
        $day = '27';
        $hgDate = new \HGDate();
        $hgDate->setHijri($year, $month, $day);
        $date = [];
        $date['hyear'] = $year;
        $date['hmonth'] = hijriMonth($month, $lang);
        $date['hday'] = $day;

        $hgDate->toGregorian();

        $date['gyear'] = $hgDate->getYear();
        $date['gmonth'] = MiladyMonth($hgDate->getMonth(), $lang);
        $date['gday'] = $hgDate->getDay();
        $date['name'] = $title[3] ;
        array_push($dates , $date);

        /*End Ramdhan Event*/


        /*Eid Al-Fitr Event */
        $month = '10';
        $day = '1';
        $hgDate = new \HGDate();
        $hgDate->setHijri($year, $month, $day);
        $date = [];
        $date['hyear'] = $year;
        $date['hmonth'] = hijriMonth($month, $lang);
        $date['hday'] = $day;

        $hgDate->toGregorian();

        $date['gyear'] = $hgDate->getYear();
        $date['gmonth'] = MiladyMonth($hgDate->getMonth(), $lang);
        $date['gday'] = $hgDate->getDay();
        $date['name'] = $title[4] ;
        array_push($dates , $date);

        /*Eid Al-Fitr Event*/

        /* Waqf Al Arafa Event */
        $month = '12';
        $day = '9';
        $hgDate = new \HGDate();
        $hgDate->setHijri($year, $month, $day);
        $date = [];
        $date['hyear'] = $year;
        $date['hmonth'] = hijriMonth($month, $lang);
        $date['hday'] = $day;

        $hgDate->toGregorian();

        $date['gyear'] = $hgDate->getYear();
        $date['gmonth'] = MiladyMonth($hgDate->getMonth(), $lang);
        $date['gday'] = $hgDate->getDay();
        $date['name'] = $title[5] ;
        array_push($dates , $date);

        /* Eid Al-Adha Event */
        $month = '12';
        $day = '10';
        $hgDate = new \HGDate();
        $hgDate->setHijri($year, $month, $day);
        $date = [];
        $date['hyear'] = $year;
        $date['hmonth'] = hijriMonth($month, $lang);
        $date['hday'] = $day;

        $hgDate->toGregorian();

        $date['gyear'] = $hgDate->getYear();
        $date['gmonth'] = MiladyMonth($hgDate->getMonth(), $lang);
        $date['gday'] = $hgDate->getDay();
        $date['name'] = $title[6] ;
        array_push($dates , $date);

        /* Eid Al-Adha Event*/

        return $dates;
    }
    
    public function getPrayerTimes($lat,$lng ,$date){
        if($date == 'null'){
            $dt = Carbon::now();
        }else{
            $carbonDate= Carbon::createFromFormat('m-d-Y', $date);
            $dt = $carbonDate ;
        }
        $hgDate = new \HGDate();
        $hgDate->setGregorian($dt->year, $dt->month, $dt->day);
        $date = [];

        $prayerTimes = new \PrayerTimes($hgDate->getDay(), $hgDate->getMonth(), $hgDate->getYear(), $lat, $lng, 2, 0, 0, 0);

        $times = $prayerTimes->get();

        $date['year'] = $hgDate->getYear();
        $date['month'] = $hgDate->getMonth();
        $date['day'] = $hgDate->getDay();
        $date['times'] = $times;

        return $date ;

    }
    
    public function NextPrayer($lat,$lng){
        $prayer = $this->getPrayerTimes($lat,$lng , 'null');
        $carbon = Carbon::now();
        $h = $carbon->hour ;
        $arr = array() ;
        $counter = 1 ;
        foreach ($prayer['times'] as $row){
            if($h < $row[0]){
                array_push($arr,[$row , $counter]);
                $arr = array_collapse($arr) ;
                break ;
            }
            $counter++ ;
        }
        if(!empty($arr)){
            return $arr ;
        }else{
            $carbon = Carbon::tomorrow();
            $h = $carbon->hour ;
            foreach ($prayer['times'] as $row){
                if($h < $row[0]){
                    array_push($arr,[$row , $counter]);
                    $arr = array_collapse($arr) ;
                    return $arr ;
                    break ;
                }
                $counter++ ;
            }

        }


    }
    
    public function NextEvent($lang){
        $event = $this->getIslamicEvents($lang);
        $carbon = Carbon::now();
        $date1 = "$carbon->year-$carbon->month-$carbon->day";
        foreach ($event as $row){

            $date2 = $row['gyear']."-". MiladyMonthNumber($row['gmonth'],$lang)."-".$row['gday'];
            if(strtotime($date1) < strtotime($date2)){
                return $row ;
                break ;
            }

        }
    }
    
    public function GetIP(Request $request){

//        $data = var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));
//
//        return $data['geoplugin_request'];
        $geoplugin = new \geoPlugin();
        $geoplugin->locate();
        return $geoplugin->city ;
    }

    public function SiteMap(){
        $sitemap = App::make("sitemap");
        $sitemap->add('http://muslimmate.islam-db.com/en/prayer', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/ar/prayer', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/en/weather', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/ar/weather', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/ar/calendar', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/en/calendar', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/en/map', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/ar/map', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/en/azkar', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/ar/azkar', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/en/events', Carbon::now(),'1.0' ,'monthly');
        $sitemap->add('http://muslimmate.islam-db.com/ar/events', Carbon::now(),'1.0' ,'monthly');

        $sitemap->store('xml','sitemaps/sitemap');
    }

}
require app_path().'/Helpers/HGDate.php';
require app_path().'/Helpers/PrayerTimes.php';
require app_path().'/Helpers/PrayerTimesMath.php';
require app_path().'/Helpers/common.php';
require app_path().'/Helpers/geoplugin.class.php';