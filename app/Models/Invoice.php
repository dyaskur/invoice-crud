<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function issuer(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'issued_by');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'issued_for');
    }
}
