<?php

namespace spec\CollectionJson\Entity;

use CollectionJson\Entity\Error;
use CollectionJson\Entity\Item;
use CollectionJson\Entity\Link;
use CollectionJson\Entity\Query;
use CollectionJson\Entity\Template;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CollectionJson\Entity\Collection;
use CollectionJson\ArrayConvertible;

class CollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Collection::class);
        $this->shouldImplement(ArrayConvertible::class);
        $this->shouldImplement(\JsonSerializable::class);
    }

    function it_should_return_the_object_type()
    {
        $this::getObjectType()->shouldBeEqualTo('collection');
    }

    function it_can_be_initialized_with_an_href()
    {
        $this->beConstructedWith('http://example.com');
        $this->getHref()->shouldReturn('http://example.com');
    }


    function it_is_clonable()
    {
        $this->beConstructedThrough('fromArray', [[
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
            'queries' => [
                [
                    'rel' => 'search',
                    'href' => 'http://example.org/friends/search',
                    'prompt' => 'Search',
                    'data' => [
                        [
                            'name' => 'search',
                            'value' => ''
                        ]
                    ]
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
        ]]);

        $this->getHref()->shouldBeEqualTo('http://example.com');
        $this->getError()->shouldHaveType(Error::class);
        $this->getTemplate()->shouldHaveType(Template::class);
        $this->getItemsSet()->shouldHaveCount(2);
        $this->getLinks()->shouldHaveCount(2);
        $this->getQueriesSet()->shouldHaveCount(1);

        $copy = clone $this->getWrappedObject();

        $this->getHref()->shouldBeEqualTo($copy->getHref());
        $this->getError()->shouldNotBeEqualTo($copy->getError());
        $this->getTemplate()->shouldNotBeEqualTo($copy->getTemplate());

        $this->getItemsSet()->shouldHaveCount(count($copy->getItemsSet()));
        $this->getLinks()->shouldHaveCount(count($copy->getLinks()));
        $this->getQueriesSet()->shouldHaveCount(count($copy->getQueriesSet()));

        $this->getFirstLink()->shouldNotBeEqualTo($copy->getFirstLink());
        $this->getLastLink()->shouldNotBeEqualTo($copy->getLastLink());

        $this->getFirstItem()->shouldNotBeEqualTo($copy->getFirstItem());
        $this->getLastItem()->shouldNotBeEqualTo($copy->getLastItem());

        $this->getFirstQuery()->shouldNotBeEqualTo($copy->getFirstQuery());
        $this->getLastQuery()->shouldNotBeEqualTo($copy->getLastQuery());
    }

    function it_may_be_construct_with_an_array_representation_of_the_collection()
    {
        $data = [
            'error'    => [
                'code' => 'error code',
                'message' => 'message code',
                'title' => 'title code',
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

        $this->beConstructedThrough('fromArray', [$data]);

        $this->getHref()->shouldBeEqualTo('http://example.com');
        $this->getError()->shouldHaveType(Error::class);
        $this->getTemplate()->shouldHaveType(Template::class);
        $this->getItemsSet()->shouldHaveCount(2);
        $this->getLinks()->shouldHaveCount(2);
        $this->toArray()->shouldBeEqualTo([
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

        $this->beConstructedThrough('fromJson', [$json]);

        $this->getHref()->shouldBeEqualTo('http://example.org/friends/');
        $this->getTemplate()->shouldHaveType(Template::class);
        $this->getTemplate()->getDataSet()->shouldHaveCount(4);
        $this->getItemsSet()->shouldHaveCount(3);
        $this->getQueriesSet()->shouldHaveCount(1);
        $this->getLinks()->shouldHaveCount(1);
    }

    function it_should_throw_an_exception_when_setting_the_href_field_with_an_invalid_url()
    {
        $this->shouldThrow(
            new \DomainException('Property [href] of entity [collection] can only have one of the following values [URI]')
        )->during('withHref', ['uri']);
    }

    function it_should_set_the_href_value()
    {
        $link = $this->withHref("htp://google.com");
        $this->getHref()->shouldBeNull();
        $link->getHref()->shouldBeEqualTo("htp://google.com");
    }

    function it_should_be_chainable()
    {
        $link = new Link();
        $item = new Item();
        $query = new Query();
        $error = new Error();
        $template = new Template();

        $this->withHref('https://example.co')->shouldHaveType(Collection::class);
        $this->withItem($item)->shouldHaveType(Collection::class);
        $this->withItemsSet([$item])->shouldHaveType(Collection::class);
        $this->withQuery($query)->shouldHaveType(Collection::class);
        $this->withQueriesSet([$query])->shouldHaveType(Collection::class);
        $this->withError($error)->shouldHaveType(Collection::class);
        $this->withTemplate($template)->shouldHaveType(Collection::class);
        $this->withLink($link)->shouldHaveType(Collection::class);
        $this->withLinksSet([])->shouldHaveType(Collection::class);
    }

    function it_should_not_extract_null_and_empty_array_fields()
    {
        $this->toArray()->shouldBeEqualTo([
            'collection' => [
                'version' => '1.0'
            ]
        ]);
    }

    function it_should_add_an_item()
    {
        $item = new Item();

        $collection = $this->withItem($item);
        $this->getItemsSet()->shouldHaveCount(0);
        $collection->getItemsSet()->shouldHaveCount(1);
    }

    function it_should_remove_an_item()
    {
        $item = new Item();

        $collection = $this->withItem($item);
        $collection->getItemsSet()->shouldHaveCount(1);

        $collection = $collection->withoutItem($item);
        $collection->getItemsSet()->shouldHaveCount(0);
    }

    function it_should_throw_an_exception_when_item_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [item] must be of type [CollectionJson\Entity\Item]')
        )->during('withItem', [new Template()]);
    }

    function it_should_add_a_item_when_passing_array()
    {
        $collection = $this->withItem([
            'href' => 'https://example.co'
        ]);
        $this->getItemsSet()->shouldHaveCount(0);
        $collection->getItemsSet()->shouldHaveCount(1);
    }

    function it_should_add_multiple_items()
    {
        $item1 = new Item();
        $item2 = new Item();

        $collection = $this->withItemsSet([$item1, $item2]);
        $this->getItemsSet()->shouldHaveCount(0);
        $collection->getItemsSet()->shouldHaveCount(2);
    }

    function it_should_return_the_first_item_in_the_set()
    {
        $item1 = new Item();
        $item2 = new Item();
        $item3 = new Item();

        $collection = $this->withItemsSet([$item1, $item2, $item3]);
        $this->getFirstItem()->shouldBeNull();
        $collection->getFirstItem()->shouldBeLike($item1);
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

        $collection = $this->withItemsSet([$item1, $item2, $item3]);
        $this->getLastItem()->shouldBeNull();
        $collection->getLastItem()->shouldBeLike($item3);
    }

    function it_should_return_null_when_the_last_item_in_not_the_set()
    {
        $this->getLastItem()->shouldBeNull();
    }

    function it_should_know_if_it_has_items()
    {
        $item1 = new Item();

        $collection = $this->withItem($item1);
        $this->shouldNotHaveItems();
        $collection->shouldHaveItems();
    }

    function it_should_know_if_it_has_no_items()
    {
        $this->shouldNotHaveItems();
    }

    function it_should_add_a_query()
    {
        $query = new Query();
        $collection = $this->withQuery($query);
        $this->getQueriesSet()->shouldHaveCount(0);
        $collection->getQueriesSet()->shouldHaveCount(1);
    }

    function it_should_remove_a_query()
    {
        $query1 = new Query();
        $query2 = new Query();

        $collection = $this->withQuery($query1)->withQuery($query2);
        $collection->getQueriesSet()->shouldHaveCount(2);

        $collection = $collection->withoutQuery($query2);
        $collection->getQueriesSet()->shouldHaveCount(1);
        $collection->getFirstQuery()->shouldBeLike($query1);
    }

    function it_should_throw_an_exception_when_query_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [query] must be of type [CollectionJson\Entity\Query]')
        )->during('withQuery', [new Template()]);
    }

    function it_should_add_a_query_when_passing_an_array()
    {
        $collection = $this->withQuery([
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
        $this->getQueriesSet()->shouldHaveCount(0);
        $collection->getQueriesSet()->shouldHaveCount(1);
    }

    function it_should_add_multiple_queries()
    {
        $query1 = new Query();
        $query2 = new Query();

        $collection = $this->withQueriesSet([$query1, $query2]);
        $this->getQueriesSet()->shouldHaveCount(0);
        $collection->getQueriesSet()->shouldHaveCount(2);
    }

    function it_should_return_the_first_query_in_the_set()
    {
        $query1 = new Query();
        $query2 = new Query();
        $query3 = new Query();

        $collection = $this->withQueriesSet([$query1, $query2, $query3]);
        $this->getFirstQuery()->shouldBeNull();
        $collection->getFirstQuery()->shouldBeLike($query1);
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

        $collection = $this->withQueriesSet([$query1, $query2, $query3]);
        $this->getLastQuery()->shouldBeNull();
        $collection->getLastQuery()->shouldBeLike($query3);
    }

    function it_should_return_null_when_the_last_data_in_not_the_set()
    {
        $this->getLastQuery()->shouldBeNull();
    }

    function it_should_know_if_it_has_queries()
    {
        $query = new Query();

        $collection = $this->withQuery($query);
        $this->shouldNotHaveQueries();
        $collection->shouldHaveQueries();
    }

    function it_should_know_if_it_has_no_queries()
    {
        $this->shouldNotHaveQueries();
    }

    function it_should_add_a_link()
    {
        $link = new Link();

        $collection = $this->withLink($link);
        $this->getLinks()->shouldHaveCount(0);
        $collection->getLinks()->shouldHaveCount(1);
    }

    function it_should_remove_a_link()
    {
        $link = new Link();

        $collection = $this->withLink($link);
        $collection->getLinks()->shouldHaveCount(1);

        $collection = $collection->withoutLink($link);
        $collection->getLinks()->shouldHaveCount(0);
    }

    function it_should_retrieve_the_link_by_relation()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);

        $collection = $this->withLinksSet([$link1, $link2]);

        $this->getLinksByRel('rel1')->shouldHaveCount(0);
        $this->getLinksByRel('rel2')->shouldHaveCount(0);

        $collection->getLinksByRel('rel1')->shouldBeLike([$link1]);
        $collection->getLinksByRel('rel2')->shouldBeLike([$link2]);
    }

    function it_should_return_null_when_link_is_not_in_the_set()
    {
        $this->getLinksByRel('rel1')->shouldReturn([]);
    }

    function it_should_add_a_link_when_passing_an_array()
    {
        $collection = $this->withLink(Link::fromArray([
            'href'   => 'http://example.com',
            'rel'    => 'Rel value',
            'render' => 'link'
        ]));

        $collection->getLinks()->shouldHaveCount(1);
    }

    function it_should_add_a_link_set()
    {
        $link1 = new Link();

        $collection = $this->withLinksSet([
            $link1,
            [
                'href'   => 'http://example.com',
                'rel'    => 'Rel value2',
                'render' => 'link'
            ]
        ]);
        $this->getLinks()->shouldHaveCount(0);
        $collection->getLinks()->shouldHaveCount(2);
    }

    function it_should_return_the_first_link_in_the_set()
    {
        $link1 = Link::fromArray(['rel' => 'rel1', 'href' => 'http://example.com']);
        $link2 = Link::fromArray(['rel' => 'rel2', 'href' => 'http://example2.com']);
        $link3 = Link::fromArray(['rel' => 'rel3', 'href' => 'http://example3.com']);

        $collection = $this->withLinksSet([$link1, $link2, $link3]);

        $this->getFirstLink()->shouldBeNull();
        $collection->getFirstLink()->shouldBeLike($link1);
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

        $collection = $this->withLinksSet([$link1, $link2, $link3]);

        $this->getLastLink()->shouldBeNull();
        $collection->getLastLink()->shouldBeLike($link3);
    }

    function it_should_return_null_when_the_last_link_in_not_the_set()
    {
        $this->getLastLink()->shouldBeNull();
    }

    function it_should_know_if_it_has_links()
    {
        $link = new Link();

        $collection = $this->withLink($link);

        $collection->shouldHaveLinks();
    }

    function it_should_know_if_it_has_no_links()
    {
        $this->shouldNotHaveLinks();
    }

    function it_should_set_the_error()
    {
        $error = (new Error())
            ->withCode('error code');

        $collection = $this->withError($error);
        $this->getError()->shouldBeNull();
        $collection->getError()->shouldBeAnInstanceOf(Error::class);
        $collection->getError()->getCode()->shouldBeEqualTo('error code');
    }

    function it_should_remove_the_error()
    {
        $error = (new Error())
            ->withCode('error code');

        $collection = $this->withError($error);
        $collection->getError()->shouldBeAnInstanceOf(Error::class);

        $collection = $collection->withoutError();
        $collection->getError()->shouldBeNull();
    }

    function it_should_set_the_error_when_passing_an_array()
    {
        $collection = $this->withError([
            'message' => 'message code',
            'title' => 'title code',
            'code' => 'error code',
        ]);
        $this->getError()->shouldBeNull();
        $collection->getError()->shouldBeAnInstanceOf(Error::class);
        $collection->getError()->getMessage()->shouldBeEqualTo('message code');
        $collection->getError()->getTitle()->shouldBeEqualTo('title code');
        $collection->getError()->getCode()->shouldBeEqualTo('error code');
    }

    function it_should_throw_an_exception_when_error_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [error] must be of type [CollectionJson\Entity\Error]')
        )->during('withError', [new Query()]);
    }

    function it_should_know_if_it_has_an_error()
    {
        $error = new Error();

        $collection = $this->withError($error);
        $this->shouldNotHaveError();
        $collection->shouldHaveError();
    }

    function it_should_know_if_it_has_not_an_error()
    {
        $this->shouldNotHaveError();
    }

    function it_should_set_the_template()
    {
        $template = new Template();

        $collection = $this->withTemplate($template);
        $this->getTemplate()->shouldBeNull();
        $collection->getTemplate()->shouldBeAnInstanceOf(Template::class);
    }

    function it_should_remove_the_template()
    {
        $template = new Template();

        $collection = $this->withTemplate($template);
        $collection->getTemplate()->shouldBeAnInstanceOf(Template::class);

        $collection = $collection->withoutTemplate();
        $collection->getTemplate()->shouldBeNull();
    }

    function it_should_set_the_template_when_passing_an_array()
    {
        $collection = $this->withTemplate([
            'data' => [
                [
                    'name' => 'name 1',
                    'value' => 'value 1'
                ]
            ]
        ]);
        $this->getTemplate()->shouldBeNull();
        $collection->getTemplate()->shouldBeAnInstanceOf(Template::class);
        $collection->getTemplate()->getDataSet()->shouldHaveCount(1);
    }

    function it_should_know_if_it_has_an_template()
    {
        $error = new Template();

        $collection = $this->withTemplate($error);

        $this->shouldNotHaveTemplate();
        $collection->shouldHaveTemplate();
    }

    function it_should_know_if_it_has_not_an_template()
    {
        $this->shouldNotHaveTemplate();
    }

    function it_should_throw_an_exception_when_template_has_the_wrong_type()
    {
        $this->shouldThrow(
            new \BadMethodCallException('Property [template] must be of type [CollectionJson\Entity\Template]')
        )->during('withTemplate', [new Query()]);
    }
}
