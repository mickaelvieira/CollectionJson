<?php

namespace CollectionJson\Validator;

use CollectionJson\Type\Render as RenderType;

/**
 * Class Render
 * @package CollectionJson\Validator
 */
class Render
{
    /**
     * @param $type
     * @return bool
     */
    public static function isValid($type)
    {
        return ($type === RenderType::LINK || $type === RenderType::IMAGE);
    }
}
