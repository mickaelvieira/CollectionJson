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
use JsonCollection\DataAware;
use JsonCollection\DataContainer;

/**
 * Class Template
 * @package JsonCollection\Entity
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class Template extends BaseEntity implements DataAware
{

    use DataContainer;

    /**
     * @var \JsonCollection\Entity\Method
     * @link http://code.ge/media-types/collection-next-json/#object-method
     */
    protected $method;

    /**
     * @var \JsonCollection\Entity\Enctype
     * @link http://code.ge/media-types/collection-next-json/#object-enctype
     */
    protected $enctype;

    /**
     * @param \JsonCollection\Entity\Method $method
     * @return \JsonCollection\Entity\Template
     */
    public function setMethod(Method $method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return \JsonCollection\Entity\Method
     */
    public function getMethod()
    {
        if (is_null($this->method)) {
            $this->method = new Method();
        }
        return $this->method;
    }

    /**
     * @param \JsonCollection\Entity\Enctype $enctype
     * @return \JsonCollection\Entity\Template
     */
    public function setEnctype(Enctype $enctype)
    {
        $this->enctype = $enctype;
        return $this;
    }

    /**
     * @return \JsonCollection\Entity\Enctype
     */
    public function getEnctype()
    {
        if (is_null($this->enctype)) {
            $this->enctype = new Enctype();
        }
        return $this->enctype;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = $this->getSortedObjectVars();
        $data = $this->filterEmptyArrays($data);
        $data = $this->filterNullValues($data);

        return $data;
    }
}
