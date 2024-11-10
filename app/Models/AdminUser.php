<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @desc admin_user table model
 * @package app\models
 */
class AdminUser extends Model
{
    use HasFactory;

    protected $table = 'admin_user';

    /**
     * whether auto set timestamp field
     *
     * @var bool
     */
    public $timestamps = false;
}
