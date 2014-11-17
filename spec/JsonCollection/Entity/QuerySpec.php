<?php

namespace spec\JsonCollection\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Entity\Query');
        $this->shouldImplement('JsonCollection\DataAware');
        $this->shouldImplement('JsonCollection\ArrayInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_be_chainable()
    {
        $this->setHref('value')->shouldHaveType('JsonCollection\Entity\Query');
        $this->setRel('value')->shouldHaveType('JsonCollection\Entity\Query');
        $this->setName('value')->shouldHaveType('JsonCollection\Entity\Query');
        $this->setPrompt('value')->shouldHaveType('JsonCollection\Entity\Query');
        $this->addData([])->shouldHaveType('JsonCollection\Entity\Query');
        $this->addDataSet([])->shouldHaveType('JsonCollection\Entity\Query');
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

    function it_should_return_an_empty_array_when_the_href_field_is_null()
    {
        $this->setRel('Rel value');
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_return_an_empty_array_when_the_rel_field_is_null()
    {
        $this->setHref('Href value');
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_not_return_null_values_and_empty_arrays()
    {
        $this->setRel('Rel value');
        $this->setHref('Href value');
        $this->toArray()->shouldBeEqualTo([
            'href'   => 'Href value',
            'rel'    => 'Rel value',
        ]);
    }

    /**
     * @param \JsonCollection\Entity\Data $data
     */
    function it_should_add_data_when_it_is_passed_as_an_object($data)
    {
        $this->addData($data);
        $this->getDataSet()->shouldHaveCount(1);
    }

    function it_should_add_data_when_it_is_passed_as_an_array()
    {
        $this->addData(['value' => 'value 1']);
        $this->getDataSet()->shouldHaveCount(1);
    }

    /**
     * @param \JsonCollection\Entity\Data $data
     */
    function it_should_add_a_data_set($data)
    {
        $this->addDataSet([$data, ['value' => 'value 2'], new \stdClass()]);
        $this->getDataSet()->shouldHaveCount(2);
    }

    /**
     * @param \JsonCollection\Entity\Data $data1
     * @param \JsonCollection\Entity\Data $data2
     */
    function it_should_return_an_array_with_the_data_list($data1, $data2)
    {
        $data1->toArray()->willReturn(['value' => 'value 1']);
        $data2->toArray()->willReturn(['value' => 'value 2']);

        $this->addData($data1);
        $this->addData($data2);
        $this->setRel('Rel value');
        $this->setHref('Href value');
        $this->toArray()->shouldBeEqualTo([
            'data'   => [
                ['value' => 'value 1'],
                ['value' => 'value 2'],
            ],
            'href'   => 'Href value',
            'rel'    => 'Rel value'
        ]);
    }

    /**
     * @param \JsonCollection\Entity\Data $data1
     * @param \JsonCollection\Entity\Data $data2
     */
    function it_should_retrieve_the_data_by_name($data1, $data2)
    {
        $data1->getName()->willReturn('name1');
        $data2->getName()->willReturn('name2');

        $this->addDataSet([$data1, $data2]);

        $this->getDataByName('name1')->shouldBeEqualTo($data1);
        $this->getDataByName('name2')->shouldBeEqualTo($data2);
    }

    function it_should_return_null_when_data_is_not_the_set()
    {
        $this->getDataByName('name1')->shouldBeNull(null);
    }
}
