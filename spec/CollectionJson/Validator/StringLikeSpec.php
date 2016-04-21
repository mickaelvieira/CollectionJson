<?php

namespace spec\CollectionJson\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class StringLikeSpec
 * @package spec\CollectionJson\Validator
 */
class StringLikeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Validator\StringLike');
    }

    function it_should_validate_a_string()
    {
        $this->isValid('string')->shouldReturn(true);
    }

    function it_should_validate_a_integer()
    {
        $this->isValid(1)->shouldReturn(true);
    }

    function it_should_validate_a_float()
    {
        $this->isValid(1.1)->shouldReturn(true);
    }

    function it_should_validate_a_boolean()
    {
        $this->isValid(true)->shouldReturn(true);
    }

    function it_should_not_validate_an_array()
    {
        $this->isValid([])->shouldReturn(false);
    }

    function it_should_not_validate_an_object_which_cannot_be_converted_to_a_string($object)
    {
        $object->beADoubleOf('\stdClass');
        $this->isValid($object)->shouldReturn(false);
    }

    function it_should_not_validate_an_object_which_can_be_converted_to_a_string($object)
    {
        $object->beADoubleOf('CollectionJson\StringConvertible');
        $this->isValid($object)->shouldReturn(true);
    }

    function it_should_return_the_allowed_value_types()
    {
        $this::allowed()->shouldReturn(['scalar', 'Object::__toString']);
    }
}
