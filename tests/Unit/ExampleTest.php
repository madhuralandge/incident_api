<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_incidents()
    {        
        $response = $this->get(route('incident.get'));
        $response->assertStatus(201);
        $response->assertSee('Beta');
        $response->assertDontSee('Alpha');
    }

    public function test_create_incident()
    {
        $formData = [
            "title"=>"Ttile 8",
            "location"=>'{"latitude": 12.9231501, "longitude": 74.7818517}',
            "category"=> "1",
            "people"=>'[{"name": "Name of person 1", "type": "staff"},{"name": "Name of person 2 ","type": "witness" },{"name": "Name of person 3", "type": "staff"}]', 
            "comments"=>"test",
            "incident_date"=>"2020-09-01 13:26:00"
        ];
        $response = $this->post(route('incident.store'), $formData);
        $response->assertStatus(201);
        $response->assertSee('Beta');
        $response->assertDontSee('Alpha');
    }

    
}
