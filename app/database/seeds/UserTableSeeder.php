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
            'username' => 'user1',
            'email' => 'user1@email.com',
            'password' => Hash::make('user123'),
            'twitter_account' => '@user',
            'time_created'=>\time()
        ));
        
        User::create(array(
            'username' => 'user2',
            'email' => 'user2@email.com',
            'password' => Hash::make('user123'),
            'twitter_account' => '@erickjth',
            'time_created'=>\time()
        ));
    }

}
