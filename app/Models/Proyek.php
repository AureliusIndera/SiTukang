<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyek extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_proyek',
        'lokasi',
        'status_proyek',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function tukangs(): BelongsToMany
    {
        return $this->belongsToMany(Tukang::class, 'plotting_tukangs')
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

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_proyek) {
            'pending'  => 'Menunggu',
            'aktif'    => 'Aktif',
            'selesai'  => 'Selesai',
            default    => ucfirst($this->status_proyek),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status_proyek) {
            'pending'  => 'warning',
            'aktif'    => 'success',
            'selesai'  => 'secondary',
            default    => 'secondary',
        };
    }
}
