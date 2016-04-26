<?php

namespace spec\CollectionJson;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Entity\Item;
use CollectionJson\Entity\Query;

class BagSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('CollectionJson\Entity\Item');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Bag');
        $this->shouldImplement('\Countable');
        $this->shouldImplement('\IteratorAggregate');
    }

    function it_should_empty_by_default()
    {
        $this->shouldBeEmpty();
        $this->shouldHaveCount(0);
    }

    function it_should_add_aan_item_to_the_bag_link_set()
    {
        $this->add(new Item());
        $this->shouldHaveCount(1);
    }

    function it_should_throw_an_exception_when_item_is_of_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [item] must be of type [CollectionJson\Entity\Item]')
        )->during('add', [new Query()]);
    }

    function it_should_build_an_item_from_an_array()
    {
        $this->add([
            'href' => 'http://example.com'
        ]);
        $this->shouldHaveCount(1);
    }

    function it_should_add_multiple_items_to_the_bag()
    {
        $this->addSet([new Item(), ['href' => 'http://example.com']]);
        $this->shouldHaveCount(2);
    }

    function it_should_return_the_set()
    {
        $item1 = new Item();
        $item2 = new Item();

        $this->add($item1);
        $this->add($item2);
        $this->getSet()->shouldReturn([$item1, $item2]);
    }

    function it_should_return_the_first_element_in_the_set()
    {
        $item1 = new Item();
        $item2 = new Item();
        $item3 = new Item();

        $this->addSet([$item1, $item2, $item3]);

        $this->getFirst()->shouldReturn($item1);
    }

    function it_should_return_null_when_the_first_element_in_not_the_set()
    {
        $this->getFirst()->shouldBeNull();
    }

    function it_should_return_the_last_element_in_the_set()
    {
        $item1 = new Item();
        $item2 = new Item();
        $item3 = new Item();

        $this->addSet([$item1, $item2, $item3]);

        $this->getLast()->shouldReturn($item3);
    }

    function it_should_return_null_when_the_last_element_in_not_the_set()
    {
        $this->getLast()->shouldBeNull();
    }
}
