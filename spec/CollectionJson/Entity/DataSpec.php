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
        $this::getObjectType()->shouldBeEqualTo('data');
    }

    function it_should_be_chainable()
    {
        $this->setName('value')->shouldReturn($this);
        $this->setPrompt('value')->shouldReturn($this);
        $this->setValue('value')->shouldReturn($this);
    }

    function it_may_be_construct_with_an_array_representation_of_the_data()
    {
        $data = $this::fromArray([
            'name'     => 'Data Name',
            'prompt'   => 'Data Prompt',
            'value'    => 'Data Value'
        ]);
        $data->getName()->shouldBeEqualTo('Data Name');
        $data->getPrompt()->shouldBeEqualTo('Data Prompt');
        $data->getValue()->shouldBeEqualTo('Data Value');
    }

    function it_should_throw_an_exception_when_it_cannot_convert_the_property_name_to_a_string()
    {
        $this->shouldThrow(
            new \DomainException("Property [name] of entity [data] can only have one of the following values [scalar,Object::__toString]")
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
            new \DomainException(
                "Property [prompt] of entity [data] can only have one of the following values [scalar,Object::__toString]"
            )
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
            new \DomainException(
                "Property [value] of entity [data] can only have one of the following values [scalar,NULL]"
            )
        )->during('setValue', [[]]);
    }

    function it_should_not_set_the_value_if_it_is_an_object()
    {
        $this->shouldThrow(
            new \DomainException(
                "Property [value] of entity [data] can only have one of the following values [scalar,NULL]"
            )
        )->during('setValue', [new \stdClass()]);
    }

    function it_should_not_set_the_value_if_it_is_a_resource()
    {
        $this->shouldThrow(
            new \DomainException(
                "Property [value] of entity [data] can only have one of the following values [scalar,NULL]"
            )
        )->during('setValue', [imagecreate(10, 10)]);
    }

    function it_should_not_set_the_value_if_it_is_a_callable()
    {
        $fn = function() {};

        $this->shouldThrow(
            new \DomainException(
                "Property [value] of entity [data] can only have one of the following values [scalar,NULL]"
            )
        )->during('setValue', [$fn]);
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_name_is_null()
    {
        $this->shouldThrow(new \DomainException('Property [name] of entity [data] is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_name_is_null()
    {
        $this->shouldThrow(
            new \DomainException('Property [name] of entity [data] is required')
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
