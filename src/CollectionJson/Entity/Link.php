<?php
declare(strict_types=1);

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
     *
     * @return Link
     *
     * @throws \DomainException
     */
    public function setHref($href): Link
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
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @param string $rel
     *
     * @return Link
     *
     * @throws \DomainException
     */
    public function setRel(string $rel): Link
    {
        $this->rel = (string)$rel;

        return $this;
    }

    /**
     * @return string
     */
    public function getRel(): string
    {
        return $this->rel;
    }

    /**
     * @param string $name
     *
     * @return Link
     *
     * @throws \DomainException
     */
    public function setName(string $name): Link
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $prompt
     *
     * @return Link
     *
     * @throws \DomainException
     */
    public function setPrompt(string $prompt): Link
    {
        $this->prompt = (string)$prompt;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrompt(): string
    {
        return $this->prompt;
    }

    /**
     * @param string $render
     *
     * @return Link
     *
     * @throws \DomainException
     */
    public function setRender($render): Link
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
    public function getRender(): string
    {
        return $this->render;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData(): array
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
