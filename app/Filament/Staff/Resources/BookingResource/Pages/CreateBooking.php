<?php

namespace App\Filament\Staff\Resources\BookingResource\Pages;

use Filament\Actions;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaketSaya;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Staff\Resources\BookingResource;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;


      protected function mutateFormDataBeforeCreate(array $data): array
    {
        // $data['created_by'] = auth()->id();

        // dd($data);
        // DB::transaction(function () use ($data) {

        //     /** 1️⃣ CREATE BOOKING */
        //     $booking = Booking::create([
        //         'customer_id' => $data['data']['customer_id'],
        //         'paket_umroh_id' => $data['data']['paket_id'],
        //         'jadwal_keberangkatan_id' => $data['data']['jadwal_keberangkatan_id'],
        //         'booking_code' => $data['data']['booking_id'],
        //         'status' => 'waiting_payment',
        //         'total_price' => $data['data']['paket_details']['harga_paket'],
        //         'sisa_tagihan' => $data['data']['paket_details']['harga_paket'],
        //         'metode_pembayaran' => $data['data']['payment']['metode_pembayaran'],
        //         'created_by' => auth()->id(),
        //     ]);

        //     /** 2️⃣ CREATE PAYMENT */
        //     $payment = Payment::create([
        //         'booking_id' => $booking->id,
        //         'customer_id' => $data['data']['customer_id'],
        //         'jumlah_bayar' => $data['data']['payment']['jumlah_bayar'],
        //         'tanggal_bayar' => $data['data']['tanggal_bayar'],
        //         'metode_pembayaran' => $data['data']['payment']['metode_pembayaran'],
        //         'bukti_bayar' => $data['data']['payment']['bukti_bayar'],
        //         'status' => 'unverified',
        //         'created_by' => auth()->id(),
        //     ]);

        //     /** 3️⃣ CREATE PAKET SAYA */
        //     PaketSaya::create([
        //         'customer_id' => auth()->user()->customer->id,
        //         'paket_id' => $data['data']['paket_id'],
        //         'booking_id' => $booking->id,
        //         'payment_id' => $payment->id,
        //         'created_by' => auth()->id(),
        //     ]);

        //     /** 4️⃣ UPDATE BOOKING */
        //     $sisa = max(
        //         0,
        //         $booking->sisa_tagihan - $payment->jumlah_bayar
        //     );

        //     $booking->update([
        //         'sisa_tagihan' => $sisa,
        //         'status' => $sisa === 0 ? 'paid' : 'partial',
        //     ]);
        // });

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
