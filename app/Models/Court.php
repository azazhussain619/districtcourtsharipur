<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function causeLists(){
        return $this->hasMany(CauseList::class);
    }

    public function judgements(){
        return $this->hasMany(Judgement::class);
    }
}
