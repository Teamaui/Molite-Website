<?php

class TimeHelper
{

    public static function timeAgo($timestamp)
    {

        date_default_timezone_set("Asia/Jakarta");

        $time_ago = strtotime($timestamp);
        $current_time = time();
        $time_difference = $current_time - $time_ago;

        $seconds = abs($time_difference);
        $minutes      = round($seconds / 60);           // value 60 is seconds
        $hours        = round($seconds / 3600);         // value 3600 is 60 minutes * 60 sec
        $days         = round($seconds / 86400);        // value 86400 is 24 hours * 60 minutes * 60 sec
        $weeks        = round($seconds / 604800);       // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
        $months       = round($seconds / 2629440);      // value 2629440 is ((365+365+365+365+365)/5/12) days * 24 hours * 60 minutes * 60 sec
        $years        = round($seconds / 31553280);     // value 31553280 is 365.25 days * 24 hours * 60 minutes * 60 sec

        if ($seconds <= 60) {
            return "Baru saja"; // less than 1 minute ago
        } else if ($minutes <= 60) {
            return $minutes . " Menit yang lalu";
        } else if ($hours <= 24) {
            return $hours . " Jam yang lalu";
        } else if ($days <= 7) {
            return $days . " Hari yang lalu";
        } else if ($weeks <= 4.3) { // 4.3 == 30/7
            return $weeks . " Minggu yang lalu";
        } else if ($months <= 12) {
            return $months . " Bulan yang lalu";
        } else {
            return $years . " Tahun yang lalu";
        }
    }
}
