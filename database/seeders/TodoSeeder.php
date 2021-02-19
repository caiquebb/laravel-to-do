<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Todo::factory()
            ->count(5)
            ->forUser([
                'name' => 'Admin',
                'email' => 'admin@laravel-todo.com'
            ])
            ->create();
    }
}
