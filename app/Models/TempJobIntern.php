<?php

namespace App\Models;

use App\Enums\CheckJobStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

/**
 * 
 *
 * @property string $id
 * @property string $job_intern_id
 * @property string $user_id
 * @property string $created
 * @property string $task
 * @property string $description
 * @property string|null $deadline
 * @property CheckJobStatus|null $status
 * @property string $manage_by
 * @property string|null $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\JobIntern $job_intern
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereJobInternId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempJobIntern whereManageBy($value)
 * @property-read string $deadline_iso
 * @mixin \Eloquent
 */
class TempJobIntern extends Model
{
    use GenUid;

    protected $fillable = [
        'job_intern_id',
        'user_id',
        'created',
        'task',
        'description',
        'deadline',
        'status',
        'manage_by',
        'expired_at',
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

    protected $appends = ['deadline_iso'];

    public function getDeadlineIsoAttribute(): string
    {
        return Carbon::parse($this->deadline)->isoFormat('DD MMM YYYY');
    }

    public function job_intern()
    {
        return $this->belongsTo(JobIntern::class, 'job_intern_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
