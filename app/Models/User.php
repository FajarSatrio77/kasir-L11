<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\LogsActivity;

class User extends Authenticatable
{


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'peran',
        'tipe_pelanggan',
        'poin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function rules($isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'peran' => 'required|in:admin,pemilik,kasir,pelanggan',
            'tipe_pelanggan' => 'nullable|in:1,2,3',
        ];

        if (!$isUpdate) {
            $rules['password'] = 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/';
            $rules['password_confirmation'] = 'required|same:password';
        } else {
            $rules['password'] = 'nullable|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/';
            $rules['password_confirmation'] = 'nullable|same:password';
        }

        return $rules;
    }

    protected function getActivityDescription($action)
    {
        switch ($action) {
            case 'created':
                return "Membuat user baru {$this->name} ({$this->email})";
            case 'updated':
                return "Memperbarui user {$this->name} ({$this->email})";
            case 'deleted':
                return "Menghapus user {$this->name} ({$this->email})";
            default:
                return "Melakukan aksi {$action} pada user {$this->name} ({$this->email})";
        }
    }
}
