<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Jobs\TrimVideo;
use App\Video;
use App\VideoStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $fileName = str_random(5).'.'.$request->video->extension();
        $path = $request->video->storeAs('video', $fileName);
        if($path)
        {
            $status = VideoStatus::where(['status' => 'scheduled'])->first();
            $link = env('APP_URL').'/storage/'.$path;
            $video = Video::create([
                'user_id' => Auth::user()->id,
                'status_id' => $status->id,
                'path' => $link
            ]);
            if($video){
                dispatch(new TrimVideo($video, $request->from, $request->duration, $fileName));
                return response(['msg' => $video], 200);
            }


        }
        return response(['msg' => 'oops'], 500);
////            $frame = $video->frame(TimeCode::fromSeconds(10));
////            $frame->save(storage_path().'/image.jpg');
    }
}