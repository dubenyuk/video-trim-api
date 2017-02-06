<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = [
        'user_id', 'status_id', 'path',
    ];

    public function status()
    {
        return $this->hasOne('App\VideoStatus');
    }

    public function setStatus($statusName)
    {
        $status = VideoStatus::where(['status' => $statusName])->first();
        $this->status_id = $status->id;
        $this->save();
    }
}
