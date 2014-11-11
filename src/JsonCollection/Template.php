<?php

namespace JsonCollection;

/**
 * Class Template
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class Template extends BaseEntity implements DataAware
{

    use DataContainer;

    /**
     * @var Method
     * @link http://code.ge/media-types/collection-next-json/#object-method
     */
    protected $method;

    /**
     * @var Enctype
     * @link http://code.ge/media-types/collection-next-json/#object-enctype
     */
    protected $enctype;

    /**
     * @param Method $method
     */
    public function setMethod(Method $method)
    {
        $this->method = $method;
    }

    /**
     * @return Method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param Enctype $enctype
     */
    public function setEnctype(Enctype $enctype)
    {
        $this->enctype = $enctype;
    }

    /**
     * @return Enctype
     */
    public function getEnctype()
    {
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
