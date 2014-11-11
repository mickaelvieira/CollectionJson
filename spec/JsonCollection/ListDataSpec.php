<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListDataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\ListData');
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
        $this->shouldNotBeMultiple();
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
}
