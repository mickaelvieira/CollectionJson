<?php

namespace spec\CollectionJson;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Entity\Item;
use CollectionJson\Entity\Query;
use CollectionJson\Bag;

class BagSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Item::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Bag::class);
        $this->shouldImplement(\Countable::class);
        $this->shouldImplement(\IteratorAggregate::class);
    }

    function it_should_empty_by_default()
    {
        $this->shouldBeEmpty();
        $this->shouldHaveCount(0);
        $this->count()->shouldReturn(0);
    }

    function it_should_add_an_item_to_the_bag_link_set()
    {
        $bag = $this->with(new Item());
        $this->shouldHaveCount(0);
        $bag->shouldHaveCount(1);
    }

    function it_should_remove_an_item_from_the_bag_link_set()
    {
        $item = new Item();
        $bag = $this->with($item);
        $this->shouldHaveCount(0);
        $bag->shouldHaveCount(1);

        $bag->first()->shouldBeLike($item);

        $bag = $bag->without($item);
        $bag->shouldHaveCount(0);
        $bag->first()->shouldBeNull();
    }

    function it_should_not_blow_up_when_removing_an_unexisting_item_from_the_bag_link_set()
    {
        $item1 = new Item();
        $item2 = new Item();
        $bag = $this->with($item1);
        $this->shouldHaveCount(0);
        $bag->shouldHaveCount(1);

        $bag->first()->shouldBeLike($item1);

        $bag = $bag->without($item2);
        $bag->shouldHaveCount(1);
        $bag->first()->shouldBeLike($item1);
    }

    function it_is_clonable()
    {
        $item1 = new Item();
        $item2 = new Item();

        $copy = $this->with($item1)->with($item2);

        $copy->shouldHaveCount(2);

        $copy2 = clone $copy;

        $copy2->first()->shouldBeLike($item1);
        $copy2->last()->shouldBeLike($item2);
    }

    function it_should_throw_an_exception_when_item_is_of_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [item] must be of type [CollectionJson\Entity\Item]')
        )->during('with', [new Query()]);
    }

    function it_should_build_an_item_from_an_array()
    {
        $bag = $this->with([
            'href' => 'http://example.com'
        ]);
        $this->shouldHaveCount(0);
        $bag->shouldHaveCount(1);
    }

    function it_should_add_multiple_items_to_the_bag()
    {
        $bag = $this->withSet([new Item(), ['href' => 'http://example.com']]);
        $this->shouldHaveCount(0);
        $bag->shouldHaveCount(2);
    }

    function it_should_return_the_set()
    {
        $item1 = new Item();
        $item2 = new Item();

        $bag = $this->with($item1);
        $bag = $bag->with($item2);
        $bag->getSet()->shouldBeLike([$item1, $item2]);
    }

    function it_should_return_the_first_element_in_the_set()
    {
        $item1 = new Item();
        $item2 = new Item();
        $item3 = new Item();

        $bag = $this->withSet([$item1, $item2, $item3]);

        $this->first()->shouldBeNull();
        $bag->first()->shouldBeLike($item1);
    }

    function it_should_return_null_when_the_first_element_in_not_the_set()
    {
        $this->first()->shouldBeNull();
    }

    function it_should_return_the_last_element_in_the_set()
    {
        $item1 = new Item();
        $item2 = new Item();
        $item3 = new Item();

        $bag = $this->withSet([$item1, $item2, $item3]);

        $this->last()->shouldBeNull();
        $bag->last()->shouldReturn($item3);
    }

    function it_should_return_null_when_the_last_element_in_not_the_set()
    {
        $this->last()->shouldBeNull();
    }
}
