<x-layout>
    <div class="flex justify-center items-center">
        <div class="shadow p-2 w-96">
            <div class="flex justify-between items-center">
                <h1 class="py-1">My store | {{ $store->name }}</h1>

                <a href="{{ route('createProduct') }}">Create</a>
            </div>

            <hr class="my-5">

            @if ($products->isEmpty())
            <div class="flex justify-center">
                <p>Data Tidak Ditemukan</p>
            </div>
            @else
                <ul class="grid grid-cols-3 gap-5 gap-x-56">
                    @foreach ($products as $product)        
                    <li>
                        <x-util.card :product="$product"/>
                    </li>
                    @endforeach
                </ul>
            @endif


            {{-- @foreach ($products as $product)
                <div class="mb-4">
                    <h2>{{ $product->name }}</h2>
                    <p>{{ $product->description }}</p>
                    <p class="text-right">Price: ${{ $product->price }}</p>
                </div>
            @endforeach --}}

        </div>
    </div>
</x-layout>