<?php namespace App;



use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    protected $table = 'messages';
    protected $guarded = ['id'];
    static $searchable = ['stext','ltext'];
    protected $path = 'message';

    /**
     * The attributes that should be mutated to dates for softdeleting
     *
     * @var array
     */

    public function location()
    {
        return $this->belongsTo('App\Location','location_id','id');
    }

    public function getLocalStartAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $start = Carbon::parse($this->start);
        $ret = $start->addHours($localoffset)->format('Y-m-d\TH:i');
        return $ret;
    }
    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getVisibleStartAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $start = Carbon::parse($this->start);
        $ret = $start->addHours($localoffset)->format('d-M');
        return $ret;
    }

    public function getLocalEndAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $end = Carbon::parse($this->end);
        $ret = $end->addHours($localoffset)->format('Y-m-d\TH:i');
        return $ret;
    }
    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getVisibleEndAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $end = Carbon::parse($this->end);
        $ret = $end->addHours($localoffset)->format('d-M');
        return $ret;
    }

    public function getUTCStart()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $start = Carbon::parse($this->start);
        $ret = $start->subHours($localoffset);
        return $ret;
    }

    public function getUTCEnd()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $end = Carbon::parse($this->end);
        $ret = $end->subHours($localoffset);
        return $ret;
    }

    public function getPathAttribute()
    {
        return $this->table.'/'.$this->path.$this->id;
    }
}
