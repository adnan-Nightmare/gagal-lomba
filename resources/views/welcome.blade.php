<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopNow - Login</title>
    <link rel="icon" href="assets/anl-team-removebg-preview.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @layer utilities {
            .bg-gradient {
                background: linear-gradient(135deg, #e0f7fa, #e1bee7);
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
        }
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gradient font-sans text-gray-900 fade-in" x-data="loginPage()" x-init="init()">

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col items-center justify-center" x-show="true" x-transition>

        <!-- Login Form Section -->
        <section class="w-full max-w-md p-8 mt-6 bg-white rounded-lg shadow-lg transform transition-all duration-500 ease-in-out hover:scale-105 fade-in">
            <h2 class="text-2xl font-semibold text-center text-indigo-600 mb-6">Login to Your Account</h2>

            <!-- Login Form -->
            <form action="{{ route('postLogin') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" id="email"  required placeholder="Enter your email" class="w-full p-3 mt-2 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" value="{{ old('password') }}" id="password" required placeholder="Enter your password" class="w-full p-3 mt-2 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500">
                        <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-indigo-600 hover:underline">Forgot Password?</a>
                </div>

                <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition duration-200">Login</button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Don't have an account? <a href="/public/register.html" class="text-indigo-600 hover:underline">Sign up</a></p>
            </div>
        </section>
        
    </div>


</body>
</html>