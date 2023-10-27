<?php

function format_number($number)
{
    if ($number >= 1000) {
        $suffixes = ['', 'k', 'm', 'b', 't'];
        $suffixIndex = 0;
        while ($number >= 1000) {
            $number /= 1000;
            $suffixIndex++;
        }
        return round($number, 2) . $suffixes[$suffixIndex];
    } else {
        return $number;
    }
}

function formatTime($time)
{
    $currentDateTime = \Carbon\Carbon::now();
    $messageTime = \Carbon\Carbon::parse($time);
    $diffInDays = $messageTime->diffInDays($currentDateTime);

    if ($diffInDays > 3) {
        // Trả về ngày tháng năm
        return $messageTime->locale('vi')->format('d/m/Y');
    } else {
        // Trả về định dạng thông thường
        $formattedTime = $messageTime->locale('vi')->diffForHumans($currentDateTime);
        return $formattedTime;
    }
}
