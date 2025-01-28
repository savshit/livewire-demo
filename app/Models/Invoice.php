<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Fillable fields
    protected $fillable = [
        'amount', 
        'invoice_number', 
        'customer_email', 
        'status'
    ];

    // Casting for type safety
    protected $casts = [
        'amount' => 'decimal:2',
        'created_at' => 'datetime'
    ];

    // Status constants
    public const STATUS_DRAFT = 'Draft';
    public const STATUS_OUTSTANDING = 'Outstanding';
    public const STATUS_PAID = 'Paid';

    // Scopes for easy filtering
    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    // Scopes status outstanding
    public function scopeOutstanding($query)
    {
        return $query->where('status', self::STATUS_OUTSTANDING);
    }

    // scope status paid 
    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

}