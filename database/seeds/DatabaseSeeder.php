<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(DeviceSeeder::class);
         $this->call(DeviceUserSeeder::class);
         $this->call(RequestSeeder::class);
    }
}

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['first_name' => 'Mai', 'email' => 'maidoan2017@gmail.com', 'password' => bcrypt('12345678'), 'role' => 1],
            ['first_name' => 'Linh', 'email' => 'maidoan0502@gmail.com', 'password' => bcrypt('12345678'), 'role' => 2],
        ]);
    }
}

class DeviceSeeder extends Seeder
{
    public function run()
    {
        DB::table('devices')->insert([
            'code' => 'pc01',
            'name' => 'May tinh cay Samsung',
            'price' => 20000000,
            'category' => 2,
            'status' => 2
        ]);
    }
}

class DeviceUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('device_users')->insert([
            'user_id' => 2,
            'device_id' => 1
        ]);
    }
}

class RequestSeeder extends Seeder
{
    public function run()
    {
        DB::table('requests')->insert([
            'user_id' => 2,
            'reason' => 'Phat trien du an',
            'status' => 1
        ]);
    }
}
