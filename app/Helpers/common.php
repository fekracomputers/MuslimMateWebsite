<?php
define("MSG_INVALID_REQUEST_FORMAT", "Invalid request format.");

$exceptionsCount = 0;

//Generate Text Line Breaks
function GTLB($text){
    return mb_ereg_replace("\n", "<br>", $text);
}

//Create Short Text
function ST($text, $maxlength){
    if(mb_strlen($text, 'utf8')<=$maxlength){
        return $text;
    }
    return mb_substr($text, 0, $maxlength-3, 'utf8')."...";
}

/**
 * @brief get safe int value
 */
function safeGetInt($value, $defaultValue = 0)
{
    if(isset($value) && is_numeric($value)){
        return intval($value);
    }
    return $defaultValue;
}

/**
 * @brief get safe int value
 */
function safeGetDouble($value, $defaultValue = 0)
{
    if(isset($value) && is_double($value)){
        return doubleval($value);
    }
    return $defaultValue;
}

/**
 * @brief get safe int array value
 */
function safeGetIntArray($values, $defaultValue)
{
    if(isset($values) && is_array($values)){
        $finalValues = array();
        foreach ($values as $value)
        {
            array_push($finalValues, intval($value));
        }
        return $finalValues;
    }
    
    return $defaultValue;
}

/**
 * @brief get safe string value
 */
function safeGetString($value, $defaultValue = 0)
{
    if(isset($value)){
        return $value;
    }
    return $defaultValue;
}

/**
 * @brief get cookie for key or empty string if cookie doesn't exist
 */
function safeGetCookie($key, $defaultValue = "")
{
    if(isset($_COOKIE[$key])){
        return $_COOKIE[$key];
    }
    return $defaultValue;
}

/**
 * @brief get session 
 */
function safeGetSession($key, $defaultValue = "")
{
    if(isset($_SESSION[$key])){
        return $_SESSION[$key];
    }
    return $defaultValue;
}

/**
 * @brief generate random code
 */
function genRandCode($length)
{
    $letters = "ABCDEFGHIJKLMNPQRSTXYZ12345678";
    $code = ""; 
    for ($i = 0; $i <$length; $i++) 
    { 
        $iletter = rand(0,  strlen($letters)-1);
        $code .= substr($letters, $iletter, 1); 
    }
    return $code;
}

/**
 * @brief generate random number
 */
function genRandNumber($length)
{
    $letters = "12345678";
    $code = ""; 
    for ($i = 0; $i <$length; $i++) 
    { 
        $iletter = rand(0,  strlen($letters)-1);
        $code .= substr($letters, $iletter, 1); 
    }
    return $code;
}

/**
 * @brief check if main text contains search text
 */
function HS($mainText, $searchText)
{
    return (mb_strpos($mainText, $searchText)!==false);
}

/**
 * @brief check if main text contains search text (case sensitive)
 */
function HSI($mainText, $searchText)
{
    return (mb_stripos($mainText, $searchText)!==false);
}

/**
 * @brief check if main text starts with search text
 */
function SW($mainText, $searchText)
{
    return (mb_strpos($mainText, $searchText)===0);
}

/**
 * @brief check if main text starts with search text (case sensitive)
 */
function SWI($mainText, $searchText)
{
    return (mb_stripos($mainText, $searchText)===0);
}

/**
 * @brief convert regular time into readable one 
 */
function time2text($timestamp)
{
    $totalSeconds = mktime() - $timestamp;
    $nHours = (int)($totalSeconds/3600);
    $nMinutes = (int)(($totalSeconds%3600)/60);
    $nSeconds = (int)($totalSeconds%60);
    if($nHours==0 && $nMinutes==0 && $nSeconds==0){
        return KW("write now");
    }
    else if($nHours==0 && $nMinutes==0){
        return "".$nSeconds." ".KW("seconds ago");
    }
    else if($nHours==0){
        return "".$nMinutes." ".KW("minutes ago");
    }
    else if($nHours<24){
        return "".$nHours." ".KW("hours ago");
    }

    return date("F j, Y, g:i a", (int)$timestamp);
}

/**
 * @brief find and replace string
 */
function replace($text, $oldpart, $newpart){
    return mb_ereg_replace($oldpart, $newpart, $text);
}

function server2ClientTime($time)
{
    return $time - 60 * safeGetSession("timeZoneOffset");
}

function client2ServerTime($time)
{
    return $time + 60 * safeGetSession("timeZoneOffset");
}

