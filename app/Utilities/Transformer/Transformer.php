<?php

namespace App\Utilities\Transformer;


abstract class Transformer
{
    public function transformCollection($items)
    {
        $result = [];
        foreach ($items as $item)
        {
            $result[] = $this->transform($item);
        }
        return $result;
    }

    public abstract function transform($item);
}