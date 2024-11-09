<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Check extends Model
{
    use HasUuids;

    protected $fillable = array('name', 'author');
    public function Author(): HasOne
    {
        return $this->hasOne(User::class);    
    }
    public $timestamps = false;

}
