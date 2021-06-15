<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * Get all of the Invoice Detail for the Item
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class, 'item_id', 'id');
    }
}
