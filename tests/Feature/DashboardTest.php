<?php

use App\Models\User;

// test('guests are redirected to the login page', function () {
//     $response = $this->get('/');
//     $response->assertRedirect('/login');
// });

test('guests can see the home page', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});


test('authenticated users can visit the home', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/');
    $response->assertStatus(200);
});
