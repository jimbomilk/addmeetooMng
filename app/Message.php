<?php namespace App;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model {

    use SoftDeletes;

    protected $table = 'messages';
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates for softdeleting
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function location()
    {
        return $this->belongsTo('App\Location','location_id','id');
    }

}
