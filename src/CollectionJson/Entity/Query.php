<?php
declare(strict_types = 1);

/*
 * This file is part of CollectionJson, a php implementation
 * of the Collection+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CollectionJson\Entity;

use CollectionJson\Bag;
use CollectionJson\DataAware;
use CollectionJson\BaseEntity;
use CollectionJson\Validator\Uri;
use CollectionJson\DataContainer;
use CollectionJson\Exception\InvalidParameter;
use CollectionJson\Exception\CollectionJsonException;

/**
 * Class Query
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#arrays-queries
 */
class Query extends BaseEntity implements DataAware
{
    /**
     * @see \CollectionJson\DataContainer
     */
    use DataContainer;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-href
     */
    protected $href;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-rel
     */
    protected $rel;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-name
     */
    protected $name;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-prompt
     */
    protected $prompt;

    /**
     * Query constructor.
     *
     * @param string|null $href
     * @param string|null $rel
     * @param string|null $name
     * @param string|null $prompt
     */
    public function __construct(string $href, string $rel, string $name = null, string $prompt = null)
    {
        if (is_string($href) && !Uri::isValid($href)) {
            throw InvalidParameter::fromTemplate(self::getObjectType(), 'href', Uri::allowed());
        }

        $this->href   = $href;
        $this->rel    = $rel;
        $this->name   = $name;
        $this->prompt = $prompt;
        $this->data   = new Bag(Data::class);
    }

    /**
     * @param string $href
     *
     * @return Query
     *
     * @throws InvalidParameter
     */
    public function withHref($href): Query
    {
        if (!Uri::isValid($href)) {
            throw InvalidParameter::fromTemplate(self::getObjectType(), 'href', Uri::allowed());
        }

        $copy = clone $this;
        $copy->href = (string)$href;

        return $copy;
    }

    /**
     * @return string|null
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $name
     *
     * @return Query
     *
     * @throws CollectionJsonException
     */
    public function withName(string $name): Query
    {
        $copy = clone $this;
        $copy->name = $name;

        return $copy;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $prompt
     *
     * @return Query
     *
     * @throws CollectionJsonException
     */
    public function withPrompt(string $prompt): Query
    {
        $copy = clone $this;
        $copy->prompt = $prompt;

        return $copy;
    }

    /**
     * @return string|null
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param string $rel
     *
     * @return Query
     *
     * @throws CollectionJsonException
     */
    public function withRel(string $rel): Query
    {
        $copy = clone $this;
        $copy->rel = $rel;

        return $copy;
    }

    /**
     * @return string|null
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData(): array
    {
        $data = [
            'data'   => $this->getDataSet(),
            'href'   => $this->href,
            'name'   => $this->name,
            'prompt' => $this->prompt,
            'rel'    => $this->rel,
        ];

        $data = $this->filterEmptyArrays($data);
        $data = $this->filterNullValues($data);

        return $data;
    }

    /**
     * @return void
     */
    public function __clone()
    {
        $this->data = clone $this->data;
    }
}
