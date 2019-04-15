<?php
namespace traits;


trait database{


    protected $host;
    protected $user;
    protected $password;
    protected $connection;

    public function setconnection($host, $user, $password, $db_name){
        $this->mongo_host = $mongo_host;
    }

    protected function connect(){
        $this->connection = new MongoClient($this->mongo_host);
    }

    protected function selectcollection($database,$collection){
    	$this->connection = $this->connection->selectCollection($database,$collection);
    }

    protected function insertOne($array){
    $result = $this->connection->insertOne([
    'username' => 'admin',
    'email' => 'admin@example.com',
    'name' => 'Admin User',
	]);
    return $result;
    }

    protected function command($query){
       $result = $this->connection->command($query);
        
       return $result;
    }
    
    protected function closeConnection(){
       $this->connection->close();
    }   
}