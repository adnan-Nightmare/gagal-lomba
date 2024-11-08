<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopNow - E-commerce Homepage</title>
    <link rel="icon" href="assets/anl-team-removebg-preview.png" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/alpine.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        @layer utilities {
            .bg-gradient {
                background: linear-gradient(135deg, #e0f7fa, #e1bee7);
            }
            .category-hover:hover {
                background-color: #e0f4ff;
            }
            .search-transition {
                transition: all 0.5s ease-in-out;
            }
        }
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .card3D {
            position: relative;
            perspective: 1000px;
        }
        .card3D .inner-card {
            transition: transform 0.3s;
            transform-style: preserve-3d;
        }
        .card3D:hover .inner-card {
            transform: rotateY(10deg) rotateX(10deg) scale(1.05);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }
        .bar { transition: all 0.3s ease; }
        .bar.open { background: #4A5568; }
    </style>
</head>
<body class="bg-gradient font-sans text-gray-900 fade-in" x-data="ecommerceHome()" x-init="init()">

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col items-center" x-show="true" x-transition>

        <header class="w-full max-w-6xl flex justify-between items-center p-5 bg-white shadow-lg rounded-b-xl sticky top-0 z-10 transition duration-300 ease-in-out"
            x-show="true" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 -translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0">
            <div class="flex items-center space-x-3">
                <img src="https://github.com/EVANluasi/anl_team/blob/main/public/home/assets/anl-team-removebg-preview.png?raw=true" alt="ShopNow Logo" class="w-12 h-12">
                <span class="text-3xl font-bold text-indigo-600 hidden md:block">ShopNow</span>
            </div>

            <div class="flex items-center space-x-4">
                <button class="relative" @click="toggleSearch" aria-label="Search">
                    <img src="assets/search-removebg-preview.png" alt="Search" class="w-8 h-8 cursor-pointer transition duration-200 ease-in-out transform hover:scale-110">
                </button>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" aria-label="Menu" class="focus:outline-none">
                        <div class="space-y-1">
                            <span class="block w-6 h-0.5 bg-gray-800 bar" :class="{'open': open, 'transform rotate-0': !open, 'rotate-45 translate-y-1.5': open}"></span>
                            <span class="block w-6 h-0.5 bg-gray-800 bar" :class="{'open': open, 'opacity-100': !open, 'opacity-0': open}"></span>
                            <span class="block w-6 h-0.5 bg-gray-800 bar" :class="{'open': open, 'transform rotate-0': !open, '-rotate-45 -translate-y-1.5': open}"></span>
                        </div>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            <a href="{{ route('profile') }}" @click="viewAccount" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Account</a>
                            <a href="{{ route('purchase.showPurchase') }}" @click="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">My Order</a>
                            <a href="{{ route('myStore') }}" @click="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">My Store</a>
                            <a href="{{ route('logout') }}" @click="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div x-show="searchOpen" x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 transform -translate-y-3"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-3"
             class="w-full max-w-6xl px-4 mt-2 search-transition">
            <input type="text" placeholder="Search for products..."
                   class="w-full p-3 rounded-lg shadow-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   x-ref="searchInput">
        </div>

        <section class="w-full max-w-6xl mt-4 p-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg text-white flex items-center transform transition-all duration-500 ease-in-out hover:scale-105 fade-in">
            <img src="assets/tag-removebg-preview.png" alt="Promo" class="w-16 h-16">
            <div class="ml-4">
                <h2 class="text-2xl font-semibold">Exclusive Offer!</h2>
                <p class="text-sm">Get 20% off on your first purchase</p>
            </div>
        </section>

        <section class="w-full max-w-6xl mt-6 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 px-4">
            <template x-for="(category, index) in categories" :key="index">
                <div class="bg-white p-4 rounded-lg shadow-md flex flex-col items-center cursor-pointer category-hover transform transition-transform duration-300 hover:scale-105 hover:shadow-lg border border-gray-200 fade-in"
                     @click="viewCategory(category.name)"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-75"
                     x-transition:enter-end="opacity-100 scale-100">
                    <img :src="category.icon" :alt="category.name" class="w-12 h-12 mb-2">
                    <span class="text-sm font-medium text-gray-700" x-text="category.name"></span>
                </div>
            </template>
        </section>

        <section class="w-full max-w-6xl mt-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4" x-show="itemsAvailable"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform translate-y-5"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                 @foreach ($products as $product)
                 <div class="card3D bg-white p-4 rounded-lg shadow-lg cursor-pointer">
                     <div class="inner-card">
                         <img src="" alt="" class="w-full h-40 object-cover rounded-md">
                         <h3 class="mt-2 text-gray-800 font-semibold text-sm truncate"></h3>
                         <p class="text-gray-500 text-xs mt-1"></p>
                         <p class="text-indigo-600 text-sm font-bold mt-2">$</p>
                     </div>
                 </div>
             @endforeach
             
        </section>

        <!-- Footer Section -->
        <footer class="w-full bg-gradient py-12 mt-16">
            <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 px-6 lg:px-0 text-center md:text-left text-gray-900">
                <div>
                    <h3 class="text-lg font-semibold mb-4">About ShopNow</h3>
                    <p class="text-sm text-gray-700">ShopNow is your one-stop shop for all things you love. Enjoy seamless shopping with exclusive deals and a wide range of quality products.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                    <ul>
                        <li><a href="#" class="text-sm text-gray-700 hover:underline">Help Center</a></li>
                        <li><a href="#" class="text-sm text-gray-700 hover:underline">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul>
                        <li><a href="#" class="text-sm text-gray-700 hover:underline">Abount Us</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Stay Connected</h3>
                    <div class="flex justify-center md:justify-start space-x-4">
                        <a href="#" aria-label="Facebook" class="text-gray-700 hover:text-indigo-500">
                            <img src="assets/facebook-app-symbol-removebg-preview.png" alt="Facebook" class="w-6 h-6">
                        </a>
                        <a href="#" aria-label="Twitter" class="text-gray-700 hover:text-indigo-500">
                            <img src="assets/twitter-removebg-preview.png" alt="Twitter" class="w-6 h-6">
                        </a>
                        <a href="#" aria-label="Instagram" class="text-gray-700 hover:text-indigo-500">
                            <img src="assets/instagram-removebg-preview.png" alt="Instagram" class="w-6 h-6">
                        </a>
                        <a href="#" aria-label="LinkedIn" class="text-gray-700 hover:text-indigo-500">
                            <img src="assets/linkedin-removebg-preview.png" alt="LinkedIn" class="w-6 h-6">
                        </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 text-center text-sm text-gray-600">
                &copy; 2024 ShopNow. All rights reserved.
            </div>
        </footer>
    </div>

    <script>
        function ecommerceHome() {
            return {
                searchOpen: false,
                itemsAvailable: true,
    
                categories: JSON.parse(localStorage.getItem('categories')) || [
                    { name: 'Electronics', icon: 'assets/elektro.png' },
                    { name: 'Fashion', icon: 'assets/cloth.png' },
                    { name: 'Home', icon: 'assets/home.png' },
                    { name: 'Beauty', icon: 'assets/beauty.png' },
                    { name: 'Toys', icon: 'assets/toy.png' },
                    { name: 'Sports', icon: 'assets/sport.png' }
                ],
    
                items: JSON.parse(localStorage.getItem('items')) || [
                    { id: 1, name: 'Smartphone', description: 'Latest model', price: 599.99, image: 'assets/ROG.png' },
                    { id: 2, name: 'Laptop', description: 'High performance', price: 899.99, image: 'assets/TUF.png' },
                    { id: 3, name: 'Sneakers', description: 'Comfortable and stylish', price: 49.99, image: 'assets/sneakerss.png' },
                    { id: 4, name: 'Sneakers', description: 'Comfortable and stylish', price: 49.99, image: 'assets/sneakerss.png' },
                    { id: 5, name: 'Sneakers', description: 'Comfortable and stylish', price: 49.99, image: 'assets/sneakerss.png' },
                    { id: 6, name: 'Sneakers', description: 'Comfortable and stylish', price: 49.99, image: 'assets/sneakerss.png' },
                    { id: 7, name: 'Sneakers', description: 'Comfortable and stylish', price: 49.99, image: 'assets/sneakerss.png' },
                    { id: 8, name: 'Sneakers', description: 'Comfortable and stylish', price: 49.99, image: 'assets/sneakerss.png' },
                    { id: 9, name: 'Sneakers', description: 'Comfortable and stylish', price: 49.99, image: 'assets/sneakerss.png' },
                ],
    
                init() {
                    if (!localStorage.getItem('categories')) {
                        localStorage.setItem('categories', JSON.stringify(this.categories));
                    }
                    if (!localStorage.getItem('items')) {
                        localStorage.setItem('items', JSON.stringify(this.items));
                    }
                },
    
                toggleSearch() {
                    this.searchOpen = !this.searchOpen;
                    if (this.searchOpen) {
                        this.$nextTick(() => this.$refs.searchInput.focus());
                    }
                },
                viewAccount() {
                    // Logic untuk melihat akun
                },
                logout() {
                    // Logic untuk logout
                },
                viewCategory(categoryName) {
                    console.log(`Viewing category: ${categoryName}`);
                    // Logic untuk melihat kategori tertentu
                }
            };
        }
    </script>

</body>
</html>