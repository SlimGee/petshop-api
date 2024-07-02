<?php

namespace App\Services\Auth\Storage\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blacklist_entries';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }
}
