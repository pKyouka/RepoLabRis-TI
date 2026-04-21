<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryItemsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed inventory items from initial lab list.
     */
    public function run(): void
    {
        $items = [
            // Alat IoT Hidroponik
            ['category' => 'Alat IoT Hidroponik', 'name' => 'Water tank box', 'quantity' => 5],
            ['category' => 'Alat IoT Hidroponik', 'name' => 'Pump box', 'quantity' => 5],
            ['category' => 'Alat IoT Hidroponik', 'name' => 'Hose box', 'quantity' => 4],
            ['category' => 'Alat IoT Hidroponik', 'name' => 'Soil Sensor box', 'quantity' => 5],
            ['category' => 'Alat IoT Hidroponik', 'name' => 'Controller box', 'quantity' => 5],
            ['category' => 'Alat IoT Hidroponik', 'name' => 'Air sensor box', 'quantity' => 5],
            ['category' => 'Alat IoT Hidroponik', 'name' => 'Tanaman', 'quantity' => 5],

            // Alat Jarkom
            ['category' => 'Alat Jarkom', 'name' => 'Unifi APAC PRO', 'quantity' => 1],
            ['category' => 'Alat Jarkom', 'name' => 'RJ45 and RJ11 Cabel Tester Network', 'quantity' => 2],
            ['category' => 'Alat Jarkom', 'name' => 'Multi Meter DT-830', 'quantity' => 1],
            ['category' => 'Alat Jarkom', 'name' => 'Routerboard Hap series', 'quantity' => 2],
            ['category' => 'Alat Jarkom', 'name' => 'Routerboard Hex series', 'quantity' => 2],
            ['category' => 'Alat Jarkom', 'name' => 'Switch RG-ES205GC RUIJIE', 'quantity' => 2],
            ['category' => 'Alat Jarkom', 'name' => 'Switch TP-LINK', 'quantity' => 2],
            ['category' => 'Alat Jarkom', 'name' => 'Tang crimping 0B-315', 'quantity' => 1],

            // Barang IoT
            ['category' => 'Barang IoT', 'name' => 'Module IOT', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'ESP32', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'ESP8266', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Solder', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Arduino', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Ichibot', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Sensor pH', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'LCD2004', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'LCD1602', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'DHT11', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Analog', 'quantity' => 3],
            ['category' => 'Barang IoT', 'name' => 'Board', 'quantity' => 3],
            ['category' => 'Barang IoT', 'name' => 'LED display 7 segmen', 'quantity' => 10],
            ['category' => 'Barang IoT', 'name' => 'Loud speaker', 'quantity' => 2],
            ['category' => 'Barang IoT', 'name' => 'ULN', 'quantity' => 3],
            ['category' => 'Barang IoT', 'name' => 'Step Motor', 'quantity' => 2],
            ['category' => 'Barang IoT', 'name' => 'Potensio', 'quantity' => 2],
            ['category' => 'Barang IoT', 'name' => 'Infrared Sensor', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'StepDown Power', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Arduino Uno Protype', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Analog Gas', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'LED dot matrix', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Sensor Pir', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'LED', 'quantity' => 58],
            ['category' => 'Barang IoT', 'name' => 'Kabel Jamper', 'quantity' => 20],
            ['category' => 'Barang IoT', 'name' => 'Relay 5v', 'quantity' => 4],
            ['category' => 'Barang IoT', 'name' => 'L2C LCD', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Sensor Arus ACS', 'quantity' => 1],
            ['category' => 'Barang IoT', 'name' => 'Resistor', 'quantity' => 20],
            ['category' => 'Barang IoT', 'name' => 'Arduino mega', 'quantity' => 4],
            ['category' => 'Barang IoT', 'name' => 'Wesmus ESP 32', 'quantity' => 5],
            ['category' => 'Barang IoT', 'name' => 'Arduino d1 esp8266', 'quantity' => 4],
        ];

        foreach ($items as $itemData) {
            $item = Item::firstOrNew(['name' => $itemData['name']]);
            $item->total_stock = $itemData['quantity'];
            $item->available_stock = $itemData['quantity'];
            $item->is_active = true;
            $item->description = 'Kategori: ' . $itemData['category'];
            $item->save();
        }
    }
}
