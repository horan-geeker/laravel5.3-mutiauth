<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'thumbnail', 'read_count', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function getAuthorAttribute()
    {
        return $this->user->name;
    }

    public function getTypeAttribute()
    {
        return $this->tag->type;
    }

    public function getLessContentAttribute()
    {
        return mb_substr($this->content,0,40,'utf8');
    }
}
