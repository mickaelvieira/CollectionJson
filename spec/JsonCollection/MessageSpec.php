<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Message');
    }

    function it_should_inject_data()
    {
        $data = [
            'name'    => 'Message Name',
            'code'    => 'Message Code',
            'message' => 'Message Message'
        ];
        $this->inject($data);
        $this->getName()->shouldBeEqualTo('Message Name');
        $this->getCode()->shouldBeEqualTo('Message Code');
        $this->getMessage()->shouldBeEqualTo('Message Message');
    }

    function it_should_not_set_the_title_field_if_it_is_not_a_string()
    {
        $this->setName(true);
        $this->getName()->shouldBeNull();
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

    function it_should_extract_an_empty_array_when_the_message_field_is_null()
    {
        $this->setCode('Message Code');
        $this->toArray()->shouldBeEqualTo([]);
    }

    function it_should_not_extract_null_fields()
    {
        $this->setMessage('My Message');
        $this->toArray()->shouldBeEqualTo(['message' => 'My Message']);
    }
}
