<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Associate product with a user
        $table->string('name');
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->integer('inventory')->default(0);
        $table->string('sku')->nullable();
        $table->string('image')->nullable();
        $table->string('vendor');
        $table->boolean('is_pushed')->default(false);
        $table->timestamps();
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
