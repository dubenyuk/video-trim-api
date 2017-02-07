<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\TrimVideo;

class Video extends Model
{
    /**
     * @var string
     */
    protected $table = 'videos';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'status_id', 'path',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status()
    {
        return $this->hasOne('App\VideoStatus','id','status_id');
    }

    /**
     * @param string $statusName
     * @return $this
     */
    public function setStatus($statusName)
    {
        $status = VideoStatus::where(['status' => $statusName])->first();
        $this->status_id = $status->id;
        $this->save();
        return $this;
    }

    /**
     * @param integer $from
     * @param integer $duration
     * @return bool
     */
    public function restart($from, $duration)
    {
        $this->setStatus('scheduled');
        $arr = explode('/',$this->path);
        $fileName = array_pop( $arr );
        return ( dispatch(new TrimVideo($this, $from, $duration, $fileName)) )? true : false;
    }
}
