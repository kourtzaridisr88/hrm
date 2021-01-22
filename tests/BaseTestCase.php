<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class BaseTestCase extends TestCase
{
    public $client;
    public $endpoint;
    
    public function __construct()
    {
        $this->client = new Client();
        $this->endpoint = 'http://hr.dev.kourtzaridis.me';
        parent::__construct();
    }
}