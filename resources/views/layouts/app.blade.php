<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 80px;
            --sidebar-bg: #2c3e50;
            --sidebar-text: #ecf0f1;
            --sidebar-hover: #34495e;
            --sidebar-active: #3498db;
            --transition-speed: 0.3s;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: margin-left var(--transition-speed);
        }

        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            transition: width var(--transition-speed);
            overflow: hidden;
            z-index: 1000;
        }

        #sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 20px;
            background: var(--sidebar-hover);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-header h3 {
            margin: 0;
            white-space: nowrap;
        }

        .sidebar-menu {
            padding: 0;
            list-style: none;
        }

        .sidebar-menu li {
            position: relative;
        }

        .sidebar-menu li a,
        .sidebar-menu li button {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all var(--transition-speed);
            width: 100%;
            border: none;
            background: transparent;
            text-align: left;
            cursor: pointer;
            font-size: 1rem;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li button:hover {
            background: var(--sidebar-hover);
        }

        .sidebar-menu li a.active {
            background: var(--sidebar-active);
        }

        .sidebar-menu .icon {
            margin-right: 15px;
            font-size: 1.2rem;
            min-width: 20px;
            text-align: center;
        }

        .sidebar-menu .text {
            white-space: nowrap;
        }

        #sidebar.collapsed .text {
            display: none;
        }

        #sidebar.collapsed .sidebar-header h3 {
            display: none;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            transition: margin-left var(--transition-speed);
        }

        #sidebar.collapsed+.main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        .toggle-btn {
            background: none;
            border: none;
            color: var(--sidebar-text);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
        }

        .cart-count {
            background: var(--sidebar-active);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8rem;
            margin-left: 5px;
        }

        .mobile-header {
            display: none;
            padding: 15px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            justify-content: space-between;
            align-items: center;
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            color: var(--sidebar-text);
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            #sidebar {
                left: -100%;
                width: var(--sidebar-width);
            }

            #sidebar.active {
                left: 0;
            }

            #sidebar.collapsed {
                left: -100%;
                width: var(--sidebar-width);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-header {
                display: flex;
            }
        }
    </style>
</head>

<body>
    <div class="mobile-header">
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
        <h3>{{ config('app.name', 'Laravel') }}</h3>
    </div>

    <div id="sidebar">
        <div class="sidebar-header">
            <h3 class="text">{{ config('app.name', 'Laravel') }}</h3>
            <button class="toggle-btn" id="toggleBtn">
                <i class="fas fa-angle-left"></i>
            </button>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('home') }}"><i class="fas fa-home icon"></i><span class="text">Home</span></a></li>
            <li><a href="{{ route('shop.index') }}"><i class="fas fa-shopping-bag icon"></i><span
                        class="text">Shop</span></a></li>
            <li><a href="{{ route('gallery.index') }}"><i class="fas fa-images icon"></i><span
                        class="text">Gallery</span></a></li>

            @guest
                <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt icon"></i><span
                            class="text">Login</span></a></li>
                <li><a href="{{ route('register') }}"><i class="fas fa-user-plus icon"></i><span
                            class="text">Register</span></a></li>
            @else
                <li><a href="{{ route('orders.index') }}"><i class="fas fa-clipboard-list icon"></i><span class="text">My
                            Orders</span></a></li>
                <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user icon"></i><span class="text">My
                            Profile</span></a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"><i class="fas fa-sign-out-alt icon"></i><span
                                class="text">Logout</span></button>
                    </form>
                </li>
                <li>
                    <a href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart icon"></i>
                        <span class="text">Cart</span>
                        @if (count((array) session('cart')))
                            <span class="cart-count">{{ count((array) session('cart')) }}</span>
                        @endif
                    </a>
                </li>
            @endguest

            @auth
                @if (auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt icon"></i>
                            <span class="text">Admin Dashboard</span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->isItCommercial())
                    <li>
                        <a href="{{ route('products.create') }}">
                            <i class="fas fa-plus-circle icon"></i>
                            <span class="text">Add Product</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery.create') }}">
                            <i class="fas fa-image icon"></i>
                            <span class="text">Add Gallery Item</span>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleBtn');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');

            // Toggle collapsed state
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                const icon = toggleBtn.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('fa-angle-left');
                    icon.classList.add('fa-angle-right');
                } else {
                    icon.classList.remove('fa-angle-right');
                    icon.classList.add('fa-angle-left');
                }
            });

            // Mobile menu toggle
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768 &&
                    !sidebar.contains(event.target) &&
                    !mobileMenuBtn.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>