function reverse($sItems, $delimiter = ",")
{
    $items = explode(",", $sItems);
    $sItems = "";
    for($i=count($items)-1;$i>=0;$i--)
    {
        $sItems = $sItems.$items[$i].(($i==0)?"":",");
    }
    return $sItems;
}

function isEmptyObject($object)
{
    $vars = get_object_vars($object);
    foreach($vars as $key=>$value)
    {
        if(!empty($value))
            return false;
    }
    return true;
}

/**
 * @brief hash the password
 */
function hashPass($password){
    return hash("md5", $password);
}

/**
 * @brief convert rgba color 'rgba(..,..,..,..)' into hex #...... 
 */
function rgbaToHex($string){
	//rgba(240, 201, 201, 0.42)
	$string = str_replace('rgba(', '', $string);
	$string = str_replace(')', '', $string);
	$arr = explode(',', $string);
	$output = array();
	$i = 0;
	for($i = 0; $i<3; $i++){
		$output[$i] = dechex((int)$arr[$i]);
		if(strlen($output[$i])==1)
		{
			$output[$i] .= '0';
		}
	}
	$alpha = $arr[3];
	$hexCol = implode('', $output);
	
	$out = array();
	$out[0] = $hexCol;
    $out[1] = $alpha;
    $out[2] = dechex((int)($alpha * 0xFF));
	return $out;
}

define("MAIN_LETERS", " ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789\r\n\.\,\?\!\-\*\+\=\/\\\_\$\#\@\{\}\[\]\(\)\|\<\>\&\^\%ابتثجحخدذرزسشصضطظعغفقكلمنهويئؤءآأإةى");
define("SEARCH_LETERS", "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789ابتثجحخدذرزسشصضطظعغفقكلمنهويئؤءآأإةى");
define("SIMILER_LETERS_ALF", "أإآ");

function cleanHTML($content)
{
    $text = strip_tags($content);
    $text = html_entity_decode($text);
    $text = mb_ereg_replace("/[[:blank:]]+/"," ", $text);
    return mb_trim($text, " ");
}

function getSearchText($text)
{
    $text = mb_ereg_replace("[^".MAIN_LETERS."]", "", $text);
    $text = mb_ereg_replace("[^".SEARCH_LETERS."]", " ", $text);
    $text = mb_ereg_replace("[".SIMILER_LETERS_ALF."]","ا",$text);
    $text = mb_ereg_replace("/[[:blank:]]+/"," ", $text);
    return mb_trim($text, " ");
}

function getSearchTextWithoutNums($text)
{
    $text = mb_ereg_replace("[^".MAIN_LETERS."]", "", $text);
    $text = mb_ereg_replace("[^".SEARCH_LETERS."]", " ", $text);
    $text = mb_ereg_replace("[".SIMILER_LETERS_ALF."]","ا",$text);
    $text = mb_ereg_replace("[1234567890]","",$text);
    $text = mb_ereg_replace("/[[:blank:]]+/"," ", $text);
    return mb_trim($text, " ");
}

function echoTime($time, $msg = "")
{
    if($time>0)
    {
        $duration = (int)(1000.0 * microtime(true) - $time);
        echo "<p>$msg : $duration ms </p>";
    }
    $time = 1000.0 * microtime(true);
    return (int)$time;
}

function mb_trim($string, $trim_chars){
    return preg_replace('/^['.$trim_chars.']*(?U)(.*)['.$trim_chars.']*$/u', '\\1',$string);
}

function isMobileBrowser () {
    $user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $user_agent);
}

function getFiles($dir, $extFilter) 
{
    $filesPaths = array();
    $dir=$dir."/";
    $dir = str_replace("\\", "/", $dir);
    $dir = str_replace("//", "/", $dir);

    $dh = opendir($dir);
    if ($dh) 
    {
        while (($file = readdir($dh)) !== false) 
        {
            if($file=="."||$file=="..")continue;
            $filePath = $dir.$file;
            $path_parts = pathinfo($filePath);

            if(is_dir($filePath))
                $filesPaths = array_merge($filesPaths, getFiles($filePath, $extFilter));
            else if($extFilter=="*" || (isset($path_parts['extension']) && strstr($extFilter,".".$path_parts['extension'])))
                $filesPaths[] = $filePath;
        }
        closedir($dh);
    }
    return $filesPaths;
}

function shortText($text, $limit = 23) {
    if(mb_strlen($text)<($limit+3))return $text;
    return mb_substr($text, 0, $limit, 'utf8')."...";
}

