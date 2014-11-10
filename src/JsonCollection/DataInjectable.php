<?php

namespace JsonCollection;

/**
 * Interface DataInjectable
 * @package JsonCollection
 */
interface DataInjectable
{
    /**
     * @param array $data
     * @return mixed
     */
    public function inject(array $data = []);
}
