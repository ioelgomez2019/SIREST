<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Renombra la tabla `persona` (clientes del e-commerce) a `clientes` para evitar
 * la confusión con `usuarios` (administradores del backend).
 *
 * También renombra la columna PK `idpersona` -> `idcliente` y las columnas FK que
 * la referencian: ventas.idpersona, factura.idpersona -> idcliente y
 * pedido.personaid -> clienteid, recreando las llaves foráneas correspondientes.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1) Quitar las FK que apuntan a persona.idpersona
        DB::statement('ALTER TABLE `ventas` DROP FOREIGN KEY `fk_persona_venta`');
        DB::statement('ALTER TABLE `factura` DROP FOREIGN KEY `fk_fa_per`');
        DB::statement('ALTER TABLE `pedido` DROP FOREIGN KEY `pedido_ibfk_1`');

        // 2) Renombrar la tabla
        DB::statement('RENAME TABLE `persona` TO `clientes`');

        // 3) Renombrar la PK y las columnas FK (preservando definiciones exactas)
        DB::statement('ALTER TABLE `clientes` CHANGE `idpersona` `idcliente` bigint NOT NULL AUTO_INCREMENT');
        DB::statement('ALTER TABLE `ventas`   CHANGE `idpersona` `idcliente` bigint NOT NULL');
        DB::statement('ALTER TABLE `factura`  CHANGE `idpersona` `idcliente` bigint NULL DEFAULT NULL');
        DB::statement('ALTER TABLE `pedido`   CHANGE `personaid` `clienteid` bigint NOT NULL');

        // 4) Recrear las FK apuntando a clientes.idcliente (conservando reglas originales)
        DB::statement('ALTER TABLE `ventas`  ADD CONSTRAINT `fk_cliente_venta` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`)');
        DB::statement('ALTER TABLE `factura` ADD CONSTRAINT `fk_fa_cli` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`)');
        DB::statement('ALTER TABLE `pedido`  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`clienteid`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE');

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::statement('ALTER TABLE `ventas`  DROP FOREIGN KEY `fk_cliente_venta`');
        DB::statement('ALTER TABLE `factura` DROP FOREIGN KEY `fk_fa_cli`');
        DB::statement('ALTER TABLE `pedido`  DROP FOREIGN KEY `pedido_ibfk_1`');

        DB::statement('ALTER TABLE `pedido`   CHANGE `clienteid` `personaid` bigint NOT NULL');
        DB::statement('ALTER TABLE `factura`  CHANGE `idcliente` `idpersona` bigint NULL DEFAULT NULL');
        DB::statement('ALTER TABLE `ventas`   CHANGE `idcliente` `idpersona` bigint NOT NULL');
        DB::statement('ALTER TABLE `clientes` CHANGE `idcliente` `idpersona` bigint NOT NULL AUTO_INCREMENT');

        DB::statement('RENAME TABLE `clientes` TO `persona`');

        DB::statement('ALTER TABLE `ventas`  ADD CONSTRAINT `fk_persona_venta` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`)');
        DB::statement('ALTER TABLE `factura` ADD CONSTRAINT `fk_fa_per` FOREIGN KEY (`idpersona`) REFERENCES `persona` (`idpersona`)');
        DB::statement('ALTER TABLE `pedido`  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`personaid`) REFERENCES `persona` (`idpersona`) ON DELETE CASCADE ON UPDATE CASCADE');

        Schema::enableForeignKeyConstraints();
    }
};
