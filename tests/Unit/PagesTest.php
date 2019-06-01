<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testItShouldSeeHomePage()
    {
        $this->get('/home')
            ->assertStatus(200);
    }
}
