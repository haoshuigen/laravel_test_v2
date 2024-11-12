<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SqlExecutionLog extends Model
{
    use HasFactory;

    protected $fillable = ['user', 'sql', 'time', 'error', 'create_time'];

    protected $table = 'sql_execution_log';

    /**
     * @var bool
     */
    public $timestamps = false;
}
