<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Mass assignment के लिए सुरक्षित फ़ील्ड
    protected $fillable = ['user_id', 'title', 'content'];

    // Post belongs to one User (लेखक)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Post has many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}