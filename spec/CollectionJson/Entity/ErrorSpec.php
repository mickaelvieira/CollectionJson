<?php

namespace spec\CollectionJson\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Entity\Error;
use CollectionJson\ArrayConvertible;

class ErrorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Error::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_return_the_object_type()
    {
        $this::getObjectType()->shouldBeEqualTo('error');
    }

    function it_is_clonable()
    {
        $this->beConstructedThrough('fromArray', [[
            'title'   => 'Error Title',
            'code'    => 'Error Code',
            'message' => 'Error Message'
        ]]);

        $copy = clone $this;

        $copy->shouldHaveType(Error::class);
        $copy->getTitle()->shouldReturn($this->getTitle());
        $copy->getCode()->shouldReturn($this->getCode());
        $copy->getMessage()->shouldReturn($this->getMessage());
    }

    function it_should_be_chainable()
    {
        $this->withCode('value')->shouldHaveType(Error::class);
        $this->withMessage('value')->shouldHaveType(Error::class);
        $this->withTitle('value')->shouldHaveType(Error::class);
    }

    function it_may_be_construct_with_an_array_representation_of_the_error()
    {
        $this->beConstructedThrough('fromArray', [[
            'title'   => 'Error Title',
            'code'    => 'Error Code',
            'message' => 'Error Message'
        ]]);

        $this->getTitle()->shouldBeEqualTo('Error Title');
        $this->getCode()->shouldBeEqualTo('Error Code');
        $this->getMessage()->shouldBeEqualTo('Error Message');
    }

    function it_should_convert_the_title_value_to_a_string()
    {
        $error = $this->withTitle(true);
        $this->getTitle()->shouldBeNull();
        $error->getTitle()->shouldBeEqualTo('1');
    }

    function it_should_convert_the_code_value_to_a_string()
    {
        $error = $this->withCode(true);
        $this->getCode()->shouldBeNull();
        $error->getCode()->shouldBeEqualTo('1');
    }

    function it_should_convert_the_message_value_to_a_string()
    {
        $error = $this->withMessage(true);
        $this->getMessage()->shouldBeNull();
        $error->getMessage()->shouldBeEqualTo('1');
    }

    function it_should_not_extract_empty_array_and_null_fields()
    {
        $error = $this->withMessage('My Message');
        $error->toArray()->shouldBeEqualTo(['message' => 'My Message']);
    }
}
