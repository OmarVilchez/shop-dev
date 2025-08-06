<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_number')->unique();

            // Cliente o Empresa
            $table->enum('client_type', ['person', 'company']);
            $table->string('contact_name');
            $table->string('contact_phone')->nullable();
            $table->string('contact_document')->nullable();
            $table->string('contact_email')->nullable();

            // Información general
            $table->date('quote_date');

            // Condiciones comerciales
            $table->string('currency', 10)->default('SOLES');
            $table->string('payment_type')->nullable();             // Ej: ADELANTO 80%
            $table->string('payment_method')->default('TRANSFERENCIA DIRECTA BCP, INTERBANK Y YAPE');
            $table->string('quote_validity')->nullable();           // Ej: 5 DÍAS
            $table->string('delivery_time')->nullable();            // Ej: 3 A 5 DÍAS HÁBILES
            $table->string('delivery_considerations')->default('TRASLADO A AGENCIA / ENVÍO / DELIVERY TIENE COSTO ADICIONAL');
            $table->string('service')->nullable();                  // Ej: SUBLIMACIÓN, DISEÑO
            $table->longText('note')->nullable();                       // Ej: LOS PRODUCTOS VIENEN EN CAJITA

            // Totales (opcional)
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('igv', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();


            // Seguimiento
            $table->enum('status', ['draft', 'sent', 'accepted', 'rejected'])->default('draft');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
