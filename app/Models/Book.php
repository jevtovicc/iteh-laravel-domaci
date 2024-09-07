<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'publisher_id',
        'store_id',
        'price',
        'stock'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
