<?php

class ProfileModel{
    protected static $table = 'profiles';

    public function insert($cols, $val, $params){
        $db = new DB();
        $sql = "INSERT INTO ".static::$table."($cols) VALUES($val)";
        return $db->query($sql, $params);
    }

    public static function getAll(){
        $db = new DB();
        $sql = "SELECT * FROM ".static::$table;
        return $db->query($sql);
    }

    public static function getOne($id){
        $db = new DB();
        $sql = "SELECT * FROM ".static::$table." WHERE id = :id";
        return $db->query($sql, array(':id'=>$id));
    }

    public static function search($val, $field){
        $db = new DB();
        $sql = "SELECT * FROM ".static::$table." WHERE $field LIKE :val";
        return $db->query($sql, array(':val'=>$val));
    }




}