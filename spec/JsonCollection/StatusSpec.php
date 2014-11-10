<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Status');
    }

    function it_should_inject_data()
    {
        $data = [
            'code'    => 'Error Code',
            'message' => 'Error Message'
        ];
        $this->inject($data);
        $this->getCode()->shouldBeEqualTo('Error Code');
        $this->getMessage()->shouldBeEqualTo('Error Message');
    }

    function it_should_not_set_the_code_field_if_it_is_not_a_string()
    {
        $this->setCode(true);
        $this->getCode()->shouldBeNull();
    }

    function it_should_not_set_the_message_field_if_it_is_not_a_string()
    {
        $this->setMessage(true);
        $this->getMessage()->shouldBeNull();
    }

    function it_should_not_extract_null_fields()
    {
        $this->setMessage('My Message');
        $this->toArray()->shouldBeEqualTo(['message' => 'My Message']);
    }
}
