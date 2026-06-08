<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Elimina la tabla `users` (modelo default de Laravel) que no se usa en el sistema.
 * La autenticación de administradores usa `usuarios` (modelo Usuarios) y la de
 * clientes usa `clientes` (modelo Cliente). Así se evita la confusión users/usuarios.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('users');
    }

    public function down(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
};
