<?php

namespace Modules\Team\Http\Controllers;

use Modules\Team\Models\Team;
use Modules\Team\Transformers\TeamResource;
use Modules\Team\Http\Requests\TeamRequest;
use Modules\Team\Http\Requests\FilterRequest;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class TeamController
 *
 * This controller handles CRUD operations for Team resources.
 *
 * @package Modules\Team\Http\Controllers
 */
class TeamController extends Controller
{
    /**
     * Display a listing of the teams.
     *
     * This method retrieves a list of teams based on the provided filters, sorting, and pagination parameters.
     * 
     * @param FilterRequest $request The request instance containing filter, sort, and pagination parameters.
     * @return AnonymousResourceCollection A JSON response containing the paginated list of teams.
     */
    public function index(FilterRequest $request): AnonymousResourceCollection
    {
        $params  = $request->validated();
        $filters = $params['filters'] ?? [];

        $fields  = $request->input('fields', '');
        $sort    = $request->input('sort', 'created_at:desc');
        $page    = $request->input('page', 1);
        $perPage = $request->input('per_page', 15);

        $builder  = Team::query();
        $builder  = Team::applyFilters($builder, $filters);
        $builder  = Team::applySorting($builder, $sort);
        $teams = Team::paginateResults($builder, $perPage, $page);

        return TeamResource::collection($teams);
    }

    /**
     * Store a newly created team in the database.
     *
     * This method validates the request data and creates a new team record in the database.
     * 
     * @param TeamRequest $request The request instance containing the data for the new team.
     * @return JsonResponse A JSON response with the created team and a 201 Created status code.
     */
    public function store(TeamRequest $request): JsonResponse
    {
        $team = Team::create($request->validated());
        return response()->json(new TeamResource($team), Response::HTTP_CREATED);
    }

    /**
     * Display the specified team.
     *
     * This method retrieves a team by its ID and returns it in a JSON response.
     * 
     * @param int $id The ID of the team to retrieve.
     * @return JsonResponse A JSON response containing the team if found, or an error message with a 404 Not Found status code if not found.
     */
    public function show(int $id): JsonResponse
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['error' => 'Team not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new TeamResource($team), Response::HTTP_OK);
    }

    /**
     * Update the specified team in the database.
     *
     * This method validates the request data and updates the team record with the specified ID.
     * 
     * @param TeamRequest $request The request instance containing the data to update the team.
     * @param int $id The ID of the team to update.
     * @return JsonResponse A JSON response with the updated team and a 200 OK status code, or an error message with a 404 Not Found status code if the team is not found.
     */
    public function update(TeamRequest $request, int $id): JsonResponse
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['error' => 'Team not found'], Response::HTTP_NOT_FOUND);
        }

        $team->update($request->validated());

        return response()->json(new TeamResource($team), Response::HTTP_OK);
    }

    /**
     * Remove the specified team from the database.
     *
     * This method deletes the team record with the specified ID from the database.
     * 
     * @param int $id The ID of the team to delete.
     * @return JsonResponse A JSON response with a success message and a 204 No Content status code, or an error message with a 404 Not Found status code if the team is not found.
     */
    public function destroy(int $id): JsonResponse
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['error' => 'Team not found'], Response::HTTP_NOT_FOUND);
        }

        $team->delete();

        return response()->json(['message' => 'Team deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}
