
<x-layout>
    <h1>Checkout</h1>

<form action="{{ route('orders.placeOrder') }}" method="POST">
    @csrf
    <label for="address">Alamat Pengiriman</label>
    <input type="text" name="address" required>

    <h2>Produk yang Dipesan</h2>
    @foreach($selectedCarts  as $cart)
    <div>
        <input type="checkbox" name="items[]" value="{{ $cart->id }}" id="item{{ $cart->id }}" checked hidden>
        <p>{{ $cart->product->judul }} - Quantity: {{ $cart->quantity }} - Price: ${{ $cart->product->price }}</p>
    </div>
        {{-- <input type="hidden" name="" value=""> --}}
    @endforeach

    <h2>Metode Pengiriman</h2>
    @foreach($shippingMethods as $method)
        <div>
            <input type="radio" id="shipping{{ $method->id }}" name="shipping_method_id" value="{{ $method->id }}">
            <label for="shipping{{ $method->id }}">{{ $method->name }} - ${{ $method->cost }}</label>
        </div>
    @endforeach

    <h2>Rincian Biaya</h2>
    <p>Subtotal: ${{ $selectedCarts ->sum(function ($cart) { return $cart->product->price * $cart->quantity; }) }}</p>
    <p>Biaya Pengiriman: $<span id="shippingCost">0.00</span></p>
    <p>Pajak Aplikasi: $5.00</p>
    <p>Total: $<span id="totalAmount">0.00</span></p>

    <button type="submit">Place Order</button>
</form>

<script>
    document.querySelectorAll('input[name="shipping_method_id"]').forEach((element) => {
        element.addEventListener('change', function() {
            const shippingCost = parseFloat(this.nextElementSibling.textContent.split('$')[1]);
            const subtotal = {{ $selectedCarts ->sum(function ($cart) { return $cart->product->price * $cart->quantity; }) }};
            const tax = 5.00; // Pajak tetap
            const total = subtotal + shippingCost + tax;
            document.getElementById('shippingCost').textContent = shippingCost.toFixed(2);
            document.getElementById('totalAmount').textContent = total.toFixed(2);
        });
    });
</script>
</x-layout>