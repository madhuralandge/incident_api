<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;
    public $timestamps      = true;
    protected $table 		= 'incidents';
    protected $fillable 	= ['id', 'title', 'category_id ', 'location', 'comments', 'incident_date'];

    public function category(){
    	return $this->hasOne('App\Models\Category', 'id', 'category_id')->select(array('id', 'name',));
    }

    public function getLocationAttribute($value){
    	return json_decode($value, true);
    }
    public function people_involved()
    {
        return $this->belongsToMany('App\Models\People', 'incident_people_involved', 'incident_id', 'people_id')->select(array('name', 'type'));
    }
}
