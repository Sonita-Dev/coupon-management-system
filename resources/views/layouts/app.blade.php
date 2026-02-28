<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Coupon Management System')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --bg: #f3f4f6;
            --text: #111827;
            --danger: #dc2626;
            --success: #16a34a;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: var(--bg);
            color: var(--text);
        }
        .navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }
        .nav-links a {
            margin-right: 1rem;
            text-decoration: none;
            color: #4b5563;
            font-size: 0.95rem;
        }
        .nav-links a:hover {
            color: var(--primary-dark);
        }
        .container {
            max-width: 960px;
            margin: 1.5rem auto;
            padding: 0 1rem 2rem;
        }
        .card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        }
        h1, h2, h3 {
            margin-top: 0;
        }
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            background-color: var(--primary);
            color: white;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: var(--primary-dark);
        }
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }
        .btn-danger {
            background-color: var(--danger);
        }
        .btn-danger:hover {
            background-color: #b91c1c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
        th, td {
            padding: 0.5rem 0.65rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            font-weight: 600;
        }
        .badge {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            border-radius: 999px;
            font-size: 0.75rem;
        }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-danger { background-color: #fee2e2; color: #b91c1c; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .form-group {
            margin-bottom: 0.9rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }
        .form-control, select {
            width: 100%;
            padding: 0.45rem 0.5rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
        }
        .form-control:focus, select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.3);
        }
        .text-danger { color: var(--danger); font-size: 0.8rem; }
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }
        .alert-danger {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .flex { display: flex; }
        .justify-between { justify-content: space-between; }
        .items-center { align-items: center; }
        .gap-sm { gap: 0.5rem; }
        .mt-sm { margin-top: 0.5rem; }
        .mt-md { margin-top: 1rem; }
        .mt-lg { margin-top: 1.5rem; }
        .text-right { text-align: right; }
        .text-muted { color: #6b7280; font-size: 0.85rem; }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }
        .stat-card {
            padding: 1rem;
            border-radius: 0.75rem;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }
        .stat-label {
            font-size: 0.8rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 0.25rem;
        }
        @media (max-width: 640px) {
            .navbar { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
            .nav-links a { margin-right: 0.75rem; }
        }
    </style>
</head>
<body>
<header class="navbar">
    <a href="{{ route('dashboard') }}" class="navbar-brand">Coupon Admin</a>
    <nav class="nav-links">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('coupons.index') }}">Coupons</a>
        <a href="{{ route('coupons.apply-form') }}">Test Coupon</a>
        @auth
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">
                    Logout
                </button>
            </form>
        @endauth
    </nav>
</header>

<main class="container">
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There were some problems with your input.</strong>
            </div>
        @endif

        @yield('content')
    </div>
    <p class="text-muted mt-md">Coupon Management System · Laravel &amp; Blade</p>
</main>
</body>
</html>

