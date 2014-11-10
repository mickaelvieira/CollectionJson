<?php

namespace JsonCollection\Type;

/**
 * Class Media
 * @package JsonCollection\Type
 */
final class Media
{
    /**
     *
     */
    private function __construct()
    {
    }

    const HTML                 = "text/html";
    const TIFF                 = "image/tiff";
    const JPEG                 = "image/jpeg";
    const COLLECTION_JSON      = "application/vnd.collection+json";
    const COLLECTION_NEXT_JSON = "application/vnd.collection.next+json";
}
