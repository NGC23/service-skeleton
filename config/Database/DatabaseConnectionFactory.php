<?php

namespace Neil\Config\Database;

readonly class DatabaseConnectionFactory implements ConnectionFactoryInterface
{
    public function __construct(
        private string $host,
        private string $db,
        private string $username,
        private string $password
    )
    {
    }

    /**
     * @throws DatabaseConnectionException
     */
    public function create(): object
    {
        try {
            return new \PDO("mysql:host={$this->host};dbname={$this->db}", $this->username, $this->password);
        } catch(\Throwable $e) {
            throw new DatabaseConnectionException('unable to create database instance, error: ' .  $e->getMessage(), 0, $e);
        }
    }
}