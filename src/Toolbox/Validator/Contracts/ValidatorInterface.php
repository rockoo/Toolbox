<?php namespace Fantasyrock\Validator\Contracts;

interface ValidatorInterface
{
    public function getValidator();

    public function getSanitizer();

    public function setValidator($validator);

    public function setSanitizer($sanitizer);

    public function validateWith(CanValidateInput $validator);

    public function sanitizeWith(CanSanitizeInput $sanitizer);
}