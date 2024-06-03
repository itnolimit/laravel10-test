<?php

declare(strict_types=1);

namespace App;

use App\Models\Company;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Spatie\ModelFlags\Models\Concerns\HasFlags;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        HasRoles,
        HasFlags,
        HasPermissions,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'company_id', 'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('name', function (Builder $builder) {
            $builder->oldest('name');
        });
    }

    // Scope
    public function scopeUuid(Builder $builder, string $uuid)
    {
        return $builder->where('uuid', $uuid);
    }

    //Methods

    public function getByIds(array $ids)
    {
        return self::whereIn('id', $ids)->get();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'users_companies', 'user_id', 'company_id');
    }

    public function isAdministrator(): bool
    {
        return ! $this->roles->isEmpty() && $this->roles()->first()->name == 'Administrator' ? true : false;
    }

    /**
     * Route notifications for the Slack channel.
     */
    public function routeNotificationForSlack(Notification $notification): string
    {
        return 'https://hooks.slack.com/services/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';
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
