<?php

use Illuminate\Database\Seeder;

class PaymentGatewayScelliusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_gateways = [
            [
                'id' => 5,
                'name' => 'Scellius',
                'provider_name' => 'Scellius Gateway Service',
                'provider_url' => 'https://www.labanquepostale.fr/associations-gestionnaires/services/dons_cotisations/paiement_distance/paiement_securise_internet.avantages.html',
                'is_on_site' => 0,
                'can_refund' => 0,
            ],
        ];

        DB::table('payment_gateways')->insert($payment_gateways);
    }
}
