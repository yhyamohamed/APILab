<?php

namespace App;

use App\DbHandler;
use Illuminate\Database\Capsule\Manager as Capsule;

class MYSQLHandler implements DbHandler
{
    var $db;

    public function __construct()
    {
        $capsule = new Capsule();
        $capsule->addConnection([
            "driver" => _driver,
            "host" => _host,
            "database" => _database,
            "username" => _username,
            "password" => ""
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        if (Capsule::getDatabaseName() == null) {
            throw new \PDOException();
        }
    }

    public function index()
    {
        try {
            return Capsule::table('items')->get();
        } catch (\PDOException $ex) {
            $cutmark = strpos($ex->getMessage(), '(S');
            return array('Error' => substr($ex->getMessage(),  16, $cutmark - 17));
        }
    }
    public function get_data($fields = array(),  $start = 0)
    {
        //if empty array is given then select all cols 
        $fields = (count($fields) > 0) ? $fields : '*';
        if (count($fields) > 0)
            $fields[] = 'id';
        $fields[] = 'Photo';
        //query starting from an index and to the length of a pre define rows numer
        return Capsule::table('items')->skip($start)
            ->take(_rec_per_page)
            ->select($fields)
            ->get();
    }

    public function add($product)
    {
        try {
            Capsule::table('items')->insert($product);
            return array('sucsess' => 'inserted');
        } catch (\PDOException $ex) {
            // return $ex->getMessage();
            $cutmark = strpos($ex->getMessage(), '(S');
            return array('Error' => substr($ex->getMessage(),  16, $cutmark - 17));
        }
    }
    public function get_record_by_id($primary_key)
    {

        try {
            $data =  Capsule::table('items')->select('*')->find($primary_key);
            if (!$data) throw new \PDOException();
            return $data;
        } catch (\PDOException $ex) {
            $cutmark = strpos($ex->getMessage(), '(S');
            if (!$ex->getMessage()) $msg = 'couldnt found that id';
            else $msg =  substr($ex->getMessage(),  16, $cutmark - 17);
            return array('Error' => $msg);
        }
    }


    public function update($id, $data)
    {
        try {
            Capsule::table('items')->where('id', $id)
                ->update($data);
            return array('sucsess' => 'updated');
        } catch (\PDOException $ex) {
            // return $ex->getMessage();
            $cutmark = strpos($ex->getMessage(), '(S');
            return array('Error' => substr($ex->getMessage(),  16, $cutmark - 17));
        }
    }
    public function delete($id)
    {
        
        try {
            $deleted = Capsule::table('items')->where('id', $id)->delete();
            if (!$deleted) throw new \PDOException();
            return array('sucsess' =>  'deleted');
        } catch (\PDOException $ex) {
            // return $ex->getMessage();
            $cutmark = strpos($ex->getMessage(), '(S');
            if (!$ex->getMessage()) $msg = 'couldnt found that id';
            else $msg =  substr($ex->getMessage(),  16, $cutmark - 17);
            return array('Error' => $msg);
        }
    }
    public function search($pname)
    {
        $found = Capsule::table('items')
            ->select('*')
            ->where('product_name', 'like', "%$pname%")
            ->orWhere('PRODUCT_code', 'like', "%$pname%")
            ->get();
        return $found;
    }
    public function disconnect()
    {
        Capsule::disconnect();
        $this->capsule = null;
    }
}
