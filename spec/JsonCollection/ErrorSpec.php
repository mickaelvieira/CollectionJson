<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ErrorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Error');
        $this->shouldImplement('JsonCollection\DataInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    /**
     * @param \JsonCollection\Message $message
     */
    function it_should_be_chainable($message)
    {
        $this->setCode('value')->shouldHaveType('JsonCollection\Error');
        $this->setMessage('value')->shouldHaveType('JsonCollection\Error');
        $this->setTitle('value')->shouldHaveType('JsonCollection\Error');
        $this->addMessage($message)->shouldHaveType('JsonCollection\Error');
    }

    function it_should_inject_data()
    {
        $data = [
            'title'   => 'Error Title',
            'code'    => 'Error Code',
            'message' => 'Error Message'
        ];
        $this->inject($data);
        $this->getTitle()->shouldBeEqualTo('Error Title');
        $this->getCode()->shouldBeEqualTo('Error Code');
        $this->getMessage()->shouldBeEqualTo('Error Message');
    }

    function it_should_not_set_the_title_field_if_it_is_not_a_string()
    {
        $this->setTitle(true);
        $this->getTitle()->shouldBeNull();
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

    function it_should_not_extract_empty_array_and_null_fields()
    {
        $this->setMessage('My Message');
        $this->toArray()->shouldBeEqualTo(['message' => 'My Message']);
    }

    /**
     * @param \JsonCollection\Message $message
     */
    function it_should_return_an_array_with_the_messages_list($message)
    {
        $message->toArray()->willReturn([
            'message' => 'Error Message'
        ]);

        $this->setTitle('Error Title');
        $this->setCode('Error Code');
        $this->addMessage($message);
        $this->toArray()->shouldBeEqualTo([
            'code' => 'Error Code',
            'messages' => [
                [
                    'message' => 'Error Message'
                ]
            ],
            'title' => 'Error Title'
        ]);
    }
}
