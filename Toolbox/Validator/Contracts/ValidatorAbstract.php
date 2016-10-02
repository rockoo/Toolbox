<?php namespace Fantasyrock\Validator\Contracts;

use Fantasyrock\Validator\Helpers\General;

abstract class ValidatorAbstract
{
    use General;

    protected $validator;

    protected $sanitizer;

    protected $input;

    protected function getClassPath($class)
    {

        return str_replace($this->class_basename($class), '', get_class($class));
    }

    public function setInput($input)
    {

        $this->input = $input;

        return $this;
    }

    public function getInput()
    {
        return $this->input;
    }
}