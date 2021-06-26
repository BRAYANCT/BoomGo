<?php

use App\OrderState;
use Illuminate\Database\Seeder;

class OrderStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderState::insert(
            array(

                ['id'=>1,'name' => 'Pendiente de pago'],
                ['id'=>2,'name' => 'Pedido pagado'],
                ['id'=>3,'name' => 'Entregado'],
                ['id'=>4,'name' => 'Pago fallido'],
                ['id'=>5,'name' => 'Cancelado'],
            )

        );
    }
}
