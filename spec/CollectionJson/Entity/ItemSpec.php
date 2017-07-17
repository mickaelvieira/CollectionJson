<?php

namespace spec\CollectionJson\Entity;

use CollectionJson\Entity\Link;
use CollectionJson\Entity\Data;
use CollectionJson\Entity\Template;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Prophet;
use CollectionJson\Entity\Item;
use CollectionJson\DataAware;
use CollectionJson\LinkAware;
use CollectionJson\ArrayConvertible;

class ItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Item::class);
        $this->shouldImplement(DataAware::class);
        $this->shouldImplement(LinkAware::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_return_the_object_type()
    {
        $this::getObjectType()->shouldBeEqualTo('item');
    }

    function it_is_clonable()
    {
        $this->beConstructedThrough('fromArray', [[
            'href'   => 'http://example.com',
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
            ],
            'links' => [
                [
                    'rel' => 'rel1',
                    'href' => 'http://example.com'
                ],
                [
                    'rel' => 'rel2',
                    'href' => 'http://example2.com'
                ]
            ]
        ]]);

        $this->getDataSet()->shouldHaveCount(2);
        $this->getLinks()->shouldHaveCount(2);
        $this->getFirstData()->shouldHaveType(Data::class);
        $this->getLastData()->shouldHaveType(Data::class);

        $copy = clone $this->getWrappedObject();

        $this->getHref()->shouldReturn($copy->getHref());

        $this->getDataSet()->shouldHaveCount(count($copy->getDataSet()));
        $this->getLinks()->shouldHaveCount(count($copy->getLinks()));

        $this->getFirstData()->shouldNotBeEqualTo($copy->getFirstData());
        $this->getLastData()->shouldNotBeEqualTo($copy->getLastData());

        $this->getFirstLink()->shouldNotBeEqualTo($copy->getFirstLink());
        $this->getLastLink()->shouldNotBeEqualTo($copy->getLastLink());
    }

    function it_should_be_chainable()
    {
        $this->withHref('http://example.com')->shouldHaveType(Item::class);
        $this->withLink(new Link())->shouldHaveType(Item::class);
        $this->addLinksSet([])->shouldHaveType(Item::class);
        $this->addData([])->shouldHaveType(Item::class);
        $this->addDataSet([])->shouldHaveType(Item::class);
    }

    function it_may_be_construct_with_an_array_representation_of_the_item()
    {
        $data2 = (new Prophet())->prophesize(Data::class);
        $data2->getName()->willReturn('name 2');
        $data2->getValue()->willReturn('value 2');

        $data = [
            'href' => 'http://example.com',
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
        $this->getDataSet()->shouldHaveCount(2);
        $this->findDataByName('name 1')->getValue()->shouldBeEqualTo('value 1');
        $this->findDataByName('name 2')->getValue()->shouldBeEqualTo('value 2');
    }

    function it_should_throw_an_exception_when_setting_the_href_field_with_an_invalid_url()
    {
        $this->shouldThrow(
            new \DomainException("Property [href] of entity [item] can only have one of the following values [URI]")
        )->during('withHref', ['uri']);
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_href_is_null()
    {
        $this->shouldThrow(new \DomainException('Property [href] of entity [item] is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_href_is_null()
    {
        $this->shouldThrow(
            new \DomainException('Property [href] of entity [item] is required')
        )->during('jsonSerialize');
    }

    function it_should_not_return_empty_array()
    {
        $data = (new Prophet())->prophesize(Data::class);
        $data->toArray()->willReturn([
            'name' => 'Name',
            'value' => null
        ]);

        $collection = $this->withHref('http://example.com');
        $collection->addData($data);
        $collection->toArray()->shouldBeEqualTo([
            'data' => [
                [
                    'name' => 'Name',
                    'value' => null
                ]
            ],
            'href' => 'http://example.com',
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

    function it_should_retrieve_the_link_by_relation()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);

        $this->addLinksSet([$link1, $link2]);

        $this->getLinksByRel('rel1')->shouldBeEqualTo([$link1]);
        $this->getLinksByRel('rel2')->shouldBeEqualTo([$link2]);
    }

    function it_should_return_null_when_data_is_not_in_the_set()
    {
        $this->findDataByName('name1')->shouldBeNull();
    }

    function it_should_return_null_when_link_is_not_in_the_set()
    {
        $this->getLinksByRel('rel1')->shouldReturn([]);
    }

    function it_should_add_a_link_when_it_is_passed_as_an_object()
    {
        $link = (new Prophet())->prophesize(Link::class);
        $item = $this->withLink($link);
        $item->getLinks()->shouldHaveCount(1);
    }

    function it_should_add_a_link_when_it_is_passed_as_an_array()
    {
        $item = $this->withLink(Link::fromArray([
            'href'   => 'http://example.com',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]));
        $item->getLinks()->shouldHaveCount(1);
    }

    function it_should_add_a_link_set()
    {
        $link1 = (new Prophet())->prophesize(Link::class);
        $this->addLinksSet([
            $link1,
            [
                'href'   => 'http://example.com',
                'rel'    => 'Rel value2',
                'render' => 'link'
            ]
        ]);
        $collection = $this->withHref('http://example.com');
        $collection->getLinks()->shouldHaveCount(2);
    }

    function it_should_return_the_first_link_in_the_set()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);
        $link3 = Link::fromArray(['rel' => 'rel3', 'href' => 'http://example3.com']);

        $this->addLinksSet([$link1, $link2, $link3]);

        $this->getFirstLink()->shouldReturn($link1);
    }

    function it_should_return_null_when_the_first_link_in_not_the_set()
    {
        $this->getFirstLink()->shouldBeNull();
    }

    function it_should_return_the_last_link_in_the_set()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);
        $link3 = Link::fromArray(['rel' => 'rel3', 'href' => 'http://example3.com']);

        $this->addLinksSet([$link1, $link2, $link3]);

        $this->getLastLink()->shouldReturn($link3);
    }

    function it_should_return_null_when_the_last_link_in_not_the_set()
    {
        $this->getLastLink()->shouldBeNull();
    }

    function it_should_know_if_it_has_links()
    {
        $link = new Link();

        $item = $this->withLink($link);

        $item->shouldHaveLinks();
    }

    function it_should_know_if_it_has_no_links()
    {
        $this->shouldNotHaveLinks();
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
