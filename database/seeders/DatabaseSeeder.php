<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Traits\WithProgressBar;

class DatabaseSeeder extends Seeder
{

    use WithProgressBar;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->command->info(PHP_EOL . 'Creating admin...');

        $this->withProgressBar(1, fn () =>     \App\Models\User::factory(1)->create());
        $this->command->info('Admin created!');

        $this->command->info(PHP_EOL . 'Creating categories and products...');

        $categories =  $this->withProgressBar(5, fn () => Category::factory()
            ->has(Product::factory()->count(4))
            ->count(1)
            ->create());
        $this->command->info('Categories and products created!');

        //$this->command->info(PHP_EOL . 'Creating products...');
        //$products = $this->withProgressBar(10, fn () =>   Product::factory()->count(10));
        //
        //$this->command->info(PHP_EOL . 'Products created!');
    }
}
