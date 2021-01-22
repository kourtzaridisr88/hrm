<?php

namespace Tests\Feature;

use Tests\BaseTestCase;
use GuzzleHttp\RequestOptions;

class EmployeeTest extends BaseTestCase
{
    public $id;
    
    public function testCanGetEmployees()
    {
        $response = $this->client->request('GET', "{$this->endpoint}/employees");
        
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanStoreEmployee(): void
    {
        $employee = [
            'name' => 'Awesome Employee',
            'position' => 'Head of Engineering',
            'salary' => '250000',
            'department_id' => '1'
        ];

        $options = [
            RequestOptions::JSON => $employee
        ];

        $response = $this->client->request('POST', "{$this->endpoint}/employees", $options);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testCanShowEmployee(): void
    {
        $response = $this->client->request('GET', "{$this->endpoint}/employees/1");

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCanUpdateEmployee(): void
    {
        $employee = [
            'name' => 'Awesome Employee Edit',
            'position' => 'Head of Engineering Edit',
            'salary' => '500000'
        ];

        $options = [
            RequestOptions::JSON => $employee
        ];

        $response = $this->client->request('PUT', "{$this->endpoint}/employees", $employee);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testCanDeleteEmployee(): void
    {
        $response = $this->client->request('DELETE', "{$this->endpoint}/employees/{$this->id}");

        $this->assertEquals(204, $response->getStatusCode());
    }   
}