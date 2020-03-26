<?php

use Illuminate\Database\Seeder;
use App\Models\status_number;

class Status_NumberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'description' => 'Menu principal',
                'active' => true
            ],
            [
                'description' => 'Submenu',
                'active' => true
            ],
            [
                'description' => 'Solicitação de servico',
                'active' => true
            ],
        ];

        foreach ($status as $stat) {
            
            status_number::create($stat);

        }
    }
}
