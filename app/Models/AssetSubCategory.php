<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class AssetSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_name',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // Since it's an enum, casting is optional
    ];

    /**
     * Define the relationship with AssetCategory.
     */
    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }

}
