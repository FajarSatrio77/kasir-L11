<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasActivityLogs;

class Kategori extends Model
{
    use HasActivityLogs;

    protected $fillable = [
        'name',
        'description'
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }

    protected function getActivityDescription($action)
    {
        switch ($action) {
            case 'created':
                return "Membuat kategori baru {$this->name}";
            case 'updated':
                return "Memperbarui kategori {$this->name}";
            case 'deleted':
                return "Menghapus kategori {$this->name}";
            default:
                return "Melakukan aksi {$action} pada kategori {$this->name}";
        }
    }
} 