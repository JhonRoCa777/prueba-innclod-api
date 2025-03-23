<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::create([
            'fullname' => 'Jhonatan Romero',
            'document' => '1234567890',
            'email' => 'prueba@example.com',
            'state' => true,
        ]);
    }
}
