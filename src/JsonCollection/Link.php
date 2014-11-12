<?php

namespace JsonCollection;

use JsonCollection\Type\Render as RenderType;

/**
 * Class Link
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
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
     * @link http://code.ge/media-types/collection-next-json/#property-type
     */
    protected $type;

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
     * @return \JsonCollection\Link
     */
    public function setHref($href)
    {
        if (is_string($href)) {
            $this->href = $href;
        }
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
     * @return \JsonCollection\Link
     */
    public function setRel($rel)
    {
        if (is_string($rel)) {
            $this->rel = $rel;
        }
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
     * @param string $type
     * @return \JsonCollection\Link
     */
    public function setType($type)
    {
        if (is_string($type)) {
            $this->type = $type;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $name
     * @return \JsonCollection\Link
     */
    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }
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
     * @return \JsonCollection\Link
     */
    public function setPrompt($prompt)
    {
        if (is_string($prompt)) {
            $this->prompt = $prompt;
        }
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
     * @return \JsonCollection\Link
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
        $data = [];

        if (!is_null($this->href) && !is_null($this->rel)) {
            $data = $this->getSortedObjectVars();
            $data = $this->filterNullValues($data);
        }
        return $data;
    }
}
