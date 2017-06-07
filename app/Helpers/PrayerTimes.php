<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("PTC_WAY_EGYPT", 0);
define("PTC_WAY_KARACHI", 1);
define("PTC_WAY_ISNA", 2);
define("PTC_WAY_UMQURA", 3);
define("PTC_WAY_MWl", 4);

define("PTC_MAZHAB_SHAFEI", 0);
define("PTC_MAZHAB_HANAFI", 1);

define("MECCA_LATITUDE", 21.41666);
define("MECCA_LONGITUDE", 39.81666);

/**
 * Description of PrayerTime
 *
 * @author fekracomputers
 */
class PrayerTimes {
    
    private $fajr;
    private $sunrise;
    private $thuhr;
    private $asr;
    private $sunset;
    private $maghreb;
    private $isha;
    
    private $latitude;
    private $longitude;
    private $timeZone;
    private $summmerTimeEnabled;
    
    private $mazhab;
    private $way;
    
    private $day;
    private $month;
    private $year;
    private $julianDate;
    
    private $timePortions = array();

    public function __construct($day, $month, $year, $latitude, $longitude, $timeZone, $summmerTimeEnabled, $mazhab, $way) {
        
        $this->timePortions = array( 5 / 24.0, 6 / 24.0, 12 / 24.0, 13 / 24.0, 18 / 24.0, 18 / 24.0, 18 / 24.0 );

        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        $this->julianDate = PrayerTimes::calculateJulianDate($this->day, $this->month, $this->year);
        
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timeZone = $timeZone;
        $this->summmerTimeEnabled = $summmerTimeEnabled;        

        $this->mazhab = $mazhab;
        $this->way = $way;
    }
    
    private static function fixHours($a) {

        $a = $a - 24.0 * (floor($a / 24.0));
        $a = $a < 0 ? $a + 24.0 : $a;

        return $a;
    }

    private static function calculateJulianDate($day, $month, $year) {

        if ($month <= 2) {
            $year -= 1;
            $month += 12;
        }

        $a = (Integer)($year / 100);
        $b = (Integer)($a / 4);
        $c = (Integer)(2 - $a + $b);
        $d = (Integer)$day;
        $e = (Integer) (365.25 * ($year + 4716));
        $f = (Integer) (30.7 * ($month + 1));
        $julianDate = $c + $d + $e + $f - 1524.5 - 1;

        return $julianDate;
    }
    
    private static function calculateEquationOfTime($julianDate, $timePortion) {

        $d = $julianDate - 2451545.0 + $timePortion;
        $g = PrayerTimesMath::fixAngle(357.529 + 0.98560028 * $d);
        $q = PrayerTimesMath::fixAngle(280.459 + 0.98564736 * $d);
        $l = $q + 1.915 * (PrayerTimesMath::dSin($g)) + 0.020 * (PrayerTimesMath::dSin(2 * $g));
        $e = 23.439 - 0.00000036 * $d;
        $ra = PrayerTimesMath::dATan2((PrayerTimesMath::dCos($e)) * (PrayerTimesMath::dSin($l)), (PrayerTimesMath::dCos($l))) / 15;
        $ra = PrayerTimes::fixHours($ra);
        $equationOfTime = $q / 15 - $ra;

        return $equationOfTime;
    }
    
    private static function calculateSunDeclination($julianDate, $timePortion) {

        $d = $julianDate - 2451545.0 + $timePortion;
        $g = 357.529 + 0.98560028 * $d;
        $q = 280.459 + 0.98564736 * $d;
        $l = $q + 1.915 * (PrayerTimesMath::dSin($g)) + 0.020 * (PrayerTimesMath::dSin(2 * $g));
        $e = 23.439 - 0.00000036 * $d;
        $sunDeclination = PrayerTimesMath::dASin((PrayerTimesMath::dSin($e)) * (PrayerTimesMath::dSin($l)));

        return $sunDeclination;
    }
    
    private static function calculateMidDay($julianDate, $timePortion) {

        $equationOfTime = PrayerTimes::calculateEquationOfTime($julianDate, $timePortion);
        $midDay = PrayerTimes::fixHours(12 - $equationOfTime);

        return $midDay;
    }
    
    private static function calculateSunDuration($a, $latitude, $julianDate, $timePortion) {

        // time period between mid-day and the time at which sun reaches an angle below the horizon
        $sunDeclination = PrayerTimes::calculateSunDeclination($julianDate, $timePortion);
        $a = PrayerTimesMath::dSin($a);
        $b = (PrayerTimesMath::dSin($latitude)) * (PrayerTimesMath::dSin($sunDeclination));
        $c = (PrayerTimesMath::dCos($latitude)) * (PrayerTimesMath::dCos($sunDeclination));
        $d = (PrayerTimesMath::dACos((-$a - $b) / $c));
        $sunDuration = 2 * $d / 15;

        return $sunDuration;
    }
    
    private function calculateThuhr() {

        $equationOfTime = PrayerTimes::calculateEquationOfTime($this->julianDate, $this->timePortions[2]);
        $this->thuhr = PrayerTimes::fixHours(12 - $equationOfTime);
    }

