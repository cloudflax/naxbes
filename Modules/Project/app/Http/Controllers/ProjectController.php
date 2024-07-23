<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Modules\Project\Models\Project;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Modules\Project\Http\Requests\FilterRequest;
use Modules\Project\Http\Requests\ProjectRequest;
use Modules\Project\Transformers\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(FilterRequest $request)
    {
        $params  = $request->validated();
        $filters = $params['filters'] ?? [];
        $sort    = $request->input('sort', 'created_at:desc');
        $perPage = $request->input('per_page', 15);
        $page    = $request->input('page', 1);

        $builder  = Project::query();
        $builder  = Project::applyFilters($builder, $filters);
        $builder  = Project::applySorting($builder, $sort);
        $projects = Project::paginateResults($builder, $perPage, $page);

        return ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        $project = Project::create($request->validated());
        return response()->json(new ProjectResource($project), Response::HTTP_CREATED);
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new ProjectResource($project), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProjectRequest $request, int $id): JsonResponse
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $project->update($request->validated());

        return response()->json(new ProjectResource($project), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], Response::HTTP_NOT_FOUND);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
