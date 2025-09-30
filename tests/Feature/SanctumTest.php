<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('task list can be retrieved', function () {
    Sanctum::actingAs(
        User::factory()->create(),
        ['*']
    );

    $response = $this->get('/api/task');

    $response->assertOk();
});
