<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->index('estado');
            $table->index('prioridad');
            $table->index('created_at');
        });
    }
    
    public function down(): void
    {
        Schema::table('incidencias', function (Blueprint $table) {
            $table->dropIndex(['estado']);
            $table->dropIndex(['prioridad']);
            $table->dropIndex(['created_at']);
        });
    }
};