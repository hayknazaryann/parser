<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFile extends Model
{
    use HasFactory;
    protected $table = 'posts_files';
    public $timestamps = false;
    protected $fillable = ['file_link'];

}
