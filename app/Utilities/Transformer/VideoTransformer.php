<?php
/**
 * Created by PhpStorm.
 * User: vitalij
 * Date: 07.02.2017
 * Time: 7:56
 */

namespace App\Utilities\Transformer;


class VideoTransformer extends Transformer
{
    public function transform($video)
    {
        return [
            'id' => $video->id,
            'status' => $video->status->status,
            'link' => $video->path,
        ];
    }
}