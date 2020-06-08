<?php
namespace Prinx\Utils;

class Str
{
    public static function isAlphabetic($str, $min_length = 1, $max_length = -1)
    {
        $length = strlen($str);

        $in_length = $min_length <= $length;

        if ($max_length > $min_length) {
            $in_length = $in_length && ($length <= $max_length);
        }

        return $in_length && '' . intval($str) !== $str && '' . floatval($str) !== $str;
    }

    public static function isNumeric($num)
    {
        return self::isIntegerNumeric($num);
    }

    public static function isFloatNumeric($num)
    {
        return preg_match('/^[0-9]+(,[0-9]+)*\.?[0-9]*$/', $num);
    }

    public static function isIntegerNumeric($num)
    {
        return preg_match('/^[0-9]+(,[0-9]+)*$/', $num);
    }

    public static function camelCase($name)
    {
        return lcfirst(self::pascalCase($name));
    }

    public static function pascalCase($name, $separators = ['_', '-', ' '])
    {
        $separators = is_string($separators) ? [$separators] : $separators;

        $pascal_case = $name;

        foreach ($separators as $sep) {
            $chunks = explode($sep, $pascal_case);

            $temp = '';
            foreach ($chunks as $value) {
                $temp .= ucfirst($value);
            }

            $pascal_case = $temp;
        }

        return $pascal_case;
    }

    public static function internationaliseNumber(
        string $number,
        string $country = 'GH'
    ) {
        $default_country_code = '233';

        // To be completed
        $country_codes = [
            'GH' => '233',
        ];

        $num = preg_replace('/\([0-9]+?\)/', '', $number);
        $num = preg_replace('/[^0-9]/', '', $num);
        $num = ltrim($num, '0');

        $country_type = preg_match('/^[0-9]+$/', $country) ? 'prefix' : 'name';

        if (
            $country_type === 'name' &&
            array_key_exists($country, $country_codes)
        ) {
            $prefix = $country_codes[$country];
        } elseif (
            $country_type === 'prefix' &&
            in_array($country, $country_codes)
        ) {
            $prefix = $country;
        } else {
            $prefix = $default_country_code;
        }

        if (!preg_match('/^' . $prefix . '/', $num)) {
            $num = $prefix . $num;
        }

        return $num;
    }

    public static function capitalise(string $str)
    {
        $exploded = explode(' ', $str);
        $capitalised = '';

        foreach ($exploded as $value) {
            $capitalised .= ucfirst(strtolower($value)) . ' ';
        }

        return trim($capitalised);
    }

    public static function isTelNumber(string $str)
    {
        return preg_match('/^(\+|00)?[0-9-() ]{8,}$/', $str) === 1;
    }

    public static function isMaxLength(string $str, int $maxLen)
    {
        return strlen($str) <= $maxLen;
    }

    public static function isMinLength(string $str, int $minLen)
    {
        return strlen($str) >= $minLen;
    }
}
