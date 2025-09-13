<!DOCTYPE html>
<html lang="tr" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GlobalGPT - AI Chat Assistant')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Helvetica Font -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Helvetica+Neue:wght@300;400;500;600;700&display=swap');
    </style>
    
    <style>
        :root {
            --background: 222.2 84% 4.9%;
            --foreground: 210 40% 98%;
            --card: #262626;
            --card-foreground: 210 40% 98%;
            --popover: 222.2 84% 4.9%;
            --popover-foreground: 210 40% 98%;
            --primary: 210 40% 98%;
            --primary-foreground: 222.2 47.4% 11.2%;
            --secondary: 217.2 32.6% 17.5%;
            --secondary-foreground: 210 40% 98%;
            --muted: 217.2 32.6% 17.5%;
            --muted-foreground: 215 20.2% 65.1%;
            --accent: 217.2 32.6% 17.5%;
            --accent-foreground: 210 40% 98%;
            --destructive: 0 62.8% 30.6%;
            --destructive-foreground: 210 40% 98%;
            --border: 217.2 32.6% 17.5%;
            --input: 217.2 32.6% 17.5%;
            --ring: 212.7 26.8% 83.9%;
            --sidebar: 222.2 84% 4.9%;
            --sidebar-foreground: 210 40% 98%;
            --sidebar-accent: 217.2 32.6% 17.5%;
            --sidebar-accent-foreground: 210 40% 98%;
            --radius: 0.5rem;
        }

        body {
            background-color: hsl(var(--background));
            color: hsl(var(--foreground));
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        .sidebar {
            background-color: hsl(var(--sidebar));
            border-right: 1px solid hsl(var(--border));
        }

        .sidebar-item {
            color: hsl(var(--sidebar-foreground));
            transition: all 0.2s ease;
        }

        .sidebar-item:hover {
            background-color: hsl(var(--sidebar-accent));
            color: hsl(var(--sidebar-accent-foreground));
        }

        .sidebar-item.active {
            background-color: hsl(var(--sidebar-accent));
            color: hsl(var(--sidebar-accent-foreground));
            font-weight: 500;
        }

        .card {
            background-color: var(--card);
            color: hsl(var(--card-foreground));
            border: 1px solid hsl(var(--border));
        }

        .chat-message {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .typing-dots {
            display: inline-block;
            position: relative;
            width: 60px;
            height: 20px;
        }

        .typing-dots div {
            position: absolute;
            top: 8px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: hsl(var(--muted-foreground));
            animation: typing-dots 1.4s infinite ease-in-out both;
        }

        .typing-dots div:nth-child(1) {
            left: 8px;
            animation-delay: -0.32s;
        }

        .typing-dots div:nth-child(2) {
            left: 24px;
            animation-delay: -0.16s;
        }

        .typing-dots div:nth-child(3) {
            left: 40px;
            animation-delay: 0s;
        }

        @keyframes typing-dots {
            0%, 80%, 100% {
                transform: scale(0);
            }
            40% {
                transform: scale(1);
            }
        }

        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: hsl(var(--muted)) hsl(var(--background));
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: hsl(var(--background));
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: hsl(var(--muted));
            border-radius: 3px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: hsl(var(--muted-foreground));
        }
    </style>
    
    @yield('styles')
</head>
<body class="min-h-screen bg-background font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 sidebar flex flex-col h-screen fixed left-0 top-0 z-40">
            <!-- Logo/Brand -->
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-xl font-bold text-white flex items-center" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
                    <img src="{{ asset('ggpt.png') }}" alt="GlobalGPT" class="w-14 h-14.7 mr-3 rounded-lg">
                    GlobalGPT
                </h1>
            </div>

            <!-- Sidebar Content -->
            <div class="flex min-h-0 flex-1 flex-col gap-2 overflow-auto p-2">
                <!-- Main Navigation -->
                <div class="relative flex w-full min-w-0 flex-col p-2">
                    <div class="text-gray-400 flex h-8 shrink-0 items-center rounded-md px-2 text-xs font-medium mb-2">
                        Ana Menü
                    </div>
                    <ul class="flex w-full min-w-0 flex-col gap-1">
                        <li class="group/menu-item relative">
                            <a href="/admin/dashboard" class="sidebar-item flex w-full items-center cursor-pointer gap-2 overflow-hidden rounded-md p-2 text-left transition-all hover:bg-gray-700 h-8 text-sm {{ request()->is('admin/dashboard') ? 'active bg-gray-700' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                    <path d="M13.45 11.55l2.05 -2.05"></path>
                                    <path d="M6.4 20a9 9 0 1 1 11.2 0z"></path>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="group/menu-item relative">
                            <a href="/admin/users" class="sidebar-item flex w-full items-center cursor-pointer gap-2 overflow-hidden rounded-md p-2 text-left transition-all hover:bg-gray-700 h-8 text-sm {{ request()->is('admin/users') ? 'active bg-gray-700' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                </svg>
                                <span>Kullanıcılar</span>
                            </a>
                        </li>
                        <li class="group/menu-item relative">
                            <a href="/admin/projects" class="sidebar-item flex w-full items-center cursor-pointer gap-2 overflow-hidden rounded-md p-2 text-left transition-all hover:bg-gray-700 h-8 text-sm {{ request()->is('admin/projects') ? 'active bg-gray-700' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h5l2 2h5a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"></path>
                                </svg>
                                <span>Projeler</span>
                            </a>
                        </li>
                        <li class="group/menu-item relative">
                            <a href="/admin/security" class="sidebar-item flex w-full items-center cursor-pointer gap-2 overflow-hidden rounded-md p-2 text-left transition-all hover:bg-gray-700 h-8 text-sm {{ request()->is('admin/security') ? 'active bg-gray-700' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <span>Güvenlik</span>
                            </a>
                        </li>
                        <li class="group/menu-item relative">
                            <a href="/admin/history" class="sidebar-item flex w-full items-center cursor-pointer gap-2 overflow-hidden rounded-md p-2 text-left transition-all hover:bg-gray-700 h-8 text-sm {{ request()->is('admin/history') ? 'active bg-gray-700' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                    <path d="M3 3v5h5"></path>
                                    <path d="M12 7v5l4 2"></path>
                                </svg>
                                <span>Geçmiş</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- User Profile Section -->
            <div class="border-t border-gray-700 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">Kullanıcı</p>
                        <p class="text-xs text-gray-400 truncate">Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-64">
            @yield('content')
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @yield('scripts')
</body>
</html>
