<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'reviews';
    public $timestamps = true;
    /**
     * Field to be mass-assigned.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'author_id', 'hotel_id'];

    /**
     * Used for get author data that given the review
     */
    public function authorget(){
        return $this->belongsTo('App\Models\User', 'author_id');
    }
}
