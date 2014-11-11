<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Query');
    }

    function it_should_inject_data()
    {
        $data = [
            'href'   => 'Query Href',
            'rel'    => 'Query Rel',
            'name'   => 'Query Name',
            'prompt' => 'Query Prompt'
        ];
        $this->inject($data);
        $this->getHref()->shouldBeEqualTo('Query Href');
        $this->getRel()->shouldBeEqualTo('Query Rel');
        $this->getName()->shouldBeEqualTo('Query Name');
        $this->getPrompt()->shouldBeEqualTo('Query Prompt');
    }

    function it_should_not_set_the_href_field_if_it_is_not_a_string()
    {
        $this->setHref(true);
        $this->getHref()->shouldBeNull();
    }

    function it_should_not_set_the_rel_field_if_it_is_not_a_string()
    {
        $this->setRel(true);
        $this->getRel()->shouldBeNull();
    }

    function it_should_not_set_the_name_field_if_it_is_not_a_string()
    {
        $this->setName(true);
        $this->getName()->shouldBeNull();
    }

    function it_should_not_set_the_prompt_field_if_it_is_not_a_string()
    {
        $this->setPrompt(true);
        $this->getPrompt()->shouldBeNull();
    }

    function it_should_extract_an_empty_array_when_the_href_field_is_null()
    {
        $this->setRel('Rel value');
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_extract_an_empty_array_when_the_rel_field_is_null()
    {
        $this->setHref('Href value');
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_not_extract_null_and_empty_array_fields()
    {
        $this->setRel('Rel value');
        $this->setHref('Href value');
        $this->toArray()->shouldBeEqualTo(
            [
                'href'   => 'Href value',
                'rel'    => 'Rel value',
            ]
        );
    }

    /**
     * @param \JsonCollection\Data $data1
     * @param \JsonCollection\Data $data2
     */
    function it_should_extract_the_data_list($data1, $data2)
    {
        $data1->toArray()->willReturn(['value' => 'value 1']);
        $data2->toArray()->willReturn(['value' => 'value 2']);

        $this->addData($data1);
        $this->addData($data2);
        $this->setRel('Rel value');
        $this->setHref('Href value');
        $this->toArray()->shouldBeEqualTo(
            [
                'data'   => [
                    ['value' => 'value 1'],
                    ['value' => 'value 2'],
                ],
                'href'   => 'Href value',
                'rel'    => 'Rel value'
            ]
        );
    }

    /**
     * @param \JsonCollection\Data $data1
     * @param \JsonCollection\Data $data2
     */
    function it_should_add_a_data_set($data1, $data2)
    {
        $data1->toArray()->willReturn(['value' => 'value 1']);
        $data2->toArray()->willReturn(['value' => 'value 2']);

        $this->addDataSet([
            $data1, $data2, new \stdClass()
        ]);
        $this->setRel('Rel value');
        $this->setHref('Href value');
        $this->toArray()->shouldBeEqualTo(
            [
                'data'   => [
                    ['value' => 'value 1'],
                    ['value' => 'value 2'],
                ],
                'href'   => 'Href value',
                'rel'    => 'Rel value'
            ]
        );
    }
}
