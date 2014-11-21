<?php

namespace spec\CollectionJson\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Entity\Item');
        $this->shouldImplement('CollectionJson\DataAware');
        $this->shouldImplement('CollectionJson\LinkAware');
        $this->shouldImplement('CollectionJson\ArrayInjectable');
        $this->shouldImplement('CollectionJson\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_be_chainable()
    {
        $this->setHref('value')->shouldHaveType('CollectionJson\Entity\Item');
        $this->addLink([])->shouldHaveType('CollectionJson\Entity\Item');
        $this->addLinksSet([])->shouldHaveType('CollectionJson\Entity\Item');
        $this->addData([])->shouldHaveType('CollectionJson\Entity\Item');
        $this->addDataSet([])->shouldHaveType('CollectionJson\Entity\Item');
    }

    /**
     * @param \CollectionJson\Entity\Data $data2
     */
    function it_should_inject_data($data2)
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
        $this->beConstructedWith($data);
        $this->getHref()->shouldBeEqualTo('http://example.com');
        $this->getDataSet()->shouldHaveCount(2);
        $this->getDataByName('name 1')->getValue()->shouldBeEqualTo('value 1');
        $this->getDataByName('name 2')->getValue()->shouldBeEqualTo('value 2');
    }

    function it_should_not_set_the_href_field_if_it_is_not_a_string()
    {
        $this->setHref(true);
        $this->getHref()->shouldBeNull();
    }

    function it_should_not_set_the_href_field_if_it_is_not_a_valid_url()
    {
        $this->setHref('uri');
        $this->getHref()->shouldBeNull();
    }

    /**
     * @param \CollectionJson\Entity\Data $data
     */
    function it_should_return_an_empty_array_when_the_href_field_is_not_defined($data)
    {
        $data->toArray()->willReturn(
            [
                'name' => 'Name',
                'value' => null
            ]
        );

        $this->addData($data);
        $this->toArray()->shouldBeEqualTo([]);
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

        $this->getDataByName('name1')->shouldBeEqualTo($data1);
        $this->getDataByName('name2')->shouldBeEqualTo($data2);
    }

    function it_should_return_null_when_data_is_not_the_set()
    {
        $this->getDataByName('name1')->shouldBeNull(null);
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
            'href'   => 'Href value',
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
                'href'   => 'Href value2',
                'rel'    => 'Rel value2',
                'render' => 'link2'
            ],
            new \stdClass()
        ]);
        $this->setHref('uri');
        $this->getLinksSet()->shouldHaveCount(2);
    }
}
