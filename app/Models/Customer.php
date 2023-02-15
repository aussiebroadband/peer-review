<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    public function application(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function getFullNameAttribute(): string
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function getPrimaryContactAttribute():Contact
    {
        return $this->contacts()->where('primary', true)->first();
    }

    public function getLatestApplicationAttribute(): Application
    {
        return $this->applications->latest()->first();
    }

    public function updateActiveStatus($active): void
    {
        $this->active = $active;
    }

}
