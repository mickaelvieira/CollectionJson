<?php

namespace spec\CollectionJson\Entity;

use CollectionJson\Type\Render;
use PhpSpec\ObjectBehavior;
use CollectionJson\Entity\Link;
use CollectionJson\ArrayConvertible;
use Psr\Link\LinkInterface;

class LinkSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->shouldHaveType(Link::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
        $this->shouldImplement(LinkInterface::class);
    }

    function it_s_not_templated()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->shouldNotBeTemplated();
    }

    function it_should_return_the_object_type()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this::getObjectType()->shouldBeEqualTo('link');
    }

    function it_can_be_initialized_with_data()
    {
        $this->beConstructedWith('http://example.com', 'self', 'my link');
        $this->getHref()->shouldReturn('http://example.com');
        $this->getRels()->shouldReturn(['self']);
        $this->getName()->shouldReturn('my link');
    }

    function it_is_clonable()
    {
        $this->beConstructedThrough('fromArray', [[
            'name'   => 'my link',
            'href'   => 'http://example.com',
            'rel'    => 'Rel value',
            'render' => 'link',
            'prompt' => 'Hello'
        ]]);

        $copy = clone $this;

        $copy->shouldHaveType(Link::class);
        $copy->getName()->shouldReturn($this->getName());
        $copy->getHref()->shouldReturn($this->getHref());
        $copy->getRels()->shouldReturn($this->getRels());
        $copy->getRender()->shouldReturn($this->getRender());
        $copy->getPrompt()->shouldReturn($this->getPrompt());
    }

    function it_should_be_chainable()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->withHref('http://example.com')->shouldHaveType(Link::class);
        $this->withRel('value')->shouldHaveType(Link::class);
        $this->withName('value')->shouldHaveType(Link::class);
        $this->withPrompt('value')->shouldHaveType(Link::class);
        $this->withRender('image')->shouldHaveType(Link::class);
    }

    function it_may_be_construct_with_an_array_representation_of_the_link()
    {
        $this->beConstructedThrough('fromArray', [[
            'href'   => 'http://example.com',
            'rel'    => 'Link Rel',
            'name'   => 'Link Name',
            'render' => 'image',
            'prompt' => 'Link Prompt'
        ]]);

        $this->getHref()->shouldBeEqualTo('http://example.com');
        $this->getRels()->shouldBeEqualTo(['Link Rel']);
        $this->getName()->shouldBeEqualTo('Link Name');
        $this->getRender()->shouldBeEqualTo('image');
        $this->getPrompt()->shouldBeEqualTo('Link Prompt');
    }

    function it_should_convert_the_rel_value_to_a_string()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $link = $this->withRel(true);
        $this->getRels()->shouldBeEqualTo(['item']);
        $link->getRels()->shouldBeEqualTo(['item', '1']);
    }

    function it_should_return_a_new_link_with_the_added_relation_type()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $link = $this->withRel('stylesheet');
        $this->getRels()->shouldBeEqualTo(['item']);
        $link->getRels()->shouldBeEqualTo(['item', 'stylesheet']);
    }

    function it_knows_when_it_has_a_relation_type()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $link = $this->withRel('stylesheet');
        $link->shouldHaveRel('stylesheet');
        $link->shouldNotHaveRel('canonical');
    }

    function it_should_return_a_new_link_without_the_removed_relation_type()
    {
        $this->beConstructedThrough('fromArray', [[
            'href' => 'http://example.com',
            'rel' => 'stylesheet'
        ]]);

        $link = $this->withoutRel('stylesheet');
        $this->getRels()->shouldBeEqualTo(['stylesheet']);
        $link->getRels()->shouldBeEqualTo([]);
    }

    function it_should_return_a_list_of_relations()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $link = $this->withRel('stylesheet');
        $link->getRels()->shouldBeEqualTo(['item', 'stylesheet']);
    }

    function it_should_set_render_type()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $link = $this->withRender(Render::IMAGE);
        $this->getRender()->shouldBeEqualTo(Render::LINK);
        $link->getRender()->shouldBeEqualTo(Render::IMAGE);
    }

    function it_should_return_the_default_render_value()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->getRender()->shouldBeEqualTo('link');
    }

    function it_should_throw_an_exception_when_setting_an_incorrect_render_type()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $this->shouldThrow(new \DomainException(
            "Property [render] of entity [link] can only have one of the following values [link,image]"
        ))->during('withRender', ["Render this"]);
        $this->getRender()->shouldBeEqualTo('link');
    }

    function it_should_convert_the_prompt_value_to_a_string()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $link = $this->withPrompt(true);
        $link->getPrompt()->shouldBeEqualTo('1');
    }

    function it_should_not_return_null_values()
    {
        $this->beConstructedWith('http://example.com', 'item');
        $link = $this->withRel('Rel value');
        $link = $link->withHref('http://example.com');
        $link->toArray()->shouldBeEqualTo([
            'href'   => 'http://example.com',
            'rel'    => 'item,Rel value',
            'render' => 'link'
        ]);
    }
}
