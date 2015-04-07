<?php

namespace spec\CollectionJson\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Entity\Data');
        $this->shouldImplement('CollectionJson\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_return_the_object_type()
    {
        $this->getObjectType()->shouldBeEqualTo('data');
    }

    function it_should_be_chainable()
    {
        $this->setName('value')->shouldHaveType('CollectionJson\Entity\Data');
        $this->setPrompt('value')->shouldHaveType('CollectionJson\Entity\Data');
        $this->setValue('value')->shouldHaveType('CollectionJson\Entity\Data');
    }

    function it_should_inject_data()
    {
        $data = [
            'name'     => 'Data Name',
            'prompt'   => 'Data Prompt',
            'value'    => 'Data Value'
        ];
        $this->beConstructedWith($data);
        $this->getName()->shouldBeEqualTo('Data Name');
        $this->getPrompt()->shouldBeEqualTo('Data Prompt');
        $this->getValue()->shouldBeEqualTo('Data Value');
    }

    function it_should_throw_an_exception_when_it_cannot_convert_the_property_name_to_a_string()
    {
        $this->shouldThrow(
            new \BadMethodCallException("Property name of object type data cannot be converted to a string")
        )->during('setName', [new \stdClass()]);
    }

    function it_should_convert_the_name_value_to_a_string()
    {
        $this->setName(true);
        $this->getName()->shouldBeEqualTo('1');
    }

    function it_should_throw_an_exception_when_it_cannot_convert_the_property_prompt_to_a_string()
    {
        $this->shouldThrow(
            new \BadMethodCallException("Property prompt of object type data cannot be converted to a string")
        )->during('setPrompt', [new \stdClass()]);
    }

    function it_should_not_set_the_prompt_if_it_is_not_string()
    {
        $this->setPrompt(true);
        $this->getPrompt()->shouldBeEqualTo('1');
    }

    function it_should_set_the_value_if_it_is_a_boolean()
    {
        $this->setValue(false);
        $this->getValue()->shouldBeEqualTo(false);
    }

    function it_should_set_the_value_if_it_is_a_string()
    {
        $this->setValue("string value");
        $this->getValue()->shouldBeEqualTo("string value");
    }

    function it_should_set_the_value_if_it_is_a_number()
    {
        $this->setValue(42);
        $this->getValue()->shouldBeEqualTo(42);
    }

    function it_should_set_the_value_if_it_is_a_float()
    {
        $this->setValue(42.10);
        $this->getValue()->shouldBeEqualTo(42.10);
    }

    function it_should_set_the_value_if_it_is_a_null()
    {
        $this->setValue(null);
        $this->getValue()->shouldBeEqualTo(null);
    }

    function it_should_not_set_the_value_if_it_is_an_array()
    {
        $this->shouldThrow(
            new \BadMethodCallException(
                "Property value of object type data may only have types string, number, boolean or null"
            )
        )->during('setValue', [[]]);
    }

    function it_should_not_set_the_value_if_it_is_an_object()
    {
        $this->shouldThrow(
            new \BadMethodCallException(
                "Property value of object type data may only have types string, number, boolean or null"
            )
        )->during('setValue', [new \stdClass()]);
    }

    function it_should_not_set_the_value_if_it_is_a_resource()
    {
        $this->shouldThrow(
            new \BadMethodCallException(
                "Property value of object type data may only have types string, number, boolean or null"
            )
        )->during('setValue', [imagecreate(10, 10)]);
    }

    function it_should_not_set_the_value_if_it_is_a_callable()
    {
        $fn = function () {

        };

        $this->shouldThrow(
            new \BadMethodCallException(
                "Property value of object type data may only have types string, number, boolean or null"
            )
        )->during('setValue', [$fn]);
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_name_is_null()
    {
        $this->shouldThrow(new \LogicException('Property name of object type data is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_name_is_null()
    {
        $this->shouldThrow(
            new \LogicException('Property name of object type data is required')
        )->during('jsonSerialize');
    }

    function it_should_not_return_empty_arrays_and_null_properties_apart_from_the_value_field()
    {
        $this->setName('Name');
        $this->toArray()->shouldBeEqualTo([
            'name' => 'Name',
            'value' => null
        ]);
    }
}
