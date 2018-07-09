<?php

class DB{
    private $db;
    public function __construct(){
        $config = parse_ini_file(__DIR__."/../config.ini");
        $this->db = new \PDO($config['db.conn'], $config['db.user'], $config['db.pass']);
    }

    public function query($sql, $params=array()){
        $res = $this->db->prepare($sql);
        $res->execute($params);
        return $res->fetchAll(\PDO::FETCH_CLASS);
    }






}

