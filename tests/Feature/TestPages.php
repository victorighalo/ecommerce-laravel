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
    public function testHomeTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testOffice()
    {
        $response = $this->get('/office/products');

        $response->assertStatus(200);
    }
}
