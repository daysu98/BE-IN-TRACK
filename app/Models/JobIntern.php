<?php

namespace App\Models;

use App\Enums\CheckJobStatus;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

/**
 *
 *
 * @property string $id
 * @property string $user_id
 * @property string $created
 * @property string $task
 * @property string $description
 * @property string|null $deadline
 * @property CheckJobStatus|null $status
 * @property string $manage_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, JobIntern> $temp_job_interns
 * @property-read int|null $temp_job_interns_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobIntern whereManageBy($value)
 * @mixin \Eloquent
 */
class JobIntern extends Model
{
    use GenUid;

    protected $fillable = [
        'user_id',
        'created',
        'task',
        'description',
        'deadline',
        'status',
        'manage_by'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => CheckJobStatus::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function temp_job_interns()
    {
        return $this->hasMany(JobIntern::class, 'job_intern_id', 'id');
    }
}
