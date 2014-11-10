<?php

namespace spec\JsonCollection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ItemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('JsonCollection\Item');
    }

    function it_should_inject_data()
    {
        $data = array(
            'href'   => 'Link Href'
        );
        $this->inject($data);
        $this->getHref()->shouldBeEqualTo('Link Href');
    }

    function it_should_not_set_the_href_field_if_it_is_not_a_string()
    {
        $this->setHref(true);
        $this->getHref()->shouldBeNull();
    }

    /**
     * @param \JsonCollection\Data $data
     */
    function it_should_return_an_empty_array_when_the_href_field_is_not_defined($data)
    {
        $data->toArray()->willReturn(
            array(
                'name' => 'Name',
                'value' => null
            )
        );

        $this->addData($data);
        $this->toArray()->shouldBeEqualTo(array());
    }

    /**
     * @param \JsonCollection\Data $data
     */
    function it_should_not_extract_empty_array_fields($data)
    {
        $data->toArray()->willReturn(
            array(
                'name' => 'Name',
                'value' => null
            )
        );

        $this->setHref('uri');
        $this->addData($data);
        $this->toArray()->shouldBeEqualTo(
            array(
                'data' => array(
                    array(
                        'name' => 'Name',
                        'value' => null
                    )
                ),
                'href' => 'uri',
            )
        );
    }
}
