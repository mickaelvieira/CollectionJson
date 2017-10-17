<?php

namespace spec\CollectionJson\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Exception\InvalidType;
use CollectionJson\Exception\CollectionJsonException;

class InvalidTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidType::class);
        $this->shouldHaveType(CollectionJsonException::class);
    }

    function it_should_build_a_domain_exception()
    {
        $this::fromTemplate('property', 'type')->shouldHaveType(\DomainException::class);
    }

    function it_should_format_the_exception_message()
    {
        $exception = $this::fromTemplate('this property', 'this type');
        $exception->getMessage()->shouldReturn(
            'Property [this property] must be of type [this type]'
        );
    }
}
