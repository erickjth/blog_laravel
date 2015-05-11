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
class EntryTableSeeder extends Seeder {

    public function run() {
        DB::table('entries')->delete();
        Entry::create(array(
            'title' => 'Post 1',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse auctor nibh imperdiet tortor dignissim fringilla. Vestibulum congue commodo aliquet. Maecenas blandit sem id tellus sodales hendrerit et sit amet elit. Suspendisse id facilisis diam. Curabitur quis fringilla nulla. Maecenas sit amet nunc consequat, pellentesque magna sit amet, convallis magna. Etiam bibendum, magna sit amet blandit finibus, urna risus lobortis libero, nec pellentesque erat lacus quis arcu. Curabitur ipsum eros, auctor volutpat tellus nec, varius hendrerit massa. In mattis pharetra tortor, vitae rhoncus ipsum malesuada molestie. Nam quis diam felis. Sed vestibulum metus eget leo dignissim, vel tempor felis volutpat. Ut commodo, felis at commodo auctor, quam dolor suscipit neque, et ullamcorper est libero ut risus. Quisque mattis mi et dignissim sagittis. Mauris eu dolor et leo lacinia fringilla sed nec neque.',
            'user_id' => User::where('username', '=', 'user')->first()->id,
            'time_created' => \time(),
            'time_updated' => \time(),
        ));
    }

}
