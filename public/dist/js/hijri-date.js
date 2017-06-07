/**
 *
 * @description JavaScript Hijri Date Function
 * @version 1.0
 *
 * @author (c) ZulNs, Yogyakarta, December 2013
 *
 * @namespace HijriDate
 */

function HijriDate(year, month, date, hour, minute, second, millisecond) {
    var gregDate = new Date(),
        time,
        day,
        timezoneOffset = gregDate.getTimezoneOffset() * 6e4;

    if (year === undefined) {
        time = gregDate.getTime() - timezoneOffset;
        updateDate();
    }
    else if (month === undefined) {
        time = HijriDate.parseInt(year, 0) - timezoneOffset;
        updateDate();
    }
    else {
        year = HijriDate.parseInt(year, 1);
        month = HijriDate.parseInt(month, 0);
        date = HijriDate.parseInt(date, 1);
        hour = HijriDate.parseInt(hour, 0);
        minute = HijriDate.parseInt(minute, 0);
        second = HijriDate.parseInt(second, 0);
        millisecond = HijriDate.parseInt(millisecond, 0);
        updateTime();
    }

    this.toString = function() {
        return this.getFullDateString();
    };

    this.valueOf = function() {
        return time;
    };

    this.getDateString = function() {
        return	this.getDayName() + ', ' +
            date + ' ' +
            this.getMonthName() + ' ' +
            this.getFullYearString();
    };

    this.getTimeString = function() {
        return	HijriDate.toDigit(hour, 2) + ':' +
            HijriDate.toDigit(minute, 2) + ':' +
            HijriDate.toDigit(second, 2) + '.' +
            HijriDate.toDigit(millisecond, 3);
    };

    this.getFullDateString = function() {
        return this.getDateString() + ' ' + this.getTimeString();
    };

    this.getTime = function() {
        return time + timezoneOffset;
    };

    this.getFullYear = function() {
        return year;
    };

    this.getFullYearString = function() {
        return (year > 0) ? HijriDate.toDigit(year, 4) + " H" : HijriDate.toDigit(Math.abs(year - 1), 4) + " BH";
    };

    this.getMonth = function() {
        return month;
    };

    this.getMonthName = function(mon) {
        return HijriDate.monthNames[(mon === undefined) ? month : parseInt(mon)];
    };

    this.getMonthShortName = function(mon) {
        return HijriDate.monthShortNames[(mon === undefined) ? month : parseInt(mon)];
    };

    this.getDate = function() {
        return date;
    };

    this.getHours = function() {
        return hour;
    };

    this.getMinutes = function() {
        return minute;
    };

    this.getSeconds = function() {
        return second;
    };

    this.getMilliseconds = function() {
        return millisecond;
    };

    this.getDay = function() {
        return day;
    };

    this.getDayName = function(dy) {
        return HijriDate.weekdayNames[(dy === undefined) ? day : parseInt(dy)];
    };

    this.getDayShortName = function(dy) {
        return HijriDate.weekdayShortNames[(dy === undefined) ? day : parseInt(dy)];
    };

    this.getDaysInMonth = function() {
        return HijriDate.daysInMonth((year - 1) * 12 + month);
    };

    this.getJavaWeekday = function() {
        return this.getGregorianDate().getJavaWeekday();
    };

    this.getJavaWeekdayName = function(dy) {
        return this.getGregorianDate().getJavaWeekdayName(dy);
    };

    this.getGregorianDate = function() {
        gregDate.setTime(time + timezoneOffset);
        return gregDate;
    };

    this.setTime = function(tm) {
        time = parseInt(tm) - timezoneOffset;
        updateDate();
    };

    this.setFullYear = function(yr) {
        year = parseInt(yr);
        updateTime();
    };

    this.setMonth = function(mon) {
        month = parseInt(mon);
        updateTime();
    };

    this.setDate = function(dt) {
        date = parseInt(dt);
        updateTime();
    };

    this.setHours = function(hr) {
        hour = parseInt(hr);
        updateTime();
    };

    this.setMinutes = function(min) {
        minute = parseInt(min);
        updateTime();
    };

    this.setSeconds = function(sec) {
        second = parseInt(sec);
        updateTime();
    };

    this.setMilliseconds = function(ms) {
        millisecond = parseInt(ms);
        updateTime();
    };

    function updateDate() {
        var tm = time - HijriDate.constInterval,
            range;
        month = parseInt(parseInt((tm / 864e5)) / HijriDate.moonCycle);
        month = (tm >= 0) ? month : --month;
        date = HijriDate.daysCount(month) * 864e5;
        tm = (tm >= 0) ? tm - date : date + tm;
        millisecond = tm % 1e3;
        tm = parseInt(tm / 1e3);
        second = tm % 60;
        tm = parseInt(tm / 60);
        minute  = tm % 60;
        tm = parseInt(tm / 60);
        hour = tm % 24;
        tm = parseInt(tm / 24);
        date = tm;
        range = HijriDate.daysInMonth(month);
        if (date >= range) {
            month++;
            date -= range;
        }
        date++;
        year = Math.floor(month / 12) + 1;
        month = (month >= 0) ? month % 12 : (month % 12 === 0) ? 0 : 12 + month % 12;
        day = Math.floor(time / 864e5);
        day = (day + 4) % 7;
        day = (day < 0) ? day + 7 : day;
    }

    function updateTime() {
        var months = (year - 1) * 12 + month;
        time = (months >= 0) ? HijriDate.daysCount(months) : -HijriDate.daysCount(months);
        time += date;
        time *= 864e5;
        time += hour * 36e5 + minute * 6e4 + second * 1e3 + millisecond - 864e5;
        time += HijriDate.constInterval;
        updateDate();
    }
}

