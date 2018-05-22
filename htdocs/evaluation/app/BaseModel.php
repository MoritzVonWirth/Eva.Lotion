<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BaseModel extends Model {

    public static function selectQuery($sql_stmt) {
        return DB::select($sql_stmt);
    }

    public static function sqlStatement($sql_stmt) {
        DB::statement($sql_stmt);
    }
}