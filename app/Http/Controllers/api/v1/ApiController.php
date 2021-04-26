<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\People;
use App\Models\IncidentPeopleInvolved;
use App\Models\Incident;

class ApiController extends Controller
{
    //
    // API        : Get incidents 
    // URL        : http://localhost/incident_api/public/api/v1/incident
    // Method     : GET
    // Returns    : status, message, incidents
    // Status     : 1 - Sucess
    public function getIncidents(){
    	$incidents 	= Incident::with('category', 'people_involved')->get();    	
    	$output		= array('status'=>1,'message'=>'Success', 'incidents'=>$incidents);
        return response()->json($output, 200);  
    }


    // API        : Stor incidents 
    // URL        : http://localhost/incident_api/public/api/v1/incident
    // Method     : Post
    // Parameters : title, location, category, people, comments, incident_date
    // Returns    : status, message, incident
    // Status     : 0 - Empty fileds, 1 - Sucess
    // Note       :  1. location will be json string like {"latitude": 12.9231501, "longitude": 74.7818517}
    //               2. people will be json string like [{"name": "Name of person 1", "type": "staff"},{"name": "Name of person 2 ","type": "witness" },{"name": "Name of person 3", "type": "staff"}]
    public function storeIncidents(Request $request){
    	$data = $request->all();
        
    	if(isset($data['title']) && isset($data['category']) && isset($data['location']) && isset($data['incident_date']) && isset($data['comments']) && isset($data['people'])){
    		$insertData['title'] 			= $data['title'];
    		$insertData['location'] 		= $data['location'];
    		$insertData['incident_date'] 	=  date('Y-m-d H:i:s', strtotime($data['incident_date']));
    		$insertData['comments'] 		= $data['comments'];
    		$insertData['category_id'] 		= $data['category'];
    		$new_incident 	 				= Incident::insertGetId($insertData);
    		$people 						= json_decode($data['people'], true);
    		foreach($people as $row){
	    		$new_people = People::firstOrCreate(
				    ['name' => $row['name'], 'type' => $row['type']],
				    ['name' => $row['name'], 'type' => $row['type']]
				);
				IncidentPeopleInvolved::insert(['incident_id'=>$new_incident, 'people_id'=>$new_people['id']]);
		    }
			

			$incident 	= Incident::with('category', 'people_involved')->find($new_incident);   
    		$output		= array('status'=>1,'message'=>'Success', 'incident'=>$incident);
    	}
    	else{
    		$output = array('status'=>0,'message'=>'Emprty fileds.');
    	}	
    	
        return response()->json($output, 201);  
    }
}
