<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get all of the orders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The books that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot(['status', 'type'])->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->role->name == 'Admin';
    }

    public function getLastOrder($book_id, $status = null, $type = null)
    {
        if ($status && $type) {
            return $this->books()->wherePivot('book_id', $book_id)->wherePivot('type', $type)->wherePivot('status', $status)->latest()->first();
        } else if ($status && !$type) {
            return $this->books()->wherePivot('book_id', $book_id)->wherePivot('status', $status)->latest()->first();
        } else if (!$status && $type) {
            return $this->books()->wherePivot('book_id', $book_id)->wherePivot('type', $type)->latest()->first();
        } else {
            return $this->books()->wherePivot('book_id', $book_id)->latest()->first();
        }
    }

    public function lastOrder($book_id)
    {
        return $this->books()->wherePivot('book_id', $book_id)->latest()->first();
    }
}
