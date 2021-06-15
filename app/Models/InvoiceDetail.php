<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "item_id",
        "invoice_id",
        "quantity",
    ];

    /**
     * Get the Item that owns the InvoiceDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    /**
     * Get the Invoice that owns the InvoiceDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo(User::class, 'invoice_id', 'id');
    }
}
