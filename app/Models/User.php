<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HashableId, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nidn',
        'address',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'user' => $this->roles->first()->name, // Include roles as a claim
        ];
    }

    public function kaprodi()
    {
        return $this->hasOne(Kaprodi::class);
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    public function scopeDppmRole($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'dppm');
        });
    }

    public function scopeKaprodiRole($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'kaprodi');
        });
    }

    public function scopeDosenRole($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'dosen');
        });
    }

    public function scopeKeuanganRole($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'keuangan');
        });
    }

    public function scopeActiveKaprodi($query, $type)
    {
        return $query->whereHas('kaprodi', function ($query) use ($type) {
            $query->where('is_active', $type);
        });
    }

    public function scopeActiveDosen($query, $type)
    {
        return $query->whereHas('dosen', function ($query) use ($type) {
            $query->where('is_active', $type);
        });
    }

    public function scopeApprovedDosen($query, $type)
    {
        return $query->whereHas('dosen', function ($query) use ($type) {
            $query->where('is_approved', $type);
        });
    }

    public function scopeDosenNotNullProfile($query)
    {
        return $query->whereHas('dosen', function ($query) {
            $query->whereNotNull([
                'name',
                'nidn',
                'phone_number',
                'scholar_id',
                'scopus_id',
                'job_functional',
                'affiliate_campus',
            ]);
        });
    }

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
}
