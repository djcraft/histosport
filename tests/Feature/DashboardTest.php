<?php

use App\Models\User;

test('guests are redirected to dashboard', function () {
    $this->get('/dashboard')->assertStatus(200);
});

test('authenticated users can visit the dashboard', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/dashboard')->assertStatus(200);
});
