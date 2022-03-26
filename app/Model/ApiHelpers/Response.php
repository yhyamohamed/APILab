<?php

namespace App\ApiHelpers;

use App\MYSQLHandler;

class Response
{
    public function __construct()
    {
        $this->db = new MYSQLHandler;
    }
    public function handler($method, $id = null)
    {
        return match ($method) {
            'GET' => $this->get($id),
            'POST' => $this->create(),
            'PUT' => $this->edit($id),
            'DELETE' => $this->delete($id),
        };
    }
    public function get($id)
    {
        if ($id == -1) {
            return $this->db->index();
        } else {
            return $this->db->get_record_by_id($id);
        }
    }
    public function create()
    {
        $data = array();
        foreach ($_POST as $key => $value) {
            $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
         
      return  $this->store($data);
    }
    public function store($Product)
    {
        return $this->db->add($Product);
    }
    public function edit($id)
    {
        $oldData = $this->db->get_record_by_id($id);
       
        if (isset($oldData->id)) {
            parse_str(file_get_contents("php://input"), $post_vars);
            $submitedData = json_decode(file_get_contents("php://input"));
            $editeddata  = ([
                "id" => 17,
                "PRODUCT_code" => $submitedData->PRODUCT_code ?? $oldData->PRODUCT_code,
                "product_name" => $submitedData->product_name ?? $oldData->product_name,
                "Photo" => $submitedData->Photo ?? $oldData->Photo,
                "list_price" => $submitedData->list_price ?? $oldData->list_price,
                "reorder_level" => $submitedData->reorder_level ?? $oldData->reorder_level,
                "Units_In_Stock" => $submitedData->Units_In_Stock ?? $oldData->Units_In_Stock,
                "category" => $submitedData->category ?? $oldData->category,
                "CouNtry" => $submitedData->CouNtry ?? $oldData->CouNtry,
                "Rating" => $submitedData->Rating ?? $oldData->Rating,
                "discontinued" => $submitedData->discontinued ?? $oldData->discontinued,
                "date" => $submitedData->date ?? $oldData->date
            ]);
            return $this->update($id, $editeddata);
        } else {
            return $oldData;
        }
    }
    public function update($id,$data)
    {
        return $this->db->update($id,$data);
    }
    public function delete($id)
    {
        return $this->db->delete($id);
    }
}
