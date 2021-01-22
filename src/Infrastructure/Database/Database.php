<?php

namespace Hr\Infrastructure\Database;

use PDO;
use Hr\Infrastructure\Contracts\ShouldTerminateInterface;

class Database implements ShouldTerminateInterface
{
    private $host;
    private $database;
    private $user;
    private $password;
    private $connection;

    public static $INSTANCE;

    private function __construct() 
    {
        $this->host = $_ENV['DB_HOST'];
        $this->database = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];

        $this->connect();
    }

    public static function instance() 
    {
        if (!isset(static::$INSTANCE)) {
            static::$INSTANCE = new self();
        }

        return static::$INSTANCE;
    }

    public function connect()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database}";
        $user = $this->user;
        $passwd = $this->password;

        $this->connection = new PDO($dsn, $user, $passwd);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    public function query($sql, $values = []) 
    {
        $stmt = $this->prepare($sql);
        $stmt = $this->bindParams($stmt, $values);
        
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute($sql, $values)
    {
        try {
            $stmt = $this->prepare($sql);
            $stmt = $this->bindParams($stmt, $values);
            
            $stmt->execute();
        } catch(\Exception $e) {
            var_dump($e->getMessage());
            die;
        }
    }

    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }

    public function bindParams($stmt, $values)
    {
        foreach ($values as $key => &$value) {
            $stmt->bindParam(':' . $key, $value);
        }
        
        return $stmt;
    }

    public function terminate(): void
    {
        $this->connection = null;
    }
}