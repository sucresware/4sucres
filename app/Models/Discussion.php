<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $dates = ['last_reply_at'];

    public static function boot()
    {
        parent::boot();

        self::creating(function($discussion){
            $discussion->slug = Str::slug($discussion->title);

            return $discussion;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'ASC');
    }

    public function get_posts_count_attribute()
    {
        return $this->posts()
            ->selectRaw('discussion_id, count(*)-1 as total')
            ->groupBy('discussion_id');
    }

    public function scopeSticky($query){
        return $query
            ->where('sticky', true)
            ->orderBy('updated_at', 'DESC');
    }

    public function scopeOrdered($query){
        return $query
            ->where('sticky', false)
            ->orderBy('updated_at', 'DESC');
    }

    public function getPresentedLastReplyAtAttribute(){
        return str_replace('il y a', '', $this->last_reply_at->diffForHumans());
    }
}
