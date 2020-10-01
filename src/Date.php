<?php

/*
 * This file is part of the PHPUtils package.
 *
 * (c) Prince Dorcis <princedorcis@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Prinx\Utils;

use DateTime;

/**
 * Date utilities class.
 *
 * @author Prince Dorcis <princedorcis@gmail.com>
 */
class Date
{
    /**
     * Return number of days from a given date (in string).
     */
    public static function daysNumberFrom($date_string, $strict = false, $format = 'Y-m-d')
    {
        $now = null;
        $date = null;

        if ($strict) {
            $now = time();
            $date = strtotime($date_string);
        } else {
            $now = strtotime(date($format));
            $d = date($format, strtotime($date_string));
            $date = strtotime($d);
        }

        $diff_in_seconds = $date - $now;
        $one_day_in_seconds = 60 * 60 * 24;

        $diff_in_seconds / $one_day_in_seconds;

        return (int) round($diff_in_seconds / $one_day_in_seconds);
    }

    public static function numberOfDaysFrom($date_string, $strict = false, $format = 'Y-m-d')
    {
        return self::daysNumberFrom($date_string, $strict, $format);
    }

    public static function now($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    public static function isDate($date, $format = 'j/n/Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        // echo $d->format($format) . '<br>';
        // echo $date;
        // return $d && $d->format($format) === $date;
        return (bool) $d;
    }

    public static function hasPassed($date, $format = 'j/n/Y')
    {
        return DateTime::createFromFormat($format, $date) < DateTime::createFromFormat($format, date($format));
    }

    public static function tooFar($date, $max, $format = 'j/n/Y')
    {
        return DateTime::createFromFormat($format, $max) < DateTime::createFromFormat($format, $date);
    }

    public static function dayToSecond(int $days = 1)
    {
        return 60 * 60 * 24 * $days;
    }

    public static function futureDay(int $days = 1)
    {
        return time() + self::dayToSecond($days);
    }

    public static function pastDay(int $days = 1)
    {
        return self::futureDay(-$days);
    }

    public static function yearToSecond(int $years = 1)
    {
        return self::dayToSecond() * 365 * $years;
    }

    public static function futureYear(int $years = 1)
    {
        return time() + self::yearToSecond($years);
    }

    public static function toDatabaseFormat($date, $currentFormat = 'j/n/Y')
    {
        $db_date = DateTime::createFromFormat($currentFormat, $date);

        return $db_date->format('Y-m-d H:i:s');
    }
}
