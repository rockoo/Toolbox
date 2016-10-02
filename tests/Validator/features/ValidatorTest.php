<?php

use Fantasyrock\Validator\Client as Validator;
use PHPUnit_Framework_TestCase as TestCase;
use Fantasyrock\Validator\Helpers\General;

use Mockery as m;

class ValidatorTest extends TestCase
{
    use General;

    /** @test * */
    public function test_it_can_load_validator()
    {

        $validator = new Validator;

        $this->assertInstanceOf(Validator::class, $validator);
    }

    /**
     * @test
     * @expectedException Exception
     **/
    public function test_it_fails_when_loading_nonexistent_validators()
    {

        $validator = new Validator;
        $validator->setValidator('non-existant');
    }

    /**
     * @test
     * @expectedException Exception
     **/
    public function test_it_fails_when_trying_to_get_validator_instance_without_being_set()
    {

        $validator = new Validator;
        $validator->getValidator();
    }

    /** @test * */
    public function test_it_can_set_validator_by_string()
    {

        $clerk = new Validator;
        $validator = $clerk->setValidator('UsPhoneNumberValidator')->getValidator();

        $this->assertInstanceOf(\Fantasyrock\Validator\Contracts\CanValidateInput::class, $clerk->getValidator());
    }

    /** @test * */
    public function test_it_can_set_validator_from_object()
    {

        $clerk = new Validator;
        $validator = $clerk->setValidator(new \Fantasyrock\Validator\Validators\UsPhoneNumberValidator);

        $this->assertInstanceOf(\Fantasyrock\Validator\Contracts\CanValidateInput::class, $clerk->getValidator());
    }

    /** @test * */
    public function test_it_can_set_sanitizer_by_string()
    {

        $validator = new Validator;
        $sanitizer = $validator->setSanitizer('UsPhoneNumberSanitizer')->getSanitizer();

        $this->assertInstanceOf(\Fantasyrock\Validator\Contracts\CanSanitizeInput::class, $validator->getSanitizer());

    }

    /** @test * */
    public function test_it_can_set_sanitizer_from_object()
    {

        $clerk = new Validator;
        $sanitizer = $clerk->setSanitizer(new \Fantasyrock\Validator\Sanitizers\UsPhoneNumberSanitizer);

        $this->assertInstanceOf(\Fantasyrock\Validator\Contracts\CanSanitizeInput::class, $clerk->getSanitizer());
    }

    /** @test * */
    public function test_it_can_dynamically_load_validator()
    {

        $clerk = new Validator;
        $clerk->validateWith(new \Fantasyrock\Validator\Validators\UsPhoneNumberValidator);

        $this->assertInstanceOf(\Fantasyrock\Validator\Contracts\CanValidateInput::class, $clerk->getValidator());
    }

    /** @test * */
    public function test_it_can_dynamically_load_sanitizer()
    {

        $clerk = new Validator;
        $clerk->sanitizeWith(new \Fantasyrock\Validator\Sanitizers\UsPhoneNumberSanitizer);

        $this->assertInstanceOf(\Fantasyrock\Validator\Contracts\CanSanitizeInput::class, $clerk->getSanitizer());
    }

    /** @test * */
    public function test_it_can_set_input()
    {

        $validator = new Validator;
        $validator->setInput('Input accepted');

        $this->assertEquals('Input accepted', $validator->getInput());
    }

    /** @test * */
    public function test_it_can_sanitize_input()
    {

        $validator = new Validator;
        $validator->setInput('+13057662233')->sanitizeWith(new \Fantasyrock\Validator\Sanitizers\UsPhoneNumberSanitizer);

        $this->assertEquals('3057662233', $validator->getInput());

        $validatorTwo = new Validator;
        $validatorTwo->setInput('+13057662233')->setSanitizer('UsPhoneNumberSanitizer');

        $sanitizer = $validatorTwo->getSanitizer();
        $output = $sanitizer->sanitize($validatorTwo->getInput());

        $this->assertEquals('3057662233', $output);
    }

    /** @test * */
    public function test_it_can_validate_input()
    {

        $subject = m::mock('Fantasyrock\Validator\Contracts\CanValidateInput');
        $subject->shouldReceive('validate')->once()->andReturn(3057662233);

        $validator = new Validator;
        $validator->setInput('3057662233')->setValidator($subject);

        $clerk = $validator->getValidator();
        $output = $clerk->validate($validator->getInput());


        $this->assertEquals('3057662233', $output);
    }
}
