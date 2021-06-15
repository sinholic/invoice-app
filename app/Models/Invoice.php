<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "number",
        "issue_date",
        "due_date",
        "subject",
        "is_paid",
        "client_id"
    ];

    /**
     * Get the Client that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    /**
     * Get all of the Invoice Detail for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
    }
}
