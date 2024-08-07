<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $fillable = [
        'id',
        'name',
        'brand_id',
        'category_id',
        'users_create_id',
        'users_update_id',
    ];

    public function images()
    {
        return $this->hasMany(SystemFile::class, 'reference_id', 'id')->where('reference', '=', 'products');
    }
}
