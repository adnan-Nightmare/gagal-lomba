
<x-layout>
    <div class="flex justify-center items-center flex-col">
        <div class="bg-white w-[60rem] shadow my-5">
            <h1 class="p-3">Shopping Cart</h1>
        </div>

        <form action="{{ route('checkout.selected') }}" method="POST">
            @csrf
        <ul class="flex flex-col gap-8">
            @foreach ($carts as $cart)
            @php
                $price = $cart->product->price;
                $items = $cart->quantity;

                $totalPrice = $price * $items;
            @endphp

            <div class="bg-white shadow">
                <div class="flex flex-col">
                    <div class="flex gap-3 p-2 border-b">
                        <input type="checkbox" class="item-checkbox" name="selected_items[]" value="{{ $cart->id }}" id="" data-price="{{ $cart->product->price * $cart->quantity }}">
                        <a href="#" class="font-semibold">{{ $cart->product->toko }}</a>
                        <a href="#" class="border px-2 bg-sky-300 font-semibold rounded text-sm text-center">Chat</a>
                    </div>
            
                    <div class="flex p-2 gap-3">
                        <div class="flex gap-3">
                            <img src="{{ asset($cart->product->thumbnail ? 'images/products/' . $cart->product->thumbnail : 'https://placehold.co/600x400/png') }}" alt="..." class="w-28">
                            <h1 class="w-40 font-semibold text-sm">{{  $cart->product->judul }}</h1>
                        </div>
            
                        <div class="flex justify-center items-center mx-10">
                            <h1 class="w-20">$ {{ number_format($cart->product->price, 2, ',', '.') }}</h1>
                        </div>
            
                        <div class="flex justify-center items-center mx-10">
                            <h1 class="w-20">{{ $cart->quantity }}</h1>
                        </div>
            
                        <div class="flex justify-center items-center mx-10">
                            <h1 class="w-20">$ {{ number_format($totalPrice, 2, ',', '.') }}</h1>
                        </div>
            
                        
                        <div class="flex justify-center items-center mx-10">
                            <button type="button" onclick="removeCartItem({{ $cart->id }})" class="text-red-500">Hapus</button>
                        </div>
            
                    </div>
            
            
                </div>
            </div>
            @endforeach
        </ul>

        <div class="bg-white w-[60rem] shadow my-10 flex items-center justify-end p-3 gap-5">
            <h1 class="font-semibold text-lg">$ <span id="total-price">0.00</span></h1>
                <button type="submit" class="bg-sky-400 px-3" id="check">CheckOut</button>
            </div>
        </form>
    </div>

    <script>
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const totalPriceElement = document.getElementById('total-price');


        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });

        function calculateTotal() {
            let total = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    total += parseFloat(checkbox.getAttribute('data-price'));
                }
            });
            totalPriceElement.textContent = total.toFixed(2);
        }

        function removeCartItem(cartId) {
        if (confirm("Yakin ingin menghapus item ini dari keranjang?")) {
            fetch(`/user/${cartId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hapus item dari tampilan
                    location.reload(); // Atau perbarui total harga dan elemen terkait lainnya
                } else {
                    alert('Gagal menghapus item. Coba lagi.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
    </script>
</x-layout>