@props(['product'])
<div class="border rounded-lg w-52 h-fit p-2">
    <h2 class="font-semibold">Atur jumlah dan catatan</h2>
    <div class="flex items-center my-5 gap-2">
        <img src="https://placehold.co/600x400/png" alt="" class="rounded-lg w-14 h-14">
        <p>{{ $product->judul }}</p>
    </div>

    <form action="{{ route('store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="flex gap-2">
            <input type="number" name="quantity" value="1" id="quantity1" min="1" class="border rounded-lg w-20 pl-8" required>
            <p class="font-semibold">Stock: <span class="text-red-500 font-semibold">Sisa {{ $product->stock_quantity }}</span></p>
        </div>
    
        <div class="flex justify-between mt-10">
            <div>
                SubTotal
            </div>
            <div>
                <h4 class="font-bold">$ {{ $product->price }}</h4>
            </div>
        </div>
        <div class="flex flex-col gap-2 mt-4">
            <button type="submit" class="bg-green-600 rounded-lg text-white p-1">+ Keranjang</button>
    </form>
    <form action="{{ route('buy') }}" method="post">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <input type="hidden" value="1" id="quantity2" name="quantity">
        <button type="submit" class="border border-green-600 rounded-lg text-green-600 p-1">Beli Langsung</button>
    </form>
        </div>

    </div>

