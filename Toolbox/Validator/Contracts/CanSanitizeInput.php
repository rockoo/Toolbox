<?php namespace Fantasyrock\Validator\Contracts;


interface CanSanitizeInput
{

    public function sanitize($input);
}