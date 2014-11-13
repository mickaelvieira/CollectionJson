<?php

namespace spec\JsonCollection\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Entity\Data');
        $this->shouldImplement('JsonCollection\ArrayInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    /**
     * @param \JsonCollection\Entity\ListData $list
     */
    function it_should_be_chainable($list)
    {
        $this->setName('value')->shouldHaveType('JsonCollection\Entity\Data');
        $this->setPrompt('value')->shouldHaveType('JsonCollection\Entity\Data');
        $this->setValue('value')->shouldHaveType('JsonCollection\Entity\Data');
        $this->setType('value')->shouldHaveType('JsonCollection\Entity\Data');
        $this->setRequired('value')->shouldHaveType('JsonCollection\Entity\Data');
        $this->setList($list)->shouldHaveType('JsonCollection\Entity\Data');
        $this->addOption([])->shouldHaveType('JsonCollection\Entity\Data');
        $this->addOptions([])->shouldHaveType('JsonCollection\Entity\Data');


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
        $this->isRequired()->shouldBeNull();
    }

    function it_should_return_an_empty_array_when_the_name_field_is_null()
    {
        $this->setValue('Value');
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_not_return_empty_arrays_and_null_properties_apart_from_the_value_field()
    {
        $this->setName('Name');
        $this->toArray()->shouldBeEqualTo([
            'name' => 'Name',
            'value' => null
        ]);
    }

    /**
     * @param \JsonCollection\Entity\ListData $list
     */
    function it_should_return_an_array_with_the_options_list($list)
    {
        $list->toArray()->willReturn([
            'multiple' => true,
            'options' => [
                [
                    'value' => 'value 1'
                ],
                [
                    'value' => 'value 2'
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
                        'value' => 'value 2'
                    ]
                ]
            ],
            'name' => 'Name',
            'value' => null
        ]);
    }

    function it_should_add_an_option_to_the_list_when_it_is_passed_as_an_array()
    {
        $this->setName('Data Name');
        $this->addOption([
            'value' => 'option value',
            'prompt' => 'option prompt'
        ]);

        $this->getList()->shouldHaveType('JsonCollection\Entity\ListData');
        $this->getList()->getOptionSet()->shouldHaveCount(1);
    }

    /**
     * @param \JsonCollection\Entity\Option $option
     */
    function it_should_add_an_option_to_the_list_when_it_is_passed_as_an_object($option)
    {
        $this->setName('Data Name');
        $option->toArray()->willReturn([
            'prompt' => 'option prompt',
            'value' => 'option value'
        ]);

        $this->addOption($option);
        $this->getList()->shouldHaveType('JsonCollection\Entity\ListData');
        $this->getList()->getOptionSet()->shouldHaveCount(1);
    }

    /**
     * @param \JsonCollection\Entity\Option $option
     */
    function it_should_add_multiple_options_and_set_the_default_values_to_the_list($option)
    {
        $options = [
            [
                'prompt' => 'option1 prompt',
                'value' => 'option1 value'
            ],
            $option
        ];

        $this->addOptions($options);

        $this->getList()->shouldHaveType('JsonCollection\Entity\ListData');
        $this->getList()->isMultiple()->shouldBeNull();
        $this->getList()->getDefault()->shouldBeNull();
        $this->getList()->getOptionSet()->shouldHaveCount(2);
    }

    /**
     * @param \JsonCollection\Entity\Option $option
     */
    function it_should_add_multiple_options_and_set_values_to_the_list($option)
    {
        $options = [
            [
                'prompt' => 'option1 prompt',
                'value' => 'option1 value'
            ],
            $option
        ];

        $this->addOptions($options, true, 'default value');

        $this->getList()->shouldHaveType('JsonCollection\Entity\ListData');
        $this->getList()->shouldBeMultiple();
        $this->getList()->getDefault()->shouldBeEqualTo('default value');
        $this->getList()->getOptionSet()->shouldHaveCount(2);
    }
}
