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
        if (is_null($this->method)) {
            $this->method = new Method();
        }
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
