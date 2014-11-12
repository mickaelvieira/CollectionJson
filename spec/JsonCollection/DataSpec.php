<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Data');
        $this->shouldImplement('JsonCollection\DataInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_inject_data()
    {
        $data = [
            'name'     => 'Data Name',
            'prompt'   => 'Data Prompt',
            'type'     => 'Data Type',
            'value'    => 'Data Value',
            'required' => true
        ];
        $this->inject($data);
        $this->getName()->shouldBeEqualTo('Data Name');
        $this->getPrompt()->shouldBeEqualTo('Data Prompt');
        $this->getType()->shouldBeEqualTo('Data Type');
        $this->getValue()->shouldBeEqualTo('Data Value');
        $this->shouldBeRequired();
    }

    function it_should_not_set_the_name_if_it_is_not_string()
    {
        $this->setName(true);
        $this->getName()->shouldBeNull();
    }

    function it_should_not_set_the_prompt_if_it_is_not_string()
    {
        $this->setPrompt(true);
        $this->getPrompt()->shouldBeNull();
    }

    function it_should_not_set_the_type_if_it_is_not_string()
    {
        $this->setType(true);
        $this->getType()->shouldBeNull();
    }

    function it_should_not_set_the_value_if_it_is_not_string()
    {
        $this->setValue(true);
        $this->getValue()->shouldBeNull();
    }

    function it_should_not_set_required_if_it_is_not_boolean()
    {
        $this->setRequired(1);
        $this->shouldNotBeRequired();
    }

    function it_should_extract_an_empty_array_when_the_name_field_is_null()
    {
        $this->setValue('Value');
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_not_extract_empty_array_and_null_properties_apart_from_the_value_field()
    {
        $this->setName('Name');
        $this->toArray()->shouldBeEqualTo([
            'name' => 'Name',
            'value' => null
        ]);
    }

    /**
     * @param \JsonCollection\ListData $list
     */
    function it_should_extract_the_list($list)
    {
        $list->toArray()->willReturn([
            'multiple' => true,
            'options' => [
                [
                    'value' => 'value 1'
                ],
                [
                    'value' => 'value 1'
                ]
            ]
        ]);

        $this->setName('Name');
        $this->setList($list);
        $this->toArray()->shouldBeEqualTo([
            'list' => [
                'multiple' => true,
                'options' => [
                    [
                        'value' => 'value 1'
                    ],
                    [
                        'value' => 'value 1'
                    ]
                ]
            ],
            'name' => 'Name',
            'value' => null
        ]);
    }

    function it_should_add_an_option_to_the_list()
    {
        $this->setName('Data Name');
        $this->addOption('option value', 'option prompt');

        $this->getList()->shouldHaveType('JsonCollection\ListData');
        $this->toArray()->shouldBeEqualTo([
            'list' => [
                'options' => [
                    [
                        'prompt' => 'option prompt',
                        'value' => 'option value'
                    ]
                ]
            ],
            'name' => 'Data Name',
            'value' => null
        ]);
    }
}
