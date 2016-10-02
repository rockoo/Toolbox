<?php namespace Fantasyrock\Validator;

use Fantasyrock\Validator\Contracts\CanSanitizeInput;
use Fantasyrock\Validator\Contracts\CanValidateInput;
use Fantasyrock\Validator\Contracts\ValidatorAbstract;
use Fantasyrock\Validator\Contracts\ValidatorInterface;
use Fantasyrock\Validator\Helpers\General;

class Client extends ValidatorAbstract implements ValidatorInterface
{
    use General;

    public function validateWith(CanValidateInput $validator)
    {
        $validator = $this->setValidator($this->class_basename($validator))->getValidator();

        $this->input = $validator->validate($this->input);

        return $this;
    }

    public function sanitizeWith(CanSanitizeInput $sanitizer)
    {
        $sanitizer = $this->setSanitizer($this->class_basename($sanitizer))->getSanitizer();

        $this->input = $sanitizer->sanitize($this->input);

        return $this;
    }

    public function setValidator($validator)
    {
        if (is_object($validator)) return $this->validator = $validator; // Allow loading as object

        if (!class_exists($validator = $this->getClassPath($this) . 'Validators\\' . $validator)) { // or string

            throw new \Exception(
                sprintf('%s', 'No validator found ' . $validator)
            );
        }

        $this->validator = $this->validator ?: new $validator;

        return $this;
    }

    public function setSanitizer($sanitizer)
    {
        if (is_object($sanitizer)) return $this->sanitizer = $sanitizer; // Allow loading as object

        if (!class_exists($sanitizer = $this->getClassPath($this) . 'Sanitizers\\' . $sanitizer)) { // or string

            throw new \Exception(
                sprintf('%s', 'No sanitizer found ' . $sanitizer)
            );
        }

        $this->sanitizer = $this->sanitizer ?: new $sanitizer;

        return $this;
    }

    public function getValidator()
    {

        if (!$this->validator) {
            throw new \Exception(
                sprintf('%s', 'No validator has been set. Please set validator first')
            );
        }

        return $this->validator;
    }

    public function getSanitizer()
    {
        if (!$this->sanitizer) {
            throw new \Exception(
                sprintf('%s', 'No sanitizer has been set. Please set sanitizer first')
            );
        }

        return $this->sanitizer;
    }
}