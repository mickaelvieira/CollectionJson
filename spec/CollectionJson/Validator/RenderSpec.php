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

    function it_should_validate_a_render_type_image()
    {
        $this->isValid('image')->shouldReturn(true);
    }

    function it_should_validate_a_render_type_link()
    {
        $this->isValid('link')->shouldReturn(true);
    }

    function it_should_not_validate_other_render_types()
    {
        $this->isValid('custom')->shouldReturn(false);
    }
}
