<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'aksi',
        'model',
        'model_id',
        'detail',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'detail' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function catat(
        int $userId,
        string $aksi,
        string $model = null,
        int $modelId = null,
        array $detail = [],
        string $ip = null
    ): self {
        return self::create([
            'user_id'    => $userId,
            'aksi'       => $aksi,
            'model'      => $model,
            'model_id'   => $modelId,
            'detail'     => $detail,
            'ip_address' => $ip,
        ]);
    }
}
