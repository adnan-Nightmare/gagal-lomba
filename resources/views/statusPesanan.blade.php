<x-layout>
    <div class="flex justify-center items-center flex-col">
        <div class="bg-white w-[60rem] shadow my-5">
            <h1 class="p-3">Shopping Cart</h1>
        </div>

        <ul class="flex flex-col gap-8">
            @foreach($orders as $order)
            @if($order->items->isNotEmpty())
                @foreach($order->items as $item)
                <div class="bg-white shadow w-[60rem]">
                    <div class="flex flex-col">
                        <div class="flex justify-between gap-3 p-2 px-3 border-b">
                            <div class="flex gap-3">
                                <a href="#" class="font-semibold">{{ $item->product->toko }}</a>
                                <a href="#" class="border px-2 bg-sky-300 font-semibold rounded text-sm text-center">Chat</a>
                            </div>
                            <div>
                                <h1 class="font-semibold">{{ $order->status }}</h1>
                            </div>
                        </div>
                
                        <div class="flex p-2 gap-3 justify-between items-center">
                            <div class="flex gap-3">
                                <img src="{{ asset($item->product->thumbnail ? 'images/products/' . $item->product->thumbnail : 'https://placehold.co/600x400/png') }}" alt="..." class="w-28">
                                <div class="flex flex-col">
                                    <h1 class="font-semibold text-sm">{{ $item->product->judul }}</h1>
                                    <p>x{{ $item->quantity }}</p>
                                </div>
                            </div>
    
                            <h1 class="pr-5 text-lg">$ {{ $item->price }}</h1>
                        </div>
    
                        <hr class="my-3">
                
                        <div class="justify-end flex p-3">
                            <h1 class="font-semibold">Total Pesanan: <span class="font-bold text-xl">$ {{ $item->quantity * $item->price }}</span></h1>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <tr>
                    <td colspan="4">Tidak ada item untuk pesanan ini.</td>
                </tr>
            @endif
        @endforeach
        </ul>

    </div>
    @section('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        setInterval(function() {
            fetch("{{ route('orders.updateStatus') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); 
                    }
                })
                .catch(error => console.error('Error updating status:', error));
        }, 60000);
    });
    </script>
@endsection
</x-layout>