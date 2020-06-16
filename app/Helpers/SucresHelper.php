<?php

namespace App\Helpers;

use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
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
                $response = back()->withInput()->with('error', 'Commence par cliquer plus lentement ¯\_(ツ). Réessaie dans ' . $decayInMinutes . ' ' . Str::plural('minute', $decayInMinutes) . '.');
                $response->throwResponse();
            }

            throw new TooManyRequestsHttpException();
        }

        return true;
    }

    public static function throttle($key = 'validation', $maxAttempts = 5, $decayInMinutes = 10)
    {
        $ip_throttle = Throttle::get([
            'ip'    => request()->ip(),
            'route' => $key,
        ], $maxAttempts, $decayInMinutes);

        if ($ip_check = $ip_throttle->check()) {
            $ip_throttle->hit();
        }

        return $ip_check;
    }

    const NICEDATE_MINIMAL = 0;
    const NICEDATE_WITH_HOURS = 1;

    public static function niceDate(Carbon $date, $ret_type = self::NICEDATE_WITH_HOURS)
    {
        if ($date->isToday()) {
            $markup = 'aujourd\'hui';
        } elseif ($date->isLastDay()) {
            $markup = 'hier';
        } else {
            $markup = sprintf('le %s', $date->format('d/m/Y'));
        }

        switch ($ret_type) {
            case self::NICEDATE_WITH_HOURS:
                $markup .= sprintf(' à %s', $date->format('H:i:s'));

                break;

            case self::NICEDATE_MINIMAL:
            default:
                break;
        }

        return $markup;
    }
}
