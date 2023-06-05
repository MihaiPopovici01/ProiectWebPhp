<?php


class Config{
    private $dbSettings;
    private $errorSettings;

    public function __construct(){
        $this->dbSettings = [
            'dbname' => 'slimphp',
            'user' => 'mihai',
            'password' => 'password',
            'host' => 'mysql',
            'driver' => 'pdo_mysql'
        ];
    }

    public function getDbConfig(){
        return $this->dbSettings;
    }
}