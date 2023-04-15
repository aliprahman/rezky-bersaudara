<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Sale extends Model
{
    use HasFactory;

    /*
    * The "booted" method of the model.
    */
   protected static function booted(): void
   {
       static::created(function (Sale $sale) {
           $code = Carbon::createFromFormat('Y-m-d H:i:s', $sale->sale_date)->format('Ymd');
           $code .= str_pad($sale->id, 5, "0", STR_PAD_LEFT);

           $sale->code = $code;
           $sale->total = $sale->price * $sale->quantity;
           $sale->save();
       });
   }

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
       'code',
       'sale_date',
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
       'sale_date' => 'datetime',
   ];

   /**
     * Interact with the quantity.
     */
    protected function quantity(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str_replace(".", "", $value),
        );
    }


   public function product(): BelongsTo
   {
       return $this->belongsTo(Product::class);
   }

   public function user(): BelongsTo
   {
       return $this->belongsTo(User::class);
   }
}
