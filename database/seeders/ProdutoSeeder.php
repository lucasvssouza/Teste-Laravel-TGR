<?php

namespace Database\Seeders;

use App\Models\Produto;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            Produto::create([
                'nome' => 'Produto ' . $i,
                'descricao' => 'Descrição do produto ' . $i,
                'preco' => rand(1000, 99999) / 100, // entre 10,00 e 999,99
                'quantidade' => rand(1, 200),
            ]);
        }
    }
}
