<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::where(['email' => 'admin957@gmail.com'])->count() < 1){
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin957@gmail.com',
                'password' => bcrypt('11223344'),
            ]);
        }
    }
}
