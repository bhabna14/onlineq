<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BookingType;
use App\Models\IdProofType;
use App\Models\Relation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('Admin@123'),
        // ]);

        User::create([
            'role_id' => '2',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin@123'),
        ]);

        Role::create([
            'role_name' => 'Super Admin',
            'created_by' => 1
        ]);

        Role::create([
            'role_name' => 'Admin',
            'created_by' => 1
        ]);

        Role::create([
            'role_name' => 'User',
            'created_by' => 1
        ]);
        $this->command->info('Role table seeded!');

        IdProofType::create([
            'id_proof' => 'Aadhaar Card',
            'created_by' => 1
        ]);
        IdProofType::create([
            'id_proof' => 'Voter Card',
            'created_by' => 1
        ]);
        $this->command->info('ID proof table seeded!');

        Relation::create([
            'relation' => 'Father',
            'created_by' => 1
        ]);
        Relation::create([
            'relation' => 'Mother',
            'created_by' => 1
        ]);
        Relation::create([
            'relation' => 'Brother',
            'created_by' => 1
        ]);
        Relation::create([
            'relation' => 'Sister',
            'created_by' => 1
        ]);
        $this->command->info('Relation table seeded!');

        BookingType::create([
            'booking_type_name' => 'Specially Abled Booking',
            'booking_type_slug' => 'specially-abled-booking',
            'booking_price' => '0',
            'booking_number' => '20',
            'created_by' => 1
        ]);
        BookingType::create([
            'booking_type_name' => 'Normal Booking',
            'booking_type_slug' => 'normal-booking',
            'booking_price' => '100',
            'booking_number' => '1000',
            'created_by' => 1
        ]);
        $this->command->info('Booking type table seeded!');
        // User::create([
        //     'role_id' => '3',
        //     'email' => 'user@gmail.com',
        //     'phone' => '9178712154',
        //     'password' => Hash::make('User@123'),
        // ]);
    }
}
