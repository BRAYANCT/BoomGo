<?php

use App\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::insert(
            array(
                [
                    'name' => 'Mercado Pago',
                    'picture'=> 'visa-mastercard-amex.jpg',
                    'active' => 1
                ],
                [
                    'name' => 'Contra Entrega',
                    'picture'=> 'wire-transfer-white.png',
                    'active' => 1
                ],

                [
                    'name' => 'Transferencia bancaria',
                    'picture'=> 'wire-transfer-white.png',
                    'active' => 1
                ],

            )
        );
    }
}
