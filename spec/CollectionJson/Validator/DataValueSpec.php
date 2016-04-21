<?php

namespace spec\CollectionJson\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataValueSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Validator\DataValue');
    }

    function it_should_validate_a_boolean()
    {
        $this->isValid(true)->shouldReturn(true);
    }

    function it_should_validate_a_string()
    {
        $this->isValid('string')->shouldReturn(true);
    }

    function it_should_validate_an_integer()
    {
        $this->isValid(42)->shouldReturn(true);
    }

    function it_should_validate_an_float()
    {
        $this->isValid(42.10)->shouldReturn(true);
    }

    function it_should_validate_a_null_value()
    {
        $this->isValid(null)->shouldReturn(true);
    }

    function it_should_not_validate_an_array()
    {
        $this->isValid([])->shouldReturn(false);
    }

    function it_should_not_validate_an_object()
    {
        $this->isValid(new \stdClass())->shouldReturn(false);
    }

    function it_should_not_validate_an_resource()
    {
        $this->isValid(imagecreate(10, 10))->shouldReturn(false);
    }

    function it_should_not_validate_an_callable()
    {
        $this->isValid(function () {

        })->shouldReturn(false);
    }

    function it_should_return_the_allowed_value_types()
    {
        $this::allowed()->shouldReturn(['scalar', 'NULL']);
    }
}
