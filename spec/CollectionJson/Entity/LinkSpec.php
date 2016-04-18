<?php

namespace spec\CollectionJson\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LinkSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Entity\Link');
        $this->shouldImplement('CollectionJson\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_return_the_object_type()
    {
        $this->getObjectType()->shouldBeEqualTo('link');
    }

    function it_should_be_chainable()
    {
        $this->setHref('http://example.com')->shouldHaveType('CollectionJson\Entity\Link');
        $this->setRel('value')->shouldHaveType('CollectionJson\Entity\Link');
        $this->setName('value')->shouldHaveType('CollectionJson\Entity\Link');
        $this->setPrompt('value')->shouldHaveType('CollectionJson\Entity\Link');
        $this->setRender('image')->shouldHaveType('CollectionJson\Entity\Link');
    }

    function it_may_be_construct_with_an_array_representation_of_the_link()
    {
        $data = [
            'href'   => 'http://example.com',
            'rel'    => 'Link Rel',
            'name'   => 'Link Name',
            'render' => 'image',
            'prompt' => 'Link Prompt'
        ];
        $link = $this::fromArray($data);
        $link->getHref()->shouldBeEqualTo('http://example.com');
        $link->getRel()->shouldBeEqualTo('Link Rel');
        $link->getName()->shouldBeEqualTo('Link Name');
        $link->getRender()->shouldBeEqualTo('image');
        $link->getPrompt()->shouldBeEqualTo('Link Prompt');
    }

    function it_should_throw_an_exception_when_setting_the_href_field_with_an_invalid_url()
    {
        $this->shouldThrow('\Exception')->duringSetHref('uri');
    }

    function it_should_throw_an_exception_when_it_cannot_convert_the_property_rel_to_a_string()
    {
        $this->shouldThrow(
            new \DomainException("Property rel of object type link cannot be converted to a string")
        )->during('setRel', [new \stdClass()]);
    }

    function it_should_convert_the_rel_value_to_a_string()
    {
        $this->setRel(true);
        $this->getRel()->shouldBeEqualTo('1');
    }

    function it_should_throw_an_exception_when_it_cannot_convert_the_property_name_to_a_string()
    {
        $this->shouldThrow(
            new \DomainException("Property name of object type link cannot be converted to a string")
        )->during('setName', [new \stdClass()]);
    }

    function it_should_convert_the_name_value_to_a_string()
    {
        $this->setName(true);
        $this->getName()->shouldBeEqualTo('1');
    }

    function it_should_return_the_default_render_value()
    {
        $this->getRender()->shouldBeEqualTo('link');
    }

    function it_should_throw_an_exception_when_setting_an_incorrect_render_type()
    {
        $this->shouldThrow(new \DomainException(
            "Property render of object type link may only be equal to link or image"
        ))->during('setRender', ["Render this"]);
        $this->getRender()->shouldBeEqualTo('link');
    }

    function it_should_throw_an_exception_when_it_cannot_convert_the_property_prompt_to_a_string()
    {
        $this->shouldThrow(
            new \DomainException("Property prompt of object type link cannot be converted to a string")
        )->during('setPrompt', [new \stdClass()]);
    }

    function it_should_convert_the_prompt_value_to_a_string()
    {
        $this->setPrompt(true);
        $this->getPrompt()->shouldBeEqualTo('1');
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_href_is_null()
    {
        $this->setRel('Rel value');
        $this->shouldThrow(new \LogicException('Property href of object type link is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_href_is_null()
    {
        $this->setRel('Rel value');
        $this->shouldThrow(
            new \LogicException('Property href of object type link is required')
        )->during('jsonSerialize');
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_rel_is_null()
    {
        $this->setHref('http://example.com');
        $this->shouldThrow(new \LogicException('Property rel of object type link is required'))->during('toArray');
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_rel_is_null()
    {
        $this->setHref('http://example.com');
        $this->shouldThrow(
            new \LogicException('Property rel of object type link is required')
        )->during('jsonSerialize');
    }

    function it_should_not_return_null_values()
    {
        $this->setRel('Rel value');
        $this->setHref('http://example.com');
        $this->toArray()->shouldBeEqualTo([
            'href'   => 'http://example.com',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]);
    }
}
