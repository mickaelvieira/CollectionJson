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
        $this->beConstructedWith('http://example.com');
        $this->shouldHaveType(Item::class);
        $this->shouldImplement(DataAware::class);
        $this->shouldImplement(LinkAware::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_return_the_object_type()
    {
        $this->beConstructedWith('http://example.com');
        $this::getObjectType()->shouldBeEqualTo('item');
    }


    function it_can_be_initialized_with_an_href()
    {
        $this->beConstructedWith('http://example.com');
        $this->getHref()->shouldReturn('http://example.com');
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
        $this->beConstructedWith('http://example.com');
        $this->withHref('http://example.com')->shouldHaveType(Item::class);
        $this->withLink(new Link('http://example.com', 'item'))->shouldHaveType(Item::class);
        $this->withLinksSet([])->shouldHaveType(Item::class);
        $this->withData(['name' => 'my name'])->shouldHaveType(Item::class);
        $this->withDataSet([])->shouldHaveType(Item::class);
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
        $this->getDataByName('name 1')->getValue()->shouldBeEqualTo('value 1');
        $this->getDataByName('name 2')->getValue()->shouldBeEqualTo('value 2');
    }

    function it_should_throw_an_exception_when_setting_the_href_field_with_an_invalid_url()
    {
        $this->beConstructedWith('http://example.com');
        $this->shouldThrow(
            new \DomainException("Property [href] of entity [item] can only have one of the following values [URI]")
        )->during('withHref', ['uri']);
    }

    function it_should_set_the_href_value()
    {
        $this->beConstructedWith('http://example.com');
        $link = $this->withHref("htp://google.com");
        $this->getHref()->shouldBeEqualTo('http://example.com');
        $link->getHref()->shouldBeEqualTo("htp://google.com");
    }

    function it_should_not_return_empty_array()
    {
        $data = (new Prophet())->prophesize(Data::class);
        $data->toArray()->willReturn([
            'name' => 'Name',
            'value' => null
        ]);

        $this->beConstructedWith('http://example.com');
        $collection = $this->withHref('http://example.com');
        $collection = $collection->withData($data);
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
        $data = new Data('Name');

        $this->beConstructedWith('http://example.com');
        $item = $this->withData($data);
        $this->getDataSet()->shouldHaveCount(0);
        $item->getDataSet()->shouldHaveCount(1);
    }

    function it_should_remove_data()
    {
        $data = new Data('Name');

        $this->beConstructedWith('http://example.com');
        $template = $this->withData($data);
        $template->getDataSet()->shouldHaveCount(1);

        $template = $template->withoutData($data);
        $template->getDataSet()->shouldHaveCount(0);
    }

    function it_should_throw_an_exception_when_data_has_the_wrong_type()
    {
        $this->beConstructedWith('http://example.com');
        $this->shouldThrow(
            new \DomainException('Property [data] must be of type [CollectionJson\Entity\Data]')
        )->during('withData', [new Template()]);
    }

    function it_should_add_data_when_it_is_passed_as_an_array()
    {
        $this->beConstructedWith('http://example.com');
        $item = $this->withData(['name' => 'name 1', 'value' => 'value 1']);
        $this->getDataSet()->shouldHaveCount(0);
        $item->getDataSet()->shouldHaveCount(1);
    }

    function it_should_add_a_data_set()
    {
        $data = (new Prophet())->prophesize(Data::class);

        $this->beConstructedWith('http://example.com');
        $item = $this->withDataSet([$data, ['name' => 'name 2', 'value' => 'value 2']]);
        $this->getDataSet()->shouldHaveCount(0);
        $item->getDataSet()->shouldHaveCount(2);
    }

    function it_should_retrieve_the_data_by_name()
    {
        $data1 = (new Prophet())->prophesize(Data::class);
        $data2 = (new Prophet())->prophesize(Data::class);

        $data1->getName()->willReturn('name1');
        $data2->getName()->willReturn('name2');

        $this->beConstructedWith('http://example.com');
        $item = $this->withDataSet([$data1, $data2]);

        $this->getDataByName('name1')->shouldBeNull();
        $this->getDataByName('name2')->shouldBeNull();

        $item->getDataByName('name1')->shouldBeLike($data1);
        $item->getDataByName('name2')->shouldBeLike($data2);
    }

    function it_should_retrieve_the_link_by_relation()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);

        $this->beConstructedWith('http://example.com');
        $item = $this->withLinksSet([$link1, $link2]);

        $this->getLinksByRel('rel1')->shouldHaveCount(0);
        $this->getLinksByRel('rel2')->shouldHaveCount(0);

        $item->getLinksByRel('rel1')->shouldBeLike([$link1]);
        $item->getLinksByRel('rel2')->shouldBeLike([$link2]);
    }

    function it_should_return_null_when_data_is_not_in_the_set()
    {
        $this->beConstructedWith('http://example.com');
        $this->getDataByName('name1')->shouldBeNull();
    }

    function it_should_return_null_when_link_is_not_in_the_set()
    {
        $this->beConstructedWith('http://example.com');
        $this->getLinksByRel('rel1')->shouldReturn([]);
    }

    function it_should_add_a_link_when_it_is_passed_as_an_object()
    {
        $link = (new Prophet())->prophesize(Link::class);

        $this->beConstructedWith('http://example.com');
        $item = $this->withLink($link);
        $item->getLinks()->shouldHaveCount(1);
    }

    function it_should_add_a_link_when_it_is_passed_as_an_array()
    {
        $this->beConstructedWith('http://example.com');
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

        $this->beConstructedWith('http://example.com');
        $item = $this->withLinksSet([
            $link1,
            [
                'href'   => 'http://example.com',
                'rel'    => 'Rel value2',
                'render' => 'link'
            ]
        ]);
        $item = $item->withHref('http://example.com');
        $item->getLinks()->shouldHaveCount(2);
    }

    function it_should_return_the_first_link_in_the_set()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);
        $link3 = Link::fromArray(['rel' => 'rel3', 'href' => 'http://example3.com']);

        $this->beConstructedWith('http://example.com');
        $item = $this->withLinksSet([$link1, $link2, $link3]);

        $item->getFirstLink()->shouldBeLike($link1);
    }

    function it_should_return_the_last_link_in_the_set()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);
        $link3 = Link::fromArray(['rel' => 'rel3', 'href' => 'http://example3.com']);

        $this->beConstructedWith('http://example.com');
        $item = $this->withLinksSet([$link1, $link2, $link3]);

        $item->getLastLink()->shouldBeLike($link3);
    }

    function it_should_know_if_it_has_links()
    {
        $link = new Link('http://example.com', 'item');

        $this->beConstructedWith('http://example.com');
        $item = $this->withLink($link);

        $item->shouldHaveLinks();
    }

    function it_should_know_if_it_has_no_links()
    {
        $this->beConstructedWith('http://example.com');
        $this->shouldNotHaveLinks();
    }

    function it_should_return_the_first_data_in_the_set()
    {
        $this->beConstructedWith('http://example.com');

        $data1 = Data::fromArray(['name' => 'name 1', 'value' => 'value1']);
        $data2 = Data::fromArray(['name' => 'name 2', 'value' => 'value2']);
        $data3 = Data::fromArray(['name' => 'name 3', 'value' => 'value3']);

        $item = $this->withDataSet([$data1, $data2, $data3]);

        $item->getFirstData()->shouldBeLike($data1);
    }

    function it_should_return_the_last_data_in_the_set()
    {
        $this->beConstructedWith('http://example.com');

        $data1 = Data::fromArray(['name' => 'name 1', 'value' => 'value1']);
        $data2 = Data::fromArray(['name' => 'name 2', 'value' => 'value2']);
        $data3 = Data::fromArray(['name' => 'name 3', 'value' => 'value3']);

        $item = $this->withDataSet([$data1, $data2, $data3]);

        $item->getLastData()->shouldReturn($data3);
    }

    function it_should_know_if_it_has_data()
    {
        $data = new Data('Name');

        $this->beConstructedWith('http://example.com');
        $item = $this->withData($data);
        $this->shouldNotHaveData();
        $item->shouldHaveData();
    }

    function it_should_know_if_it_has_no_data()
    {
        $this->beConstructedWith('http://example.com');
        $this->shouldNotHaveData();
    }
}
