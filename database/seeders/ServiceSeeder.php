<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Service::insert([
            ['name' => 'Haircut', 'description' => 'Professional haircut', 'price' => 20, 'status' => 'active'],
            ['name' => 'Massage', 'description' => 'Relaxing massage', 'price' => 50, 'status' => 'active'],
            ['name' => 'Manicure', 'description' => 'Nail care', 'price' => 30, 'status' => 'active'],
        ]);
    }
}
