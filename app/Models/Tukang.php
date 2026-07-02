<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tukang extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_tukang',
        'no_hp',
        'alamat',
        'skill',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function proyeks(): BelongsToMany
    {
        return $this->belongsToMany(Proyek::class, 'plotting_tukangs')
                    ->withPivot(['tarif_harian', 'tanggal_masuk', 'tanggal_keluar'])
                    ->withTimestamps();
    }

    public function plottings(): HasMany
    {
        return $this->hasMany(PlottingTukang::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function gajis(): HasMany
    {
        return $this->hasMany(Gaji::class);
    }
}
