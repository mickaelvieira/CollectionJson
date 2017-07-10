<?php

namespace spec\CollectionJson\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Entity\Link;
use CollectionJson\ArrayConvertible;
use Psr\Link\LinkInterface;

class LinkSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Link::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
        $this->shouldImplement(LinkInterface::class);
    }

    function it_s_not_templated()
    {
        $this->shouldNotBeTemplated();
    }

    function it_should_return_the_object_type()
    {
        $this::getObjectType()->shouldBeEqualTo('link');
    }

    function it_should_be_chainable()
    {
        $this->withHref('http://example.com')->shouldHaveType(Link::class);
        $this->withRel('value')->shouldHaveType(Link::class);
        $this->withName('value')->shouldHaveType(Link::class);
        $this->withPrompt('value')->shouldHaveType(Link::class);
        $this->withRender('image')->shouldHaveType(Link::class);
    }

    function it_may_be_construct_with_an_array_representation_of_the_link()
    {
        $link = $this::fromArray([
            'href'   => 'http://example.com',
            'rel'    => 'Link Rel',
            'name'   => 'Link Name',
            'render' => 'image',
            'prompt' => 'Link Prompt'
        ]);
        $link->getHref()->shouldBeEqualTo('http://example.com');
        $link->getRels()->shouldBeEqualTo(['Link Rel']);
        $link->getName()->shouldBeEqualTo('Link Name');
        $link->getRender()->shouldBeEqualTo('image');
        $link->getPrompt()->shouldBeEqualTo('Link Prompt');
    }

    function it_should_convert_the_rel_value_to_a_string()
    {
        $link = $this->withRel(true);
        $link->getRels()->shouldBeEqualTo(['1']);
    }

    function it_should_return_a_new_link_with_the_added_relation_type()
    {
        $link = $this->withRel('stylesheet');
        $this->getRels()->shouldBeEqualTo([]);
        $link->getRels()->shouldBeEqualTo(['stylesheet']);
    }

    function it_knows_when_it_has_a_relation_type()
    {
        $link = $this->withRel('stylesheet');
        $link->shouldHaveRel('stylesheet');
        $link->shouldNotHaveRel('canonical');
    }

    function it_should_return_a_new_link_without_the_removed_relation_type()
    {
        $this->beConstructedThrough('fromArray', [[
            'rel' => 'stylesheet'
        ]]);
        $link = $this->withoutRel('stylesheet');
        $this->getRels()->shouldBeEqualTo(['stylesheet']);
        $link->getRels()->shouldBeEqualTo([]);
    }

    function it_should_return_a_list_of_relations()
    {
        $link = $this->withRel('stylesheet');
        $link->getRels()->shouldBeEqualTo(['stylesheet']);
    }

    function it_should_convert_the_name_value_to_a_string()
    {
        $link = $this->withName(true);
        $link->getName()->shouldBeEqualTo('1');
    }

    function it_should_return_the_default_render_value()
    {
        $this->getRender()->shouldBeEqualTo('link');
    }

    function it_should_throw_an_exception_when_setting_an_incorrect_render_type()
    {
        $this->shouldThrow(new \DomainException(
            "Property [render] of entity [link] can only have one of the following values [link,image]"
        ))->during('withRender', ["Render this"]);
        $this->getRender()->shouldBeEqualTo('link');
    }

    function it_should_convert_the_prompt_value_to_a_string()
    {
        $link = $this->withPrompt(true);
        $link->getPrompt()->shouldBeEqualTo('1');
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_href_is_null()
    {
        $link = $this->withRel('Rel value');
        $link->shouldThrow(new \DomainException('Property [href] of entity [link] is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_href_is_null()
    {
        $link = $this->withRel('Rel value');
        $link->shouldThrow(
            new \DomainException('Property [href] of entity [link] is required')
        )->during('jsonSerialize');
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_rel_is_null()
    {
        $link = $this->withHref('http://example.com');
        $link->shouldThrow(new \DomainException('Property [rel] of entity [link] is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_rel_is_null()
    {
        $link = $this->withHref('http://example.com');
        $link->shouldThrow(
            new \DomainException('Property [rel] of entity [link] is required')
        )->during('jsonSerialize');
    }

    function it_should_not_return_null_values()
    {
        $link = $this->withRel('Rel value');
        $link = $link->withHref('http://example.com');
        $link->toArray()->shouldBeEqualTo([
            'href'   => 'http://example.com',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]);
    }
}
