<?php

namespace spec\CollectionJson\Entity;

use CollectionJson\Entity\Template;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Entity\Data;
use Prophecy\Prophet;
use CollectionJson\ArrayConvertible;
use CollectionJson\DataAware;
use CollectionJson\Entity\Query;

class QuerySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Query::class);
        $this->shouldImplement(DataAware::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_return_the_object_type()
    {
        $this::getObjectType()->shouldBeEqualTo('query');
    }

    function it_should_be_chainable()
    {
        $this->setHref('http://example.com')->shouldReturn($this);
        $this->setRel('value')->shouldReturn($this);
        $this->setName('value')->shouldReturn($this);
        $this->setPrompt('value')->shouldReturn($this);
        $this->addData([])->shouldReturn($this);
        $this->addDataSet([])->shouldReturn($this);
    }

    function it_may_be_construct_with_an_array_representation_of_the_query()
    {
        $data2 = (new Prophet())->prophesize(Data::class);

        $data2->getName()->willReturn('name 2');
        $data2->getValue()->willReturn('value 2');

        $data = [
            'href'   => 'http://example.com',
            'rel'    => 'Query Rel',
            'name'   => 'Query Name',
            'prompt' => 'Query Prompt',
            'data' => [
                [
                    'name' => 'name 1',
                    'value' => 'value 1'
                ],
                $data2
            ]
        ];

        $query = $this::fromArray($data);
        $query->getHref()->shouldBeEqualTo('http://example.com');
        $query->getRel()->shouldBeEqualTo('Query Rel');
        $query->getName()->shouldBeEqualTo('Query Name');
        $query->getPrompt()->shouldBeEqualTo('Query Prompt');
        $query->getDataSet()->shouldHaveCount(2);
        $query->findDataByName('name 1')->getValue()->shouldBeEqualTo('value 1');
        $query->findDataByName('name 2')->getValue()->shouldBeEqualTo('value 2');
    }

    function it_should_throw_an_exception_when_setting_the_href_field_with_an_invalid_url()
    {
        $this->shouldThrow(
            new \DomainException("Property [href] of entity [query] can only have one of the following values [URI]")
        )->duringSetHref('uri');
    }

    function it_should_convert_the_rel_value_to_a_string()
    {
        $this->setRel(true);
        $this->getRel()->shouldBeEqualTo('1');
    }

    function it_should_convert_the_name_value_to_a_string()
    {
        $this->setName(true);
        $this->getName()->shouldBeEqualTo('1');
    }

    function it_should_convert_the_prompt_value_to_a_string()
    {
        $this->setPrompt(true);
        $this->getPrompt()->shouldBeEqualTo('1');
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_href_is_null()
    {
        $this->setRel('Rel value');
        $this->shouldThrow(new \DomainException('Property [href] of entity [query] is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_href_is_null()
    {
        $this->setRel('Rel value');
        $this->shouldThrow(
            new \DomainException('Property [href] of entity [query] is required')
        )->during('jsonSerialize');
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_rel_is_null()
    {
        $this->setHref('http://example.com');
        $this->shouldThrow(new \DomainException('Property [rel] of entity [query] is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_rel_is_null()
    {
        $this->setHref('http://example.com');
        $this->shouldThrow(
            new \DomainException('Property [rel] of entity [query] is required')
        )->during('jsonSerialize');
    }

    function it_should_not_return_null_values_and_empty_arrays()
    {
        $this->setRel('Rel value');
        $this->setHref('http://example.com');
        $this->toArray()->shouldBeEqualTo([
            'href'   => 'http://example.com',
            'rel'    => 'Rel value',
        ]);
    }

    function it_should_add_data_when_it_is_passed_as_an_object()
    {
        $data = (new Prophet())->prophesize(Data::class);
        $this->addData($data);
        $this->getDataSet()->shouldHaveCount(1);
    }

    function it_should_throw_an_exception_when_data_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [data] must be of type [CollectionJson\Entity\Data]')
        )->during('addData', [new Template()]);
    }

    function it_should_add_data_when_it_is_passed_as_an_array()
    {
        $this->addData(['value' => 'value 1']);
        $this->getDataSet()->shouldHaveCount(1);
    }

    function it_should_add_a_data_set()
    {
        $data = (new Prophet())->prophesize(Data::class);
        $this->addDataSet([$data, ['value' => 'value 2']]);
        $this->getDataSet()->shouldHaveCount(2);
    }

    function it_should_return_an_array_with_the_data_list()
    {
        $data1 = (new Prophet())->prophesize(Data::class);
        $data2 = (new Prophet())->prophesize(Data::class);
        
        $data1->toArray()->willReturn(['value' => 'value 1']);
        $data2->toArray()->willReturn(['value' => 'value 2']);

        $this->addData($data1);
        $this->addData($data2);
        $this->setRel('Rel value');
        $this->setHref('http://example.com');
        $this->toArray()->shouldBeEqualTo([
            'data'   => [
                ['value' => 'value 1'],
                ['value' => 'value 2'],
            ],
            'href'   => 'http://example.com',
            'rel'    => 'Rel value'
        ]);
    }


    function it_should_retrieve_the_data_by_name()
    {
        $data1 = (new Prophet())->prophesize(Data::class);
        $data2 = (new Prophet())->prophesize(Data::class);
        
        $data1->getName()->willReturn('name1');
        $data2->getName()->willReturn('name2');

        $this->addDataSet([$data1, $data2]);

        $this->findDataByName('name1')->shouldBeEqualTo($data1);
        $this->findDataByName('name2')->shouldBeEqualTo($data2);
    }

    function it_should_return_null_when_data_is_not_in_the_set()
    {
        $this->findDataByName('name1')->shouldBeNull();
    }

    function it_should_return_the_first_data_in_the_set()
    {
        $data1 = Data::fromArray(['value' => 'value1']);
        $data2 = Data::fromArray(['value' => 'value2']);
        $data3 = Data::fromArray(['value' => 'value3']);

        $this->addDataSet([$data1, $data2, $data3]);

        $this->getFirstData()->shouldReturn($data1);
    }

    function it_should_return_null_when_the_first_data_in_not_the_set()
    {
        $this->getFirstData()->shouldBeNull();
    }

    function it_should_return_the_last_data_in_the_set()
    {
        $data1 = Data::fromArray(['value' => 'value1']);
        $data2 = Data::fromArray(['value' => 'value2']);
        $data3 = Data::fromArray(['value' => 'value3']);

        $this->addDataSet([$data1, $data2, $data3]);

        $this->getLastData()->shouldReturn($data3);
    }

    function it_should_return_null_when_the_last_data_in_not_the_set()
    {
        $this->getLastData()->shouldBeNull();
    }
    
    function it_should_know_if_it_has_data()
    {
        $data = new Data();

        $this->addData($data);

        $this->shouldHaveData();
    }

    function it_should_know_if_it_has_no_data()
    {
        $this->shouldNotHaveData();
    }
}
