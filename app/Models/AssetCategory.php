<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class AssetCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // Since it's an enum, casting is optional
    ];

    public function subCategories()
    {
        return $this->hasMany(AssetSubCategory::class, 'category_id');
    }
}
