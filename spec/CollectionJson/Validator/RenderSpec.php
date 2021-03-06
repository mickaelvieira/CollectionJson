<?php

namespace spec\CollectionJson\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Validator\Render;

class RenderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Render::class);
    }

    function it_should_validate_the_word_image()
    {
        $this->isValid('image')->shouldReturn(true);
    }

    function it_should_validate_the_word_link()
    {
        $this->isValid('link')->shouldReturn(true);
    }

    function it_should_not_validate_other_words()
    {
        $this->isValid('custom')->shouldReturn(false);
    }

    function it_should_return_the_allowed_value_types()
    {
        $this::allowed()->shouldReturn(['link', 'image']);
    }
}
