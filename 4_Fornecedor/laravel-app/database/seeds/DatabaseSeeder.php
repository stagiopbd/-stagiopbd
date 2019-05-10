<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
	//Ordered according to foreign keys (keep that in mind)
	$this->call(ProductTypeTableSeeder::class);
	$this->call(SupplierTypeTableSeeder::class);
	$this->call(StripeTableSeeder::class);
	$this->call(TherapeuticClassTableSeeder::class);
	$this->call(PersonTableSeeder::class);
	$this->call(SupplierTableSeeder::class);
	$this->call(MedicineTableSeeder::class);
	$this->call(ExamGroupTableSeeder::class);
	$this->call(ExamItemTableSeeder::class);
	$this->call(ExamSubitemTableSeeder::class);
	$this->call(ExamTypeTableSeeder::class);
    }
}
