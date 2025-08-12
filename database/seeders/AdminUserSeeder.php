<?php
    
    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use App\Models\User;
    use Illuminate\Support\Facades\Hash;

    class AdminUserSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            User::updateOrCreate(
                ['email' => 'admin@bakorwil.com'], // Cari berdasarkan email
                [
                    'name' => 'Admin Bakorwil',
                    'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
                    'role' => 'admin',
                ]
            );
        }
    }
    