    private function calculateSunrise() {

        $this->sunrise = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[1]) - PrayerTimes::calculateSunDuration(0.8333, $this->latitude, $this->julianDate, $this->timePortions[1])/2;
    }

    private function calculateSunset() {

        $this->sunset = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[5]) + PrayerTimes::calculateSunDuration(0.8333, $this->latitude, $this->julianDate, $this->timePortions[4])/2;
    }

    // Asr Prayer
    private function calculateAsr() {
        
        $m = 0;
        switch($this->mazhab){
            case PTC_MAZHAB_SHAFEI: $m  = 0; break;
            case PTC_MAZHAB_HANAFI: $m  = 1; break;
        }

        $d = PrayerTimes::calculateSunDeclination($this->julianDate, $this->timePortions[3]);
        $g = -PrayerTimesMath::dACot($m + 1 + PrayerTimesMath::dTan(abs($this->latitude - $d)));
        $s = PrayerTimes::calculateSunDeclination($this->julianDate, $this->timePortions[3]);
        $z = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[3]);
        $v = ((double) (1 / 15.0)) * PrayerTimesMath::dACos((-PrayerTimesMath::dSin($g) - PrayerTimesMath::dSin($s) * PrayerTimesMath::dSin($this->latitude)) / (PrayerTimesMath::dCos($s) * PrayerTimesMath::dCos($this->latitude)));

        $this->asr = $z + ($g > 90 ? -$v : $v);
    }

    private function calculateFajrAndIsha() {

        if ($this->latitude <= 50) {
            
            switch ($this->way) {
                case PTC_WAY_EGYPT: // Egyptian General Authority of Survey
                    $this->fajr = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[0]) - PrayerTimes::calculateSunDuration(19.5, $this->latitude, $this->julianDate, $this->timePortions[0])/2;
                    $this->isha = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[6]) + PrayerTimes::calculateSunDuration(17.5, $this->latitude, $this->julianDate, $this->timePortions[6])/2;
                    break;
                case PTC_WAY_KARACHI: // Karachi
                    $this->fajr = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[0]) - PrayerTimes::calculateSunDuration(18, $this->latitude, $this->julianDate, $this->timePortions[0])/2;
                    $this->isha = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[6]) + PrayerTimes::calculateSunDuration(18, $this->latitude, $this->julianDate, $this->timePortions[6])/2;
                    break;
                case PTC_WAY_ISNA: // Islamic Society of North America (ISNA)
                    $this->fajr = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[0]) - PrayerTimes::calculateSunDuration(15, $this->latitude, $this->julianDate, $this->timePortions[0])/2;
                    $this->isha = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[6]) + PrayerTimes::calculateSunDuration(15, $this->latitude, $this->julianDate, $this->timePortions[6])/2;
                    break;
                case PTC_WAY_UMQURA: // Umm al-Qura, Makkah
                    $this->fajr = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[0]) - PrayerTimes::calculateSunDuration(18.5, $this->latitude, $this->julianDate, $this->timePortions[0])/2;
                    $this->isha = $maghreb + 1.5;
                    break;
                case PTC_WAY_MWl: // Muslim World League(MWL)
                    $this->fajr = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[0]) - PrayerTimes::calculateSunDuration(18, $this->latitude, $this->julianDate, $this->timePortions[0])/2;
                    $this->isha = PrayerTimes::calculateMidDay($this->julianDate, $this->timePortions[6]) + PrayerTimes::calculateSunDuration(17, $this->latitude, $this->julianDate, $this->timePortions[6])/2;
                    break;
            }
            
        } else {// high latitude. One-Seventh of the Night method is used

            // period between sunset-sunrise
            $p = 24 - ($this->sunset - $this->sunrise);
            $this->fajr = $this->sunrise - 2 * $p / 7.0 - 1 / 6.0;
            $this->isha = $this->sunset + 2 * $p / 7.0 - 1 / 15.0;

        }        
    }

    private function calculate() {
        
        $this->calculateSunrise();
        $this->calculateSunset();
        $this->calculateThuhr();
        $this->calculateAsr();
        $this->maghreb = $this->sunset;
        $this->calculateFajrAndIsha();
        
        $prayers = array();
        $prayers[0] = $this->fajr;
        $prayers[1] = $this->sunrise;
        $prayers[2] = $this->thuhr;
        $prayers[3] = $this->asr;
        $prayers[4] = $this->maghreb;
        $prayers[5] = $this->isha;
        
        return $prayers;
    }
    
    private function updateTimePortions($prayers) {
        
        for ($i = 0; $i < count($prayers); $i++){
            $this->timePortions[$i] = $prayers[$i] / 24.0;
        }
        
        $this->timePortions[6] = 1.0;
    }
    
    private function adjust($prayers) {
        
        $finalPrayers = array();
        for ($i = 0; $i < count($prayers); $i++) {
            $finalPrayers[$i] = $prayers[$i] + $this->timeZone - $this->longitude / 15.0;
            $finalPrayers[$i] = (ceil($finalPrayers[$i] * 60)) / 60.0;
            if ($this->summmerTimeEnabled)
                $finalPrayers[$i]++;
        }
        
        return $finalPrayers;
    }

    public function get() {
        
        $prayers = $this->calculate();
        $this->updateTimePortions($prayers);
         

        $prayers = $this->calculate();
        $prayers = $this->adjust($prayers);
        
        $prayersTimes = array();
        
        for ($i = 0; $i < count($prayers); $i++) {
            $h = (Integer)$prayers[$i];
            $m = (Integer)(60*($prayers[$i]-$h));
            $prayersTimes[$i] = array($h, $m);
        }

        return $prayersTimes;
    }

    public static function calculateAngle($latitude, $longitude) {
        
        $a = $latitude ;
        $b = MECCA_LATITUDE;
        $c = ($longitude - MECCA_LONGITUDE);

        $cotan = (PrayerTimesMath::dSin($a)*PrayerTimesMath::dCos($c) - PrayerTimesMath::dCos($a) * PrayerTimesMath::dTan($b)) / PrayerTimesMath::dSin($c);
        $angle = PrayerTimesMath::dACot($cotan);	    

        if($longitude > MECCA_LONGITUDE)
            $angle += 180;

        return $angle;
    }
}
