<?php

namespace App\Rules;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class CheckOTP implements ValidationRule
{
    protected $attempt = 3; // maximum number of attempts
    protected $seconds = 1800; // time in seconds to wait before attempting again

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // if ($this->checkTooManyFailedAttempts()) {
        //     $fail('Too many login attempts. You may try again in '.round(RateLimiter::availableIn($this->throttleKey())/60).' minutes.');
        // }

        $user = User::where([
            'phone' => request('phone'),
            'role_id' => Role::where('role_name', 'User')->first()->role_id,
            'is_deleted' => 0
        ])
        ->firstOrFail();

        if (!$user && $user->otp != $value) {
            // $attempt = $this->checkRemainingAttempts();
            // RateLimiter::hit($this->throttleKey(), $this->seconds);
            // $fail("The password is incorrect. Only $attempt ".($attempt == 1 ? 'attempt' : 'attempts')." remaining");
            $fail(__("The provided OTP is incorrect."));
        }

        // RateLimiter::clear($this->throttleKey());


    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower(request('user_email')) . '|' . request()->ip();
    }

    /**
     * Checks if the allowed login attempts are over or not.
     *
     * @return void
     */
    public function checkTooManyFailedAttempts()
    {
        return RateLimiter::tooManyAttempts($this->throttleKey(), $this->attempt);
    }

    /**
     * Returns the remaining login attempts.
     *
     * @return void
     */
    public function checkRemainingAttempts()
    {
        return RateLimiter::remaining($this->throttleKey(), $this->attempt);
    }
}
