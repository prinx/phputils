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

/**
 * URL utilities class.
 *
 * @author Prince Dorcis <princedorcis@gmail.com>
 */
class URL
{
    /**
     * Check if a string is an URL.
     *
     * @param  string    $url
     * @return boolean
     */
    public static function isUrl($url)
    {
        /*
        The function `filter_var` to validate URL, has some limitations...
        Among all the limitations, tt doesn't parse url with non-latin caracters.
        I'm not really felling comfortable using it here.

        But let's stick to it for the meantime.

        TO IMPROVE this `is_url` function, do not remove completly
        the filter_var function unless you have a better function.
        Instead, use filter_var to validate and check the cases that
        filter_var does not support.
         */
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}
