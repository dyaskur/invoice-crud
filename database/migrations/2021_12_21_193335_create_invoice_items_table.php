<?php

use App\Models\Invoice;
use App\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function(Blueprint $table) {
            $table->id();
            $table->smallInteger('quantity');
            $table->decimal('price', 8, 2);
            $table->foreignIdFor(Item::class)->constrained();
            $table->foreignIdFor(Invoice::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
