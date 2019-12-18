<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\DataGudangController;

class GudangTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testDataGudang()
    {
        // $this->assertTrue(true);
        $gudang = new DataGudangController();
    }
}
