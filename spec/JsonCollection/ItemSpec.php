<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Item');
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
        $this->setHref('uri');
        $this->toArray()->shouldBeEqualTo([
            'href' => 'uri',
            'links' => [
                [
                    'href'   => 'Href value',
                    'rel'    => 'Rel value',
                    'render' => 'link'
                ]
            ]
        ]);
    }

    /**
     * @param \JsonCollection\Link $link1
     * @param \JsonCollection\Link $link2
     */
    function it_should_add_a_link_set($link1, $link2)
    {
        $link1->toArray()->willReturn([
            'href'   => 'Href value1',
            'rel'    => 'Rel value1',
            'render' => 'link1'
        ]);
        $link2->toArray()->willReturn([
            'href'   => 'Href value2',
            'rel'    => 'Rel value2',
            'render' => 'link2'
        ]);

        $this->addLinkSet(
            [
                $link1, $link2, new \stdClass()
            ]
        );
        $this->setHref('uri');
        $this->toArray()->shouldBeEqualTo([
            'href' => 'uri',
            'links' => [
                [
                    'href'   => 'Href value1',
                    'rel'    => 'Rel value1',
                    'render' => 'link1'
                ],
                [
                    'href'   => 'Href value2',
                    'rel'    => 'Rel value2',
                    'render' => 'link2'
                ]
            ]
        ]);
    }
}
