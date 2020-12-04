<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;
use GrahamCampbell\Throttle\Facades\Throttle as Throttler;

class Throttle implements Rule
{
    /**
     * The throttle key.
     *
     * @var string
     */
    protected $key = 'validation';

    /**
     * The maximum number of attempts a user can perform.
     *
     * @var int
     */
    protected $maxAttempts = 5;

    /**
     * The amount of minutes to restrict the requests by.
     *
     * @var int
     */
    protected $decayInMinutes = 10;

    /**
     * Create a new rule instance.
     *
     * @param int $maxAttempts
     * @param int $decayInMinutes
     */
    public function __construct($key = 'validation', $maxAttempts = 5, $decayInMinutes = 10)
    {
        $this->key = $key;
        $this->maxAttempts = $maxAttempts;
        $this->decayInMinutes = $decayInMinutes;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Throttler::attempt(
            ['ip' => $this->request()->ip(), 'route' => $this->key],
            $this->maxAttempts,
            $this->decayInMinutes
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('C\'est un peu trop rapide D: ! Réessaie dans ' . $this->decayInMinutes . ' ' . Str::plural('minute', $this->decayInMinutes) . '.');
    }

    /**
     * Get the current HTTP request.
     *
     * @return \Illuminate\Http\Request
     */
    protected function request()
    {
        return app(Request::class);
    }
}
