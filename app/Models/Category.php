<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'product_id',
        'description',
        'type',
        'regex_validation'
    ];

    public $timestamps = false;

    public function getForeignKey()
    {
        return 'ref_category';
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
}
