<?php

namespace App\Utilities\Ffmpeg;

use FFMpeg\FFMpeg;

class FfmpegBuilder
{
    public static function create()
    {
        $obj = FFMpeg::create([
            'ffmpeg.binaries'  => env('FFMPEG'),
            'ffprobe.binaries' => env('FFPROBE'),
            'timeout'          => 0,
            'ffmpeg.threads'   => 12,
        ]);
        return $obj;
    }
}