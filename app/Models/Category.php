<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get all of the fruits for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fruits(): HasMany
    {
        return $this->hasMany(Fruit::class, 'category_id');
    }
}
