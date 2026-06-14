<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
    
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use App\Models\File;

public function projects(): HasMany
{
    return $this->hasMany(Project::class);
}

public function tasks(): HasMany
{
    return $this->hasMany(Task::class, 'author_id');
}

public function comments(): HasMany
{
    return $this->hasMany(Comment::class);
}

public function files(): HasMany
{
    return $this->hasMany(File::class, 'entity_id')
                ->where('entity', 'user');
}
}
