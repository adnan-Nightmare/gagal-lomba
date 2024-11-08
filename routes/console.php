<?php

use App\Models\Order;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('orders:update-status', function () {
    $orders = Order::where('status', 'pending')
        ->orWhere('status', 'processing')
        ->get();

    foreach ($orders as $order) {
        $order->updateStatus();
    }
})->describe('Update order statuses every 10 minutes');