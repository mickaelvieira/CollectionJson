<?php

namespace spec\JsonCollection\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Entity\Collection');
        $this->shouldImplement('JsonCollection\ArrayInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    /**
     * @param \JsonCollection\Entity\Item $item
     * @param \JsonCollection\Entity\Query $query
     * @param \JsonCollection\Entity\Error $error
     * @param \JsonCollection\Entity\Status $status
     * @param \JsonCollection\Entity\Template $template
     */
    function it_should_be_chainable($item, $query, $error, $status, $template)
    {
        $this->setHref('href')->shouldHaveType('JsonCollection\Entity\Collection');
        $this->addItem($item)->shouldHaveType('JsonCollection\Entity\Collection');
        $this->addItems([$item])->shouldHaveType('JsonCollection\Entity\Collection');
        $this->addQuery($query)->shouldHaveType('JsonCollection\Entity\Collection');
        $this->setError($error)->shouldHaveType('JsonCollection\Entity\Collection');
        $this->setStatus($status)->shouldHaveType('JsonCollection\Entity\Collection');
        $this->setTemplate($template)->shouldHaveType('JsonCollection\Entity\Collection');
        $this->addLink([])->shouldHaveType('JsonCollection\Entity\Collection');
        $this->addLinkSet([])->shouldHaveType('JsonCollection\Entity\Collection');
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
     * @param \JsonCollection\Entity\Item $item
     */
    function it_should_add_a_item($item)
    {
        $this->addItem($item);
        $this->getItems()->shouldHaveCount(1);
    }

    /**
     * @param \JsonCollection\Entity\Item $item1
     * @param \JsonCollection\Entity\Item $item2
     */
    function it_should_add_multiple_items($item1, $item2)
    {
        $this->addItems([$item1, $item2]);
        $this->getItems()->shouldHaveCount(2);
    }

    /**
     * @param \JsonCollection\Entity\Link $link
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
        $this->countLinks()->shouldBeEqualTo(2);
    }
}