HijriDate.moonCycle = 29.5305882;

HijriDate.constInterval = -42521608800000; // -42521587200000;
// value of time interval in milliseconds
// from July 18, 622AD 06:00 PM to January 1, 1970AD, 00:00 AM

HijriDate.monthNames = ["Muharram", "Safar", "Rabi'ul-Awwal", "Rabi'ul-Akhir", "Jumadal-Ula", "Jumadal-Akhir",
    "Rajab", "Sha'ban", "Ramadan", "Syawwal", "Dhul-Qa'da", "Dhul-Hijja"];

HijriDate.monthShortNames = ['Muh', 'Saf', 'RAw', 'RAk', 'JAw', 'JAk', 'Raj', 'Sha', 'Ram', 'Sya', 'DhQ', 'DhH'];

HijriDate.weekdayNames = ["Ahad", "Ithnin", "Thulatha", "Arba'a", "Khams", "Jumu'ah", "Sabt"];

HijriDate.weekdayShortNames = ['Ahd', 'Ith', 'Thu', 'Arb', 'Kha', 'Jum', 'Sab'];

HijriDate.toDigit = function(num, digit) {
    var ns = num.toString();
    if (ns.length > digit) return ns;
    return ('00000000' + ns).slice(-digit);
}

HijriDate.daysInMonth = function(month) {
    return (month >= 0) ? HijriDate.daysCount(month + 1) - HijriDate.daysCount(month) : HijriDate.daysCount(month) - HijriDate.daysCount(month + 1);
}

HijriDate.daysCount = function(month) {
    if (month >= 0) return parseInt(month * HijriDate.moonCycle);
    var times = (parseInt(-month / 30601) + 1) * 30601;
    return parseInt(times * HijriDate.moonCycle) - parseInt((times + month) * HijriDate.moonCycle);
}

HijriDate.parseInt = function(num, def) {
    var res = parseInt(num);
    return isNaN(res) ? def : res;
}

Date.monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

Date.monthShortNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

Date.weekdayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ];

Date.weekdayShortNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

Date.javaWeekdayNames = ['Legi', 'Pahing', 'Pon', 'Wage', 'Kliwon'];

Date.prototype.getHijriDate = function() {
    return new HijriDate(this.getTime());
};

Date.prototype.getDaysInMonth = function() {
    var y = this.getFullYear(),
        isLeapYear = (y % 100 !== 0) && (y % 4 === 0) || (y % 400 === 0),
        daysInMonth = [31, isLeapYear ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    return daysInMonth[this.getMonth()];
};

Date.prototype.getMonthName = function(month) {
    return Date.monthNames[(month === undefined) ? this.getMonth() : parseInt(month)];
};

Date.prototype.getMonthShortName = function(month) {
    return Date.monthShortNames[(month === undefined) ? this.getMonth() : parseInt(month)];
};

Date.prototype.getDayName = function(day) {
    return Date.weekdayNames[(day === undefined) ? this.getDay() : parseInt(day)];
};

Date.prototype.getDayShortName = function(day) {
    return Date.weekdayShortNames[(day === undefined) ? this.getDay() : parseInt(day)];
};

Date.prototype.getJavaWeekday = function() {
    var day = (this.getTime() - this.getTimezoneOffset() * 6e4) / 864e5;
    day = Math.floor(day);
    day = (day + 3) % 5;
    return (day < 0) ? day + 5 : day;
};

Date.prototype.getJavaWeekdayName = function(day) {
    return Date.javaWeekdayNames[(day === undefined) ? this.getJavaWeekday() : parseInt(day)];
};

Date.prototype.getFullYearString = function() {
    var y = this.getFullYear();
    return (y > 0) ? HijriDate.toDigit(y, 4) + " AD" : HijriDate.toDigit(Math.abs(y - 1), 4) + " BC";
};

Date.prototype.getDateString = function() {
    return	this.getDayName() + ', ' +
        this.getMonthName() + ' ' +
        this.getDate() + ', ' +
        this.getFullYearString();
};

Date.prototype.getTimeString = function() {
    return	HijriDate.toDigit(this.getHours(), 2) + ':' +
        HijriDate.toDigit(this.getMinutes(), 2) + ':' +
        HijriDate.toDigit(this.getSeconds(), 2) + '.' +
        HijriDate.toDigit(this.getMilliseconds(), 3);
};

Date.prototype.getFullDateString = function() {
    return this.getDateString() + ' ' + this.getTimeString();
};
