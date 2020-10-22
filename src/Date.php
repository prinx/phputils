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
    public static function daysNumberFrom($dateString, $strict = false, $format = 'Y-m-d')
    {
        $now = null;
        $date = null;

        if ($strict) {
            $now = time();
            $date = strtotime($dateString);
        } else {
            $now = strtotime(date($format));
            $d = date($format, strtotime($dateString));
            $date = strtotime($d);
        }

        $diffInSeconds = $date - $now;
        $oneDayInSeconds = 60 * 60 * 24;

        return (int) round($diffInSeconds / $oneDayInSeconds);
    }

    public static function numberOfDaysFrom($dateString, $strict = false, $format = 'Y-m-d')
    {
        return self::daysNumberFrom($dateString, $strict, $format);
    }

    public static function now($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    public static function isDate($date, $format = 'j/n/Y')
    {
        $d = DateTime::createFromFormat($format, $date);

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
        return DateTime::createFromFormat($currentFormat, $date)->format('Y-m-d H:i:s');
    }
}
