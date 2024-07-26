<?php

namespace Modules\Project\Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Modules\Project\Models\Project;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test suite for the Project API endpoints.
 *
 * This class contains unit tests for the CRUD operations of the Project API endpoints.
 * It tests various aspects such as retrieving, creating, updating, and deleting projects.
 * Each test ensures that the endpoints function correctly and adhere to the expected behavior.
 */
#[Group('project')]
class ProjectApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the API endpoint to retrieve a list of projects.
     *
     * This test verifies that authenticated users can successfully retrieve a list of projects.
     * It also checks if the response JSON structure is correct.
     *
     * @return void
     */
    public function test_can_get_projects(): void
    {
        $user = User::factory()->create();
        Project::factory()->count(5)->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/v1/projects');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['*' => [
                    'id',
                    'name',
                    'description',
                    'owner_id',
                    'status',
                    'created_at',
                    'updated_at'
                ]]
            ]);
    }

    /**
     * Test the API endpoint to retrieve projects without authentication.
     *
     * This test checks if unauthenticated users are denied access to the projects list.
     * It ensures that the endpoint returns a 401 Unauthorized status code when no valid authentication is provided.
     *
     * @return void
     */
    public function test_cannot_get_projects_without_authentication(): void
    {
        $response = $this->get('/api/v1/projects', ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }

    /**
     * Test the API endpoint to retrieve a single project by ID.
     *
     * This test verifies that authenticated users can successfully retrieve the details of a specific project.
     * It checks the JSON response for the correct project data and ensures that the project exists in the database.
     *
     * @return void
     */
    public function test_can_get_single_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get("/api/v1/projects/{$project->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id'          => $project->id,
                'name'        => $project->name,
                'status'      => $project->status,
                'owner_id'    => $project->owner_id,
                'description' => $project->description,
                'created_at'  => $project->created_at->toDateTimeString(),
                'updated_at'  => $project->updated_at->toDateTimeString(),
            ]);
    }

    /**
     * Test the API endpoint to retrieve a single project by a non-existent ID.
     *
     * This test verifies that an authenticated user receives a 404 Not Found status
     * when attempting to retrieve details of a project that does not exist.
     * It ensures that the endpoint correctly handles requests for non-existent resources.
     *
     * @return void
     */
    public function test_cannot_get_non_existent_project(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $nonExistentProjectId = 999999;

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get("/api/v1/projects/{$nonExistentProjectId}");

        $response->assertStatus(404);
    }


    /**
     * Test the API endpoint to retrieve a single project without authentication.
     *
     * This test checks if unauthenticated users are denied access when attempting to retrieve the details of a project.
     * It ensures that the endpoint returns a 401 Unauthorized status code when no valid authentication is provided.
     *
     * @return void
     */
    public function test_cannot_get_single_project_without_authentication(): void
    {
        $project = Project::factory()->create();

        $response = $this->get("/api/v1/projects/{$project->id}", ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }

    /**
     * Test the API endpoint to create a new project.
     *
     * This test verifies that authenticated users can successfully create a new project.
     * It checks the JSON response for correct project data and ensures the project is saved in the database.
     *
     * @return void
     */
    public function test_can_create_project(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $projectData = [
            'name'        => $this->faker->word,
            'status'      => 'active',
            'owner_id'    => $user->id,
            'description' => $this->faker->sentence(),
        ];

        $response = $this->post('/api/v1/projects', $projectData, ['Accept' => 'application/json']);

        $response->assertStatus(201)
            ->assertJson([
                'id'          => $response->json('id'),
                'name'        => $projectData['name'],
                'status'      => $projectData['status'],
                'owner_id'    => $projectData['owner_id'],
                'description' => $projectData['description'],
                'created_at'  => $response->json('created_at'),
                'updated_at'  => $response->json('updated_at'),
            ]);

        $this->assertDatabaseHas('projects', $projectData);
    }

    /**
     * Test the API endpoint to create a project without authentication.
     *
     * This test checks if unauthenticated users are denied access when attempting to create a new project.
     * It ensures that the endpoint returns a 401 Unauthorized status code when no valid authentication is provided.
     *
     * @return void
     */
    public function test_cannot_create_project_without_authentication(): void
    {
        $projectData = [
            'name'        => $this->faker->word,
            'status'      => 'active',
            'owner_id'    => User::factory()->create()->id,
            'description' => $this->faker->sentence(),
        ];

        $response = $this->post('/api/v1/projects', $projectData, ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }

    /**
     * Test the API endpoint to update an existing project.
     *
     * This test verifies that authenticated users can successfully update an existing project.
     * It checks the JSON response to ensure the project data has been updated correctly and verifies
     * that the changes are reflected in the database.
     *
     * @return void
     */
    public function test_can_update_project(): void
    {
        $user    = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        Sanctum::actingAs($user, ['*']);

        $projectData = [
            'name'        => 'Updated Project Name',
            'status'      => 'inactive',
            'owner_id'    => $user->id,
            'description' => 'Updated Project Description',
        ];

        $response = $this->put("/api/v1/projects/{$project->id}", $projectData, ['Accept' => 'application/json']);

        $response->assertStatus(200)
            ->assertJson([
                'id'          => $response->json('id'),
                'name'        => $projectData['name'],
                'status'      => $projectData['status'],
                'owner_id'    => $projectData['owner_id'],
                'description' => $projectData['description'],
                'created_at'  => $response->json('created_at'),
                'updated_at'  => $response->json('updated_at'),
            ]);

        $this->assertDatabaseHas('projects', array_merge(['id' => $project->id], $projectData));
    }

    /**
     * Test the API endpoint to update a project that does not exist.
     *
     * This test verifies that an authenticated user receives a 404 Not Found status
     * when attempting to update a project that does not exist.
     * It ensures that the endpoint correctly handles update requests for non-existent resources.
     *
     * @return void
     */
    public function test_cannot_update_non_existent_project(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $nonExistentProjectId = 999999;

        $updateData = [
            'name'        => 'Updated Project Name',
            'status'      => 'inactive',
            'owner_id'    => $user->id,
            'description' => 'Updated Project Description',
        ];

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->put("/api/v1/projects/{$nonExistentProjectId}", $updateData);

        $response->assertStatus(404);
    }

    /**
     * Test the API endpoint to update a project without authentication.
     *
     * This test checks if unauthenticated users are denied access when attempting to update a project.
     * It ensures that the endpoint returns a 401 Unauthorized status code when no valid authentication is provided.
     *
     * @return void
     */
    public function test_cannot_update_project_without_authentication(): void
    {
        $project = Project::factory()->create();

        $updateData = [
            'name' => 'Updated Project Name',
            'description' => 'Updated Project Description',
            'status' => 'inactive'
        ];

        $response = $this->put("/api/v1/projects/{$project->id}", $updateData, ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }

    /**
     * Test the API endpoint to delete an existing project.
     *
     * This test verifies that authenticated users can successfully delete an existing project.
     * It checks that the project is removed from the database and ensures the endpoint returns
     * a 204 No Content status code indicating successful deletion.
     *
     * @return void
     */
    public function test_can_delete_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['owner_id' => $user->id]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->delete("/api/v1/projects/{$project->id}", [], ['Accept' => 'application/json']);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    /**
     * Test the API endpoint to delete a project that does not exist.
     *
     * This test verifies that an authenticated user receives a 404 Not Found status
     * when attempting to delete a project that does not exist.
     * It ensures that the endpoint correctly handles delete requests for non-existent resources.
     *
     * @return void
     */
    public function test_cannot_delete_non_existent_project(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $nonExistentProjectId = 999999;

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->delete("/api/v1/projects/{$nonExistentProjectId}");

        $response->assertStatus(404);
    }

    /**
     * Test the API endpoint to delete a project without authentication.
     *
     * This test checks if unauthenticated users are denied access when attempting to delete a project.
     * It ensures that the endpoint returns a 401 Unauthorized status code when no valid authentication is provided.
     *
     * @return void
     */
    public function test_cannot_delete_project_without_authentication(): void
    {
        $project = Project::factory()->create();

        $response = $this->delete("/api/v1/projects/{$project->id}", [], ['Accept' => 'application/json']);

        $response->assertStatus(401);
    }
}
