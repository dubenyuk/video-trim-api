<?php

namespace App\Utilities\Transformer;

abstract class Transformer
{
    /**
     * @param $items
     * @return array
     */
    public function transformCollection($items)
    {
        $result = [];
        foreach ($items as $item)
        {
            $result[] = $this->transform($item);
        }
        return $result;
    }

    /**
     * @param $item
     * @return mixed
     */
    public abstract function transform($item);
}