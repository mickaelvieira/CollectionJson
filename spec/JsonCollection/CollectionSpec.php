<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Collection');
        $this->shouldImplement('JsonCollection\DataInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    /**
     * @param \JsonCollection\Item $item
     * @param \JsonCollection\Query $query
     * @param \JsonCollection\Error $error
     * @param \JsonCollection\Status $status
     * @param \JsonCollection\Template $template
     */
    function it_should_be_chainable($item, $query, $error, $status, $template)
    {
        $this->setHref('href')->shouldHaveType('JsonCollection\Collection');
        $this->addItem($item)->shouldHaveType('JsonCollection\Collection');
        $this->addItems([$item])->shouldHaveType('JsonCollection\Collection');
        $this->addQuery($query)->shouldHaveType('JsonCollection\Collection');
        $this->setError($error)->shouldHaveType('JsonCollection\Collection');
        $this->setStatus($status)->shouldHaveType('JsonCollection\Collection');
        $this->setTemplate($template)->shouldHaveType('JsonCollection\Collection');
        $this->addLink([])->shouldHaveType('JsonCollection\Collection');
        $this->addLinkSet([])->shouldHaveType('JsonCollection\Collection');
    }

    function it_should_not_extract_null_and_empty_array_fields()
    {
        $this->toArray()->shouldBeEqualTo([
            'collection' => [
                'version' => '1.0'
            ]
        ]);
    }

    /**
     * @param \JsonCollection\Item $item
     */
    function it_should_add_a_item($item)
    {
        $this->addItem($item);
        $this->getItems()->shouldHaveCount(1);
    }

    /**
     * @param \JsonCollection\Item $item1
     * @param \JsonCollection\Item $item2
     */
    function it_should_add_multiple_items($item1, $item2)
    {
        $this->addItems([$item1, $item2]);
        $this->getItems()->shouldHaveCount(2);
    }
    
    /**
     * @param \JsonCollection\Link $link
     */
    function it_should_add_a_link($link)
    {
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
        $this->countLinks()->shouldBeEqualTo(2);
    }
}
