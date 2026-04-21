<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_code',
        'borrower_name',
        'borrower_id_number',
        'borrower_program',
        'borrower_phone',
        'purpose',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Loan $loan): void {
            if (! $loan->loan_code) {
                $loan->loan_code = 'PJ-' . now()->format('Ymd') . '-' . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function loanItems(): HasMany
    {
        return $this->hasMany(LoanItem::class);
    }
}
