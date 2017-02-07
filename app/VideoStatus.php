<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoStatus extends Model
{
    /**
     * @var string
     */
    protected $table = 'video_statuses';

    /**
     * @var array
     */
    protected $fillable = ['status'];
}
