<?php

namespace spec\CollectionJson\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Entity\Collection');
        $this->shouldImplement('CollectionJson\ArrayInjectable');
        $this->shouldImplement('CollectionJson\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_inject_data()
    {
        $data = [
            'error'    => [
                'code' => "error code",
                'message' => "message code",
                'title' => "title code",
            ],
            'href' => 'http://example.com',
            'items' => [
                [
                    'data' => [
                        [
                            'name' => 'name 1',
                            'value' => 'value 1'
                        ]
                    ],
                    'href' => 'http://www.example1.com',
                ],
                [
                    'data' => [
                        [
                            'name' => 'name 2',
                            'value' => 'value 2'
                        ]
                    ],
                    'href' => 'http://www.example2.com'
                ]
            ],
            'links' => [
                [
                    'href'   => 'http://www.example1.com',
                    'rel'    => 'Rel value 1',
                    'render' => 'link'
                ],
                [
                    'href'   => 'http://www.example2.com',
                    'rel'    => 'Rel value 2',
                    'render' => 'link'
                ]
            ],
            'template' => [
                'data' => [
                    [
                        'name' => 'name 1',
                        'value' => 'value 1'
                    ]
                ]
            ]
        ];
        $this->beConstructedWith($data);
        $this->getHref()->shouldBeEqualTo('http://example.com');
        $this->getError()->shouldHaveType('CollectionJson\Entity\Error');
        $this->getTemplate()->shouldHaveType('CollectionJson\Entity\Template');
        $this->getItemsSet()->shouldHaveCount(2);
        $this->getLinksSet()->shouldHaveCount(2);
        $this->toArray()->shouldBeEqualTo([
            'collection' => array_merge(['version' => '1.0'], $data)
        ]);
    }

    function it_should_not_set_the_href_field_if_it_is_not_a_string()
    {
        $this->setHref(true);
        $this->getHref()->shouldBeNull();
    }

    function it_should_not_set_the_href_field_if_it_is_not_a_valid_url()
    {
        $this->setHref('uri');
        $this->getHref()->shouldBeNull();
    }

    /**
     * @param \CollectionJson\Entity\Item $item
     * @param \CollectionJson\Entity\Query $query
     * @param \CollectionJson\Entity\Error $error
     * @param \CollectionJson\Entity\Template $template
     */
    function it_should_be_chainable($item, $query, $error, $template)
    {
        $this->setHref('href')->shouldHaveType('CollectionJson\Entity\Collection');
        $this->addItem($item)->shouldHaveType('CollectionJson\Entity\Collection');
        $this->addItemsSet([$item])->shouldHaveType('CollectionJson\Entity\Collection');
        $this->addQuery($query)->shouldHaveType('CollectionJson\Entity\Collection');
        $this->addQueriesSet([$query])->shouldHaveType('CollectionJson\Entity\Collection');
        $this->setError($error)->shouldHaveType('CollectionJson\Entity\Collection');
        $this->setTemplate($template)->shouldHaveType('CollectionJson\Entity\Collection');
        $this->addLink([])->shouldHaveType('CollectionJson\Entity\Collection');
        $this->addLinksSet([])->shouldHaveType('CollectionJson\Entity\Collection');
    }

    function it_should_not_extract_null_and_empty_array_fields()
    {
        $this->toArray()->shouldBeEqualTo([
            'collection' => [
                'version' => '1.0'
            ]
        ]);
    }

    /**
     * @param \CollectionJson\Entity\Item $item
     */
    function it_should_add_a_item($item)
    {
        $this->addItem($item);
        $this->getItemsSet()->shouldHaveCount(1);
    }

    function it_should_add_a_item_when_passing_array()
    {
        $this->addItem([
            'href' => 'http://www.example.com'
        ]);
        $this->getItemsSet()->shouldHaveCount(1);
    }


    /**
     * @param \CollectionJson\Entity\Item $item1
     * @param \CollectionJson\Entity\Item $item2
     */
    function it_should_add_multiple_items($item1, $item2)
    {
        $this->addItemsSet([$item1, $item2]);
        $this->getItemsSet()->shouldHaveCount(2);
    }

    /**
     * @param \CollectionJson\Entity\Query $query
     */
    function it_should_add_a_query($query)
    {
        $this->addQuery($query);
        $this->getQueriesSet()->shouldHaveCount(1);
    }

    /**
     * @param \CollectionJson\Entity\Query $query1
     * @param \CollectionJson\Entity\Query $query2
     */
    function it_should_add_multiple_queries($query1, $query2)
    {
        $this->addQueriesSet([$query1, $query2]);
        $this->getQueriesSet()->shouldHaveCount(2);
    }

    /**
     * @param \CollectionJson\Entity\Link $link
     */
    function it_should_add_a_link($link)
    {
        $this->addLink($link);
        $this->getLinksSet()->shouldHaveCount(1);
    }

    function it_should_add_a_link_when_passing_an_array()
    {
        $this->addLink([
            'href'   => 'Href value',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]);
        $this->getLinksSet()->shouldHaveCount(1);
    }

    /**
     * @param \CollectionJson\Entity\Link $link1
     */
    function it_should_add_a_link_set($link1)
    {
        $this->addLinksSet([
            $link1,
            [
                'href'   => 'Href value2',
                'rel'    => 'Rel value2',
                'render' => 'link2'
            ],
            new \stdClass()
        ]);
        $this->getLinksSet()->shouldHaveCount(2);
    }

    /**
     * @param \CollectionJson\Entity\Error $error
     */
    function it_should_set_the_error($error)
    {
        $error->getCode()->willReturn("error code");
        $this->setError($error);
        $this->getError()->shouldBeAnInstanceOf('CollectionJson\Entity\Error');
        $this->getError()->getCode()->shouldBeEqualTo("error code");
    }

    function it_should_set_the_error_when_passing_an_array()
    {
        $this->setError([
            'message' => "message code",
            'title' => "title code",
            'code' => "error code",
        ]);
        $this->getError()->shouldBeAnInstanceOf('CollectionJson\Entity\Error');
        $this->getError()->getMessage()->shouldBeEqualTo("message code");
        $this->getError()->getTitle()->shouldBeEqualTo("title code");
        $this->getError()->getCode()->shouldBeEqualTo("error code");
    }

    /**
     * @param \CollectionJson\Entity\Template $template
     */
    function it_should_set_the_template($template)
    {
        $this->setTemplate($template);
        $this->getTemplate()->shouldBeAnInstanceOf('CollectionJson\Entity\Template');
    }

    function it_should_set_the_template_when_passing_an_array()
    {
        $this->setTemplate([
            'data' => [
                [
                    'name' => 'name 1',
                    'value' => 'value 1'
                ]
            ]
        ]);
        $this->getTemplate()->shouldBeAnInstanceOf('CollectionJson\Entity\Template');
        $this->getTemplate()->getDataSet()->shouldHaveCount(1);
    }
}
