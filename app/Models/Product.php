<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <--- TAMBAHKAN BARIS INI
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'unit',     // Ditambahkan dari desain
        'discount', // Ditambahkan dari desain
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    /**
     * Relasi: Satu Produk dimiliki oleh satu Kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Satu Produk bisa ada di banyak OrderItem.
     * (Ini opsional tapi berguna jika ingin lihat histori produk)
     */
    public function orderItems(): HasMany // <--- Error merah akan hilang
    {
        // (Ini dari model Anda, biarkan saja)
        // return $this->hasMany(OrderItem::class);
        
        // Jika Anda belum punya model OrderItem, komentari saja isinya
        // agar tidak error saat aplikasi berjalan
        return $this->hasMany(OrderItem::class); // Pastikan Anda punya model OrderItem
    }

    /**
     * Accessor: Menghitung harga final setelah diskon.
     * Ini penting untuk 'ProductCard'
     */
    public function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->discount
                ? $this->price - ($this->price * $this->discount / 100)
                : $this->price
        );
    }
}