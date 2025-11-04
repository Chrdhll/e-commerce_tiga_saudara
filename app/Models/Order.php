<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_price',
        'status',
        'payment_status',
        'shipping_address',
        'phone_number',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    /**
     * Relasi: Satu Pesanan dimiliki oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Pesanan memiliki banyak OrderItem (detail produk).
     * Kita pakai nama 'items' agar lebih gampang dipanggil: $order->items
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    protected function formattedStatus(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => match ($attributes['status']) {
                'pending' => 'Menunggu',
                'processing' => 'Diproses',
                'shipped' => 'Dikirim',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default => $attributes['status'],
            },
        );
    }

    protected function statusColor(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => match ($attributes['status']) {
                'pending' => 'warning',
                'processing' => 'info',
                'shipped' => 'primary',
                'completed' => 'success',
                'cancelled' => 'danger',
                default => 'secondary',
            },
        );
    }

    protected function formattedPaymentStatus(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => match ($attributes['payment_status']) {
                'unpaid' => 'Belum Dibayar',
                'paid' => 'Sudah Dibayar',
                default => $attributes['payment_status'],
            },
        );
    }

    protected function paymentStatusColor(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => match ($attributes['payment_status']) {
                'unpaid' => 'warning',
                'paid' => 'success',
                default => 'secondary',
            },
        );
    }

    /**
     * Relasi (Opsional tapi keren):
     * Melihat produk apa saja dalam 1 order, via tabel 'order_items'.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price'); // Ambil juga data quantity & price
    }
}
