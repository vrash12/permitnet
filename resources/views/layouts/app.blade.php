<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'PermitNet' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Work Sans --}}
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .org-panel {
    background: #ffffff;
    border-radius: 12px;
    min-height: 560px;
    padding: 28px;
    position: relative;
}

.org-actions {
    position: absolute;
    top: 24px;
    right: 24px;
    display: flex;
    gap: 14px;
}

.org-action-btn {
    height: 34px;
    padding: 0 10px;
    border: 0;
    border-radius: 4px;
    background: #ffffff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.25);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    cursor: pointer;
}

.org-action-btn svg {
    width: 22px;
    height: 22px;
}

.org-chart {
    margin-top: 58px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.org-level {
    display: flex;
    justify-content: center;
    gap: 110px;
    position: relative;
}

.org-level.admin-level {
    margin-top: 55px;
}

.org-level.staff-level {
    margin-top: 58px;
    gap: 115px;
}

.org-card {
    width: 112px;
    min-height: 126px;
    background: #d9d9d9;
    text-align: center;
    padding: 8px 6px;
    position: relative;
    z-index: 2;
    color: #000;
}

.org-card:hover {
    outline: 3px solid #1293ee;
}

.org-card svg {
    width: 62px;
    height: 62px;
    fill: #000;
    display: block;
    margin: 0 auto 8px;
}

.org-name,
.org-position {
    background: #ffffff;
    border-radius: 5px;
    min-height: 18px;
    padding: 3px 4px;
    font-size: 10px;
    line-height: 1.2;
    margin-top: 4px;
}

.org-position {
    font-weight: 700;
    text-transform: uppercase;
}

.org-lines {
    width: 520px;
    height: 170px;
    position: absolute;
    top: 190px;
    left: 50%;
    transform: translateX(-50%);
    pointer-events: none;
}

.org-lines .line {
    position: absolute;
    background: #000;
}

.org-lines .ceo-down {
    width: 4px;
    height: 80px;
    left: 258px;
    top: 0;
}

.org-lines .admin-horizontal {
    height: 4px;
    width: 215px;
    left: 152px;
    top: 78px;
}

.org-lines .left-admin-down {
    width: 4px;
    height: 83px;
    left: 152px;
    top: 78px;
}

.org-lines .right-admin-down {
    width: 4px;
    height: 83px;
    left: 366px;
    top: 78px;
}

.org-lines .staff-horizontal {
    height: 4px;
    width: 520px;
    left: 0;
    top: 160px;
}

.org-lines .staff-left {
    width: 4px;
    height: 36px;
    left: 0;
    top: 160px;
}

.org-lines .staff-middle {
    width: 4px;
    height: 36px;
    left: 258px;
    top: 160px;
}

.org-lines .staff-right {
    width: 4px;
    height: 36px;
    left: 516px;
    top: 160px;
}

.member-panel {
    background: #ffffff;
    border-radius: 12px;
    min-height: 610px;
    padding: 32px;
}

.member-header {
    display: flex;
    align-items: flex-start;
    gap: 22px;
}

.member-avatar {
    width: 165px;
    height: 210px;
    background: #d9d9d9;
    display: flex;
    align-items: center;
    justify-content: center;
}

.member-avatar svg {
    width: 120px;
    height: 120px;
    fill: #000;
}

.member-info h1 {
    font-size: 28px;
    font-weight: 500;
    margin: 10px 0 22px;
}

.member-row {
    display: grid;
    grid-template-columns: 90px 1fr;
    font-size: 17px;
    margin-bottom: 15px;
}

.member-row strong {
    font-weight: 500;
}

.devices-title {
    font-size: 28px;
    font-weight: 500;
    margin: 18px 0;
}

.member-device-list {
    margin-left: 12px;
    max-width: 850px;
}

.member-device-card {
    min-height: 74px;
    border: 1px solid #333;
    border-radius: 12px;
    display: flex;
    align-items: center;
    padding: 8px 24px 8px 14px;
    margin-bottom: -1px;
}

.member-device-icon {
    width: 42px;
    margin-right: 18px;
    display: flex;
    justify-content: center;
}

.member-device-icon svg {
    width: 36px;
    height: 44px;
    fill: #000;
}

.member-device-info {
    flex: 1;
}

.member-device-name {
    font-size: 17px;
    font-weight: 800;
}

.member-device-meta {
    font-size: 11px;
    color: #777;
    margin-top: 2px;
}

.status-pill {
    width: 115px;
    height: 34px;
    border-radius: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
}

.status-online {
    background: #c6f6d5;
    color: #22a35a;
}

.status-offline {
    background: #ffc6cc;
    color: #f04450;
}

@media (max-width: 850px) {
    .org-panel {
        overflow-x: auto;
    }

    .org-chart {
        min-width: 680px;
    }

    .member-header {
        flex-direction: column;
    }

    .member-device-card {
        align-items: flex-start;
        gap: 10px;
    }
}
        :root {
            --blue: #1293ee;
            --blue-dark: #0878c8;
            --blue-card: #78b7e9;
            --blue-card-light: #8fc6f1;
            --white: #ffffff;
            --sidebar: #f2f2f2;
            --page-bg: #eeeeee;
            --text: #050505;
            --muted: #4b5563;
            --border: #d2d2d2;
            --shadow: rgba(0, 0, 0, 0.18);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Work Sans', Arial, sans-serif;
            background: var(--page-bg);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font-family: inherit;
        }

        .app-layout {
            display: flex;
            min-height: 100vh;
            background: var(--page-bg);
        }

        .sidebar {
            width: 235px;
            background: var(--sidebar);
            border-right: 1px solid #cfcfcf;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 18px 18px 24px;
        }

        .brand-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 34px;
        }

        .brand-logo {
            width: 62px;
            height: 62px;
            background: #3159b8;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .brand-logo svg {
            width: 40px;
            height: 40px;
            stroke: white;
        }

        .brand-name {
            font-size: 25px;
            font-weight: 800;
        }

        .side-menu {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .side-link {
            height: 50px;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 18px;
            border-radius: 3px;
            color: #222;
            font-size: 13px;
            font-weight: 500;
        }

        .side-link.active {
            background: #dddddd;
            color: var(--blue);
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        }

        .side-link svg {
            width: 28px;
            height: 28px;
            fill: #000;
            flex-shrink: 0;
        }

        .side-link.active svg {
            fill: #000;
        }

        .sidebar-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
        }

        .sidebar-user svg,
        .logout-button svg {
            width: 30px;
            height: 30px;
            fill: #000;
        }

        .logout-button {
            border: 0;
            background: transparent;
            cursor: pointer;
            padding: 0;
        }

        .main-content {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            height: 70px;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px 0 42px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }

        .breadcrumb {
            font-size: 16px;
            font-weight: 500;
            color: #07111f;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .search-box {
            width: 205px;
            height: 39px;
            border-radius: 22px;
            background: white;
            display: flex;
            align-items: center;
            padding: 0 13px;
            gap: 8px;
        }

        .search-box svg {
            width: 23px;
            height: 23px;
            stroke: var(--blue);
        }

        .search-box input {
            border: 0;
            outline: none;
            width: 100%;
            font-family: inherit;
            font-size: 14px;
        }

        .bell svg {
            width: 28px;
            height: 28px;
            stroke: white;
        }

        .page-wrap {
            padding: 24px 30px 36px;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
            margin-bottom: 18px;
        }

        .stat-card {
            height: 134px;
            background: linear-gradient(180deg, var(--blue-card-light), var(--blue-card));
            border-radius: 10px;
            box-shadow: 0 3px 7px var(--shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            padding: 18px;
        }

        .stat-card svg {
            width: 62px;
            height: 62px;
            fill: #000;
        }

        .stat-number {
            font-size: 40px;
            font-weight: 800;
            letter-spacing: 1px;
            line-height: 1;
        }

        .stat-label {
            margin-top: 18px;
            font-size: 18px;
            font-weight: 700;
            text-align: center;
        }

        .activity-panel {
            background: white;
            border: 1px solid #c8c8c8;
            box-shadow: 0 3px 7px rgba(0,0,0,0.2);
        }

        .activity-title {
            padding: 30px 20px 32px;
            font-size: 26px;
            font-weight: 800;
            border-bottom: 1px solid #c8c8c8;
        }

        .activity-row {
            display: flex;
            align-items: center;
            min-height: 58px;
            padding: 7px 20px;
            border-bottom: 1px solid #c8c8c8;
        }

        .activity-row:last-child {
            border-bottom: none;
        }

        .device-icon {
            width: 44px;
            display: flex;
            justify-content: center;
            margin-right: 18px;
        }

        .device-icon svg {
            width: 34px;
            height: 42px;
            fill: #000;
        }

        .activity-info {
            flex: 1;
        }

        .activity-name {
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .activity-mac {
            font-size: 16px;
            color: #222;
        }

        .activity-time {
            font-size: 12px;
            font-weight: 700;
            color: #333;
            white-space: nowrap;
        }

        .empty-state {
            padding: 24px 20px;
            color: var(--muted);
        }

        @media (max-width: 950px) {
            .sidebar {
                width: 90px;
                padding: 18px 10px;
            }

            .brand-name,
            .side-link span,
            .sidebar-user span {
                display: none;
            }

            .brand-area {
                justify-content: center;
            }

            .side-link {
                justify-content: center;
                padding: 0;
            }

            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            .app-layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
                flex-direction: row;
                align-items: center;
                padding: 12px;
            }

            .brand-area {
                margin: 0;
            }

            .side-menu {
                display: none;
            }

            .sidebar-bottom {
                padding: 0;
                gap: 12px;
            }

            .topbar {
                padding: 0 16px;
            }

            .breadcrumb {
                font-size: 14px;
            }

            .search-box {
                display: none;
            }

            .page-wrap {
                padding: 18px;
            }

            .stat-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
@if(session('is_logged_in'))
    <div class="app-layout">
        <aside class="sidebar">
            <div>
                <div class="brand-area">
                    <div class="brand-logo">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 3L5 6v5c0 4.5 3 8.7 7 10c4-1.3 7-5.5 7-10V6l-7-3z" stroke-width="1.8"/>
                            <path d="M9 12l2 2l4-5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="brand-name">PermitNet</div>
                </div>

                <nav class="side-menu">
                    <a href="{{ route('dashboard') }}" class="side-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="M3 3h8v8H3V3zm10 0h8v8h-8V3zM3 13h8v8H3v-8zm10 0h8v8h-8v-8z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                <a href="{{ route('organization.index') }}" class="side-link {{ request()->is('organization*') ? 'active' : '' }}">
    <svg viewBox="0 0 24 24">
        <path d="M10 3h4v4h-4V3zM4 17h4v4H4v-4zm12 0h4v4h-4v-4zM11 8h2v3h6v5h-2v-3H7v3H5v-5h6V8z"/>
    </svg>
    <span>Organization</span>
</a>
                    <a href="{{ url('/logs') }}" class="side-link {{ request()->is('logs*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="M6 2h9l5 5v15H6V2zm8 1.5V8h4.5L14 3.5zM8 11h10v2H8v-2zm0 4h10v2H8v-2zm0 4h7v2H8v-2zM3 6h2v17h13v-1H5V6H3z"/>
                        </svg>
                        <span>Logs</span>
                    </a>

                    <a href="{{ url('/settings') }}" class="side-link {{ request()->is('settings*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24">
                            <path d="M19.4 13.5c.1-.5.1-1 .1-1.5s0-1-.1-1.5l2.1-1.6l-2-3.5l-2.5 1a8 8 0 0 0-2.6-1.5L14 2h-4l-.4 2.9A8 8 0 0 0 7 6.4l-2.5-1l-2 3.5l2.1 1.6c-.1.5-.1 1-.1 1.5s0 1 .1 1.5l-2.1 1.6l2 3.5l2.5-1a8 8 0 0 0 2.6 1.5L10 22h4l.4-2.9a8 8 0 0 0 2.6-1.5l2.5 1l2-3.5l-2.1-1.6zM12 15.5A3.5 3.5 0 1 1 12 8a3.5 3.5 0 0 1 0 7.5z"/>
                        </svg>
                        <span>Settings</span>
                    </a>
                </nav>
            </div>

            <div class="sidebar-bottom">
                <div class="sidebar-user">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5s-5 2.2-5 5s2.2 5 5 5zm0 2c-4.4 0-8 2.2-8 5v3h16v-3c0-2.8-3.6-5-8-5z"/>
                    </svg>
                    <span>{{ session('admin_name', 'John Doe') }}</span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit" title="Logout">
                        <svg viewBox="0 0 24 24">
                            <path d="M10 3H4v18h6v-3H7V6h3V3zm5.6 4.4L14.2 8.8l2.2 2.2H9v2h7.4l-2.2 2.2l1.4 1.4L20.4 12l-4.8-4.6z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="breadcrumb">
                    Home / {{ $pageTitle ?? 'Dashboard' }}
                </div>

                <div class="top-actions">
                    <div class="search-box">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="7" stroke-width="2"/>
                            <path d="M16.5 16.5L21 21" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <input type="text" placeholder="Search">
                    </div>

                    <div class="bell">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M18 9a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.7 21a2 2 0 0 1-3.4 0" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>
            </header>

            <section class="page-wrap">
                @yield('content')
            </section>
        </main>
    </div>
@else
    @yield('content')
@endif
</body>
</html>