<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'client_name', 'client_email',
        'client_phone', 'service', 'appointment_date',
        'duration', 'status', 'notes',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'Completed'  => 'success',
            'Cancelled'  => 'danger',
            default      => 'primary',
        };
    }
}
