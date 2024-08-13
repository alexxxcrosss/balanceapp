<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    /**
     * фильтрованные операциии пользователя
     *
     * @param string $search
     * @param string $sortOrder
     * @param integer $perPage
     * @return void
     */
    public function getFilteredOperations(string $search = '', string $sortOrder = 'desc', int $perPage = 5)
    {
        $query = $this->operations()
            ->where('description', 'like', '%' . $search . '%')
            ->orderBy('created_at', $sortOrder)
            ->paginate($perPage)
            ->withQueryString();

        return $query;
    }

    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
