<x-layout>
    <h1>Checkout</h1>

    <p>Total Pembayaran: ${{ $order->total_amount }}</p>
    <p>Alamat: {{ $order->address }}</p>

    <h2>Metode Pengiriman</h2>
    <p>{{ $order->shipping_method }}</p>    

    <h2>Metode Pembayaran</h2>
    <p>QRIS - Midtrans</p>

    <button id="pay-button">Bayar Sekarang</button>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert("Pembayaran berhasil!");
                    window.location.href = "/user/success";
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran!");
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                }
            });
        };
    </script>
</x-layout>