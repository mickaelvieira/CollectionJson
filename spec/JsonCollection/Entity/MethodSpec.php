<?php

namespace spec\JsonCollection\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MethodSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Entity\Method');
        $this->shouldImplement('JsonCollection\ArrayInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_be_chainable()
    {
        $this->addOption([])->shouldHaveType('JsonCollection\Entity\Method');
        $this->addOptionSet([])->shouldHaveType('JsonCollection\Entity\Method');
    }

    function it_should_return_an_empty_array()
    {
        $this->toArray()->shouldBeEqualTo([]);
    }

    /**
     * @param \JsonCollection\Entity\Option $option1
     * @param \JsonCollection\Entity\Option $option2
     */
    function it_should_return_an_array_with_the_options_list($option1, $option2)
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
     * @param \JsonCollection\Entity\Option $option1
     */
    function it_should_add_option_when_it_is_passed_as_an_object($option1)
    {
        $this->addOption($option1);
        $this->getOptionSet()->shouldHaveCount(1);
    }

    function it_should_add_option_when_it_is_passed_as_an_array()
    {
        $this->addOption([
            'value' => 'Value 2',
            'prompt' => 'Prompt 2'
        ]);
        $this->getOptionSet()->shouldHaveCount(1);
    }

    /**
     * @param \JsonCollection\Entity\Option $option1
     * @param \JsonCollection\Entity\Option $option2
     */
    function it_should_add_option_set($option1, $option2)
    {
        $this->addOptionSet([$option1, $option2, new \stdClass()]);
        $this->getOptionSet()->shouldHaveCount(2);
    }
}
