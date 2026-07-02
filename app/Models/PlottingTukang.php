<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlottingTukang extends Model
{
    use HasFactory;

    protected $table = 'plotting_tukangs';

    protected $fillable = [
        'tukang_id',
        'proyek_id',
        'tarif_harian',
        'tanggal_masuk',
        'tanggal_keluar',
    ];

    protected function casts(): array
    {
        return [
            'tarif_harian'   => 'decimal:2',
            'tanggal_masuk'  => 'date',
            'tanggal_keluar' => 'date',
        ];
    }

    public function tukang(): BelongsTo
    {
        return $this->belongsTo(Tukang::class);
    }

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }

    public function getTarifFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->tarif_harian, 0, ',', '.');
    }

    public function getIsAktifAttribute(): bool
    {
        return is_null($this->tanggal_keluar);
    }
}
