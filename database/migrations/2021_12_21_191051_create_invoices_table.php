<?php

use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function(Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('subject');
            $table->date('issue_date');
            $table->date('due_date');
            $table->decimal('sub_total', 12, 2);
            $table->smallInteger('tax_percentage')->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total_payment', 12, 2);
            $table->foreignIdFor(Company::class, 'issued_by')->constrained('companies');
            $table->foreignIdFor(Company::class, 'issued_for')->constrained('companies');
            $table->enum('status', ['draft', 'sent', 'paid', 'canceled']);
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
        Schema::dropIfExists('invoices');
    }
}
