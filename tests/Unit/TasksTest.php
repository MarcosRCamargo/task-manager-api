<?php

namespace Tests\Unit;

use Tests\TestCase;


class TasksTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function test_creatTask()
    {
 
        $data = [
            'title' => 'Primeira Tarefa',
            'description' => 'Tarefa de criação de Documentação de API',
            'start_date' => '02-25-2023 09:00:00',
            'end_estimate_date' => '02-25-2023 09:00:00',
            'end_date' => '02-25-2023 09:00:00',
            'status' => 1,
            'owner' => 1,
            'delegated_user' => 2,
        ];
        $response = $this->postJson('/api/tasks', $data);
 
        $response->assertStatus(201);
    }
}
