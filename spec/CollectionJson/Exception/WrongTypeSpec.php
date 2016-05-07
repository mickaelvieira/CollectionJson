<?php

namespace spec\CollectionJson\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WrongTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Exception\WrongType');
    }

    function it_should_build_a_domain_exception()
    {
        $this::fromTemplate('property', 'type')->shouldHaveType('\BadMethodCallException');
    }

    function it_should_format_the_exception_message()
    {
        $exception = $this::fromTemplate('this property', 'this type');
        $exception->getMessage()->shouldReturn(
            'Property [this property] must be of type [this type]'
        );
    }
}
