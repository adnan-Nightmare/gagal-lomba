<x-layout>
    <div class="flex p-5 px-32">
        <img src="{{ asset($product->thumbnail ? 'images/products/' . $product->thumbnail : 'https://placehold.co/600x400/png') }}" alt="..." class="w-[28rem] h-96">
        <div class="w-[30rem] px-5">
            <h2 class="font-bold text-xl capitalize">{{ $product->judul }}</h2>
            <h1 class="font-bold text-3xl mt-5">$ <span>{{ $product->price }}</span></h1>

            <h3 class="mt-10 font-semibold">Pilihan Model: <span class="text-gray-500">Clear</span></h3>
            {{-- <div class="grid grid-cols-4 gap-2 mt-5">
                @for ($i = 0; $i<5 ; $i++)  
                <button class="border rounded-lg flex p-1 gap-2 w-fit items-center">
                    <img src="" alt="..." class="rounded-lg w-7 h-7">
                    <h5>Wheat</h5>
                </button>
                @endfor
            </div> --}}

            <div class="mt-5">
                <div class="flex gap-5 mb-3">
                    <button class="border-b border-black">Detail</button>
                    <button>Spesifikasi</button>
                    <button>Info Penting</button>
                </div>

                <div id="Detail">
                    <h4 class="text-gray-600">Kondisi: <span class="text-black">Baru</span></h4>
                    <h4 class="text-gray-600">Min. Pemesanan: <span class="text-black">1 Buah</span></h4>
                    <h4 class="text-gray-600">Etalase: <a href="/store/{{ $product->toko }}" class="text-black">{{ $product->toko }}</a></h4>

                    <br>

                    <p>{!! nl2br(e($product->description)) !!}</p>
                </div>
            </div>
        
        </div>

        <x-util.order :product="$product"/>

    </div>

    <script>
        const quantity1 = document.getElementById('quantity1')
        const quantity2 = document.getElementById('quantity2')

        quantity1.addEventListener('input',function () {
            quantity2.value = quantity1.value
        })
    </script>

</x-layout>