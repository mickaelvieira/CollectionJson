<?php

namespace spec\CollectionJson\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RenderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Validator\Render');
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
}
