<?php

namespace spec\CollectionJson\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LinkSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Entity\Link');
        $this->shouldImplement('CollectionJson\ArrayInjectable');
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
        $this->setRender('value')->shouldHaveType('CollectionJson\Entity\Link');
    }

    function it_should_inject_data()
    {
        $data = [
            'href'   => 'http://example.com',
            'rel'    => 'Link Rel',
            'name'   => 'Link Name',
            'render' => 'image',
            'prompt' => 'Link Prompt'
        ];
        $this->beConstructedWith($data);
        $this->getHref()->shouldBeEqualTo('http://example.com');
        $this->getRel()->shouldBeEqualTo('Link Rel');
        $this->getName()->shouldBeEqualTo('Link Name');
        $this->getRender()->shouldBeEqualTo('image');
        $this->getPrompt()->shouldBeEqualTo('Link Prompt');
    }

    function it_should_throw_an_exception_when_setting_the_href_field_with_an_invalid_url()
    {
        $this->shouldThrow('\Exception')->duringSetHref('uri');
    }

    function it_should_not_set_the_rel_field_if_it_is_not_a_string()
    {
        $this->setRel(true);
        $this->getRel()->shouldBeNull();
    }

    function it_should_not_set_the_name_field_if_it_is_not_a_string()
    {
        $this->setName(true);
        $this->getName()->shouldBeNull();
    }

    function it_should_return_the_default_render_value()
    {
        $this->getRender()->shouldBeEqualTo('link');
    }

    function it_should_not_set_the_render_field_if_it_is_a_valid_render_type()
    {
        $this->setRender("Render this");
        $this->getRender()->shouldBeEqualTo('link');
    }

    function it_should_not_set_the_prompt_field_if_it_is_not_a_string()
    {
        $this->setPrompt(true);
        $this->getPrompt()->shouldBeNull();
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_href_is_null()
    {
        $this->setRel('Rel value');
        $this->shouldThrow('\Exception')->duringToArray();
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_href_is_null()
    {
        $this->setRel('Rel value');
        $this->shouldThrow('\Exception')->duringJsonSerialize();
    }

    function it_should_throw_an_exception_during_array_conversion_when_the_field_rel_is_null()
    {
        $this->setHref('http://example.com');
        $this->shouldThrow('\Exception')->duringToArray();
    }

    function it_should_throw_an_exception_during_json_conversion_when_the_field_rel_is_null()
    {
        $this->setHref('http://example.com');
        $this->shouldThrow('\Exception')->duringJsonSerialize();
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
