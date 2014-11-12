<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Item');
        $this->shouldImplement('JsonCollection\DataAware');
        $this->shouldImplement('JsonCollection\LinkAware');
        $this->shouldImplement('JsonCollection\DataInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_be_chainable()
    {
        $this->setHref('value')->shouldHaveType('JsonCollection\Item');
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
     * @param \JsonCollection\Data $data
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
     * @param \JsonCollection\Data $data
     */
    function it_should_not_extract_empty_array_fields($data)
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
     * @param \JsonCollection\Data $data
     */
    function it_should_add_data($data)
    {
        $this->addData($data);
        $this->countData()->shouldBeEqualTo(1);
    }

    function it_should_add_data_when_passed_as_a_array()
    {
        $this->addData(['value' => 'value 1']);
        $this->countData()->shouldBeEqualTo(1);
    }

    /**
     * @param \JsonCollection\Data $data
     */
    function it_should_add_a_data_set($data)
    {
        $this->addDataSet([$data, ['value' => 'value 2'], new \stdClass()]);
        $this->countData()->shouldBeEqualTo(2);
    }

    /**
     * @param \JsonCollection\Data $data1
     * @param \JsonCollection\Data $data2
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
     * @param \JsonCollection\Link $link
     */
    function it_should_add_a_link($link)
    {
        $link->toArray()->willReturn([
            'href'   => 'Href value',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]);

        $this->addLink($link);
        $this->countLinks()->shouldBeEqualTo(1);
    }

    function it_should_add_a_link_when_passing_an_array()
    {
        $this->addLink([
            'href'   => 'Href value',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]);
        $this->countLinks()->shouldBeEqualTo(1);
    }

    /**
     * @param \JsonCollection\Link $link1
     * @param \JsonCollection\Link $link2
     */
    function it_should_add_a_link_set($link1, $link2)
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
