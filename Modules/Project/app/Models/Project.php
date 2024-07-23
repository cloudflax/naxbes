<?php

namespace Modules\Project\Models;

use App\Models\Model;
use Illuminate\Support\Carbon;
use Modules\Project\Models\Interfaces\IProject;

/**
 * Class Project
 *
 * This class represents a Project model that interacts with the 'projects' table in the database.
 * It extends the base Eloquent model provided by Laravel and implements the IProject interface.
 *
 * @package Modules\Project\Models
 */
class Project extends Model implements IProject
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    /**
     * Get the unique identifier of the project.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->getAttribute('id');
    }

    /**
     * Get the name of the project.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    /**
     * Get the description of the project.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getAttribute('description');
    }

    /**
     * Get the current status of the project.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->getAttribute('status');
    }

    /**
     * Get the creation timestamp of the project.
     *
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->getAttribute('created_at');
    }

    /**
     * Get the last update timestamp of the project.
     *
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->getAttribute('updated_at');
    }
}
