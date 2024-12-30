<?php

namespace App\Models;

abstract class BaseModel
{
    protected $db;
    protected $table;
    protected $primaryKey;
    protected $fillable = [];

    public function __construct($db)
    {
        $this->db = $db;
    }

    protected function validateData(array $data): array
    {
        return array_intersect_key($data, array_flip($this->fillable));
    }

    protected function buildQueryParams(array $data): array
    {
        $params = [];
        foreach ($data as $key => $value) {
            $params[":$key"] = $value;
        }
        return $params;
    }
}
