<?php

namespace App\Models\Api;

class Customer extends \App\Models\Customer
{
    protected $appends = [
      'full_name'  ,
    ];

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
