<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Fill initial user in app
 *
 * @author erick
 */
class UserTableSeeder extends Seeder {

    public function run() {
        DB::table('users')->delete();
        User::create(array(
            'username' => 'user',
            'email' => 'user@email.com',
            'password' => Hash::make('user'),
            'twitter_account' => '@user',
            'time_created'=>\time()
        ));
    }

}
