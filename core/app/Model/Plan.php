<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * The users that belong to the plan.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('id', 'last_sum', 'status', 'expire_date')->withTimestamps();
    }
}
