<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentPeopleInvolved extends Model
{
    use HasFactory;
    protected $table 		= 'incident_people_involved';
    protected $fillable 	= ['id', 'incident_id', 'peolple_id'];

    public function people()
    {
        return $this->belongsTo('App\Models\People', 'id', 'peolple_id')->select(array('name', 'type'));
    }

    public function incidents()
    {
        return $this->belongsTo('App\Models\Incident', 'id', 'incident_id');
    }
}
