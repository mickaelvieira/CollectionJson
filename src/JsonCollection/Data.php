<?php

namespace JsonCollection;

/**
 * Class Data
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class Data extends BaseEntity
{
    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-prompt
     */
    protected $prompt;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-name
     */
    protected $name;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-value
     */
    protected $value;

    /**
     * @var string
     * @link http://code.ge/media-types/collection-next-json/#property-type
     */
    protected $type;

    /**
     * @var bool
     * @link http://code.ge/media-types/collection-next-json/#property-required
     */
    protected $required;

    /**
     * @var \JsonCollection\ListData
     * @link http://code.ge/media-types/collection-next-json/#object-list
     */
    protected $list;

    /**
     * @param string $name
     * @return \JsonCollection\Data
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
     * @return \JsonCollection\Data
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
     * @param string $value
     * @return \JsonCollection\Data
     */
    public function setValue($value)
    {
        if (is_string($value)) {
            $this->value = $value;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $type
     * @return \JsonCollection\Data
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
     * @param boolean $required
     * @return \JsonCollection\Data
     */
    public function setRequired($required)
    {
        if (is_bool($required)) {
            $this->required = $required;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @return \JsonCollection\ListData
     */
    public function getList()
    {
        if (is_null($this->list)) {
            $this->list = new ListData();
        }
        return $this->list;
    }

    /**
     * @param \JsonCollection\ListData $list
     * @return \JsonCollection\Data
     */
    public function setList(ListData $list)
    {
        $this->list = $list;
        return $this;
    }

    /**
     * @param \JsonCollection\Option|array $option
     * @return \JsonCollection\Data
     */
    public function addOption($option)
    {
        $list = $this->getList();
        if (is_array($option)) {
            $option = new Option($option);
        }
        $list->addOption($option);
        return $this;
    }

    /**
     * @param array       $options
     * @param null|bool   $multiple
     * @param null|string $default
     * 
     * @return \JsonCollection\Data
     */
    public function addOptions(array $options, $multiple = null, $default = null)
    {
        $list = $this->getList();
        $list->setMultiple($multiple);
        $list->setDefault($default);

        foreach ($options as $option) {
            $this->addOption($option);
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = [];
        if (!is_null($this->name)) {
            array_walk(
                $this->getSortedObjectVars(),
                function ($value, $key) use (&$data) {
                    if (!is_null($value) || $key === 'value') {
                        $data[$key] = $value;
                    }
                }
            );
        }
        return $data;
    }
}
