<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyIntegerCast;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Laravel\Pennant\Concerns\HasFeatures;
use Prime\Extension\Models\Traits\HasExtension;
use Prime\Insurance\Models\Traits\HasInsurance;
use Prime\Maintenance\Models\Traits\HasMaintenance;
use Prime\Models\Traits\HasDocuments;
use Prime\Models\Traits\HasModules;
use Prime\Vehicle\Models\Traits\HasVehicle;
use TMS\Account\Models\Company\CompanyDocument;
use TMS\Account\Models\Company\CompanyDocumentCategory;
use TMS\Core\Models\Alert;
use TMS\Driver\Models\Driver\Driver;
use TMS\User\Models\UserCompany;
use TMSPrime\Chat\Traits\HasChat;
use TMSPrime\Wallet\Traits\HasWallet;

class Company extends Model
{
    use HasChat,
        HasDocuments,
        HasFactory,
        HasFeatures,
        HasExtension,
//        HasInsurance,
        HasMaintenance,
        HasModules,
        HasVehicle,
        HasWallet;

    const DAYS_GRACE_PERIOD = 85;

    protected $guarded = [];

    protected $casts = [
        'card_added_at' => 'datetime',
        'card_expired_at' => 'date',
        'minimum_balance' => MoneyIntegerCast::class,
        'auto_deposit' => MoneyIntegerCast::class,
        'suspended_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted()
    {
        parent::boot();

        parent::creating(function ($model) {
            $model->created_by = auth()->check() ? auth()->user()->id : 0;
        });
    }

    // Methods

    public function isCompleted(): bool
    {
        return ! is_null($this->completed_at);
    }

    /**
     * Check if company is suspended
     */
    public function isSuspended(): bool
    {
        return ! is_null($this->suspended_at);
    }

    public function getDocker()
    {
        return $this->mc_type.' '.$this->mc_number;
    }

    public function getLogoUrl(): string
    {
        return ! empty($this->attributes['logo']) ? urlCloud($this->attributes['logo']) : '';
    }

    public function getFullAddress(): string
    {
        return collect([
            $this->attributes['address'],
            $this->attributes['city'],
            $this->attributes['state'],
            $this->attributes['zip'],
        ])->implode(', ');
    }

    public static function generateSlug(string $name, int $id): string
    {
        $slug = Str::slug($name);

        $company = self::where('slug', $slug)->first();

        if (empty($company)) {
            return $slug;
        } else {
            return $slug.'-'.$id;
        }
    }

    public function showWelcomePopup(): bool
    {
        return is_null($this->welcome_popup);
    }

    public function hasSlug(): bool
    {
        return ! is_null($this->slug);
    }

    //Scope
    public function scopeSlug(Builder $builder, $slug): Builder
    {
        return $builder->where('slug', $slug);
    }

    public function scopeCompleted(Builder $builder): Builder
    {
        return $builder->whereNotNull('completed_at');
    }

    // Methods

    /**
     * ATM we need Pull Notice only for company from California.
     * Companies from non california state. we don't need
     */
    public function hasPullNotice(): bool
    {
        return $this->state === 'CA';
    }

    // Relationship
    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_companies')->using(UserCompany::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }

    public function documents()
    {
        return $this->hasMany(CompanyDocument::class);
    }

    public function documentCategories()
    {
        return $this->hasMany(CompanyDocumentCategory::class);
    }

    public function files()
    {
        return $this->hasMany(\TMS\Core\Models\File::class);
    }
}
