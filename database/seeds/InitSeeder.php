<?php

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(RoleSeeder::class);

        $this->call(UserStatesSeeder::class);

        $this->call(UsersSeeder::class);

        $this->call(RolePermissionsSeeder::class);

        $this->call(CategoryTypesSeeder::class);

        $this->call(PriceRangesSeeder::class);

        $this->call(ProviderTypesSeeder::class);

        $this->call(OrderStatesSeeder::class);

        $this->call(PaymentMethodsSeeder::class);

        $this->call(DepartmentsSeeder::class);
        $this->call(ProvincesSeeder::class);
        $this->call(DistrictsSeeder::class);

        $this->call(BusinessCategoriesSeeder::class);

        $this->call(DocumentTypesSeeder::class);

    }
}
