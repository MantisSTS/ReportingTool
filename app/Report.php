<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['client_id', 'title', 'author_id', 'summary', 'status_id', 'contributors'];
}
