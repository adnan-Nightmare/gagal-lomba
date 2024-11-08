<x-layout>
    <div class="flex justify-between bg-white shadow p-5 px-20">
        <div class="flex gap-3  items-center">
            <img src="https://placehold.co/600x400/png" alt="" class="w-20 h-20 object-cover rounded-full">
            <h1 class="font-semibold text-lg">{{ $store->name }}</h1>
        </div>


        <div class="w-fit">
            <h2>
                @if ($store->description === null)
                    descripsi belum ditambahkan
                @else
                    {{ $store->description }}
                @endif
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-5">
        @foreach ($product as $item)
        <x-util.card :product="$item"/>
            
        @endforeach
    </div>

</x-layout>