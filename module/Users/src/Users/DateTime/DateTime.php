<?php

namespace Users\DateTime;

class DateTime
{
    const SERVER_DATETIME_OFFSET = '+3 hours';

    public static function getCurrentDateTime()
    {
        $time = new \DateTime();
        date_modify($time, DateTime::SERVER_DATETIME_OFFSET);
        return $time;
    }

    public static function getCurrentDateTimeString()
    {
        $time = new \DateTime();
        date_modify($time, DateTime::SERVER_DATETIME_OFFSET);
        return date_format($time, 'Y-m-d H:i:s');
    }

    public static function getMaxDateTime()
    {
        $time = new \DateTime('1st January 2999');
        date_modify($time, DateTime::SERVER_DATETIME_OFFSET);
        return $time;
    }

    public static function getMaxDateTimeString()
    {
        $time = new \DateTime('1st January 2999');
        date_modify($time, DateTime::SERVER_DATETIME_OFFSET);
        return date_format($time, 'Y-m-d H:i:s');
    }

    public static function getDateTimeString(\DateTime $dateTime)
    {
        return date_format($dateTime, 'Y-m-d H:i:s');
    }

    public static function getDateTime($string)
    {
        return ;
    }

}