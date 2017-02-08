<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BasicAuthTest extends TestCase
{
    public function testWithoutAuthTest()
    {
        $response = $this->call('GET', 'api/v1/video');
        $response->assertStatus(401);
    }

    public function testWithAuthTest()
    {
        $response = $this->call('GET', 'api/v1/video', [], [], [],
            ['PHP_AUTH_USER' => 'admin@admin.com', 'PHP_AUTH_PW' => '123456']);
        $response->assertStatus(200);
    }
}
