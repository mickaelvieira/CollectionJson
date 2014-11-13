<?php

namespace spec\JsonCollection\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Entity\Option');
        $this->shouldImplement('JsonCollection\DataInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_be_chainable()
    {
        $this->setPrompt('value')->shouldHaveType('JsonCollection\Entity\Option');
        $this->setValue('value')->shouldHaveType('JsonCollection\Entity\Option');
    }

    function it_should_inject_data()
    {
        $data = [
            'prompt'   => 'Data Prompt',
            'value'    => 'Data Value'
        ];
        $this->inject($data);
        $this->getPrompt()->shouldBeEqualTo('Data Prompt');
        $this->getValue()->shouldBeEqualTo('Data Value');
    }

    function it_should_not_set_the_prompt_if_it_is_not_string()
    {
        $this->setPrompt(true);
        $this->getPrompt()->shouldBeNull();
    }

    function it_should_not_set_the_value_if_it_is_not_string()
    {
        $this->setValue(true);
        $this->getValue()->shouldBeNull();
    }

    function it_should_extract_an_empty_array_when_the_value_field_is_null()
    {
        $this->setPrompt('The Value');
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_not_return_null_values()
    {
        $this->setValue('Value');
        $this->toArray()->shouldBeEqualTo([
            'value' => 'Value'
        ]);
    }
}
