@php
    function sensorEmail($email){
        $emailParts = explode('@', $email);
        $emailPart = $emailParts[0];
        $domainPart = $emailParts[1];

        $maskedEmail = substr($emailPart, 0, 2) . str_repeat('*', strlen($emailPart) - 1);

        return $maskedEmail. '@'. $domainPart;
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopNow - Account Page</title>
    <link rel="icon" href="assets/anl-team-removebg-preview (1).png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        @layer utilities {
            .bg-gradient { background: linear-gradient(135deg, #e0f7fa, #e1bee7); }
        }
        .fade-in { opacity: 0; animation: fadeIn 1s ease-in-out forwards; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .card3D { perspective: 1000px; }
        .order-card { transform-style: preserve-3d; transition: transform 0.5s ease, box-shadow 0.3s ease; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); }
        .order-card:hover { transform: rotateY(10deg) rotateX(5deg); box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3); }
        .card-content { position: relative; backface-visibility: hidden; }
        .card-image { border-radius: 8px 8px 0 0; transition: transform 0.3s; }
        .order-card:hover .card-image { transform: scale(1.05); }
    </style>
</head>
<body class="bg-gradient font-sans text-gray-900 fade-in" x-data="accountPage()">

    <div class="min-h-screen flex flex-col items-center pt-10">
        <header class="w-full max-w-6xl flex justify-between items-center p-5 bg-white shadow-lg rounded-b-xl fixed top-0 z-10">
            <div class="flex items-center space-x-3">
                <img src="assets/anl-team-removebg-preview (1).png" alt="ShopNow Logo" class="w-12 h-12">
                <span class="text-3xl font-bold text-indigo-600 hidden md:block">ShopNow</span>
            </div>
            <button class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition" @click="goHome()">Home</button>
        </header>

        <section class="w-full max-w-4xl mt-20 mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profile Card -->
                <div class="card3D bg-white p-6 rounded-lg shadow-lg cursor-pointer flex flex-col items-center inner-card">
                    <img src="{{ asset('https://placehold.co/600x400/png') }}" alt="Profile Picture" class="w-24 h-24 rounded-full mb-4" id="displayProfileImage">
                    <h2 class="text-lg font-semibold text-gray-800" id="displayUsername">Anonim</h2>
                    <p class="text-sm text-gray-500" id="displayEmail">anonim@gmail.com</p>
                    <p class="text-sm text-gray-500 mt-2 text-center">Personalized recommendations based on your shopping preferences and activity</p>
                    <button class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition" onclick="openEditProfile()">Edit Profile</button>
                </div>
        
                <!-- Account Settings Card -->
                <div class="card3D bg-white p-6 rounded-lg shadow-lg cursor-pointer flex flex-col inner-card">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Account Settings</h3>
                    <ul class="space-y-4 w-full">
                        <li class="flex items-center text-gray-700 hover:text-indigo-600 transition space-x-3 cursor-pointer p-3 bg-gray-100 rounded-lg" onclick="changePassword()">
                            <img src="assets/padlock.png" alt="Change Password" class="w-5 h-5">
                            <div>
                                <span class="block text-md font-medium">Reset Password</span>
                                <span class="block text-sm text-gray-500">Change your password regularly for security</span>
                            </div>
                        </li>
                        <li class="flex items-center text-gray-700 hover:text-indigo-600 transition space-x-3 cursor-pointer p-3 bg-gray-100 rounded-lg" onclick="updateAddress()">
                            <img src="assets/location.png" alt="Update Address" class="w-5 h-5">
                            <div>
                                <span class="block text-md font-medium">Update Address</span>
                                <span class="block text-sm text-gray-500">Ensure your current shipping address is correct</span>
                            </div>
                        </li>
                        <li class="flex items-center text-gray-700 hover:text-indigo-600 transition space-x-3 cursor-pointer p-3 bg-gray-100 rounded-lg" onclick="paymentMethods()">
                            <img src="assets/wallet.png" alt="Payment Methods" class="w-5 h-5">
                            <div>
                                <span class="block text-md font-medium">Payment Methods</span>
                                <span class="block text-sm text-gray-500">Manage your saved payment options</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="w-full max-w-4xl mt-12 px-4">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Item History And Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="order in orders" :key="order.id">
                    <div class="card3D order-card bg-white p-4 rounded-lg shadow-lg">
                        <div class="card-content">
                            <img :src="order.image" alt="Order Image" class="card-image w-full h-40 object-cover mb-2">
                            <h4 class="text-lg font-semibold text-gray-800" x-text="order.name"></h4>
                            <p class="text-sm text-gray-500" x-text="'Order Date: ' + order.date"></p>
                            <p class="text-indigo-600 font-bold mt-2" x-text="'$' + order.total.toFixed(2)"></p>
                            <p class="text-xs text-gray-600 mt-1" x-text="'Status: ' + order.status"></p>
                        </div>
                    </div>
                </template>
            </div>
            <div x-ref="threeCanvas" class="h-48 w-full mt-8"></div>
        </section>

        <!-- Popup Edit Profile -->
        <div id="editProfilePopup" class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm flex justify-center items-center hidden transition-all duration-300">
            <div class="bg-white rounded-xl shadow-2xl w-[90%] max-w-sm mx-4 relative transform transition-all">
                <!-- Header Section -->
                <div class="p-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-800">Edit Profile</h2>
                        <button class="text-gray-400 hover:text-gray-600 transition-colors" onclick="closeEditProfile()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
        
                <!-- Content Section -->
                <div class="p-4 space-y-4">
                    <!-- Profile Picture Section -->
                    <div class="flex flex-col items-center space-y-2">
                        <div class="relative group">
                            <img src="assets/shin2.jpg" alt="Profile Picture" 
                                 class="w-24 h-24 rounded-full object-cover border-2 border-white shadow" 
                                 id="previewImage">
                            <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity">
                                <label for="profileImage" class="cursor-pointer text-white text-xs font-medium">
                                    Change
                                </label>
                            </div>
                        </div>
                        <input type="file" id="profileImage" accept="image/*" class="hidden" onchange="previewProfileImage(event)">
                    </div>
        
                    <div class="space-y-3">
                        <!-- Username Field -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-2 flex items-center text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </span>
                                <input type="text" id="username" 
                                       class="pl-8 w-full py-1.5 text-sm border border-gray-300 rounded-md focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                       placeholder="Enter username">
                            </div>
                        </div>
        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-2 flex items-center text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <input type="email" id="email" 
                                       class="pl-8 w-full py-1.5 text-sm border border-gray-300 rounded-md focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" 
                                       placeholder="Enter email" 
                                       oninput="updateEmailDisplay()">
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="p-4 border-t border-gray-100 flex justify-end space-x-2">
                    <button onclick="closeEditProfile()" 
                            class="px-3 py-1.5 text-sm font-medium text-gray-700 hover:text-gray-500 transition-colors">
                        Cancel
                    </button>
                    <button onclick="saveProfile()" 
                            class="px-3 py-1.5 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-indigo-500 transition-colors">
                        Save
                    </button>
                </div>
            </div>
        </div>

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
        function openEditProfile() {
    document.getElementById('editProfilePopup').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('editProfilePopup').classList.add('opacity-100');
    }, 10);
    }

    function closeEditProfile() {
        document.getElementById('editProfilePopup').classList.remove('opacity-100');
        setTimeout(() => {
            document.getElementById('editProfilePopup').classList.add('hidden');
        }, 300);
    }
    
    function previewProfileImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('previewImage');
            output.src = reader.result;
            // Update Profile Card image preview
            document.getElementById('displayProfileImage').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
    
    function saveProfile() {
        const newUsername = document.getElementById('username').value;
        const newProfileImage = document.getElementById('previewImage').src;
        const newEmail = document.getElementById('email').value;
    
        // Update display in Profile Card
        document.getElementById('displayUsername').innerText = newUsername || 'Anonim';
        document.getElementById('displayProfileImage').src = newProfileImage;
        document.getElementById('displayEmail').innerText = newEmail || 'anonim@gmail.com';
        
        closeEditProfile();
    }

    // Function to update email display in real-time as user types
    function updateEmailDisplay() {
        const newEmail = document.getElementById('email').value;
        document.getElementById('displayEmail').innerText = newEmail || 'anonim@gmail.com';
    }

        // Initialize the 3D Card scene as defined in accountPage
        document.addEventListener('DOMContentLoaded', function() {
            accountPage().init3DCards();
        });
    
        function accountPage() {
            return {
                orders: [
                    { id: 1, name: 'Smartphone', date: '2024-09-12', total: 599.99, image: 'assets/ROG.png', status: 'Shipped' },
                    { id: 2, name: 'Sneakers', date: '2024-08-22', total: 49.99, image: 'assets/sneakers.png', status: 'Delivered' },
                    { id: 3, name: 'Laptop', date: '2024-07-15', total: 899.99, image: 'assets/TUF.png', status: 'Processing' },
                ],
                init3DCards() {
                    const scene = new THREE.Scene();
                    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / 300, 0.1, 1000);
                    const renderer = new THREE.WebGLRenderer({ alpha: true });
                    renderer.setSize(window.innerWidth, 300);
                    this.$refs.threeCanvas.appendChild(renderer.domElement);
    
                    const cardGeometry = new THREE.BoxGeometry(1, 1.5, 0.1);
                    const cardMaterial = new THREE.MeshPhongMaterial({ color: 0xFFFFFF, flatShading: true });
                    const cards = [];
    
                    this.orders.forEach((order, index) => {
                        const card = new THREE.Mesh(cardGeometry, cardMaterial);
                        card.position.set(index * 1.5 - (this.orders.length - 1) * 0.75, 0, 0);
                        cards.push(card);
                        scene.add(card);
                    });
    
                    const light = new THREE.DirectionalLight(0xffffff, 1);
                    light.position.set(5, 5, 5);
                    scene.add(light);
    
                    camera.position.z = 5;
    
                    const animate = function () {
                        requestAnimationFrame(animate);
                        cards.forEach(card => {
                            card.rotation.y += 0.01;
                        });
                        renderer.render(scene, camera);
                    };
    
                    animate();
    
                    window.addEventListener('resize', () => {
                        const width = window.innerWidth;
                        const height = 300;
                        renderer.setSize(width, height);
                        camera.aspect = width / height;
                        camera.updateProjectionMatrix();
                    });
                }
            };
        }
    </script>
</body>
</html>