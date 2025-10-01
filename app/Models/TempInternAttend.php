<?php

namespace App\Models;

use App\Enums\CheckAttendStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Traits\GenUid;

/**
 * 
 *
 * @property string $id
 * @property string $intern_attend_id
 * @property string $user_id
 * @property string $status
 * @property string $tanggal
 * @property string $jam_masuk
 * @property string $jam_keluar
 * @property string|null $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\InternAttend|null $intern_attend
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereInternAttendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereJamKeluar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TempInternAttend whereUserId($value)
 * @property-read string $tanggal_iso
 * @mixin \Eloquent
 */
class TempInternAttend extends Model
{
    use GenUid;

    protected $fillable = [
        'intern_attend_id',
        'user_id',
        'status',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
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
            'status' => CheckAttendStatus::class,
        ];
    }

    protected $appends = ['tanggal_iso'];

    public function getTanggalIsoAttribute(): string
    {
        return Carbon::parse($this->tanggal)->isoFormat('DD MMM YYYY');
    }

    public function intern_attend()
    {
        return $this->belongsTo(InternAttend::class, 'intern_attend_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
