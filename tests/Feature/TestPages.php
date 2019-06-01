<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestPages extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testLanding()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testHome()
    {
        $this->get('/home')->assertStatus(200)->assertSee('Our Categories');
    }

    public function testProfile()
    {
        $this->get('/profile')->assertStatus(200);
    }
}
