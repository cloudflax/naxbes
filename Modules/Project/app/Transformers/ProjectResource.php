<?php

namespace Modules\Project\Transformers;

use Illuminate\Http\Request;
use App\Transformers\UserResource;
use Modules\Project\Models\Interfaces\IProject;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProjectResource
 *
 * This class is responsible for transforming the project model into a JSON representation.
 *
 * @package Modules\Project\Transformers
 */
class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        /** @var IProject $project */
        $project = $this;

        return [
            'id'          => $project->getId(),
            'name'        => $project->getName(),
            'description' => $project->getDescription(),
            'owner_id'    => $project->getOwnerId(),
            'owner'       => new UserResource(
                $project->owner
            ),
            'status'      => $project->getStatus(),
            'created_at'  => $project->getCreatedAt()->toDateTimeString(),
            'updated_at'  => $project->getUpdatedAt()->toDateTimeString(),
        ];
    }
}
