<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Item;
use App\Models\Client;

class CompleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory()
        ->count(5)
        ->create();

        Item::factory()
        ->food()
        ->count(5)
        ->create();

        Invoice::factory()
        ->for(Client::factory())
        ->count(50)
        ->create();

        InvoiceDetail::factory()
        ->for(Item::all()->random())
        ->for(Invoice::all()->random())
        ->count(5)
        ->create();

        InvoiceDetail::factory()
        ->for(Item::all()->random())
        ->for(Invoice::all()->random())
        ->count(5)
        ->create();

        InvoiceDetail::factory()
        ->for(Item::all()->random())
        ->for(Invoice::all()->random())
        ->count(5)
        ->create();
    }
}
