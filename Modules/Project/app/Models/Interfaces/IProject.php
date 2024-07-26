<?php

namespace Modules\Project\Models\Interfaces;

use Illuminate\Support\Carbon;
use Cloudflax\Model\Interface\IModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Interface IProject
 *
 * This interface defines the contract for a Project entity.
 * Any class that implements this interface must provide implementations for the following methods.
 */
interface IProject extends IModel
{
    /**
     * Get the unique identifier of the project.
     *
     * @return string The unique identifier of the project.
     */
    public function getId(): string;

    /**
     * Get the name of the project.
     *
     * @return string The name of the project.
     */
    public function getName(): string;

    /**
     * Get the description of the project.
     *
     * @return string The description of the project. May be an empty string if no description is provided.
     */
    public function getDescription(): string;

    /**
     * Get the identifier of the user who owns the project.
     *
     * @return int The unique identifier of the user who owns the project.
     */
    public function getOwnerId(): int;

    /**
     * Get the relationship between the project and its owner.
     *
     * @return BelongsTo The Eloquent relationship representing the ownership of the project.
     */
    public function owner(): BelongsTo;

    /**
     * Get the current status of the project.
     *
     * @return string The status of the project, which could be values like 'active' or 'inactive'.
     */
    public function getStatus(): string;

    /**
     * Get the creation timestamp of the project.
     *
     * @return Carbon The date and time when the project was created.
     */
    public function getCreatedAt(): Carbon;

    /**
     * Get the last update timestamp of the project.
     *
     * @return Carbon The date and time when the project was last updated.
     */
    public function getUpdatedAt(): Carbon;
}
