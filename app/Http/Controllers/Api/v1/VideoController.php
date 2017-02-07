<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\ApiController;
use App\Jobs\TrimVideo;
use App\Utilities\Ffmpeg\FfmpegBuilder;
use App\Utilities\Transformer\VideoTransformer;
use App\Video;
use App\VideoStatus;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

class VideoController extends ApiController
{
    protected $transformer;
    protected $ffmpeg;

    /**
     * VideoController constructor.
     * @param VideoTransformer $transformer
     */
    public function __construct(VideoTransformer $transformer)
    {
        $this->transformer = $transformer;
        $this->ffmpeg = FfmpegBuilder::create();
    }

    public function index()
    {
        $videos = Video::where(['user_id' => Auth::user()->id])->get();
        return $this->setStatusCode(200)
            ->respond(['data' => $this->transformer->transformCollection($videos)]);
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
        return $this->respondValidationErrors($validator->errors());
    }

    public function restart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_id' => 'required|integer',
            'from' => 'required|integer',
            'duration' => 'required|integer'
        ]);

        if(!$validator->fails())
        {
            $video = Video::where(['id' => $request->video_id])
                ->first();

            if( $video->status->status == 'failed' )
            {
                if( $video->restart($request->from, $request->duration) )
                {
                    return $this->setStatusCode(200)
                        ->respond(['message' => 'Video will be restarted']);
                }
            }
            return $this->respondInternalError('Video is not failed.');
        }
        return $this->respondValidationErrors($validator->errors());
    }

    public function frame(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video' => 'required|file',
            'second' => 'required|integer'
        ]);

        if(!$validator->fails())
        {
            $video = $this->ffmpeg->open($request->video);
            $frame = $video->frame(TimeCode::fromSeconds($request->second));
            $frame->save(public_path().'/image.jpg');
            $image = File::get(public_path().'/image.jpg');

            return response($image, 200, ['content-type' => 'image/jpg']);
        }

        return $this->respondValidationErrors($validator->errors());
    }
}