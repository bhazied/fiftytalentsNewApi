<?php

namespace Tests\Feature\App\Http\Controllers\Api;

use App\Model\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CountryControllerTest extends TestCase
{
    use WithoutMiddleware;
    //use DatabaseMigrations;

    public function test_index_action_countries()
    {
        $this->get(route('countries.index'))->assertStatus(200);
    }
}
