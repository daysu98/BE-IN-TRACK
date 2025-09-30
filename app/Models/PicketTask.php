<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

/**
 * 
 *
 * @property string $id
 * @property string $day
 * @property string $task_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PicketTask newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PicketTask newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PicketTask query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PicketTask whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PicketTask whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PicketTask whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PicketTask whereTaskDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PicketTask whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PicketTask extends Model
{
    use HasFactory, GenUid;

    protected $fillable = [
        'day',
        'task_description',
    ];
}