<?php

namespace App\Jobs;

use App\Utilities\Ffmpeg\FfmpegBuilder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\Format\Video\WebM;

class TrimVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ffmpeg;
    protected $model;
    protected $from;
    protected $duration;
    protected $fileName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, $from, $duration, $fileName)
    {
        $this->model = $model;
        $this->from = $from;
        $this->duration = $duration;
        $this->fileName = $fileName;
        $this->ffmpeg = FfmpegBuilder::create();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->model->setStatus('processing');
        $video = $this->ffmpeg->open($this->model->path);
        $video->filters()->clip(TimeCode::fromSeconds($this->from), TimeCode::fromSeconds($this->duration));
        if
        (
            $video->save(new WebM(), public_path().'/storage/video/'.$this->fileName)
        )
        {
            $this->model->setStatus('done');
        }
        $this->model->setStatus('failed');
    }
}
