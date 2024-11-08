@props(['product'])
<a href="product/{{ $product->slug }}">
    <div class="w-40 h-48 rounded-xl shadow-lg">
        <img src="{{ asset($product->thumbnail ? 'images/products/' . $product->thumbnail : 'https://placehold.co/600x400/png') }}" alt="" class="rounded-t-xl">
        <div class="p-1">
            <h1 class="text-sm font-semibold">{{ $product->judul }}</h1>
            <p class="text-xs text-gray-400">
                @foreach ($product->category as $category)
                    {{ $category->name }}
                @endforeach
            </p>
    
            <h5 class="text-sm font-bold">$ {{ $product->price }}</h5>
        </div>
    </div>
</a>
