<?php namespace Fantasyrock\Validator\Validators;

use Fantasyrock\Validator\Contracts\CanValidateInput;

class UsPhoneNumberValidator implements CanValidateInput
{
    public function validate($input)
    {
        $valid = $this->loadDataSource()->filter( function ($item) use ($input) {
            if ($item->code == $this->getAreaCode($input)) return $item;
        });

        if($valid->count()) return $input;
    }

    private function getAreaCode($input) {

        return substr($input, 0, 3);
    }

    private function loadDataSource($path = false) {

        $path = $path ?: __DIR__ . '/../data/us-phone-area-codes.json';

        return collect(
            json_decode(
                file_get_contents($path)
            )
        );
    }
}