<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class JsonModel extends Model
{
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
