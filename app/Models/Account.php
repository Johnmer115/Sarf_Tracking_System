<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['username', 'usertype', 'password', 'status'])]
#[Hidden(['password', 'remember_token'])]
class Account extends Authenticatable
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get the organization linked to this account.
     */
    public function organization(): HasOne
    {
        return $this->hasOne(Organization::class);
    }
}
