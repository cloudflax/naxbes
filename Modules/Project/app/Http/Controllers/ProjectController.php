<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Project\Models\Project;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Modules\Project\Http\Requests\FilterRequest;
use Modules\Project\Http\Requests\ProjectRequest;
use Modules\Project\Transformers\ProjectResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ProjectController
 *
 * This controller handles CRUD operations for Project resources.
 *
 * @package Modules\Project\Http\Controllers
 */
class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * This method retrieves a list of projects based on the provided filters, sorting, and pagination parameters.
     * 
     * @param FilterRequest $request The request instance containing filter, sort, and pagination parameters.
     * @return AnonymousResourceCollection A JSON response containing the paginated list of projects.
     */
    public function index(FilterRequest $request): AnonymousResourceCollection
    {
        $params  = $request->validated();
        $filters = $params['filters'] ?? [];

        $fields  = $request->input('fields', '');
        $sort    = $request->input('sort', 'created_at:desc');
        $page    = $request->input('page', 1);
        $perPage = $request->input('per_page', 15);

        $builder  = Project::query();
        $builder  = Project::applyFilters($builder, $filters);
        $builder  = Project::applySorting($builder, $sort);
        $projects = Project::paginateResults($builder, $perPage, $page);

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created project in the database.
     *
     * This method validates the request data and creates a new project record in the database.
     * 
     * @param ProjectRequest $request The request instance containing the data for the new project.
     * @return JsonResponse A JSON response with the created project and a 201 Created status code.
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        $project = Project::create($request->validated());
        return response()->json(new ProjectResource($project), Response::HTTP_CREATED);
    }

    /**
     * Display the specified project.
     *
     * This method retrieves a project by its ID and returns it in a JSON response.
     * 
     * @param string $id The ID of the project to retrieve.
     * @return JsonResponse A JSON response containing the project if found, or an error message with a 404 Not Found status code if not found.
     */
    public function show(string $id): JsonResponse
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new ProjectResource($project), Response::HTTP_OK);
    }

    /**
     * Update the specified project in the database.
     *
     * This method validates the request data and updates the project record with the specified ID.
     * 
     * @param ProjectRequest $request The request instance containing the data to update the project.
     * @param string $id The ID of the project to update.
     * @return JsonResponse A JSON response with the updated project and a 200 OK status code, or an error message with a 404 Not Found status code if the project is not found.
     */
    public function update(ProjectRequest $request, string $id): JsonResponse
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $project->update($request->validated());

        return response()->json(new ProjectResource($project), Response::HTTP_OK);
    }

    /**
     * Remove the specified project from the database.
     *
     * This method deletes the project record with the specified ID from the database.
     * 
     * @param string $id The ID of the project to delete.
     * @return JsonResponse A JSON response with a success message and a 204 No Content status code, or an error message with a 404 Not Found status code if the project is not found.
     */
    public function destroy(string $id): JsonResponse
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
