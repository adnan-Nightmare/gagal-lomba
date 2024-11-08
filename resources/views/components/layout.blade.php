<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ANAL E-commerce</title>
    @vite(['resources/css/app.css', 'resources/js/alpine.js'])
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

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
    <div class="min-h-screen flex flex-col items-center mt-5" x-show="true" x-transition>

        <x-navbar></x-navbar>
        {{ $slot }}
    </div>
</body>
</html>