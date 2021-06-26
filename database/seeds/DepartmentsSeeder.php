<?php

use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::insert(\DB::raw(
            "INSERT INTO `departments` (`id`, `name`) VALUES
			(1, 'AMAZONAS'),
			(2, 'ANCASH'),
			(3, 'APURIMAC'),
			(4, 'AREQUIPA'),
			(5, 'AYACUCHO'),
			(6, 'CAJAMARCA'),
			(7, 'CALLAO'),
			(8, 'CUSCO'),
			(9, 'HUANCAVELICA'),
			(10, 'HUANUCO'),
			(11, 'ICA'),
			(12, 'JUNIN'),
			(13, 'LA LIBERTAD'),
			(14, 'LAMBAYEQUE'),
			(15, 'LIMA'),
			(16, 'LORETO'),
			(17, 'MADRE DE DIOS'),
			(18, 'MOQUEGUA'),
			(19, 'PASCO'),
			(20, 'PIURA'),
			(21, 'PUNO'),
			(22, 'SAN MARTIN'),
			(23, 'TACNA'),
			(24, 'TUMBES'),
			(25, 'UCAYALI');"

        ));

    }
}
