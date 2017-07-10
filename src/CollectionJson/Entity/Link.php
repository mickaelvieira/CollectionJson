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

use Psr\Link\LinkInterface;
use Psr\Link\EvolvableLinkInterface;

use CollectionJson\BaseEntity;
use CollectionJson\Type\Render as RenderType;
use CollectionJson\Validator\Render;
use CollectionJson\Exception\WrongParameter;
use CollectionJson\Exception\MissingProperty;

/**
 * Class Link
 * @package CollectionJson\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://amundsen.com/media-types/collection/format/#arrays-links
 */
class Link extends BaseEntity implements LinkInterface, EvolvableLinkInterface
{
    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-href
     */
    protected $href;

    /**
     * @var array
     * @link http://amundsen.com/media-types/collection/format/#properties-rel
     */
    protected $rels = [];

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
     * {@inheritdoc}
     */
    public function withHref($href): Link
    {
        $copy = clone $this;
        $copy->href = (string)$href;

        return $copy;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * {@inheritdoc}
     *
     * @return Link
     */
    public function withRel($rel): Link
    {
        $copy = clone $this;
        $copy->rels[] = (string)$rel;

        return $copy;
    }

    /**
     * {@inheritdoc}
     *
     * @return Link
     */
    public function withoutRel($rel): Link
    {
        $copy = clone $this;

        $key = array_search($rel, $copy->rels, true);

        if ($key !== false) {
            unset($copy->rels[$key]);
        }

        return $copy;
    }

    /**
     * {@inheritdoc}
     */
    public function getRels(): array
    {
        return $this->rels;
    }

    /**
     * @param $rel
     *
     * @return bool
     */
    public function hasRel($rel): bool
    {
        return in_array($rel, $this->rels, true);
    }

    /**
     * @param string $name
     *
     * @return Link
     *
     * @throws \DomainException
     */
    public function withName(string $name): Link
    {
        $copy = clone $this;
        $copy->name = $name;

        return $copy;
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
    public function withPrompt(string $prompt): Link
    {
        $copy = clone $this;
        $copy->prompt = $prompt;

        return $copy;
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
    public function withRender(string $render): Link
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
    public function withAttribute($attribute, $value)
    {
        throw new \BadFunctionCallException('Not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function withoutAttribute($attribute)
    {
        throw new \BadFunctionCallException('Not implemented');
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes(): array
    {
        throw new \BadFunctionCallException('Not implemented');
    }

    /**
     * @link https://tools.ietf.org/html/rfc6570
     *
     * {@inheritdoc}
     */
    public function isTemplated(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData(): array
    {
        if (is_null($this->href)) {
            throw MissingProperty::fromTemplate(self::getObjectType(), 'href');
        }

        if (empty($this->rels)) {
            throw MissingProperty::fromTemplate(self::getObjectType(), 'rel');
        }

        $data = [
            'href'   => $this->href,
            'name'   => $this->name,
            'prompt' => $this->prompt,
            'rel'    => implode(',', $this->rels),
            'render' => $this->render,
        ];

        return  $this->filterNullValues($data);
    }
}
