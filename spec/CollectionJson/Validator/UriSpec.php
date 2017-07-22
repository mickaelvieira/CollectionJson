<?php

namespace spec\CollectionJson\Validator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Validator\Uri;

/**
 * Class UriSpec
 * @package spec\CollectionJson\Validator
 */
class UriSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Uri::class);
    }

    function it_should_validate_a_correct_uri()
    {
        $this->isValid('http://example.co.uk')->shouldReturn(true);
    }

    function it_should_not_validate_an_incorrect_uri()
    {
        $this->isValid('/test')->shouldReturn(false);
    }

    function it_should_return_the_allowed_value_types()
    {
        $this::allowed()->shouldReturn(['URI']);
    }
}
