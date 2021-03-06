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
        $this->beConstructedWith('http://example.com', 'item');
        $this->shouldHaveType(Query::class);
        $this->shouldImplement(DataAware::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_return_the_object_type()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this::getObjectType()->shouldBeEqualTo('query');
    }

    function it_can_be_initialized_with_data()
    {
        $this->beConstructedWith('http://example.com', 'self', 'my query', 'cool query');
        $this->getHref()->shouldReturn('http://example.com');
        $this->getRel()->shouldReturn('self');
        $this->getName()->shouldReturn('my query');
        $this->getPrompt()->shouldReturn('cool query');
    }

    function it_is_clonable()
    {
        $this->beConstructedThrough('fromArray', [[
            'href'   => 'http://example.com',
            'rel'    => 'Query Rel',
            'name'   => 'Query Name',
            'prompt' => 'Query Prompt',
            'data'   => [
                [
                    'name'   => 'Data Name 1',
                    'prompt' => 'Data Prompt 1',
                    'value'  => 'Data Value 1'
                ],
                [
                    'name'   => 'Data Name 2',
                    'prompt' => 'Data Prompt 2',
                    'value'  => 'Data Value 2'
                ]
            ]
        ]]);

        $this->getDataSet()->shouldHaveCount(2);
        $this->getFirstData()->shouldHaveType(Data::class);
        $this->getLastData()->shouldHaveType(Data::class);

        $copy = clone $this->getWrappedObject();

        $this->getHref()->shouldReturn($copy->getHref());
        $this->getRel()->shouldReturn($copy->getRel());
        $this->getName()->shouldReturn($copy->getName());
        $this->getPrompt()->shouldReturn($copy->getPrompt());
        $this->getDataSet()->shouldHaveCount(count($copy->getDataSet()));
        $this->getFirstData()->shouldNotBeEqualTo($copy->getFirstData());
        $this->getLastData()->shouldNotBeEqualTo($copy->getLastData());
    }

    function it_should_be_chainable()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->withHref('http://example.com')->shouldHaveType(Query::class);
        $this->withRel('value')->shouldHaveType(Query::class);
        $this->withName('value')->shouldHaveType(Query::class);
        $this->withPrompt('value')->shouldHaveType(Query::class);
        $this->withData(['name' => 'my name'])->shouldHaveType(Query::class);
        $this->withDataSet([])->shouldHaveType(Query::class);
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

        $this->beConstructedThrough('fromArray', [$data]);

        $this->getHref()->shouldBeEqualTo('http://example.com');
        $this->getRel()->shouldBeEqualTo('Query Rel');
        $this->getName()->shouldBeEqualTo('Query Name');
        $this->getPrompt()->shouldBeEqualTo('Query Prompt');
        $this->getDataSet()->shouldHaveCount(2);
        $this->getDataByName('name 1')->getValue()->shouldBeEqualTo('value 1');
        $this->getDataByName('name 2')->getValue()->shouldBeEqualTo('value 2');
    }

    function it_should_throw_an_exception_when_setting_the_href_field_with_an_invalid_url()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->shouldThrow(
            new \DomainException("Property [href] of entity [query] can only have one of the following values [URI]")
        )->during('withHref', ['uri']);
    }

    function it_should_set_the_href_value()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $link = $this->withHref("htp://google.com");
        $this->getHref()->shouldBeEqualTo('http://example.com');
        $link->getHref()->shouldBeEqualTo("htp://google.com");
    }

    function it_should_convert_the_rel_value_to_a_string()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withRel(true);
        $this->getRel()->shouldBeEqualTo('item');
        $query->getRel()->shouldBeEqualTo('1');
    }

    function it_should_convert_the_name_value_to_a_string()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withName(true);
        $this->getName()->shouldBeNull();
        $query->getName()->shouldBeEqualTo('1');
    }

    function it_should_convert_the_prompt_value_to_a_string()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withPrompt(true);
        $this->getPrompt()->shouldBeNull();
        $query->getPrompt()->shouldBeEqualTo('1');
    }

    function it_should_not_return_null_values_and_empty_arrays()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withRel('Rel value');
        $query = $query->withHref('http://example.com');
        $query->toArray()->shouldBeEqualTo([
            'href'   => 'http://example.com',
            'rel'    => 'Rel value',
        ]);
    }

    function it_should_add_data_when_it_is_passed_as_an_object()
    {
        $data = new Data('Name');

        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withData($data);
        $this->getDataSet()->shouldHaveCount(0);
        $query->getDataSet()->shouldHaveCount(1);
    }

    function it_should_remove_data()
    {
        $data = new Data('Name');

        $this->beConstructedWith('http://example.com', 'item');
        $template = $this->withData($data);
        $template->getDataSet()->shouldHaveCount(1);

        $template = $template->withoutData($data);
        $template->getDataSet()->shouldHaveCount(0);
    }

    function it_should_throw_an_exception_when_data_has_the_wrong_type()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->shouldThrow(
            new \DomainException('Property [data] must be of type [CollectionJson\Entity\Data]')
        )->during('withData', [new Template()]);
    }

    function it_should_add_data_when_it_is_passed_as_an_array()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withData(['name' => 'name 1', 'value' => 'value 1']);
        $this->getDataSet()->shouldHaveCount(0);
        $query->getDataSet()->shouldHaveCount(1);
    }

    function it_should_add_a_data_set()
    {
        $data = (new Prophet())->prophesize(Data::class);

        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withDataSet([$data, ['name' => 'name 2', 'value' => 'value 2']]);
        $this->getDataSet()->shouldHaveCount(0);
        $query->getDataSet()->shouldHaveCount(2);
    }

    function it_should_return_an_array_with_the_data_list()
    {
        $data1 = (new Prophet())->prophesize(Data::class);
        $data2 = (new Prophet())->prophesize(Data::class);
        
        $data1->toArray()->willReturn(['name' => 'name 1', 'value' => 'value 1']);
        $data2->toArray()->willReturn(['name' => 'name 2', 'value' => 'value 2']);

        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withData($data1);
        $query = $query->withData($data2);
        $query = $query->withRel('Rel value');
        $query = $query->withHref('http://example.com');
        $query->toArray()->shouldBeEqualTo([
            'data'   => [
                ['name' => 'name 1', 'value' => 'value 1'],
                ['name' => 'name 2', 'value' => 'value 2'],
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

        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withDataSet([$data1, $data2]);

        $this->getDataByName('name1')->shouldBeNull();
        $this->getDataByName('name2')->shouldBeNull();

        $query->getDataByName('name1')->shouldBeLike($data1);
        $query->getDataByName('name2')->shouldBeLike($data2);
    }

    function it_should_return_null_when_data_is_not_in_the_set()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->getDataByName('name1')->shouldBeNull();
    }

    function it_should_return_the_first_data_in_the_set()
    {
        $data1 = Data::fromArray(['name' => 'name 1', 'value' => 'value1']);
        $data2 = Data::fromArray(['name' => 'name 2', 'value' => 'value2']);
        $data3 = Data::fromArray(['name' => 'name 3', 'value' => 'value3']);

        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withDataSet([$data1, $data2, $data3]);

        $query->getFirstData()->shouldBeLike($data1);
    }

    function it_should_return_the_last_data_in_the_set()
    {
        $data1 = Data::fromArray(['name' => 'name 1', 'value' => 'value1']);
        $data2 = Data::fromArray(['name' => 'name 2', 'value' => 'value2']);
        $data3 = Data::fromArray(['name' => 'name 3', 'value' => 'value3']);

        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withDataSet([$data1, $data2, $data3]);

        $query->getLastData()->shouldBeLike($data3);
    }

    function it_should_know_if_it_has_data()
    {
        $data = new Data('Name');

        $this->beConstructedWith('http://example.com', 'item');
        $query = $this->withData($data);
        $this->shouldNotHaveData();
        $query->shouldHaveData();
    }

    function it_should_know_if_it_has_no_data()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->shouldNotHaveData();
    }
}
