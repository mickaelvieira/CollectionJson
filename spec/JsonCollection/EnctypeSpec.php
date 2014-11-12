<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EnctypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Enctype');
        $this->shouldImplement('JsonCollection\DataInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_be_chainable()
    {
        $this->addOption([])->shouldHaveType('JsonCollection\Enctype');
        $this->addOptionSet([])->shouldHaveType('JsonCollection\Enctype');
    }

    function it_should_extract_an_empty_array()
    {
        $this->toArray()->shouldBeEqualTo([]);
    }

    /**
     * @param \JsonCollection\Option $option1
     * @param \JsonCollection\Option $option2
     */
    function it_should_extract_the_options_list($option1, $option2)
    {
        $option1->toArray()->willReturn([
            'value' => 'Value 1',
            'prompt' => 'Prompt 1'
        ]);
        $option2->toArray()->willReturn([
            'value' => 'Value 2',
            'prompt' => 'Prompt 2'
        ]);

        $this->addOption($option1);
        $this->addOption($option2);
        $this->toArray()->shouldBeEqualTo([
            'options' => [
                [
                    'value' => 'Value 1',
                    'prompt' => 'Prompt 1'
                ],
                [
                    'value' => 'Value 2',
                    'prompt' => 'Prompt 2'
                ]
            ]
        ]);
    }

    /**
     * @param \JsonCollection\Option $option1
     */
    function it_should_add_option($option1)
    {
        $this->addOption($option1);
        $this->countOptions()->shouldBeEqualTo(1);
    }

    function it_should_add_option_when_passed_as_an_array()
    {
        $this->addOption([
            'value' => 'Value 2',
            'prompt' => 'Prompt 2'
        ]);
        $this->countOptions()->shouldBeEqualTo(1);
    }

    /**
     * @param \JsonCollection\Option $option1
     * @param \JsonCollection\Option $option2
     */
    function it_should_add_option_set($option1, $option2)
    {
        $this->addOptionSet([$option1, $option2, new \stdClass()]);
        $this->countOptions()->shouldBeEqualTo(2);
    }
}
