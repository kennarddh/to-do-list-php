<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use Faker\Factory;

class ToDoSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $faker = Factory::create();

            $data = [
                'title' => $faker->sentence(6),
            ];

            $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

            $this->db->table('to-do')->insert($data);
        }
    }
}
