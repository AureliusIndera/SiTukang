<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gajis';

    protected $fillable = [
        'tukang_id',
        'bulan',
        'tahun',
        'total_hari_kerja',
        'total_gaji',
        'status_pembayaran',
        'dibayar_pada',
        'dibayar_oleh',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'total_gaji'  => 'decimal:2',
            'dibayar_pada' => 'datetime',
            'bulan'        => 'integer',
            'tahun'        => 'integer',
        ];
    }

    public function tukang(): BelongsTo
    {
        return $this->belongsTo(Tukang::class);
    }

    public function dibayarOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibayar_oleh');
    }

    public function scopePeriode($query, int $bulan, int $tahun)
    {
        return $query->where('bulan', $bulan)->where('tahun', $tahun);
    }

    public function scopePending($query)
    {
        return $query->where('status_pembayaran', 'pending');
    }

    public function scopeDibayar($query)
    {
        return $query->where('status_pembayaran', 'dibayar');
    }

    public function getTotalGajiFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->total_gaji, 0, ',', '.');
    }

    public function getBulanLabelAttribute(): string
    {
        $bulanList = [
            1  => 'Januari',   2  => 'Februari', 3  => 'Maret',
            4  => 'April',     5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',      8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',   11 => 'November',  12 => 'Desember',
        ];

        return $bulanList[$this->bulan] ?? '-';
    }

    public function getPeriodeLabelAttribute(): string
    {
        return $this->bulan_label . ' ' . $this->tahun;
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->status_pembayaran === 'dibayar' ? 'success' : 'warning';
    }
}
