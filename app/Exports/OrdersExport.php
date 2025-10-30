<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Ambil semua pesanan, join dengan user untuk dapat nama
        return Order::with('user')->get();
    }

    /**
     * Tentukan judul kolom (Header)
     */
    public function headings(): array
    {
        return [
            'Invoice',
            'Pelanggan',
            'Status Pesanan',
            'Status Pembayaran',
            'Total Harga',
            'Alamat Pengiriman',
            'Tanggal Pesan',
        ];
    }

    /**
     * Mapping data: Tentukan data apa di setiap baris
     * @var Order $order
     */
    public function map($order): array
    {
        return [
            $order->invoice_number,
            $order->user->name,
            $order->status,
            $order->payment_status,
            $order->total_price,
            $order->shipping_address,
            $order->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
