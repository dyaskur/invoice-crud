<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, InvoiceItem::class)
            ->withPivot(['quantity', 'price',]);
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
