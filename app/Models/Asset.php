<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_name',
        'asset_category_id',
        'asset_sub_category_id',
        'asset_image',
        'quantity',
        'pricing',
        'in_use',
        'in_stock',
        'is_disabled',
        'is_lost',
        'lost_approved',
        'warranty_from',
        'warranty_to',
        'note',
        'status',
    ];

    protected $casts = [
        'warranty_from' => 'date',
        'warranty_to' => 'date',
        'status' => 'string', // Since it's an enum, casting is optional
    ];

    /**
     * Define the relationship with AssetCategory.
     */
    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }

    /**
     * Define the relationship with AssetSubCategory.
     */
    public function subCategory()
    {
        return $this->belongsTo(AssetSubCategory::class, 'asset_sub_category_id');
    }
}
