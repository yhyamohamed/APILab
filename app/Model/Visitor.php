<?php
namespace App;

class Visitor{
    var $db;
    var $userName;
    var $pass;
    var $visited;

    public function __construct()
    {
      
           mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
           $this->db = mysqli_connect("localhost","root","","Lab3");
           if($this->db->connect_errno){
            throw new \RuntimeException('mysqli error: ' . $this->db->error);
           }
    }

    public function  getUserName(){
        return $this->userName;
    }
    public function  getpass(){
        return $this->pass;
    }
    public function  visited(){
        return $this->visited;
    }

    public function setusername($n){
        $this->userName =$n;
    }
    public function setpassword($n){
        $this->pass  =$n;
    }

    public function logIn(){
        $result = mysqli_query($this->db ,"select * from Visitors where ( user_name='".$this->getusername()."') and pass ='".$this->getpass()."'" );
        return $result;
    }
   
    public function rememberMe()
    {
        setcookie("user_name",$this->getUserName(),time()+60*60);
        setcookie("pass",$this->getpass(),time()+60*60);
    }
    public function logout(){
        setcookie("user_name",$this->getUserName(),-60);
        setcookie("pass",$this->getpass(),-60);
        session_destroy();
        header("Location:login.php");
    }
}
