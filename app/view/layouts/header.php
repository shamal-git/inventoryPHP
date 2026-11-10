<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoSpares - Spare Parts Management System</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#1e293b',
                        accent: '#0284c7'
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-900 text-slate-100 font-sans antialiased min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-950 border-r border-slate-800 flex flex-col justify-between hidden md:flex">
        <div>
            <div class="p-6 flex items-center space-x-3 border-b border-slate-800">
                <i class="fa-solid fa-gears text-2xl text-cyan-400"></i>
                <span class="text-xl font-bold tracking-wider text-white">AutoSpares</span>
            </div>
            <nav class="p-4 space-y-1">
                <a href="/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-chart-pie w-5"></i><span>Dashboard</span>
                </a>
                <a href="/pos" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-cash-register w-5"></i><span>POS Billing</span>
                </a>
                <a href="/products" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-box-archive w-5"></i><span>Products</span>
                </a>
                <a href="/categories" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-tags w-5"></i><span>Categories</span>
                </a>
                <a href="/suppliers" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-truck-field w-5"></i><span>Suppliers</span>
                </a>
                <a href="/customers" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                    <i class="fa-solid fa-users w-5"></i><span>Customers</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-800">
            <a href="/logout" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-rose-400 hover:bg-rose-950/30 transition">
                <i class="fa-solid fa-right-from-bracket w-5"></i><span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0">
        <header class="h-16 bg-slate-950 border-b border-slate-800 flex items-center justify-between px-6">
            <h1 class="text-lg font-semibold text-slate-200">Inventory & POS Management</h1>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-slate-400"><i class="fa-solid fa-user-shield text-cyan-400 mr-2"></i><?= $_SESSION['user_name'] ?? 'Admin' ?></span>
            </div>
        </header>
        <main class="flex-1 p-6 overflow-y-auto">