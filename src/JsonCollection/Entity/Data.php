<?php

/*
 * This file is part of JsonCollection, a php implementation
 * of the Collection.next+JSON Media Type
 *
 * (c) Mickaël Vieira <contact@mickael-vieira.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonCollection\Entity;

use JsonCollection\BaseEntity;

/**
 * Class Data
 * @package JsonCollection\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 * @link http://amundsen.com/media-types/collection/format/#arrays-data
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
     * @var \JsonCollection\Entity\ListData
     * @link http://code.ge/media-types/collection-next-json/#object-list
     */
    protected $list;

    /**
     * @param string $name
     * @return \JsonCollection\Entity\Data
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
     * @return \JsonCollection\Entity\Data
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
     * @return \JsonCollection\Entity\Data
     */
    public function setValue($value)
    {
        if (!is_array($value) && !is_object($value)) {
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
     * @return \JsonCollection\Entity\Data
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
     * @return \JsonCollection\Entity\Data
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
     * @return \JsonCollection\Entity\ListData
     */
    public function getList()
    {
        if (is_null($this->list)) {
            $this->list = new ListData();
        }
        return $this->list;
    }

    /**
     * @param \JsonCollection\Entity\ListData $list
     * @return \JsonCollection\Entity\Data
     */
    public function setList(ListData $list)
    {
        $this->list = $list;
        return $this;
    }

    /**
     * @param \JsonCollection\Entity\Option|array $option
     * @return \JsonCollection\Entity\Data
     */
    public function addOptionToList($option)
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
     * @return \JsonCollection\Entity\Data
     */
    public function addOptionsToList(array $options, $multiple = null, $default = null)
    {
        $list = $this->getList();
        $list->setMultiple($multiple);
        $list->setDefault($default);

        foreach ($options as $option) {
            $this->addOptionToList($option);
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
