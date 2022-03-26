<?php
namespace App;

interface DbHandler {
  
    public function get_data($fields = array(),  $start = 0);
    public function disconnect();   
    public function get_record_by_id($primary_key);
    public function search($pname);
    
    
}