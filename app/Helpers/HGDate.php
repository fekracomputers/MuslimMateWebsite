<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("DATETYPE_NONE", 0);
define("DATETYPE_HIJRI", 1);
define("DATETYPE_GREGORIAN", 2);
define("GREGORIAN_EPOCH", 1721425.5);
define("HIJRI_EPOCH", 1948438.5); //1948439.5

function mod($a, $b) {
    return (Integer)($a - ($b * floor($a / $b)));
}

/**
 * Hijri/Georgian date converter
 *
 * @author fekracomputers
 */
class HGDate {
    private $julianDay;
    private $day;
    private $month;
    private $year;
    private $type;
        
    public function __construct($date = null) {
        if($date===null){
            $this->type = '';
            $this->julianDay = 0;
            $this->day = 0;
            $this->month = 0;
            $this->year = 0;
            $this->dateNow();
        } else {
            $this->type = $date.type;
            $this->julianDay = $date.julianDay;
            $this->day = $date.day;
            $this->month = $date.month;
            $this->year = $date.year;
        }
    }
    
    public function dateNow() {
        $this->setGregorian(date("Y"), date("m"), date("d"));
    }
    
    public static function leap_gregorian($year) {
        return (($year % 4) == 0) && (!((($year % 100) == 0) && (($year % 400) != 0)));
    }

    public static function gregorian_to_jd($year, $month, $day) {
        return (double) ((GREGORIAN_EPOCH - 1) +
                (365 * ($year - 1)) +
                floor(($year - 1) / 4) +
                (-floor(($year - 1) / 100)) +
                floor(($year - 1) / 400) +
                floor((((367 * $month) - 362) / 12) +
                        (($month <= 2) ? 0 : (HGDate::leap_gregorian($year) ? -1 : -2)) +
                        $day));
    }
    
    public static function hijri_to_jd($year, $month, $day) {
        return $day +
                ceil(29.5 * ($month - 1)) +
                ($year - 1) * 354 +
                floor((3 + (11 * $year)) / 30) +
                HIJRI_EPOCH - 1;
    }
    
    public function setHijri($year, $month, $day) {
        if ($year < 1 || $month < 1 || $day < 1) return false;

        $this->julianDay = HGDate::hijri_to_jd($year, $month, $day);
        
        $this->toHijri();
        
        if ($year != $this->year || $month != $this->month || $day != $this->day) {
            $this->type = DATETYPE_NONE;
            return false;
        }

        return true;
    }
    
    public function setGregorian($year, $month, $day) {
        if ($year < 622 || $month < 1 || $day < 1) return false;
        if ($year == 622 && $month < 7) return false;
        if ($year == 622 && $month == 7 && $day < 18) return false;

        $this->julianDay = HGDate::gregorian_to_jd($year, $month, $day);
                
        $this->toGregorian();
        
        if ($year != $this->year || $month != $this->month || $day != $this->day) {
            $this->type = DATETYPE_NONE;
            return false;
        }

        return true;
    }
    
    public function toHijri() {
        $jd = floor($this->julianDay) + 0.5;

        $this->year = (Integer) floor(((30 * ($jd - HIJRI_EPOCH)) + 10646) / 10631);
        $this->month = (Integer) min(12, ceil(($jd - (29 + HGDate::hijri_to_jd($this->year, 1, 1))) / 29.5) + 1);
        $this->day = (Integer) ($jd - HGDate::hijri_to_jd($this->year, $this->month, 1) + 1);

        $this->type = DATETYPE_HIJRI;

        return true;
    }
    
    public function toGregorian() {

        $jd = floor($this->julianDay - 0.5) + 0.5;
        $depoch = $jd - GREGORIAN_EPOCH;
        $quadricent = floor($depoch / 146097);
        $dqc = mod((Integer) $depoch, 146097);
        $cent = floor($dqc / 36524);
        $dcent = mod((Integer) $dqc, 36524);
        $quad = floor($dcent / 1461);
        $dquad = mod((Integer) $dcent, 1461);
        $yindex = floor($dquad / 365);
        $this->year = (Integer) (($quadricent * 400) + ($cent * 100) + ($quad * 4) + $yindex);
        if (!(($cent == 4) || ($yindex == 4))) {
            $this->year++;
        }
        $yearday = (Integer) ($jd - HGDate::gregorian_to_jd((Integer) $this->year, 1, 1));
        $leapadj = (($jd < HGDate::gregorian_to_jd((Integer) $this->year, 3, 1)) ? 0 : (HGDate::leap_gregorian((Integer) $this->year) ? 1 : 2));
        $this->month = (Integer) floor(((($yearday + $leapadj) * 12) + 373) / 367);
        $this->day = (Integer) ($jd - HGDate::gregorian_to_jd((Integer) $this->year, $this->month, 1) + 1);

        $this->type = DATETYPE_GREGORIAN;

        return true;
    }
    
    public function getJulian() {
        return $this->julianDay;
    }
    
    public function getDay() {
        return $this->day;
    }

    public function getMonth() {
        return $this->month;
    }

    public function getYear() {
        return $this->year;
    }

    public function getType() {
        return $this->type;
    }   

    public function weekDay() {
        return (Integer) mod((Integer) floor(($this->julianDay + 1.5)), 7);
    }

    public function nextDay() {
        $this->julianDay = $this->julianDay + 1;
        if ($this->type == DATETYPE_HIJRI) $this->toHijri();
        else if ($this->type == DATETYPE_GREGORIAN) $this->toGregorian();
    }

    public function previousDay() {
        $this->julianDay = $this->julianDay - 1;
        if ($this->type == DATETYPE_HIJRI) $this->toHijri();
        else if ($this->type == DATETYPE_GREGORIAN) $this->toGregorian();
    }

    public function toString() {
        return "$this->day / $this->month / $this->year";
    }
}
?>