<?php 

// namespace Tests\Feature;

// use Tests\BaseTestCase;
// use GuzzleHttp\RequestOptions;

// final class DepartmentTests extends BaseTestCase
// {
//     public function testCanGetDepartments(): void
//     {
//         $response = $this->client->request('GET', "{$this->endpoint}/departments");

//         $this->assertEquals(200, $response->getStatusCode());
//     }

//     public function testCanStoreDepartment(): void
//     {
//         $department = [
//             'name' => 'Human Resources'
//         ];

//         $options = [
//             RequestOptions::JSON => $department
//         ];

//         $response = $this->client->request('POST', "{$this->endpoint}/departments", $department);
//         // var_dump($response->getBody());
//         // die;
//         $this->assertEquals(201, $response->getStatusCode());
//     }

//     public function testCanShowDepartment(): void
//     {
//         $response = $this->client->request('GET', "{$this->endpoint}/departments/1");

//         $this->assertEquals(200, $response->getStatusCode());
//     }

//     public function testCanUpdateDepartment(): void
//     {

//     }

//     public function testCanDeleteDepartment(): void
//     {
        
//     }
// }