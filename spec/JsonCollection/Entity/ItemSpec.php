<?php

namespace spec\JsonCollection\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Entity\Item');
        $this->shouldImplement('JsonCollection\DataAware');
        $this->shouldImplement('JsonCollection\LinkAware');
        $this->shouldImplement('JsonCollection\ArrayInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_be_chainable()
    {
        $this->setHref('value')->shouldHaveType('JsonCollection\Entity\Item');
        $this->addLink([])->shouldHaveType('JsonCollection\Entity\Item');
        $this->addLinkSet([])->shouldHaveType('JsonCollection\Entity\Item');
        $this->addData([])->shouldHaveType('JsonCollection\Entity\Item');
        $this->addDataSet([])->shouldHaveType('JsonCollection\Entity\Item');
    }

    function it_should_inject_data()
    {
        $data = [
            'href' => 'Link Href'
        ];
        $this->inject($data);
        $this->getHref()->shouldBeEqualTo('Link Href');
    }

    function it_should_not_set_the_href_field_if_it_is_not_a_string()
    {
        $this->setHref(true);
        $this->getHref()->shouldBeNull();
    }

    /**
     * @param \JsonCollection\Entity\Data $data
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
     * @param \JsonCollection\Entity\Data $data
     */
    function it_should_not_return_empty_array($data)
    {
        $data->toArray()->willReturn(
            [
                'name' => 'Name',
                'value' => null
            ]
        );

        $this->setHref('uri');
        $this->addData($data);
        $this->toArray()->shouldBeEqualTo(
            [
                'data' => [
                    [
                        'name' => 'Name',
                        'value' => null
                    ]
                ],
                'href' => 'uri',
            ]
        );
    }

    /**
     * @param \JsonCollection\Entity\Data $data
     */
    function it_should_add_data_when_it_is_passed_as_an_object($data)
    {
        $this->addData($data);
        $this->countData()->shouldBeEqualTo(1);
    }

    function it_should_add_data_when_it_is_passed_as_an_array()
    {
        $this->addData(['value' => 'value 1']);
        $this->countData()->shouldBeEqualTo(1);
    }

    /**
     * @param \JsonCollection\Entity\Data $data
     */
    function it_should_add_a_data_set($data)
    {
        $this->addDataSet([$data, ['value' => 'value 2'], new \stdClass()]);
        $this->countData()->shouldBeEqualTo(2);
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

    /**
     * @param \JsonCollection\Entity\Link $link
     */
    function it_should_add_a_link_when_it_is_passed_as_an_object($link)
    {
        $this->addLink($link);
        $this->countLinks()->shouldBeEqualTo(1);
    }

    function it_should_add_a_link_when_it_is_passed_as_an_array()
    {
        $this->addLink([
            'href'   => 'Href value',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]);
        $this->countLinks()->shouldBeEqualTo(1);
    }

    /**
     * @param \JsonCollection\Entity\Link $link1
     */
    function it_should_add_a_link_set($link1)
    {
        $this->addLinkSet([
            $link1,
            [
                'href'   => 'Href value2',
                'rel'    => 'Rel value2',
                'render' => 'link2'
            ],
            new \stdClass()
        ]);
        $this->setHref('uri');
        $this->countLinks()->shouldBeEqualTo(2);
    }
}
