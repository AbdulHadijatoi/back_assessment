<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * Get the projects associated with the user.
     *
     * This function defines a many-to-many relationship between the User and Project models.
     * It allows retrieving all projects that the user is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany A collection of Project models associated with this user.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Get the timesheets associated with the user.
     *
     * This function defines a one-to-many relationship between the User and Timesheet models.
     * It allows retrieving timesheet that belong to this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany A collection of Timesheet models associated with this user.
     */
    public function timesheet(): HasOne
    {
        return $this->hasOne(Timesheet::class);
    }

}
