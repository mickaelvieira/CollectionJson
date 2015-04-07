<?php

namespace spec\CollectionJson\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ErrorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Entity\Error');
        $this->shouldImplement('CollectionJson\ArrayInjectable');
        $this->shouldImplement('CollectionJson\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_return_the_object_type()
    {
        $this->getObjectType()->shouldBeEqualTo('error');
    }

    function it_should_be_chainable()
    {
        $this->setCode('value')->shouldHaveType('CollectionJson\Entity\Error');
        $this->setMessage('value')->shouldHaveType('CollectionJson\Entity\Error');
        $this->setTitle('value')->shouldHaveType('CollectionJson\Entity\Error');
    }

    function it_should_inject_data()
    {
        $data = [
            'title'   => 'Error Title',
            'code'    => 'Error Code',
            'message' => 'Error Message'
        ];
        $this->beConstructedWith($data);
        $this->getTitle()->shouldBeEqualTo('Error Title');
        $this->getCode()->shouldBeEqualTo('Error Code');
        $this->getMessage()->shouldBeEqualTo('Error Message');
    }

    function it_should_throw_an_exception_when_it_cannot_convert_the_property_title_to_a_string()
    {
        $this->shouldThrow(
            new \BadMethodCallException("Property title of object type error cannot be converted to a string")
        )->during('setTitle', [new \stdClass()]);
    }

    function it_should_convert_the_title_value_to_a_string()
    {
        $this->setTitle(true);
        $this->getTitle()->shouldBeEqualTo('1');
    }

    function it_should_throw_an_exception_when_it_cannot_convert_the_property_code_to_a_string()
    {
        $this->shouldThrow(
            new \BadMethodCallException("Property code of object type error cannot be converted to a string")
        )->during('setCode', [new \stdClass()]);
    }

    function it_should_convert_the_code_value_to_a_string()
    {
        $this->setCode(true);
        $this->getCode()->shouldBeEqualTo('1');
    }

    function it_should_throw_an_exception_when_it_cannot_convert_the_property_message_to_a_string()
    {
        $this->shouldThrow(
            new \BadMethodCallException("Property message of object type error cannot be converted to a string")
        )->during('setMessage', [new \stdClass()]);
    }

    function it_should_convert_the_message_value_to_a_string()
    {
        $this->setMessage(true);
        $this->getMessage()->shouldBeEqualTo('1');
    }

    function it_should_not_extract_empty_array_and_null_fields()
    {
        $this->setMessage('My Message');
        $this->toArray()->shouldBeEqualTo(['message' => 'My Message']);
    }
}
