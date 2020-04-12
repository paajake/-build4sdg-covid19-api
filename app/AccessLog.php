<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $table = "access_logs";
    protected $guarded = ["id"];
    protected $dateFormat = 'Y-m-d H:i:s.u';

    public function getResponseTimeAttribute()
    {
        return $this->updated_at->diffInMilliseconds($this->created_at);
    }
}
