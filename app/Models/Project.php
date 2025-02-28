<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the users associated with the project.
     *
     * This function defines a many-to-many relationship between the Project
     * and User models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany The users associated with this project.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the timesheet associated with the project.
     *
     * This function defines a one-to-one relationship between the Project
     * and Timesheet models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne The timesheet associated with this project.
     */
    public function timesheet(): HasOne
    {
        return $this->hasOne(Timesheet::class);
    }

    public function attributes()
    {
        return $this->hasMany(AttributeValue::class, 'entity_id');
    }
}
