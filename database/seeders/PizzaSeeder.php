<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pizza;

class PizzaSeeder extends Seeder
{
    public function run()
    {
        // Pizza data
        $pizzas = [
            ['pname' => 'Áfonyás', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Babos', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Barbecue chicken', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Betyáros', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Caribi', 'category_name' => 'page', 'vegetarian' => 0],
            ['pname' => 'Country', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Csabesz', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Csupa sajt', 'category_name' => 'knight', 'vegetarian' => 1],
            ['pname' => 'Erdő kapitánya', 'category_name' => 'page', 'vegetarian' => 0],
            ['pname' => 'Erős János', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Excellent', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Főnök kedvence', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Francia', 'category_name' => 'nobleman', 'vegetarian' => 0],
            ['pname' => 'Frankfurti', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Füstös', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Gino', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Gombás', 'category_name' => 'page', 'vegetarian' => 1],
            ['pname' => 'Góré', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Görög', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Gyros pizza', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'HamAndEggs', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Hamm', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Hawaii', 'category_name' => 'nobleman', 'vegetarian' => 0],
            ['pname' => 'Hellas', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Hercegnő', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Ilike', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Ínyenc', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Jázmin álma', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Jobbágy', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Juhtúrós', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Kagylós', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Kétszínű', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Kiadós', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Király pizza', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Kívánság', 'category_name' => 'knight', 'vegetarian' => 1],
            ['pname' => 'Kolbászos', 'category_name' => 'page', 'vegetarian' => 0],
            ['pname' => 'Lagúna', 'category_name' => 'king', 'vegetarian' => 1],
            ['pname' => 'Lecsó', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Maffiózó', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Magvas', 'category_name' => 'king', 'vegetarian' => 1],
            ['pname' => 'Magyaros', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Máj Fair Lady', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Mamma fia', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Mexikói', 'category_name' => 'nobleman', 'vegetarian' => 0],
            ['pname' => 'Mixi', 'category_name' => 'nobleman', 'vegetarian' => 1],
            ['pname' => 'Nikó', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Nordic', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Nyuszó-Muszó', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Pacalos', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Pástétomos', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Pásztor', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Pipis', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Popey', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Quattro', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Ráki', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Rettenetes magyar', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Röfi', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Sajtos', 'category_name' => 'page', 'vegetarian' => 1],
            ['pname' => 'So-ku', 'category_name' => 'page', 'vegetarian' => 0],
            ['pname' => 'Son-go-ku', 'category_name' => 'nobleman', 'vegetarian' => 1],
            ['pname' => 'Sonkás', 'category_name' => 'page', 'vegetarian' => 0],
            ['pname' => 'Spanyol', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Spencer', 'category_name' => 'nobleman', 'vegetarian' => 0],
            ['pname' => 'Szalámis', 'category_name' => 'page', 'vegetarian' => 0],
            ['pname' => 'Szardíniás', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Szerzetes', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Szőke kapitány', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Tenger gyümölcsei', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Tonhalas', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Törperős', 'category_name' => 'knight', 'vegetarian' => 0],
            ['pname' => 'Tündi kedvence', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Tüzes halál', 'category_name' => 'king', 'vegetarian' => 0],
            ['pname' => 'Vega', 'category_name' => 'knight', 'vegetarian' => 1],
            ['pname' => 'Zöldike', 'category_name' => 'nobleman', 'vegetarian' => 1],

        ];

        // Insert the data into the pizzas table
        foreach ($pizzas as $pizza) {
            Pizza::create($pizza);
        }
    }
}
