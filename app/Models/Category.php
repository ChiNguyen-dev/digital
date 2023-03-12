<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['cate_name', "parent_id", 'slug', 'delete_at'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function categoryChildrent(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
