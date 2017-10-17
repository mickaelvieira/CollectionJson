<?php

namespace spec\CollectionJson\Entity;

use CollectionJson\Entity\Template;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Entity\Data;
use Prophecy\Prophet;
use CollectionJson\ArrayConvertible;
use CollectionJson\DataAware;

class TemplateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Template::class);
        $this->shouldImplement(DataAware::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_return_the_object_type()
    {
        $this::getObjectType()->shouldBeEqualTo('template');
    }

    function it_is_clonable()
    {
        $this->beConstructedThrough('fromArray', [[
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

        $this->getDataSet()->shouldHaveCount(count($copy->getDataSet()));
        $this->getFirstData()->shouldNotBeEqualTo($copy->getFirstData());
        $this->getLastData()->shouldNotBeEqualTo($copy->getLastData());
    }

    function it_may_be_construct_with_an_array_representation_of_the_template()
    {
        $data = (new Prophet())->prophesize(Data::class);

        $data->getName()->willReturn('name 2');
        $data->getValue()->willReturn('value 2');

        $data = [
            'data' => [
                [
                    'name' => 'name 1',
                    'value' => 'value 1'
                ],
                $data
            ]
        ];

        $this->beConstructedThrough('fromArray', [$data]);

        $this->getDataSet()->shouldHaveCount(2);

        $this->getDataByName('name 1')->getValue()->shouldBeEqualTo('value 1');
        $this->getDataByName('name 2')->getValue()->shouldBeEqualTo('value 2');
    }

    function it_may_be_construct_from_a_json_representation_of_the_collection()
    {
        $json = '
        {
          "template": {
            "data": [
              {
                "name": "full-name",
                "value": "",
                "prompt": "Full Name"
              },
              {
                "name": "email",
                "value": "",
                "prompt": "Email"
              },
              {
                "name": "blog",
                "value": "",
                "prompt": "Blog"
              },
              {
                "name": "avatar",
                "value": "",
                "prompt": "Avatar"
              }
            ]
          }
        }';

        $template = $this::fromJson($json);
        $template->getFirstData()->getName()->shouldReturn('full-name');
        $template->getLastData()->getName()->shouldReturn('avatar');
        $template->getDataSet()->shouldHaveCount(4);
    }

    function it_should_be_chainable()
    {
        $this->withData(['name' => 'my name'])->shouldHaveType(Template::class);
        $this->withDataSet([])->shouldHaveType(Template::class);
    }

    function it_should_not_return_null_values_and_empty_arrays()
    {
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_add_data_when_it_is_passed_as_an_object()
    {
        $data = new Data('Name');

        $template = $this->withData($data);
        $this->getDataSet()->shouldHaveCount(0);
        $template->getDataSet()->shouldHaveCount(1);
    }

    function it_should_remove_data()
    {
        $data = new Data('Name');

        $template = $this->withData($data);
        $template->getDataSet()->shouldHaveCount(1);

        $template = $template->withoutData($data);
        $template->getDataSet()->shouldHaveCount(0);
    }

    function it_should_throw_an_exception_when_data_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \DomainException('Property [data] must be of type [CollectionJson\Entity\Data]')
        )->during('withData', [new Template()]);
    }

    function it_should_add_data_when_it_is_passed_as_an_array()
    {
        $template = $this->withData(['name' => 'name 1', 'value' => 'value 1']);
        $this->getDataSet()->shouldHaveCount(0);
        $template->getDataSet()->shouldHaveCount(1);
    }

    function it_should_add_a_data_set()
    {
        $data = (new Prophet())->prophesize(Data::class);

        $template = $this->withDataSet([$data, ['name' => 'name 2', 'value' => 'value 2']]);
        $this->getDataSet()->shouldHaveCount(0);
        $template->getDataSet()->shouldHaveCount(2);
    }

    function it_should_return_an_array_with_the_data_list()
    {
        $data1 = (new Prophet())->prophesize(Data::class);
        $data2 = (new Prophet())->prophesize(Data::class);

        $data1->toArray()->willReturn(['value' => 'value 1']);
        $data2->toArray()->willReturn(['value' => 'value 2']);

        $template = $this->withData($data1);
        $template = $template->withData($data2);
        $template->toArray()->shouldBeEqualTo([
            'data'   => [
                ['value' => 'value 1'],
                ['value' => 'value 2'],
            ]
        ]);
    }

    function it_should_add_an_envelope()
    {
        $data = (new Prophet())->prophesize(Data::class);
        $data->toArray()->willReturn(['value' => 'value 1']);

        $template = $this->withData($data);
        $template = $template->wrap();
        $template->toArray()->shouldBeEqualTo([
            'template' => [
                'data' => [
                    ['value' => 'value 1']
                ]
            ]
        ]);
    }

    function it_should_be_chainable_during_wrapping()
    {
        $this->wrap()->shouldHaveType(Template::class);
    }

    function it_should_retrieve_the_data_by_name()
    {
        $data1 = (new Prophet())->prophesize(Data::class);
        $data2 = (new Prophet())->prophesize(Data::class);

        $data1->getName()->willReturn('name1');
        $data2->getName()->willReturn('name2');

        $template = $this->withDataSet([$data1, $data2]);

        $this->getDataByName('name1')->shouldBeNull();
        $this->getDataByName('name2')->shouldBeNull();

        $template->getDataByName('name1')->shouldBeLike($data1);
        $template->getDataByName('name2')->shouldBeLike($data2);
    }

    function it_should_return_null_when_data_is_not_in_the_set()
    {
        $this->getDataByName('name1')->shouldBeNull();
    }

    function it_should_return_the_first_data_in_the_set()
    {
        $data1 = Data::fromArray(['name' => 'name 1', 'value' => 'value1']);
        $data2 = Data::fromArray(['name' => 'name 2', 'value' => 'value2']);
        $data3 = Data::fromArray(['name' => 'name 3', 'value' => 'value3']);

        $template = $this->withDataSet([$data1, $data2, $data3]);

        $template->getFirstData()->shouldBeLike($data1);
    }

    function it_should_return_the_last_data_in_the_set()
    {
        $data1 = Data::fromArray(['name' => 'name 1', 'value' => 'value1']);
        $data2 = Data::fromArray(['name' => 'name 2', 'value' => 'value2']);
        $data3 = Data::fromArray(['name' => 'name 3', 'value' => 'value3']);

        $template = $this->withDataSet([$data1, $data2, $data3]);

        $template->getLastData()->shouldBeLike($data3);
    }

    function it_should_know_if_it_has_data()
    {
        $data = new Data('Name');

        $template = $this->withData($data);
        $this->shouldNotHaveData();
        $template->shouldHaveData();
    }

    function it_should_know_if_it_has_no_data()
    {
        $this->shouldNotHaveData();
    }
}
