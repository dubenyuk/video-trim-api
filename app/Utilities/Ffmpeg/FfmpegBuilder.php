<?php

namespace App\Utilities\Ffmpeg;

use FFMpeg\FFMpeg;

class FfmpegBuilder
{
    /**
     * @return FFMpeg
     */
    public static function create()
    {
        return FFMpeg::create([
            'ffmpeg.binaries'  => env('FFMPEG'),
            'ffprobe.binaries' => env('FFPROBE'),
            'timeout'          => 0,
            'ffmpeg.threads'   => 12,
        ]);
    }
}