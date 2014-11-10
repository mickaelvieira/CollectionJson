<?php

namespace JsonCollection;

/**
 * Class Status
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class Status extends BaseEntity
{
    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-code
     */
    protected $code;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-message
     */
    protected $message;

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        if (is_string($code)) {
            $this->code = $code;
        }
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        if (is_string($message)) {
            $this->message = $message;
        }
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    protected function getObjectData()
    {
        $data = $this->getSortedObjectVars();
        $data = $this->filterNullValues($data);

        return $data;
    }
}
