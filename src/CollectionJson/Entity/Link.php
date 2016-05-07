<?php

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

use CollectionJson\BaseEntity;
use CollectionJson\Type\Render as RenderType;
use CollectionJson\Validator\Uri;
use CollectionJson\Validator\Render;
use CollectionJson\Validator\StringLike;
use CollectionJson\Exception\WrongParameter;
use CollectionJson\Exception\MissingProperty;

/**
 * Class Link
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#arrays-links
 */
class Link extends BaseEntity
{
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
     * @link http://amundsen.com/media-types/collection/format/#properties-render
     */
    protected $render = RenderType::LINK;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-prompt
     */
    protected $prompt;

    /**
     * @param string $href
     * @return \CollectionJson\Entity\Link
     * @throws \DomainException
     */
    public function setHref($href)
    {
        if (!Uri::isValid($href)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'href', Uri::allowed());
        }
        $this->href = $href;

        return $this;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param string $rel
     * @return \CollectionJson\Entity\Link
     * @throws \DomainException
     */
    public function setRel($rel)
    {
        if (!StringLike::isValid($rel)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'rel', StringLike::allowed());
        }
        $this->rel = (string)$rel;

        return $this;
    }

    /**
     * @return string
     */
    public function getRel()
    {
        return $this->rel;
    }

    /**
     * @param string $name
     * @return \CollectionJson\Entity\Link
     * @throws \DomainException
     */
    public function setName($name)
    {
        if (!StringLike::isValid($name)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'name', StringLike::allowed());
        }
        $this->name = (string)$name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $prompt
     * @return \CollectionJson\Entity\Link
     * @throws \DomainException
     */
    public function setPrompt($prompt)
    {
        if (!StringLike::isValid($prompt)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'prompt', StringLike::allowed());
        }
        $this->prompt = (string)$prompt;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param string $render
     * @return \CollectionJson\Entity\Link
     * @throws \DomainException
     */
    public function setRender($render)
    {
        if (!Render::isValid($render)) {
            throw WrongParameter::fromTemplate(self::getObjectType(), 'render', Render::allowed());
        }
        $this->render = $render;

        return $this;
    }

    /**
     * @return string
     */
    public function getRender()
    {
        return $this->render;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        foreach (['href', 'rel'] as $property) {
            if (is_null($this->$property)) {
                throw MissingProperty::fromTemplate(self::getObjectType(), $property);
            }
        }

        $data = [
            'href'   => $this->href,
            'name'   => $this->name,
            'prompt' => $this->prompt,
            'rel'    => $this->rel,
            'render' => $this->render,
        ];

        return  $this->filterNullValues($data);
    }
}
