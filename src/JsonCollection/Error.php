<?php

namespace JsonCollection;

/**
 * Class Error
 * @package JsonCollection
 * @link http://amundsen.com/media-types/collection/format/
 * @link http://code.ge/media-types/collection-next-json/
 */
class Error extends BaseEntity
{
    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#properties-title
     */
    protected $title;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#property-code
     */
    protected $code;

    /**
     * @var string
     * @link http://amundsen.com/media-types/collection/format/#property-message
     */
    protected $message;

    /**
     * @var array
     * @link http://code.ge/media-types/collection-next-json/#array-messages
     */
    protected $messages = [];

    /**
     * @param string $code
     * @return \JsonCollection\Error
     */
    public function setCode($code)
    {
        if (is_string($code)) {
            $this->code = $code;
        }
        return $this;
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
     * @return \JsonCollection\Error
     */
    public function setMessage($message)
    {
        if (is_string($message)) {
            $this->message = $message;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $title
     * @return \JsonCollection\Error
     */
    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param \JsonCollection\Message $message
     * @return \JsonCollection\Error
     */
    public function addMessage(Message $message)
    {
        array_push($this->messages, $message);
        return $this;
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
