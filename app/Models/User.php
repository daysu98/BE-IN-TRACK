<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use LaravelEasyRepository\Traits\GenUid;

/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $bio
 * @property string|null $institution
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property string|null $photo
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CallOfDuty> $call_of_duties
 * @property-read int|null $call_of_duties_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InternAttend> $intern_attends
 * @property-read int|null $intern_attends_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JobIntern> $job_interns
 * @property-read int|null $job_interns_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TempInternAttend> $temp_intern_attends
 * @property-read int|null $temp_intern_attends_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TempJobIntern> $temp_job_interns
 * @property-read int|null $temp_job_interns_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereInstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, GenUid;

    protected $fillable = [
        'name',
        'email',
        'date',
        'password',
        'role',
        'bio',
        'institution',
        'due_date',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'due_date' => 'date',
        ];
    }

    public function intern_attends()
    {
        return $this->hasMany(InternAttend::class, 'user_id', 'id');
    }

    public function job_interns()
    {
        return $this->hasMany(JobIntern::class, 'user_id', 'id');
    }

    public function call_of_duties()
    {
        return $this->hasMany(CallOfDuty::class, 'user_id', 'id');
    }

    public function temp_intern_attends()
    {
        return $this->hasMany(TempInternAttend::class, 'user_id', 'id');
    }

    public function temp_job_interns()
    {
        return $this->hasMany(TempJobIntern::class, 'user_id', 'id');
    }
}