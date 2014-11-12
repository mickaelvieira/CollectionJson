<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TemplateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Template');
        $this->shouldImplement('JsonCollection\DataAware');
        $this->shouldImplement('JsonCollection\DataInjectable');
        $this->shouldImplement('JsonCollection\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_not_extract_null_and_empty_array_fields()
    {
        $this->toArray()->shouldBeEqualTo([]);
    }

    /**
     * @param \JsonCollection\Method $method
     */
    function it_should_extract_the_method($method)
    {
        $method->toArray()->willReturn([
            'options' => [
                [
                    'value' => 'Value 1',
                    'prompt' => 'Prompt 1'
                ]
            ]
        ]);
        $this->setMethod($method);
        $this->toArray()->shouldBeEqualTo([
            'method' => [
                'options' => [
                    [
                        'value' => 'Value 1',
                        'prompt' => 'Prompt 1'
                    ]
                ]
            ]
        ]);
    }

    /**
     * @param \JsonCollection\Enctype $enctype
     */
    function it_should_extract_the_enctype($enctype)
    {
        $enctype->toArray()->willReturn([
            'options' => [
                [
                    'value' => 'Value 1',
                    'prompt' => 'Prompt 1'
                ]
            ]
        ]);
        $this->setEnctype($enctype);
        $this->toArray()->shouldBeEqualTo([
            'enctype' => [
                'options' => [
                    [
                        'value' => 'Value 1',
                        'prompt' => 'Prompt 1'
                    ]
                ]
            ]
        ]);
    }

    /**
     * @param \JsonCollection\Data $data1
     * @param \JsonCollection\Data $data2
     */
    function it_should_extract_the_data_list($data1, $data2)
    {
        $data1->toArray()->willReturn(['value' => 'value 1']);
        $data2->toArray()->willReturn(['value' => 'value 2']);

        $this->addData($data1);
        $this->addData($data2);
        $this->toArray()->shouldBeEqualTo([
            'data'   => [
                ['value' => 'value 1'],
                ['value' => 'value 2'],
            ]
        ]);
    }

    /**
     * @param \JsonCollection\Data $data1
     * @param \JsonCollection\Data $data2
     */
    function it_should_add_a_data_set($data1, $data2)
    {
        $data1->toArray()->willReturn(['value' => 'value 1']);
        $data2->toArray()->willReturn(['value' => 'value 2']);

        $this->addDataSet([
            $data1, $data2, new \stdClass()
        ]);
        $this->toArray()->shouldBeEqualTo([
            'data'   => [
                ['value' => 'value 1'],
                ['value' => 'value 2'],
            ]
        ]);
    }

    /**
     * @param \JsonCollection\Data $data1
     * @param \JsonCollection\Data $data2
     */
    function it_should_retrieve_the_data_by_name($data1, $data2)
    {
        $data1->getName()->willReturn('name1');
        $data2->getName()->willReturn('name2');

        $this->addDataSet([$data1, $data2]);

        $this->getDataByName('name1')->shouldBeEqualTo($data1);
        $this->getDataByName('name2')->shouldBeEqualTo($data2);
    }

    function it_should_return_null_when_data_is_not_the_set()
    {
        $this->getDataByName('name1')->shouldBeNull(null);
    }
}
