<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListDataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\ListData');
        $this->shouldImplement('JsonCollection\DataInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_inject_data()
    {
        $data = [
            'multiple' => true,
            'default'    => 'Default Value'
        ];
        $this->inject($data);
        $this->getDefault()->shouldBeEqualTo('Default Value');
        $this->shouldBeMultiple();
    }

    function it_should_not_set_the_default_field_if_it_is_not_a_string()
    {
        $this->setDefault(true);
        $this->getDefault()->shouldBeNull();
    }

    function it_should_not_set_the_multiple_field_if_it_is_not_a_boolean()
    {
        $this->setMultiple(1);
        $this->isMultiple()->shouldBeNull();
    }

    function it_should_extract_an_empty_array_when_there_is_no_option()
    {
        $this->setMultiple(true);
        $this->setDefault('Default Value');
        $this->toArray()->shouldBeEqualTo([]);
    }

    /**
     * @param \JsonCollection\Option $option
     */
    function it_should_not_extract_null_fields($option)
    {
        $option->toArray()->willReturn([
            'value' => 'test'
        ]);

        $this->addOption($option);
        $this->toArray()->shouldBeEqualTo([
            'options' => [
                [
                    'value' => 'test'
                ]
            ]
        ]);
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
     * @param \JsonCollection\Option $option2
     */
    function it_should_add_option_set($option1, $option2)
    {
        $option1->toArray()->willReturn([
            'value' => 'Value 1',
            'prompt' => 'Prompt 1'
        ]);
        $option2->toArray()->willReturn([
            'value' => 'Value 2',
            'prompt' => 'Prompt 2'
        ]);

        $this->addOptionSet([$option1, $option2, new \stdClass()]);
        $this->countOptions()->shouldBeEqualTo(2);
        /*$this->toArray()->shouldBeEqualTo([
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
        ]);*/
    }
}
