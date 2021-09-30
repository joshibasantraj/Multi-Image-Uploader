<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable=['pic'];

    public function getValidationRule(){
        return [
            'pic'=>'sometimes|image'
        ];
    }

    public function more_images(){
        return $this->hasMany('App\Models\MoreImage','ref_img','id');
    }
}
