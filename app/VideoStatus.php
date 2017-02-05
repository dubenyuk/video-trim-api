<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoStatus extends Model
{
    protected $table = 'video_statuses';

    protected $fillable = ['status'];
}
