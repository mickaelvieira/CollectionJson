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

use LogicException;
use BadMethodCallException;
use CollectionJson\BaseEntity;
use CollectionJson\Type\Render as RenderType;
use CollectionJson\Validator\Uri;
use CollectionJson\Validator\StringLike;

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
     * @throws \BadMethodCallException
     */
    public function setHref($href)
    {
        if (!Uri::isValid($href)) {
            throw new BadMethodCallException(sprintf("Field href must be a valid URL, %s given", $href));
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
     * @throws \BadMethodCallException
     */
    public function setRel($rel)
    {
        if (!StringLike::isValid($rel)) {
            throw new BadMethodCallException(
                sprintf("Property rel of object type %s cannot be converted to a string", $this->getObjectType())
            );
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
     * @throws \BadMethodCallException
     */
    public function setName($name)
    {
        if (!StringLike::isValid($name)) {
            throw new BadMethodCallException(
                sprintf("Property name of object type %s cannot be converted to a string", $this->getObjectType())
            );
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
     * @throws \BadMethodCallException
     */
    public function setPrompt($prompt)
    {
        if (!StringLike::isValid($prompt)) {
            throw new BadMethodCallException(
                sprintf("Property prompt of object type %s cannot be converted to a string", $this->getObjectType())
            );
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
     */
    public function setRender($render)
    {
        if ($render === RenderType::LINK || $render === RenderType::IMAGE) {
            $this->render = $render;
        }
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
        if (is_null($this->href)) {
            throw new LogicException(sprintf("Property href of object type %s is required", $this->getObjectType()));
        }
        if (is_null($this->rel)) {
            throw new LogicException(sprintf("Property rel of object type %s is required", $this->getObjectType()));
        }

        $data = [
            'href'   => $this->href,
            'name'   => $this->name,
            'prompt' => $this->prompt,
            'rel'    => $this->rel,
            'render' => $this->render,
        ];

        $data = $this->filterNullValues($data);

        return $data;
    }
}
