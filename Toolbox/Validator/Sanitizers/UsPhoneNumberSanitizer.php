<?php namespace Fantasyrock\Validator\Sanitizers;

use Fantasyrock\Validator\Contracts\CanSanitizeInput;

class UsPhoneNumberSanitizer implements CanSanitizeInput
{

    public function sanitize($input)
    {
        $pattern  = '^[\\\\/:\*\?\"<>\|()\- ]^';
        $number  = preg_replace($pattern, '', $input);

        if(substr($number, 0, 2) == '+1') $number = substr($number, 2);

        return $number;
    }
}