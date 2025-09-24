<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DownloadLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'downloadable_id', 'user_id', 'ip_address', 'user_agent', 'referer'
    ];

    public function downloadable()
    {
        return $this->belongsTo(Downloadable::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}