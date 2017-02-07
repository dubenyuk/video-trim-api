<?php

namespace App\Utilities\Transformer;

class VideoTransformer extends Transformer
{
    /**
     * @param $video
     * @return array
     */
    public function transform($video)
    {
        return [
            'id' => $video->id,
            'status' => $video->status->status,
            'link' => $video->path,
        ];
    }
}