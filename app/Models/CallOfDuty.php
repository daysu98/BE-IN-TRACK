<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

/**
 * 
 *
 * @property string $id
 * @property string $user_id
 * @property string $days
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CallOfDuty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CallOfDuty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CallOfDuty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CallOfDuty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CallOfDuty whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CallOfDuty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CallOfDuty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CallOfDuty whereUserId($value)
 * @mixin \Eloquent
 */
class CallOfDuty extends Model
{
    use GenUid;

    protected $fillable = [
        'user_id',
        'days',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
