<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Jobs\TrimVideo;
use App\Video;
use App\VideoStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video' => 'required|file',
            'from' => 'required|integer',
            'duration' => 'required|integer'
        ]);

        if(!$validator->fails()){
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
        }
        return response(['msg' => $validator->errors()], 500);
////            $frame = $video->frame(TimeCode::fromSeconds(10));
////            $frame->save(storage_path().'/image.jpg');
    }
}