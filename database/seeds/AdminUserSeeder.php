<?php

use Illuminate\Database\Seeder;
use App\User;
use Konekt\Acl\Models\Role;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Role::findByName('admin')){
            Role::create(['name' => 'admin']);
        }
            $user = User::create([
           'firstname' => 'Admin',
           'lastname' => 'Admin',
           'email' => 'admin@app.com',
           'password' => Hash::make('admin'),
       ]);
       $user->assignRole('admin');
    }
}
