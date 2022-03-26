<?php

namespace App\ApiHelpers;

use App\ApiHelpers\Response;

class Router
{
    protected $routs =
    [
        'items' => 'items.php'
    ];
    protected $allowedMethods =
    [
        "GET" => "GET", "POST" => "POST", "DELETE" => "DELETE", "PUT" => "PUT"
    ];
    private $method;
    private $path;
    private $responseObj;
    private $resourceID;
    public function __construct()
    {
        $this->path = $this->isAvalidPath();
        $this->method = $this->Methodllowed();


        if ($this->isAvalidPath() && $this->Methodllowed()) {
            $this->responseObj = new Response;
            $this->sendResponse(200);
        } else if (!$this->isAvalidPath()) {
            $this->sendResponse(404);
        } else if (!$this->Methodllowed()) {
            $this->sendResponse(405);
        }
    }
    //get path
    public function isAvalidPath()
    {
        // http://localhost/webServices/lab2-2/GlassShopApi.php/items/100
        $pos =  stripos($_SERVER['REQUEST_URI'], 'GlassShopApi.php');
        $pathParts =  substr($_SERVER['REQUEST_URI'], $pos);

        // GlassShopApi.php/items/100
        $reqArr = explode("/", trim($pathParts, '/')); //[GlassShopApi.php,items,100]

        if (array_key_exists($reqArr[1], $this->routs)) {
            if (!isset($reqArr[2]) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                $reqArr[2] = -1;
            }
            if (!isset($reqArr[2]) && $_SERVER['REQUEST_METHOD'] != 'POST') {
                $this->sendResponse(422);
            }

            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                $this->resourceID = $reqArr[2];
            }

            return $this->routs[$reqArr[1]];
        } else {
            return null;
        }
    }
    //get method 
    public function Methodllowed()
    {

        if (array_key_exists($_SERVER['REQUEST_METHOD'], $this->allowedMethods)) {

            return $this->allowedMethods[$_SERVER['REQUEST_METHOD']];
        } else {
            return null;
        }
    }
    //response 
    public function sendResponse($resStatus)
    {
        http_response_code($resStatus);
        header('Content-Type: application/json');
        $data = match ($resStatus) {
            200 => $this->responseObj->handler($this->method, $this->resourceID),
            504 => array("Error" => "not cool , thats not allowed method"),
            404 => array("Error" => "WTF dude! choose write path"),
            422 => array("Error" => "missing a required parameter")
        };
        $response = json_encode($data);
        // if(!isset($data['Error']))
        // $logMsg = $data['Error'] ?? 'Success';

        // $this->logInFile($_SERVER['REQUEST_METHOD'], $logMsg);
        echo $response;
        exit;
    }
    function logInFile($method, $log_msg)
    {

        $data_to_log = "User ip: " . $_SERVER['REMOTE_ADDR'] . PHP_EOL . 'date : ' . date("F j, Y, g:i a") . PHP_EOL .
            "Attempt: " . $method . PHP_EOL .
            "result: " . ($log_msg) . PHP_EOL .
            "-------------------------" . PHP_EOL;

        file_put_contents('./log_' . date("j.n.Y") . '.log', $data_to_log, FILE_APPEND);

        // file_put_contents('../../../log.txt', $data_to_log, FILE_APPEND);
    }
}
