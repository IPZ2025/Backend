<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(["name" => "Техніка", "photo_url" => "https://categories.olxcdn.com/assets/categories/olxua/zapchasti-dlya-transporta-3-1x.png",]);
        Category::create(["name" => "Електроніка", "photo_url" => "https://categories.olxcdn.com/assets/categories/olxua/elektronika-37-1x.png",]);
        Category::create(["name" => "Транспорт", "photo_url" => "https://categories.olxcdn.com/assets/categories/olxua/transport-1532-1x.png",]);
        Category::create(["name" => "Одяг", "photo_url" => "https://categories.olxcdn.com/assets/categories/olxua/moda-i-stil-891-1x.png",]);
        Category::create(["name" => "Хоббі", "photo_url" => "https://categories.olxcdn.com/assets/categories/olxua/hobbi-otdyh-i-sport-903-1x.png",]);
        Category::create(["name" => "Меблі", "photo_url" => "https://categories.olxcdn.com/assets/categories/olxua/dom-i-sad-899-1x.png",]);
        Category::create(["name" => "Тварини", "photo_url" => "https://categories.olxcdn.com/assets/categories/olxua/zhivotnye-35-1x.png",]);
        Category::create(["name" => "Сад і город", "photo_url" => "https://categories.olxcdn.com/assets/categories/olxua/uslugi-7-1x.png",]);
        Category::create(["name" => "Товари для дітей", "photo_url" => "https://categories.olxcdn.com/assets/categories/olxua/detskiy-mir-36-1x.png",]);
    }
}
