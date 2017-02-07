<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Jobs\TrimVideo;
use App\Utilities\Transformer\VideoTransformer;
use App\Video;
use App\VideoStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VideoController extends ApiController
{
    protected $transformer;

    /**
     * VideoController constructor.
     * @param VideoTransformer $transformer
     */
    public function __construct(VideoTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function index()
    {
        $videos = Video::where(['user_id' => Auth::user()->id])->get();
        return $this->setStatusCode(200)
            ->respond($this->transformer->transformCollection($videos));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video' => 'file',
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
                    return $this->respondCreated($this->transformer->transform($video));
                }
            }
        }
        return $this->setStatusCode(500)
            ->respond(['validation_errors' => $validator->errors()]);
////            $frame = $video->frame(TimeCode::fromSeconds(10));
////            $frame->save(storage_path().'/image.jpg');
    }
}