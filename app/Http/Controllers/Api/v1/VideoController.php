<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 05.02.2017
 * Time: 22:08
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\WebM;
use FFMpeg\Format\Video\WMV;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        //dd(public_path());
        //$ffmpeg = FFMpeg::create();
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => 'C:/FFmpeg/bin/ffmpeg.exe',
            'ffprobe.binaries' => 'C:/FFmpeg/bin/ffprobe.exe',
            'timeout'          => 0,
            'ffmpeg.threads'   => 12,
        ]);

        $path = $request->video->storeAs('video', 'test.mp4');
        if($path){
            $video = $ffmpeg->open($request->video);
            //$video = $ffmpeg->open('http://videotrim/storage/video/test.mp4');
            $video->filters()->clip(TimeCode::fromSeconds(3), TimeCode::fromSeconds(15));
            $video->save(new WebM(), 'output.mp4');
            //$video->save(new X264(), 'output.mp4');
            //Storage::put('new.mp4', $res);
            //$new->save(storage_path().'/new.,p4');

//            $frame = $video->frame(TimeCode::fromSeconds(10));
//            $frame->save(storage_path().'/image.jpg');

            return response(['msg' => $path], 200);
        }
        return response(['msg' => 'oops'], 500);





//        $path = $request->video->storeAs('video', 'test.mp4');
//        //$res = Storage::put('video', $request->video);
//        if($path){
//            return response(['msg' => $path], 200);
//        }
//        return response(['msg' => 'oops'], 500);
    }
}