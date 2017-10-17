<?php

namespace spec\CollectionJson\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Entity\Data;
use CollectionJson\ArrayConvertible;

class DataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('Data Name');
        $this->shouldHaveType(Data::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_return_the_object_type()
    {
        $this->beConstructedWith('Data Name');
        $this::getObjectType()->shouldBeEqualTo('data');
    }

    function it_can_be_initialized_with_data()
    {
        $this->beConstructedWith('Data Name', 'Data Value', 'Data Prompt');
        $this->getName()->shouldReturn('Data Name');
        $this->getValue()->shouldReturn('Data Value');
        $this->getPrompt()->shouldReturn('Data Prompt');
    }

    function it_is_clonable()
    {
        $this->beConstructedThrough('fromArray', [[
            'name'     => 'Data Name',
            'prompt'   => 'Data Prompt',
            'value'    => 'Data Value'
        ]]);

        $copy = clone $this;

        $copy->shouldHaveType(Data::class);
        $copy->getName()->shouldReturn($this->getName());
        $copy->getPrompt()->shouldReturn($this->getPrompt());
        $copy->getValue()->shouldReturn($this->getValue());
    }

    function it_should_be_chainable()
    {
        $this->beConstructedWith('Data Name');
        $this->withName('value')->shouldHaveType(Data::class);
        $this->withPrompt('value')->shouldHaveType(Data::class);
        $this->withValue('value')->shouldHaveType(Data::class);
    }

    function it_may_be_construct_with_an_array_representation_of_the_data()
    {
        $this->beConstructedThrough('fromArray', [[
            'name'     => 'Data Name',
            'prompt'   => 'Data Prompt',
            'value'    => 'Data Value'
        ]]);

        $this->getName()->shouldBeEqualTo('Data Name');
        $this->getPrompt()->shouldBeEqualTo('Data Prompt');
        $this->getValue()->shouldBeEqualTo('Data Value');
    }

    function it_should_convert_the_name_value_to_a_string()
    {
        $this->beConstructedWith('Data Name');
        $data = $this->withName(true);
        $this->getName()->shouldBeEqualTo('Data Name');
        $data->getName()->shouldBeEqualTo('1');
    }

    function it_should_not_set_the_prompt_if_it_is_not_string()
    {
        $this->beConstructedWith('Data Name');
        $data = $this->withPrompt(true);
        $this->getPrompt()->shouldBeNull();
        $data->getPrompt()->shouldBeEqualTo('1');
    }

    function it_should_set_the_value_if_it_is_a_boolean()
    {
        $this->beConstructedWith('Data Name');
        $data = $this->withValue(false);
        $this->getValue()->shouldBeNull();
        $data->getValue()->shouldBeEqualTo(false);
    }

    function it_should_set_the_value_if_it_is_a_string()
    {
        $this->beConstructedWith('Data Name');
        $data = $this->withValue('string value');
        $this->getValue()->shouldBeNull();
        $data->getValue()->shouldBeEqualTo('string value');
    }

    function it_should_set_the_value_if_it_is_a_number()
    {
        $this->beConstructedWith('Data Name');
        $data = $this->withValue(42);
        $this->getValue()->shouldBeNull();
        $data->getValue()->shouldBeEqualTo(42);
    }

    function it_should_set_the_value_if_it_is_a_float()
    {
        $this->beConstructedWith('Data Name');
        $data = $this->withValue(42.10);
        $this->getValue()->shouldBeNull();
        $data->getValue()->shouldBeEqualTo(42.10);
    }

    function it_should_set_the_value_if_it_is_a_null()
    {
        $this->beConstructedWith('Data Name');
        $data = $this->withValue(null);
        $this->getValue()->shouldBeNull();
        $data->getValue()->shouldBeEqualTo(null);
    }

    function it_should_not_set_the_value_if_it_is_an_array()
    {
        $this->beConstructedWith('Data Name');
        $this->shouldThrow(
            new \DomainException(
                'Property [value] of entity [data] can only have one of the following values [scalar,NULL]'
            )
        )->during('withValue', [[]]);
    }

    function it_should_not_set_the_value_if_it_is_an_object()
    {
        $this->beConstructedWith('Data Name');
        $this->shouldThrow(
            new \DomainException(
                'Property [value] of entity [data] can only have one of the following values [scalar,NULL]'
            )
        )->during('withValue', [new \stdClass()]);
    }

    function it_should_not_set_the_value_if_it_is_a_resource()
    {
        $this->beConstructedWith('Data Name');
        $this->shouldThrow(
            new \DomainException(
                "Property [value] of entity [data] can only have one of the following values [scalar,NULL]"
            )
        )->during('withValue', [imagecreate(10, 10)]);
    }

    function it_should_not_set_the_value_if_it_is_a_callable()
    {
        $fn = function() {};

        $this->beConstructedWith('Data Name');
        $this->shouldThrow(
            new \DomainException(
                "Property [value] of entity [data] can only have one of the following values [scalar,NULL]"
            )
        )->during('withValue', [$fn]);
    }

    function it_should_not_return_empty_arrays_and_null_properties_apart_from_the_value_field()
    {
        $this->beConstructedWith('Name');
        $this->toArray()->shouldBeEqualTo([
            'name' => 'Name',
            'value' => null
        ]);
    }
}
