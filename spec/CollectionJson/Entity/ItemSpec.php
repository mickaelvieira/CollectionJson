<?php

namespace spec\CollectionJson\Entity;

use CollectionJson\Entity\Link;
use CollectionJson\Entity\Data;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Entity\Item');
        $this->shouldImplement('CollectionJson\DataAware');
        $this->shouldImplement('CollectionJson\LinkAware');
        $this->shouldImplement('CollectionJson\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_return_the_object_type()
    {
        $this->getObjectType()->shouldBeEqualTo('item');
    }

    function it_should_be_chainable()
    {
        $this->setHref('http://example.com')->shouldReturn($this);
        $this->addLink([])->shouldReturn($this);
        $this->addLinksSet([])->shouldReturn($this);
        $this->addData([])->shouldReturn($this);
        $this->addDataSet([])->shouldReturn($this);
    }

    /**
     * @param \CollectionJson\Entity\Data $data2
     */
    function it_may_be_construct_with_an_array_representation_of_the_item($data2)
    {
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
        $item = $this::fromArray($data);
        $item->getHref()->shouldBeEqualTo('http://example.com');
        $item->getDataSet()->shouldHaveCount(2);
        $item->findDataByName('name 1')->getValue()->shouldBeEqualTo('value 1');
        $item->findDataByName('name 2')->getValue()->shouldBeEqualTo('value 2');
    }

    function it_should_throw_an_exception_when_setting_the_href_field_with_an_invalid_url()
    {
        $this->shouldThrow('\Exception')->duringSetHref('uri');
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_href_is_null()
    {
        $this->shouldThrow(new \LogicException('Property href of object type item is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_href_is_null()
    {
        $this->shouldThrow(
            new \LogicException('Property href of object type item is required')
        )->during('jsonSerialize');
    }

    /**
     * @param \CollectionJson\Entity\Data $data
     */
    function it_should_not_return_empty_array($data)
    {
        $data->toArray()->willReturn(
            [
                'name' => 'Name',
                'value' => null
            ]
        );

        $this->setHref('http://example.com');
        $this->addData($data);
        $this->toArray()->shouldBeEqualTo(
            [
                'data' => [
                    [
                        'name' => 'Name',
                        'value' => null
                    ]
                ],
                'href' => 'http://example.com',
            ]
        );
    }

    /**
     * @param \CollectionJson\Entity\Data $data
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
     * @param \CollectionJson\Entity\Data $data
     */
    function it_should_add_a_data_set($data)
    {
        $this->addDataSet([$data, ['value' => 'value 2'], new \stdClass()]);
        $this->getDataSet()->shouldHaveCount(2);
    }

    /**
     * @param \CollectionJson\Entity\Data $data1
     * @param \CollectionJson\Entity\Data $data2
     */
    function it_should_retrieve_the_data_by_name($data1, $data2)
    {
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

        $this->findLinkByRelation('rel1')->shouldBeEqualTo($link1);
        $this->findLinkByRelation('rel2')->shouldBeEqualTo($link2);
    }

    function it_should_return_null_when_data_is_not_in_the_set()
    {
        $this->findDataByName('name1')->shouldBeNull();
    }

    function it_should_return_null_when_link_is_not_in_the_set()
    {
        $this->findLinkByRelation('rel1')->shouldBeNull();
    }

    /**
     * @param \CollectionJson\Entity\Link $link
     */
    function it_should_add_a_link_when_it_is_passed_as_an_object($link)
    {
        $this->addLink($link);
        $this->getLinksSet()->shouldHaveCount(1);
    }

    function it_should_add_a_link_when_it_is_passed_as_an_array()
    {
        $this->addLink([
            'href'   => 'http://example.com',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]);
        $this->getLinksSet()->shouldHaveCount(1);
    }

    /**
     * @param \CollectionJson\Entity\Link $link1
     */
    function it_should_add_a_link_set($link1)
    {
        $this->addLinksSet([
            $link1,
            [
                'href'   => 'http://example.com',
                'rel'    => 'Rel value2',
                'render' => 'link'
            ],
            new \stdClass()
        ]);
        $this->setHref('http://example.com');
        $this->getLinksSet()->shouldHaveCount(2);
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

        $this->addLink($link);

        $this->shouldHaveLinks();
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
