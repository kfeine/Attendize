<?php

use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('order_statuses')->delete();
        Schema::enableForeignKeyConstraints();

        $order_statuses = [
            [
                'id' => 1,
                'name' => 'Finalisé',
            ],
            [
                'id' => 2,
                'name' => 'Remboursé',
            ],
            [
                'id' => 3,
                'name' => 'Partiellement remboursé',
            ],
            [
                'id' => 4,
                'name' => 'Annulé',
            ],
            [
                'id' => 5,
                'name' => 'En attente de paiement',
            ],
        ];

        DB::table('order_statuses')->insert($order_statuses);
    }
}
