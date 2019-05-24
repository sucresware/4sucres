<?php

namespace App\Helpers;

use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class SucresHelper
{
    public static function throttleOrFail($key = 'validation', $maxAttempts = 5, $decayInMinutes = 10)
    {
        if (auth()->check() && user()->can('bypass throttle')) {
            return true;
        }

        if (!self::throttle($key, $maxAttempts, $decayInMinutes)) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'level'  => 'warning',
                    'method' => __METHOD__,
                    'key'    => $key,
                ])
                ->log('ThrottleHit');

            if (request()->ajax()) {
                throw new TooManyRequestsHttpException($decayInMinutes);
            } elseif (request()->isMethod('post')) {
                $response = back()->withInput()->with('error', 'Commence par cliquer plus lentement ¯\_(ツ). Réessaie dans ' . $decayInMinutes . ' ' . str_plural('minute', $decayInMinutes) . '.');
                $response->throwResponse();
            }

            throw new TooManyRequestsHttpException();
        }

        return true;
    }

    public static function throttle($key = 'validation', $maxAttempts = 5, $decayInMinutes = 10)
    {
        $throttle = Throttle::get(['ip' => request()->ip(), 'route' => $key], $maxAttempts, $decayInMinutes);

        if ($check = $throttle->check()) {
            $throttle->hit();
        }

        return $check;
    }

    const NICEDATE_MINIMAL = 0;
    const NICEDATE_WITH_HOURS = 1;

    public static function niceDate(Carbon $date, $ret_type = self::NICEDATE_WITH_HOURS)
    {
        $diffInDays = $date->copy()->startOfDay()->diffInWeekDays(now()->startOfDay());

        switch ($diffInDays) {
            case 0:
                $markup = 'aujourd\'hui';

                break;
            case 1:
                $markup = 'hier';

                break;
            default:
                $markup = 'le ' . $date->format('d/m/Y');
        }

        if ($ret_type == self::NICEDATE_WITH_HOURS) {
            $markup .= ' à ' . $date->format('H:i:s');
        }

        return $markup;
    }

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
