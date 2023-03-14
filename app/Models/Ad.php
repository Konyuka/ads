<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'product_information';

    // protected $fillable = [
    //     'name',
    //     'description',
    //     'price',
    // ];

    public function productInformation()
    {
        return $this->hasOne(ProductInformation::class);
    }
}
