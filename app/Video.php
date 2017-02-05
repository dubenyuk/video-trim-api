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
}
