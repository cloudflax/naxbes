<?php

namespace Modules\Project\Models\Interfaces;

use Illuminate\Support\Carbon;
use App\Models\Interfaces\IModel;

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
     * @return string
     */
    public function getId(): string;

    /**
     * Get the name of the project.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the description of the project.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get the current status of the project.
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Get the creation timestamp of the project.
     *
     * @return Carbon
     */
    public function getCreatedAt(): Carbon;

    /**
     * Get the last update timestamp of the project.
     *
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon;
}
