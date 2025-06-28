<?php

namespace App\Models\Vapp;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchCategory extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'match_categories';

    public function vapp_variations()
    {
        return $this->hasMany(VappVariation::class, 'match_category_id');
    }
    public function match_list()
    {
        return $this->hasMany(MatchList::class, 'match_category_id');
    }
}
