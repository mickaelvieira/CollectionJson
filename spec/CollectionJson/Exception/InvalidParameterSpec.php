<?php

namespace spec\CollectionJson\Exception;

use CollectionJson\Exception\CollectionJsonException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Exception\InvalidParameter;

class InvalidParameterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidParameter::class);
        $this->shouldHaveType(CollectionJsonException::class);
    }

    function it_should_build_a_domain_exception()
    {
        $this::fromTemplate('entity', 'property', [])->shouldHaveType(\DomainException::class);
    }

    function it_should_format_the_exception_message()
    {
        $exception = $this::fromTemplate('my entity', 'its property', ['type 1', 'type 2']);
        $exception->getMessage()->shouldReturn(
            'Property [its property] of entity [my entity] can only have one of the following values [type 1,type 2]'
        );
    }
}
