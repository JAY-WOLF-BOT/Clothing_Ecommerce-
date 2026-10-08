<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The storefront answers once the catalogue exists.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed();

        $this->get('/')->assertStatus(200);
    }
}
