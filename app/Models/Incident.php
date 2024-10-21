<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $table = 'incident';

    protected $fillable = [
        'ref_user',
        'ref_vendor_id',
        'ref_category',
        'latitude',
        'longitude',
        'value',
        'is_active',
        'dt_register'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'ref_user', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'ref_category', 'id');
    }
}
