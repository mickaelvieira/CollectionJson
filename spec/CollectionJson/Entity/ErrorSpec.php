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

    function it_should_be_chainable()
    {
        $this->setCode('value')->shouldReturn($this);
        $this->setMessage('value')->shouldReturn($this);
        $this->setTitle('value')->shouldReturn($this);
    }

    function it_may_be_construct_with_an_array_representation_of_the_error()
    {
        $error = $this::fromArray([
            'title'   => 'Error Title',
            'code'    => 'Error Code',
            'message' => 'Error Message'
        ]);
        $error->getTitle()->shouldBeEqualTo('Error Title');
        $error->getCode()->shouldBeEqualTo('Error Code');
        $error->getMessage()->shouldBeEqualTo('Error Message');
    }

    function it_should_convert_the_title_value_to_a_string()
    {
        $this->setTitle(true);
        $this->getTitle()->shouldBeEqualTo('1');
    }

    function it_should_convert_the_code_value_to_a_string()
    {
        $this->setCode(true);
        $this->getCode()->shouldBeEqualTo('1');
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
