<?php

use Illuminate\Database\Seeder;
use Konekt\Acl\Models\Role;
use App\User;
class GuestUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'firstname' => 'guest',
            'lastname' => 'guest',
            'email' => 'guest@app.com',
            'password' => Hash::make('guest'),
        ]);
        $user->assignRole('guest');
    }
}
