<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseEntitySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\BaseEntity');
    }

    function it_should_not_inject_any_data()
    {
        $this->inject(['prop' => 'test']);
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_not_return_any_data()
    {
        $this->toArray()->shouldBeEqualTo([]);
    }
}
