
<header class="bg-sky-300 p-5 flex items-center justify-between px-20">
    <a href="{{ route('home') }}"><h1 class="font-semibold capitalize">ini home page</h1></a>

    <div class="flex">
        <form class="inline-flex items-center gap-2">
            <input type="text" placeholder="Search..." class="border-2 px-3 rounded-md">
        </form>
    </div>
    
    <div class="flex items-center gap-5">
        <a href="{{ route('showCart') }}">Cart</a>
        @guest
        <i class="fa-solid fa-cart-shopping"></i>
        <a href="{{ route('login') }}">Login</a>
        @endguest
        @auth
        <div class="relative flex items-center gap-3" x-data="{isAktif: false}">
            <img @click="isAktif = !isAktif" src="{{ asset(Auth::user()->profile ? 'profileUsers/' . Auth::user()->profile : 'https://placehold.co/600x400/png') }}" alt="..." class="rounded-full w-8 h-8 object-cover">
            <h1 class="text-sm">{{ Auth::user()->username }}</h1>

            <div x-show="isAktif" class="bg-white shadow-md rounded-lg absolute -bottom-[5.3rem] w-32 h-fit left-0 p-2">
                <ul class="*:text-sm">
                    <li><a href="{{ route('profile') }}" class="">Akun Saya</a></li>
                    <li><a href="{{ route('purchase.showPurchase') }}">Pesanan Saya</a></li>
                    @if ($store)
                        <li><a href="{{ route('myStore') }}">Kelola Toko</a></li>
                    @endif
                    <li><a href="{{ route('logout') }}">Log out</a></li>
                </ul>
            </div>
        </div>
        @endauth
    </div>
</header>