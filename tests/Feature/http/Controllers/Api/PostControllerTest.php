<?php

namespace Tests\Feature\http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class PostControllerTest extends TestCase
{
  use RefreshDatabase;

  public function test_store()
  {
      $this->withoutExceptionHandling();
      $user = factory(User::class)->create();

      $response = $this->actingAs($user, 'api')->json('POST', '/api/posts', [
          'title' => 'El post de prueba'
      ]);

      $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
          ->assertJson(['title' => 'El post de prueba'])
          ->assertStatus(201); //OK, creado un recurso

      $this->assertDatabaseHas('posts', ['title' => 'El post de prueba']);
  }
}
