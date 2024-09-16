<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private ?PDO $connection = null;

    private string $host;
    private string $dbName;
    private string $username;
    private string $password;

    /**
     * Database constructor.
     */
    private function __construct()
    {   
        // Read the configuration file and set the properties
        $config = parse_ini_file(__DIR__ . '/../config/.env');

        $this->host = $config['DB_HOST'];
        $this->dbName = $config['DB_NAME'];
        $this->username = $config['DB_USERNAME'];
        $this->password = $config['DB_PASSWORD'];
    }

    /** Static method to get the singleton instance
     * 
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        
        return self::$instance;
    }

    /** Method to get the PDO connection
     * 
     * @return PDO|null
     */
    public function getConnection(): ?PDO
    {

        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbName}",
                    $this->username,
                    $this->password
                );
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        return $this->connection;
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing the instance
    private function __wakeup() {}
}
