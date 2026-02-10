<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GitState extends Model
{
    protected $table = 'git_state';
    protected $primaryKey = 'project_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    public $timestamps = false;
}
