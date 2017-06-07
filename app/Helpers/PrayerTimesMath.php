<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define("RTD", 180 / pi());
define("DTR", pi() / 180);

/**
 * Description of PrayerTimesMath
 *
 * @author fekracomputers
 */
class PrayerTimesMath {

    public static function fixAngle($a) {
        $a = $a - 360.0 * (floor($a / 360.0));
        $a = $a < 0 ? $a + 360.0 : $a;
        return $a;
    }

    //degree Sin
    public static function dSin($degreeAngle) {
        return sin($degreeAngle * DTR);
    }

    //degree Cos
    public static function dCos($degreeAngle) {
        return cos($degreeAngle * DTR);
    }

    //degree Tan
    public static function dTan($degreeAngle) {
        return tan($degreeAngle * DTR);
    }

    //degree arcsin
    public static function dASin($x) {
        
        return RTD * asin($x);
    }

    //degree arccos
    public static function dACos($x) {
        
        return RTD * acos($x);
    }

    //degree arctan
    public static function dATan($x) {
        
        return RTD * atan($x);
    }

    //degree arctan2
    public static function dATan2($y, $x) {
        
        return RTD * atan2($y, $x);
    }

    //degree arccot
    public static function dACot($x) {
        
        return 90 - PrayerTimesMath::dATan($x);
    }

    //fraction part of double variable
    public static function frac($x) {
        return x - (Integer) x;
    }
}