function stripWordsBeginWith($text, $marks)
{
    foreach ($marks as $mark)
    {
        while (true)
        {
            $start = mb_strpos($text, $mark, 0);
            if($start===false)break;
            
            $end = mb_strpos($text, " ", $start);
            if($end===false)$end = mb_strlen($text);

            $firstText = mb_substr($text, 0, $start);
            $lastText = mb_substr($text, $end+1, mb_strlen($text)-$end);

            $text = $firstText."".$lastText;
        }
    }
    
    return $text;
}

function isArabicDate($date)
{
    return (preg_match('/[أ-ي]/ui', $date));
}

function isEnglishDate($date)
{
    return (preg_match('/[a-z]/ui', $date));
}

function arabicToEnglishDate($arabicDate)
{
    $dateArray = explode(" ", $arabicDate);

    $arabicEnglishDay = ['الجمعة' => 'Fri', 'السبت' => 'Sat', 'الأحد' => 'Sun', 'الإثنين' => 'Mon', 'الثلاثاء' => 'Tue', 'الأربعاء' => 'Wed', 'الخميس' => 'Thu'];
    $arabicEnglishMonth = ["يناير" => "Jan", "فبراير" => "Feb", "مارس" => "Mar", "أبريل" => "Apr", "مايو" => "May", "يونيو" => "Jun", "يونيه" => "Jun", "يوليه" => "Jul", "يوليو" => "Jul", "أغسطس" => "Aug", "سبتمبر" => "Sep", "أكتوبر" => "Oct", "نوفمبر" => "Nov", "ديسمبر" => "Dec"];
    $arabicEnglishMode = ['ص' => 'AM', 'م' =>'PM'];

    $englishDate = $arabicEnglishDay[str_replace('،', '', $dateArray[0])];
    $englishDate .= ', '.$dateArray[1].' '.$arabicEnglishMonth[$dateArray[2]].' ';
    $englishDate .= $dateArray[3].' '.$dateArray[4].' '.$arabicEnglishMode[$dateArray[5]];

    return $englishDate;
}

function tr($text, $language)
{
    if($language=="ar")
    {
        switch($text)
        {
            case "photo": return "صورة";
            case "link": return "رابط";
            case "email": return "عنوان";
        }
    }
    
    return $text;
}

function hashTagLink($feedType)
{
    if($feedType=="facebook")
        return "https://twitter.com/hashtag/";
       
    return "https://www.facebook.com/hashtag/";
}

