# Validator

Package used to validate user input based on custom validators

## Installation

Just install through composer
```json
composer require fantasyrock/support
```

## Usage
In this example we will be using a custom US Phone number validator. Our example is pretty simple
as our validators criteria is only a valid area code, however your validation logic maybe 
more complex.

For the purpose of getting you started we will use a default validator and sanitizer to validate our input.

#### Fluent Option
```php
<?php require __DIR__ . '/vendor/autoload.php';

use Fantasyrock\Validator\Client;
use Fantasyrock\Validator\Validators\UsPhoneNumberValidator as Validator;
use Fantasyrock\Validator\Sanitizers\UsPhoneNumberSanitizer as Sanitizer;

$validate = new Client;
$validate->setInput('+1305-555-4483')->sanitizeWith(new Sanitizer)->validateWith(new Validator);
```

#### Controlled Option
```php
<?php require __DIR__ . '/vendor/autoload.php';

use Fantasyrock\Validator\Client;

$client = new Client;

// Setting sanitizer / validator may be done by directly passing an object as well
// i.e.
// $client->setSanitizer(new Sanitizer);
// $client->setValidator(new Validator);

$sanitizer = $client->setSanitizer('UsPhoneNumberSanitizer')->getSanitizer();
$validator = $client->setValidator('UsPhoneNumberValidator')->getValidator();

$client->setInput('+1305-555-4483');
$sanitizedInput = $sanitizer->sanitize($client->getInput());
$validatedInput = $validator->validate($sanitizedInput);
```

```php
// Output
3055554483
```

## Extending
You may easily add your custom sanitizers and validators to match your needs.

### Sanitizers
Sanitizers role is to clean up the users input in a way you may process it with the validators afterwards (or don't).
To write your custom sanitizers, you must implement **CanSanitizeInput** interface which has one method **sanitize($input)**.

### Validators
Validators (as per name suggestion) validate user input. To add custom validators all you need to do is
have custom validator implement the **CanValidateInput** interface which holds one method **validate($input)**

## Bugs
If you find any bugs please contact me directly or open an issue