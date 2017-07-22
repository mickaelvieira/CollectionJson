<?php

namespace spec\CollectionJson\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Exception\MissingProperty;

class MissingPropertySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MissingProperty::class);
    }

    function it_should_build_a_domain_exception()
    {
        $this::fromTemplate('entity', 'property')->shouldHaveType(\DomainException::class);
    }

    function it_should_format_the_exception_message()
    {
        $exception = $this::fromTemplate('my entity', 'its property');
        $exception->getMessage()->shouldReturn('Property [its property] of entity [my entity] is required');
    }
}
