<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    
    // Comments के लिए सुरक्षित फ़ील्ड
    protected $fillable = ['post_id', 'user_id', 'comment'];
    
    // Comment belongs to one Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    
    // Comment belongs to one User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}