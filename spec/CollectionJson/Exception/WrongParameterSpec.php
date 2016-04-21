<?php

namespace spec\CollectionJson\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WrongParameterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Exception\WrongParameter');
    }

    function it_should_build_a_domain_exception()
    {
        $this::format('entity', 'property', [])->shouldHaveType('\DomainException');
    }

    function it_should_format_the_exception_message()
    {
        $exception = $this::format('my entity', 'its property', ['type 1', 'type 2']);
        $exception->getMessage()->shouldReturn(
            'Property [its property] of entity [my entity] can only have one of the following values [type 1,type 2]'
        );
    }
}
