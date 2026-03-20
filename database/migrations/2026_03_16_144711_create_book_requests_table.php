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
        Schema::create('book_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pendente', 'aprovada', 'devolvida', 'rejeitada'])->default('pendente');
            $table->date('requested_at');
            $table->date('due_date')->nullable();    // data limite de devolução
            $table->date('returned_at')->nullable(); // data de devolução efetiva
            $table->timestamps();
        });

        // Adiciona campo de disponibilidade à tabela books
        Schema::table('books', function (Blueprint $table) {
            $table->boolean('available')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_requests');
    }
};
