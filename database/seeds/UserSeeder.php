<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Gianluca';
        $user->email = 'gianluca@mail.com';
        $user->password = bcrypt('password');  
        
        $user->save();
    }
}
