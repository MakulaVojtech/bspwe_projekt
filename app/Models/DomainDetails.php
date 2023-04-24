<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainDetails extends Model
{

    protected $fillable = [
        'domain_name',
        'ftp_user',
        'ftp_password',
        'db_name',
        'db_user',
        'db_password'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
