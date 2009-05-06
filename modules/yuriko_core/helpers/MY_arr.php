<?php defined('SYSPATH') OR die('No direct access allowed.');

class arr extends arr_Core
{
	/*
	 * Recursive version of in_array()
	 */
    public static function in_array($needle, $haystack)
    {
        foreach ($haystack as $stack)
        {
            if ($needle === $stack || (is_array($stack) && self::in_array($needle, $stack)))
            {
                return TRUE;
            }
        }
        return FALSE;
    }
}
