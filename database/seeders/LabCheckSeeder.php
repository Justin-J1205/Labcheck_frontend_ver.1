<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class LabCheckSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. USERS ---
        $admin = User::create([
            'full_name' => 'Dr. Emmett Brown',
            'email' => 'admin@labcheck.edu.ph',
            'date_of_birth' => '1985-10-26',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $student1 = User::create([
            'full_name' => 'Marty McFly',
            'email' => 'student@labcheck.edu.ph',
            'date_of_birth' => '2005-06-09',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);

        $student2 = User::create([
            'full_name' => 'Gwen Stacy',
            'email' => 'gwen@labcheck.edu.ph',
            'date_of_birth' => '2006-02-12',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);

        // --- 2. CHEMICALS & STOCK ---
        $chemicals = [
            ['name' => 'Hydrochloric Acid', 'formula' => 'HCl', 'unit' => 'ml', 'qty' => 500, 'safety' => 'Corrosive. Wear goggles.'],
            ['name' => 'Sodium Hydroxide', 'formula' => 'NaOH', 'unit' => 'grams', 'qty' => 1000, 'safety' => 'Caustic. Avoid skin contact.'],
            ['name' => 'Ethanol', 'formula' => 'C2H5OH', 'unit' => 'ml', 'qty' => 2500, 'safety' => 'Flammable. Keep away from heat.'],
            ['name' => 'Distilled Water', 'formula' => 'H2O', 'unit' => 'liters', 'qty' => 10, 'safety' => 'Safe for general use.'],
            ['name' => 'Iodine Solution', 'formula' => 'I2', 'unit' => 'ml', 'qty' => 0, 'safety' => 'Stains skin. Toxic if swallowed.'], // Out of stock example
        ];

        foreach ($chemicals as $c) {
            $id = DB::table('chemicals')->insertGetId([
                'name' => $c['name'],
                'formula' => $c['formula'],
                'description' => "Standard laboratory grade {$c['name']}.",
                'safety_info' => $c['safety'],
                'created_at' => now(),
            ]);

            DB::table('stocks')->insert([
                'chemical_id' => $id,
                'quantity' => $c['qty'],
                'unit' => $c['unit'],
                'is_available' => $c['qty'] > 0,
                'created_at' => now(),
            ]);
        }

        // --- 3. EQUIPMENT ---
        $equipmentItems = [
            ['name' => 'Compound Microscope 04', 'loc' => 'Shelf A, Room 302', 'status' => 'available'],
            ['name' => 'Digital Centrifuge', 'loc' => 'Bench 2, Room 302', 'status' => 'maintenance'],
            ['name' => 'Bunsen Burner Set 01', 'loc' => 'Cabinet 05', 'status' => 'available'],
            ['name' => 'Spectrophotometer', 'loc' => 'Dark Room 101', 'status' => 'available'],
            ['name' => 'Analytical Balance', 'loc' => 'Weighing Room', 'status' => 'available'],
        ];

        foreach ($equipmentItems as $item) {
            DB::table('equipment')->insert([
                'name' => $item['name'],
                'location_directions' => $item['loc'],
                'status' => $item['status'],
                'created_at' => now(),
            ]);
        }

        // --- 4. EXPERIMENTS ---
        $experiments = [
            [
                'title' => 'Acid-Base Titration',
                'cat' => 'Chemistry',
                'diff' => 'medium',
                'dur' => 45,
                'steps' => ['Prepare NaOH', 'Add indicator', 'Titrate until pink']
            ],
            [
                'title' => 'Mitosis in Onion Root Tips',
                'cat' => 'Biology',
                'diff' => 'hard',
                'dur' => 90,
                'steps' => ['Stain root tips', 'Squash on slide', 'Observe under 400x']
            ],
            [
                'title' => 'Simple Pendulum Gravity Test',
                'cat' => 'Physics',
                'diff' => 'easy',
                'dur' => 30,
                'steps' => ['Measure string length', 'Record 10 oscillations', 'Calculate g']
            ],
            [
                'title' => 'Paper Chromatography',
                'cat' => 'Chemistry',
                'diff' => 'easy',
                'dur' => 20,
                'steps' => ['Spot ink on paper', 'Place in solvent', 'Calculate Rf values']
            ],
        ];

        foreach ($experiments as $exp) {
            $eId = DB::table('experiments')->insertGetId([
                'title' => $exp['title'],
                'category' => $exp['cat'],
                'difficulty' => $exp['diff'],
                'duration_minutes' => $exp['dur'],
                'procedure_steps' => json_encode($exp['steps']),
                'created_at' => now(),
            ]);

            // Randomly favorite some experiments for the students
            DB::table('experiment_user')->insert([
                'user_id' => $student1->id,
                'experiment_id' => $eId,
            ]);
        }

        // --- 5. SCHEDULES ---
        DB::table('schedules')->insert([
            [
                'user_id' => $student1->id,
                'equipment_id' => 1, // Microscope
                'start_time' => Carbon::now()->addDays(1)->setTime(9, 0),
                'end_time' => Carbon::now()->addDays(1)->setTime(10, 30),
                'created_at' => now(),
            ],
            [
                'user_id' => $student2->id,
                'equipment_id' => 4, // Spectrophotometer
                'start_time' => Carbon::now()->addDays(2)->setTime(14, 0),
                'end_time' => Carbon::now()->addDays(2)->setTime(15, 0),
                'created_at' => now(),
            ]
        ]);
    }
}