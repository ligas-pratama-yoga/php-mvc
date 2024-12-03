<?php

namespace App\Core;

class Database
{
	public \PDO $connection;
	public function __construct()
	{
    $this->connection = new \PDO("mysql:host=127.0.0.1;dbname=sekolah", "root", "");
	}
}
