<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Transaction $transaction) {
            $code = '';
            if ($transaction->type == 1) {
                $code .= 'JL-';
            } else {
                $code .= 'BL-';
            }
            $code .= Carbon::createFromFormat('Y-m-d H:i:s', $transaction->transaction_date)->format('Ymd');
            $code .= str_pad($transaction->id, 5, "0", STR_PAD_LEFT);

            $transaction->code = $code;
            $transaction->save();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'code',
        'transaction_date',
        'product_id',
        'price',
        'quantity',
        'total',
        'notes',
        'user_id',
        'ref'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ref' => 'array',
        'transaction_date' => 'datetime',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
