<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'tukang_id',
        'proyek_id',
        'mandor_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
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

    public function mandor(): BelongsTo
    {
        return $this->belongsTo(Mandor::class);
    }

    public function scopeHadir($query)
    {
        return $query->where('status', 'Hadir');
    }

    public function scopeBulanIni($query, int $bulan, int $tahun)
    {
        return $query->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);
    }

    public function scopeProyek($query, int $proyekId)
    {
        return $query->where('proyek_id', $proyekId);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Hadir' => 'success',
            'Absen' => 'danger',
            'Izin'  => 'warning',
            default => 'secondary',
        };
    }
}
