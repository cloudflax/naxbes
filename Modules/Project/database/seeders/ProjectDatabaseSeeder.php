<?php

namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Project\Models\Interfaces\IProject;

/**
 * Class ProjectDatabaseSeeder
 *
 * Seeds the 'projects' table with initial data. This class is responsible for populating the
 * table with predefined project records, which is useful for setting up the database with
 * some initial data during development or testing.
 *
 * @package Modules\Project\Database\Seeders
 */
class ProjectDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method is called when running the db:seed Artisan command. It inserts predefined
     * project records into the 'projects' table. The method uses the IProject interface to 
     * interact with the model, ensuring adherence to the defined contract for project models.
     *
     * @param IProject $project An instance of the IProject interface for interacting with the model.
     * @return void
     */
    public function run(IProject $project): void
    {
        $projects = [
            [
                'name'        => 'Gestión de Relaciones con Clientes (CRM)',
                'description' => 'La Gestión de Relaciones con Clientes (CRM) es una estrategia de negocio centrada en el cliente que se apoya en un conjunto de aplicaciones software para gestionar y optimizar las interacciones con los clientes actuales y potenciales.',
                'owner_id'    => 1,
                'status'      => 'active',
            ],
            [
                'name'        => 'Facturación Electrónica',
                'description' => 'La Facturación Electrónica es un proceso que permite la emisión y gestión de facturas en formato digital, reemplazando el uso de facturas en papel. Este sistema utiliza tecnologías de la información para generar, firmar digitalmente y transmitir comprobantes fiscales de manera electrónica.',
                'owner_id'    => 1,
                'status'      => 'active',
            ],
            [
                'name'        => 'Plataforma de Comercio Electrónico',
                'description' => 'Plataforma de Comercio Electrónico (E-commerce) es un software que facilita la creación y gestión de tiendas en línea, permitiendo a las empresas vender sus productos o servicios a través de Internet. Estas plataformas proporcionan la infraestructura necesaria para mostrar productos, procesar pedidos y gestionar transacciones de forma segura.',
                'owner_id'    => 1,
                'status'      => 'active',
            ]
        ];

        foreach ($projects as $record) {
            $project::newBuilder()->create($record);
        }
    }
}
