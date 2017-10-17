<?php

namespace spec\CollectionJson\Validator;

use CollectionJson\Entity\Data;
use CollectionJson\Entity\Template;
use CollectionJson\Validator\Dataset;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Symfony\Component\Validator\Constraints;

class DatasetSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Dataset::class);
    }

    function it_validates_a_data_set_when_it_does_not_contain_errors()
    {
        $constraints = [
            'id'    => [
                new Constraints\NotBlank(),
            ],
            'url'   => [
                new Constraints\NotBlank(),
                new Constraints\Url(),
            ],
            'email' => [
                new Constraints\NotBlank(),
                new Constraints\Email(),
            ],
        ];

        $template = (new Template())
            ->withData(new Data('id', '123'))
            ->withData(new Data('url', 'http://example.co'))
            ->withData(new Data('email', 'test@example.co'));

        $this->validate($template->getDataSet(), $constraints)->shouldReturn([]);
    }

    function it_does_not_validate_a_data_set_when_it_contains_errors()
    {
        $constraints = [
            'id' => [
                new Constraints\NotBlank(),
            ],
            'url' => [
                new Constraints\NotBlank(),
                new Constraints\Url(),
            ],
            'email' => [
                new Constraints\NotBlank(),
                new Constraints\Email(),
            ]
        ];

        $template = (new Template())
            ->withData(new Data('url', 'example.co'))
            ->withData(new Data('email', 'testexample.co'));

        $this->validate($template->getDataSet(), $constraints)->shouldReturn([
            'id'    => [
                'message' => 'This value should not be blank.',
                'value'   => null,
            ],
            'url'   => [
                'message' => 'This value is not a valid URL.',
                'value'   => 'example.co',
            ],
            'email' => [
                'message' => 'This value is not a valid email address.',
                'value'   => 'testexample.co',
            ],
        ]);
    }
}
