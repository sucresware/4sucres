<?php

namespace App\Helpers;

class sucresHelper
{
    /**
     * Matches what we call "unicode whitespace", i.e. normal ASCII whitespace as well as special
     * unicode control and whitespace properties. Use only in regex with /u modifier!
     *
     * By using:
     * - \pZ we match any kind of whitespace or invisible separator
     * - \p{Cc} we match control characters
     * - \x{feff} we match \uFEFF ; in the past known as BOM
     *
     * http://www.regular-expressions.info/unicode.html has a good overview
     */
    const RE_UNICODE_WS = '[\pZ\p{Cc}\x{feff}]';

    /**
     * Like trim() but also handles unicode specific properties.
     *
     * @param string $str
     *
     * @return string
     */
    public static function unicodeTrim($str): string
    {
        $str = preg_replace(
            '/^' . self::RE_UNICODE_WS . '+|' . self::RE_UNICODE_WS . '+$/u',
            ' ',
            $str
        );

        return trim($str, "\t\n\r\0\x0B" . '⠀');
    }
}
