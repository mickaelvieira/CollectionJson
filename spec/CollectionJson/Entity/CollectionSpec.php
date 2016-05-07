<?php

namespace spec\CollectionJson\Entity;

use CollectionJson\Entity\Error;
use CollectionJson\Entity\Item;
use CollectionJson\Entity\Link;
use CollectionJson\Entity\Query;
use CollectionJson\Entity\Template;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CollectionJson\Entity\Collection');
        $this->shouldImplement('CollectionJson\ArrayConvertible');
        $this->shouldImplement('JsonSerializable');
    }

    function it_should_return_the_object_type()
    {
        $this::getObjectType()->shouldBeEqualTo('collection');
    }

    function it_may_be_construct_with_an_array_representation_of_the_collection()
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
        $collection = $this::fromArray($data);
        $collection->getHref()->shouldBeEqualTo('http://example.com');
        $collection->getError()->shouldHaveType('CollectionJson\Entity\Error');
        $collection->getTemplate()->shouldHaveType('CollectionJson\Entity\Template');
        $collection->getItemsSet()->shouldHaveCount(2);
        $collection->getLinksSet()->shouldHaveCount(2);
        $collection->toArray()->shouldBeEqualTo([
            'collection' => array_merge(['version' => '1.0'], $data)
        ]);
    }


    function it_may_be_construct_from_a_json_representation_of_the_collection()
    {
        $json = '
        {
            "collection": {
                "version": "1.0",
                "href": "http://example.org/friends/",
                "links": [
                    {
                        "rel": "feed",
                        "href": "http://example.org/friends/rss"
                    }
                ],
                "items": [
                    {
                        "href": "http://example.org/friends/jdoe",
                        "data": [
                            {
                                "name": "full-name",
                                "value": "J. Doe",
                                "prompt": "Full Name"
                            },
                            {
                                "name": "email",
                                "value": "jdoe@example.org",
                                "prompt": "Email"
                            }
                        ],
                        "links": [
                            {
                                "rel": "blog",
                                "href": "http://examples.org/blogs/jdoe",
                                "prompt": "Blog"
                            },
                            {
                                "rel": "avatar",
                                "href": "http://examples.org/images/jdoe",
                                "prompt": "Avatar",
                                "render": "image"
                            }
                        ]
                    },
                    {
                        "href": "http://example.org/friends/msmith",
                        "data": [
                            {
                                "name": "full-name",
                                "value": "M. Smith",
                                "prompt": "Full Name"
                            },
                            {
                                "name": "email",
                                "value": "msmith@example.org",
                                "prompt": "Email"
                            }
                        ],
                        "links": [
                            {
                                "rel": "blog",
                                "href": "http://examples.org/blogs/msmith",
                                "prompt": "Blog"
                            },
                            {
                                "rel": "avatar",
                                "href": "http://examples.org/images/msmith",
                                "prompt": "Avatar",
                                "render": "image"
                            }
                        ]
                    },
                    {
                        "href": "http://example.org/friends/rwilliams",
                        "data": [
                            {
                                "name": "full-name",
                                "value": "R. Williams",
                                "prompt": "Full Name"
                            },
                            {
                                "name": "email",
                                "value": "rwilliams@example.org",
                                "prompt": "Email"
                            }
                        ],
                        "links": [
                            {
                                "rel": "blog",
                                "href": "http://examples.org/blogs/rwilliams",
                                "prompt": "Blog"
                            },
                            {
                                "rel": "avatar",
                                "href": "http://examples.org/images/rwilliams",
                                "prompt": "Avatar",
                                "render": "image"
                            }
                        ]
                    }
                ],
                "queries": [
                    {
                        "rel": "search",
                        "href": "http://example.org/friends/search",
                        "prompt": "Search",
                        "data": [
                            {
                                "name": "search",
                                "value": ""
                            }
                        ]
                    }
                ],
                "template": {
                    "data": [
                        {
                            "name": "full-name",
                            "value": "",
                            "prompt": "Full Name"
                        },
                        {
                            "name": "email",
                            "value": "",
                            "prompt": "Email"
                        },
                        {
                            "name": "blog",
                            "value": "",
                            "prompt": "Blog"
                        },
                        {
                            "name": "avatar",
                            "value": "",
                            "prompt": "Avatar"
                        }
                    ]
                }
            }
        }';

        $collection = $this::fromJson($json);
        $collection->getHref()->shouldBeEqualTo('http://example.org/friends/');
        $collection->getTemplate()->shouldHaveType('CollectionJson\Entity\Template');
        $collection->getTemplate()->getDataSet()->shouldHaveCount(4);
        $collection->getItemsSet()->shouldHaveCount(3);
        $collection->getQueriesSet()->shouldHaveCount(1);
        $collection->getLinksSet()->shouldHaveCount(1);
    }

    function it_should_throw_an_exception_when_setting_the_href_field_with_an_invalid_url()
    {
        $this->shouldThrow(
            new \DomainException("Property [href] of entity [collection] can only have one of the following values [URI]")
        )->duringSetHref('uri');
    }

    function it_should_be_chainable()
    {
        $item = new Item();
        $query = new Query();
        $error = new Error();
        $template = new Template();

        $this->setHref('http://www.example.com')->shouldReturn($this);
        $this->addItem($item)->shouldReturn($this);
        $this->addItemsSet([$item])->shouldReturn($this);
        $this->addQuery($query)->shouldReturn($this);
        $this->addQueriesSet([$query])->shouldReturn($this);
        $this->setError($error)->shouldReturn($this);
        $this->setTemplate($template)->shouldReturn($this);
        $this->addLink([])->shouldReturn($this);
        $this->addLinksSet([])->shouldReturn($this);
    }

    function it_should_not_extract_null_and_empty_array_fields()
    {
        $this->toArray()->shouldBeEqualTo([
            'collection' => [
                'version' => '1.0'
            ]
        ]);
    }

    function it_should_add_a_item()
    {
        $item = new Item();

        $this->addItem($item);
        $this->getItemsSet()->shouldHaveCount(1);
    }

    function it_should_throw_an_exception_when_item_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [item] must be of type [CollectionJson\Entity\Item]')
        )->during('addItem', [new Template()]);
    }

    function it_should_add_a_item_when_passing_array()
    {
        $this->addItem([
            'href' => 'http://www.example.com'
        ]);
        $this->getItemsSet()->shouldHaveCount(1);
    }

    function it_should_add_multiple_items()
    {
        $item1 = new Item();
        $item2 = new Item();

        $this->addItemsSet([$item1, $item2]);
        $this->getItemsSet()->shouldHaveCount(2);
    }

    function it_should_return_the_first_item_in_the_set()
    {
        $item1 = new Item();
        $item2 = new Item();
        $item3 = new Item();

        $this->addItemsSet([$item1, $item2, $item3]);

        $this->getFirstItem()->shouldReturn($item1);
    }

    function it_should_return_null_when_the_first_item_in_not_the_set()
    {
        $this->getFirstItem()->shouldBeNull();
    }

    function it_should_return_the_last_item_in_the_set()
    {
        $item1 = new Item();
        $item2 = new Item();
        $item3 = new Item();

        $this->addItemsSet([$item1, $item2, $item3]);

        $this->getLastItem()->shouldReturn($item3);
    }

    function it_should_return_null_when_the_last_item_in_not_the_set()
    {
        $this->getLastItem()->shouldBeNull();
    }

    function it_should_know_if_it_has_items()
    {
        $item1 = new Item();

        $this->addItem($item1);

        $this->shouldHaveItems();
    }

    function it_should_know_if_it_has_no_items()
    {
        $this->shouldNotHaveItems();
    }

    function it_should_add_a_query()
    {
        $query = new Query();
        $this->addQuery($query);
        $this->getQueriesSet()->shouldHaveCount(1);
    }

    function it_should_throw_an_exception_when_query_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [query] must be of type [CollectionJson\Entity\Query]')
        )->during('addQuery', [new Template()]);
    }

    function it_should_add_a_query_when_passing_an_array()
    {
        $this->addQuery([
            'href'   => 'http://example.com',
            'rel'    => 'Query Rel',
            'name'   => 'Query Name',
            'prompt' => 'Query Prompt',
            'data' => [
                [
                    'name' => 'name 1',
                    'value' => 'value 1'
                ]
            ]
        ]);
        $this->getQueriesSet()->shouldHaveCount(1);
    }

    function it_should_add_multiple_queries()
    {
        $query1 = new Query();
        $query2 = new Query();

        $this->addQueriesSet([$query1, $query2]);
        $this->getQueriesSet()->shouldHaveCount(2);
    }

    function it_should_return_the_first_query_in_the_set()
    {
        $query1 = new Query();
        $query2 = new Query();
        $query3 = new Query();

        $this->addQueriesSet([$query1, $query2, $query3]);

        $this->getFirstQuery()->shouldReturn($query1);
    }

    function it_should_return_null_when_the_first_data_in_not_the_set()
    {
        $this->getFirstQuery()->shouldBeNull();
    }

    function it_should_return_the_last_data_in_the_set()
    {
        $query1 = new Query();
        $query2 = new Query();
        $query3 = new Query();

        $this->addQueriesSet([$query1, $query2, $query3]);

        $this->getLastQuery()->shouldReturn($query3);
    }

    function it_should_return_null_when_the_last_data_in_not_the_set()
    {
        $this->getLastQuery()->shouldBeNull();
    }

    function it_should_know_if_it_has_queries()
    {
        $query = new Query();

        $this->addQuery($query);

        $this->shouldHaveQueries();
    }

    function it_should_know_if_it_has_no_queries()
    {
        $this->shouldNotHaveQueries();
    }

    function it_should_add_a_link()
    {
        $link = new Link();

        $this->addLink($link);
        $this->getLinksSet()->shouldHaveCount(1);
    }

    function it_should_throw_an_exception_when_link_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [link] must be of type [CollectionJson\Entity\Link]')
        )->during('addLink', [new Template()]);
    }

    function it_should_retrieve_the_link_by_relation()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);

        $this->addLinksSet([$link1, $link2]);

        $this->findLinkByRelation('rel1')->shouldBeEqualTo($link1);
        $this->findLinkByRelation('rel2')->shouldBeEqualTo($link2);
    }

    function it_should_return_null_when_link_is_not_in_the_set()
    {
        $this->findLinkByRelation('rel1')->shouldBeNull();
    }

    function it_should_add_a_link_when_passing_an_array()
    {
        $this->addLink([
            'href'   => 'http://example.com',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]);
        $this->getLinksSet()->shouldHaveCount(1);
    }

    function it_should_add_a_link_set()
    {
        $link1 = new Link();

        $this->addLinksSet([
            $link1,
            [
                'href'   => 'http://example.com',
                'rel'    => 'Rel value2',
                'render' => 'link'
            ]
        ]);
        $this->getLinksSet()->shouldHaveCount(2);
    }

    function it_should_return_the_first_link_in_the_set()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);
        $link3 = Link::fromArray(['rel' => 'rel3', 'href' => 'http://example3.com']);

        $this->addLinksSet([$link1, $link2, $link3]);

        $this->getFirstLink()->shouldReturn($link1);
    }

    function it_should_return_null_when_the_first_link_in_not_the_set()
    {
        $this->getFirstLink()->shouldBeNull();
    }

    function it_should_return_the_last_link_in_the_set()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);
        $link3 = Link::fromArray(['rel' => 'rel3', 'href' => 'http://example3.com']);

        $this->addLinksSet([$link1, $link2, $link3]);

        $this->getLastLink()->shouldReturn($link3);
    }

    function it_should_return_null_when_the_last_link_in_not_the_set()
    {
        $this->getLastLink()->shouldBeNull();
    }

    function it_should_know_if_it_has_links()
    {
        $link = new Link();

        $this->addLink($link);

        $this->shouldHaveLinks();
    }

    function it_should_know_if_it_has_no_links()
    {
        $this->shouldNotHaveLinks();
    }

    function it_should_set_the_error()
    {
        $error = (new Error())
            ->setCode("error code");

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

    function it_should_throw_an_exception_when_error_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [error] must be of type [CollectionJson\Entity\Error]')
        )->during('setError', [new Query()]);
    }

    function it_should_know_if_it_has_an_error()
    {
        $error = new Error();

        $this->setError($error);

        $this->shouldHaveError();
    }

    function it_should_know_if_it_has_not_an_error()
    {
        $this->shouldNotHaveError();
    }

    function it_should_set_the_template()
    {
        $template = new Template();

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

    function it_should_know_if_it_has_an_template()
    {
        $error = new Template();

        $this->setTemplate($error);

        $this->shouldHaveTemplate();
    }

    function it_should_know_if_it_has_not_an_template()
    {
        $this->shouldNotHaveTemplate();
    }

    function it_should_throw_an_exception_when_template_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [template] must be of type [CollectionJson\Entity\Template]')
        )->during('setTemplate', [new Query()]);
    }
}
