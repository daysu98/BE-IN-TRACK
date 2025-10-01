<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
	class CallOfDuty extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $user_id
 * @property CheckAttendStatus $status
 * @property string $tanggal
 * @property string|null $jam_masuk
 * @property string|null $jam_keluar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TempInternAttend> $temp_intern_attends
 * @property-read int|null $temp_intern_attends_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend whereJamKeluar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InternAttend whereUserId($value)
 * @property-read string $tanggal_iso
 * @mixin \Eloquent
 */
	class InternAttend extends \Eloquent {}
}

namespace App\Models{
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
 * @property-read string $deadline_iso
 * @mixin \Eloquent
 */
	class JobIntern extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $tokenable_type
 * @property string $tokenable_id
 * @property string $name
 * @property string $token
 * @property array<array-key, mixed>|null $abilities
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $tokenable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereTokenableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereTokenableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class PersonalAccessToken extends \Eloquent {}
}

namespace App\Models{
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
	class PicketTask extends \Eloquent {}
}

namespace App\Models{
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
	class TempInternAttend extends \Eloquent {}
}

namespace App\Models{
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
	class TempJobIntern extends \Eloquent {}
}

namespace App\Models{
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
	class User extends \Eloquent {}
}

