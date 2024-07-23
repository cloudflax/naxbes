<?php

namespace Modules\Project\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Project\Models\Interfaces\IProject;

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
            'status'      => $project->getStatus(),
            'created_at'  => $project->getCreatedAt()->toDateTimeString(),
            'updated_at'  => $project->getUpdatedAt()->toDateTimeString(),
        ];
    }
}
