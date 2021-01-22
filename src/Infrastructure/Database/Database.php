<?php

namespace Hr\Infrastructure\Database;

use PDO;
use Hr\Infrastructure\Contracts\ShouldTerminateInterface;

class Database implements ShouldTerminateInterface
{
    /**
     * The database host.
     * 
     * @var string
     */
    private $host;

    /**
     * The database name.
     * 
     * @var string
     */
    private $database;

    /**
     * The database user.
     * 
     * @var string
     */
    private $user;

    /**
     * The database password.
     * 
     * @var string
     */
    private $password;

    /**
     * The PDO connection.
     * 
     * @var PDO
     */
    private $connection;

    /**
     * This object instance.
     * 
     * @var string
     */
    public static $INSTANCE;

    /**
     * Create's a new database instance.
     * 
     * @var string
     */
    private function __construct() 
    {
        $this->host = $_ENV['DB_HOST'];
        $this->database = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];

        $this->connect();
    }

    /**
     * Create's a singleton database instance.
     * 
     * @var string
     */
    public static function instance() 
    {
        if (!isset(static::$INSTANCE)) {
            static::$INSTANCE = new self();
        }

        return static::$INSTANCE;
    }

    /**
     * Connect's to the database.
     * 
     * @return void
     */
    public function connect(): void
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database}";
        $user = $this->user;
        $passwd = $this->password;

        $this->connection = new PDO($dsn, $user, $passwd);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * Query a statement to the database.
     * 
     * @param string $sql
     * @param array $values The values to bind.
     * @return array
     */
    public function query($sql, $values = []): array
    {
        $stmt = $this->prepare($sql);
        $stmt = $this->bindParams($stmt, $values);
        
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute a statement to the database.
     * 
     * @param string $sql
     * @param array $values The values to bind.
     * @return array
     */
    public function execute($sql, $values)
    {
        $stmt = $this->prepare($sql);
        $stmt = $this->bindParams($stmt, $values);
        
        $stmt->execute();
    }

    /**
     * Prepare's a statement for sending to the database.
     * 
     * @param string $sql
     * @return \PDOStatement
     */
    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }

    /**
     * Bind's values to the statement.
     * 
     * @param string $stmt
     * @param array $values
     * @return \PDOStatement
     */
    public function bindParams($stmt, $values)
    {
        foreach ($values as $key => &$value) {
            $stmt->bindParam(':' . $key, $value);
        }
        
        return $stmt;
    }

    /**
     * Close the connection.
     * 
     * @return void
     */
    public function terminate(): void
    {
        $this->connection = null;
    }
}