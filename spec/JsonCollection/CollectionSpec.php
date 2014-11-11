<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Collection');
    }

    function it_should_not_extract_null_and_empty_array_fields()
    {
        $this->toArray()->shouldBeEqualTo(
            [
                'collection' => [
                    'version' => '1.0'
                ]
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
            'collection' => [
                'version' => '1.0',
                'href' => 'uri',
                'links' => [
                    [
                        'href'   => 'Href value',
                        'rel'    => 'Rel value',
                        'render' => 'link'
                    ]
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
            'collection' => [
                'version' => '1.0',
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
            ]
        ]);
    }
}