function hijriMonth($name ,$lang){
    if($lang == 'ar'){
        switch($name){
            case '1':
                return 'محرم';
                break;
            case '2':
                return 'صفر';
                break;
            case '3':
                return 'ربيع الأول';
                break;
            case '4':
                return 'ربيع الثاني';
                break;
            case '5':
                return 'جماد الأول';
                break;
            case '6':
                return 'جماد الثاني';
                break;
            case '7':
                return 'رجب';
                break;
            case '8':
                return 'شعبان';
                break;
            case '9':
                return 'رمضان';
                break;
            case '10':
                return 'شوال';
                break;
            case '11':
                return 'ذو القعدة';
                break;
            case '12':
                return 'ذو الحجة';
                break;
        }
    }else{
        switch($name){
            case '1':
                return 'Muhrram';
                break;
            case '2':
                return 'Safar';
                break;
            case '3':
                return 'Raby Al-Awal';
                break;
            case '4':
                return 'Raby Al-Thaany';
                break;
            case '5':
                return 'Jumaada Al-Awal';
                break;
            case '6':
                return 'Jumaada Al-Thaany';
                break;
            case '7':
                return 'Rajab';
                break;
            case '8':
                return 'Sha`bban';
                break;
            case '9':
                return 'Ramadhan';
                break;
            case '10':
                return 'Shawwal';
                break;
            case '11':
                return 'Thul Qa`dah';
                break;
            case '12':
                return 'Thul Hijjah';
                break;
        }
    }
}
function MiladyMonth($name ,$lang){
    if($lang == 'ar'){
        switch($name){
            case '1':
                return 'يناير';
                break;
            case '2':
                return 'فبراير';
                break;
            case '3':
                return 'مارس';
                break;
            case '4':
                return 'ابريل';
                break;
            case '5':
                return 'مايو';
                break;
            case '6':
                return 'يونيه';
                break;
            case '7':
                return 'يوليو';
                break;
            case '8':
                return 'اغسطس';
                break;
            case '9':
                return 'سبتمبر';
                break;
            case '10':
                return 'أكتوبر';
                break;
            case '11':
                return 'نوفمبر';
                break;
            case '12':
                return 'ديسمبر';
                break;
        }
    }else{
        switch($name){
            case '1':
                return 'January';
                break;
            case '2':
                return 'February';
                break;
            case '3':
                return 'March';
                break;
            case '4':
                return 'April';
                break;
            case '5':
                return 'May';
                break;
            case '6':
                return 'June';
                break;
            case '7':
                return 'July';
                break;
            case '8':
                return 'August';
                break;
            case '9':
                return 'September';
                break;
            case '10':
                return 'October';
                break;
            case '11':
                return 'November';
                break;
            case '12':
                return 'December';
                break;
        }
    }
}
function MiladyMonthNumber($name , $lang){
    if($lang == 'ar'){
        switch($name){
            case 'يناير':
                return 1;
                break;
            case 'فبراير':
                return 2;
                break;
            case 'مارس':
                return 3;
                break;
            case 'ابريل':
                return 4;
                break;
            case 'مايو':
                return 5;
                break;
            case 'يونيه':
                return 6;
                break;
            case 'يوليو':
                return 7;
                break;
            case 'اغسطس':
                return 8;
                break;
            case 'سبتمبر':
                return 9;
                break;
            case 'أكتوبر':
                return 10;
                break;
            case 'نوفمبر':
                return 11;
                break;
            case 'ديسمبر':
                return 12;
                break;
        }
    }else{
        switch($name){
            case 'January':
                return 1;
                break;
            case 'February':
                return 2;
                break;
            case 'March':
                return 3;
                break;
            case 'April':
                return 4;
                break;
            case 'May':
                return 5;
                break;
            case 'June':
                return 6;
                break;
            case 'July':
                return 7;
                break;
            case 'August':
                return 8;
                break;
            case 'September':
                return 9;
                break;
            case 'October':
                return 10;
                break;
            case 'November':
                return 11;
                break;
            case 'December':
                return 12;
                break;
        }
    }
}
function getImgEvent($name ,$lang){
    if($lang == 'ar'){
        switch($name){
            case 'السنة الهجرية':
                return 'New_Year';
                break;
            case 'رمضان':
                return 'Fanos';
                break;
            case 'عيد الفطر':
                return 'Eid_Mubarak';
                break;
            case 'عيد الأضحي':
                return 'Ka3ba';
                break;
            case 'المولد النبوي':
                return 'Muhammad';
                break;
            case 'ليلة القدر':
                return 'Laylt_ALkadr';
                break;
            case 'وقفة عرفة':
                return 'Arafa';
                break;
        }
    }else{
        switch($name){
            case 'Islamic New Year':
                return 'New_Year';
                break;
            case 'Ramdahan':
                return 'Fanos';
                break;
            case 'Eid Al-Fitr':
                return 'Eid_Mubarak';
                break;
            case 'Eid Al-Adha':
                return 'Ka3ba';
                break;
            case 'Milad Un Nabi':
                return 'Muhammad';
                break;
            case 'Laylat al Kadr':
                return 'Laylt_ALkadr';
                break;
            case 'Waqf Al Arafa':
                return 'Arafa';
                break;
        }
    }

}
function getPrayerName($id ,$lang){
    if($lang == 'ar'){
        switch($id){
            case '1':
                return 'الفجر';
                break;
            case '2':
                return 'الشروق';
                break;
            case '3':
                return 'الظهر';
                break;
            case '4':
                return 'العصر';
                break;
            case '5':
                return 'المغرب';
                break;
            case '6':
                return 'العشاء';
                break;
        }
    }
    else{
        switch($id){
            case '1':
                return 'Fajer';
                break;
            case '2':
                return 'Sunrise';
                break;
            case '3':
                return 'Zohr';
                break;
            case '4':
                return 'Asr';
                break;
            case '5':
                return 'Maghreb';
                break;
            case '6':
                return 'Eshaa';
                break;
        }

    }

}
function getEventLan($lang){
    $arevents = ['السنة الهجرية','المولد النبوي','رمضان','ليلة القدر','عيد الفطر','وقفة عرفة','عيد الأضحي'];
    $enevents = ['Islamic New Year','Milad Un Nabi','Ramdahan','Laylat al Kadr','Eid Al-Fitr' ,'Waqf Al Arafa','Eid Al-Adha'];
    if($lang == 'ar'){
        return $arevents ;
    }else{
        return $enevents ;
    }
}
function getPrayerLan($lang){
    $arPrayer = ['الفجر','الشروق','الظهر','العصر','المغرب','العشاء'];
    $enPrayer = ['Fajer','Sunrise','Zohr','Asr','Maghreb','Eshaa'] ;

    if($lang =='ar'){
        return $arPrayer ;
    }else{
        return $enPrayer ;
    }
}
function getTitle($lang){
    $arTitle = ['prayer' => 'أوقات الصلاة' ,'weather'=>'حالة الطقس' ,'places'=>'أقرب مساجد',
        'events'=> 'المناسبات الإسلامية', 'azkar' =>'الإذكار' ,'calendar'=>'التقويم'] ;
    $enTitle = ['prayer' => 'Prayer Time' ,'weather'=>'Weather Stauts' ,'places'=>'Places',
        'events'=> 'Islamic Events', 'azkar' => 'Azkar' ,'calendar'=>'Calendar'] ;
    if($lang == 'ar'){
        return $arTitle ;
    }else{
        return $enTitle ;
    }
}
function getDirection($lang){
    if($lang == 'ar'){
        return 'rtl';
    }else{
        return 'ltr';
    }
}
function getMonthHijri($name,$lang){
    if($lang == 'ar'){
        switch($name){
            case 'Muhrram':
                return 'محرم';
                break;
            case 'Safar':
                return 'صفر';
                break;
            case 'Raby Al-Awal':
                return 'ربيع الأول';
                break;
            case 'Raby Al-Thaany':
                return 'ربيع الثاني';
                break;
            case 'Jumaada Al-Awal':
                return 'جماد الأول';
                break;
            case 'Jumaada Al-Thaany':
                return 'جماد الثاني';
                break;
            case 'Rajab':
                return 'رجب';
                break;
            case 'Sha`bban':
                return 'شعبان';
                break;
            case 'Ramadhan':
                return 'رمضان';
                break;
            case 'Shawwal':
                return 'شوال';
                break;
            case 'Thul Qa`dah':
                return 'ذو القعدة';
                break;
            case 'Thul Hijjah':
                return 'ذو الحجة';
                break;
        }
    }else{
        switch($name){
            case 'محرم':
                return 'Muhrram';
                break;
            case 'صفر':
                return 'Safar';
                break;
            case 'ربيع الأول':
                return 'Raby Al-Awal';
                break;
            case 'ربيع الثاني':
                return 'Raby Al-Thaany';
                break;
            case 'جماد الأول':
                return 'Jumaada Al-Awal';
                break;
            case 'جماد الثاني':
                return 'Jumaada Al-Thaany';
                break;
            case 'رجب':
                return 'Rajab';
                break;
            case 'شعبان':
                return 'Sha`bban';
                break;
            case 'رمضان':
                return 'Ramadhan';
                break;
            case 'شوال':
                return 'Shawwal';
                break;
            case 'ذو القعدة':
                return 'Thul Qa`dah';
                break;
            case 'ذو الحجة':
                return 'Thul Hijjah';
                break;
        }
    }
}
function getMonthMilady($name ,$lang){
    if($lang == 'ar'){
        switch($name){
            case 'January':
                return 'يناير';
                break;
            case 'February':
                return 'فبراير';
                break;
            case 'March':
                return 'مارس';
                break;
            case 'April':
                return 'ابريل';
                break;
            case 'May':
                return 'مايو';
                break;
            case 'June':
                return 'يونيه';
                break;
            case 'July':
                return 'يوليو';
                break;
            case 'August':
                return 'اغسطس';
                break;
            case 'September':
                return 'سبتمبر';
                break;
            case 'October':
                return 'أكتوبر';
                break;
            case 'November':
                return 'نوفمبر';
                break;
            case 'December':
                return 'ديسمبر';
                break;
        }
    }else{
        switch($name){
            case 'يناير':
                return 'January';
                break;
            case 'فبراير':
                return 'February';
                break;
            case 'مارس':
                return 'March';
                break;
            case 'ابريل':
                return 'April';
                break;
            case 'مايو':
                return 'May';
                break;
            case 'يونيه':
                return 'June';
                break;
            case 'يوليو':
                return 'July';
                break;
            case 'أغسطس':
                return 'August';
                break;
            case 'سبتمبر':
                return 'September';
                break;
            case 'أكتوبر':
                return 'October';
                break;
            case 'نوفمبر':
                return 'November';
                break;
            case 'ديسمبر':
                return 'December';
                break;
        }
    }

}

function getActivePrayer($active , $current){
    if($active == $current){
        echo 'event-active' ;
    }
}
$prayerKey = ['Fajer'=>'الفجر','Sunrise'=> 'الشروق','Zohr'=>'الظهر',
                'Asr'=>'العصر','Maghreb'=>'المغرب','Eshaa'=>'العشاء'];




?>

