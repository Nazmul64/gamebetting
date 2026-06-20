<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        (function() {
            const currentTheme = localStorage.getItem('admin_theme') || 'dark';
            if (currentTheme === 'light') {
                document.documentElement.classList.add('light-theme');
            }
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard — Aviator Control Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-deep:        #05070f;
            --bg-sidebar:     #080c1a;
            --bg-card:        #0d1225;
            --bg-panel:       #111827;
            --bg-input:       rgba(255,255,255,0.04);
            --accent-blue:    #4f8ef7;
            --accent-purple:  #8b5cf6;
            --accent-orange:  #f06424;
            --accent-gold:    #ffbe1a;
            --accent-green:   #22c55e;
            --accent-red:     #ef4444;
            --accent-teal:    #14b8a6;
            --text-primary:   #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted:     #4b5563;
            --border-subtle:  rgba(255,255,255,0.06);
            --border-hover:   rgba(255,255,255,0.12);
            --sidebar-width:  240px;
        }

        html, body {
            height: 100%;
            font-family: 'Outfit', sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            overflow: hidden;
        }

        /* ===================== LAYOUT ===================== */
        .admin-layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ===================== SIDEBAR ===================== */
        .admin-sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-subtle);
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 20;
            overflow-y: auto;
        }

        /* Sidebar glow accent */
        .admin-sidebar::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 200px;
            background: radial-gradient(ellipse at top, rgba(79,142,247,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Sidebar logo */
        .sidebar-logo {
            padding: 24px 20px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-subtle);
            flex-shrink: 0;
        }
        .logo-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1e3a5f, #0f2040);
            border: 1px solid rgba(79,142,247,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .logo-icon-wrap i {
            font-size: 16px;
            color: var(--accent-blue);
        }
        .logo-text {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }
        .logo-text small {
            display: block;
            font-size: 10px;
            font-weight: 400;
            color: var(--text-muted);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Sidebar nav */
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
        }
        .nav-section-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 8px 8px 6px;
            margin-top: 8px;
        }
        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 2px;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .sidebar-nav-link i {
            width: 18px;
            text-align: center;
            font-size: 14px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        .sidebar-nav-link:hover {
            background: rgba(255,255,255,0.05);
            color: var(--text-primary);
        }
        .sidebar-nav-link:hover i { opacity: 1; }
        .sidebar-nav-link.active {
            background: linear-gradient(135deg, rgba(79,142,247,0.15), rgba(139,92,246,0.08));
            color: var(--accent-blue);
            border: 1px solid rgba(79,142,247,0.15);
        }
        .sidebar-nav-link.active i { color: var(--accent-blue); opacity: 1; }

        /* Admin info at bottom of sidebar */
        .sidebar-admin-card {
            margin: 12px;
            padding: 12px;
            border-radius: 12px;
            background: rgba(79,142,247,0.06);
            border: 1px solid rgba(79,142,247,0.12);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .admin-avatar {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: linear-gradient(135deg, #2563eb, #4f8ef7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #fff;
            flex-shrink: 0;
        }
        .admin-info { flex: 1; min-width: 0; }
        .admin-info-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .admin-info-role {
            font-size: 10px;
            color: var(--accent-blue);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .sidebar-logout-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 14px;
            padding: 4px;
            border-radius: 6px;
            transition: color 0.2s;
            flex-shrink: 0;
        }
        .sidebar-logout-btn:hover { color: var(--accent-red); }

        /* ===================== MAIN CONTENT ===================== */
        .admin-main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Top bar */
        .admin-topbar {
            height: 58px;
            min-height: 58px;
            background: var(--bg-sidebar);
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            flex-shrink: 0;
        }
        .topbar-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
        }
        .topbar-title span {
            font-size: 12px;
            font-weight: 400;
            color: var(--text-muted);
            margin-left: 8px;
        }
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 20px;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.2);
            color: var(--accent-green);
            font-size: 11px;
            font-weight: 600;
        }
        .status-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--accent-green);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        @keyframes crashPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239,68,68,0); }
            50% { box-shadow: 0 0 8px 2px rgba(239,68,68,0.35); }
        }

        /* Content scroll area */
        .admin-content {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }
        .admin-content::-webkit-scrollbar { width: 6px; }
        .admin-content::-webkit-scrollbar-track { background: transparent; }
        .admin-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

        /* ===================== TAB CONTENT ===================== */
        .tab-pane { display: none; }
        .tab-pane.active { display: block; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        /* Page header */
        .page-header {
            margin-bottom: 24px;
        }
        .page-header h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
        }
        .page-header p {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* ===================== STAT CARDS ===================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            padding: 20px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s, transform 0.2s;
        }
        .stat-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            border-radius: 14px 14px 0 0;
        }
        .stat-card.blue::before  { background: linear-gradient(90deg, #4f8ef7, #818cf8); }
        .stat-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #c084fc); }
        .stat-card.green::before  { background: linear-gradient(90deg, #22c55e, #4ade80); }
        .stat-card.orange::before { background: linear-gradient(90deg, #f06424, #ffbe1a); }

        .stat-card-icon {
            width: 42px; height: 42px;
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
        }
        .stat-card.blue   .stat-card-icon { background: rgba(79,142,247,0.15); color: var(--accent-blue); }
        .stat-card.purple .stat-card-icon { background: rgba(139,92,246,0.15); color: var(--accent-purple); }
        .stat-card.green  .stat-card-icon { background: rgba(34,197,94,0.15);  color: var(--accent-green); }
        .stat-card.orange .stat-card-icon { background: rgba(240,100,36,0.15); color: var(--accent-orange); }

        .stat-card-val {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-primary);
            font-family: 'Roboto Mono', monospace;
            line-height: 1;
        }
        .stat-card-label {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .stat-card-change {
            position: absolute;
            top: 16px; right: 16px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
        }
        .change-up { background: rgba(34,197,94,0.12); color: var(--accent-green); }

        /* ===================== PANELS ===================== */
        .panel {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px;
            border-bottom: 1px solid var(--border-subtle);
        }
        .panel-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .panel-title i { color: var(--accent-blue); }
        .panel-body { padding: 20px; }

        /* ===================== TABLES ===================== */
        .table-wrap { overflow-x: auto; }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .admin-table thead tr {
            background: rgba(255,255,255,0.03);
        }
        .admin-table th {
            padding: 10px 14px;
            text-align: left;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            white-space: nowrap;
        }
        .admin-table td {
            padding: 11px 14px;
            border-top: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            vertical-align: middle;
        }
        .admin-table tbody tr:hover {
            background: rgba(255,255,255,0.02);
        }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .badge-active {
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.2);
            color: var(--accent-green);
        }

        /* Currency pill */
        .currency-pill {
            font-family: 'Roboto Mono', monospace;
            font-size: 11px;
            padding: 2px 7px;
            border-radius: 5px;
            background: rgba(255,190,26,0.1);
            color: var(--accent-gold);
            font-weight: 700;
            border: 1px solid rgba(255,190,26,0.15);
        }

        /* Balance value */
        .balance-val {
            font-family: 'Roboto Mono', monospace;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* Action buttons */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px; height: 28px;
            border-radius: 7px;
            border: 1px solid var(--border-subtle);
            background: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }
        .action-btn:hover { color: var(--text-primary); border-color: var(--border-hover); background: rgba(255,255,255,0.06); }
        .action-btn.edit:hover { color: var(--accent-blue); border-color: rgba(79,142,247,0.3); }
        .action-btn.del:hover { color: var(--accent-red); border-color: rgba(239,68,68,0.3); }
        .action-btn.block-user { color: #f97316; border-color: rgba(249,115,22,0.25); }
        .action-btn.block-user:hover { color: #fb923c; border-color: rgba(249,115,22,0.5); background: rgba(249,115,22,0.08); }
        .action-btn.unblock { color: var(--accent-green, #22c55e); border-color: rgba(34,197,94,0.25); }
        .action-btn.unblock:hover { color: #4ade80; border-color: rgba(34,197,94,0.5); background: rgba(34,197,94,0.08); }

        /* User status badge */
        .user-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
        .user-status-badge.active {
            background: rgba(34,197,94,0.1);
            color: #4ade80;
            border: 1px solid rgba(34,197,94,0.2);
        }
        .user-status-badge.blocked {
            background: rgba(239,68,68,0.1);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
        }

        /* Blocked row subtle highlight */
        .user-row-blocked td {
            opacity: 0.7;
        }
        .user-row-blocked { background: rgba(239,68,68,0.03); }



        /* ===================== SEARCH BAR ===================== */
        .search-bar {
            position: relative;
            max-width: 260px;
        }
        .search-bar i {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13px;
        }
        .search-input {
            width: 100%;
            padding: 8px 12px 8px 34px;
            background: var(--bg-input);
            border: 1px solid var(--border-subtle);
            border-radius: 9px;
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s;
        }
        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus { border-color: var(--accent-blue); }

        /* ===================== EDIT BALANCE MODAL ===================== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 1000;
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .design-preview-card {
            cursor: pointer;
            transition: all 0.22s ease !important;
            background: rgba(255,255,255,0.02) !important;
            padding: 12px;
            border-radius: 12px;
            border: 2px solid var(--border-subtle) !important;
            text-align: center;
        }
        .design-preview-card:hover {
            transform: translateY(-2px);
            border-color: rgba(79,142,247,0.3) !important;
            background: rgba(255,255,255,0.04) !important;
        }
        .design-preview-card.selected-design {
            border-color: var(--accent-gold) !important;
            background: rgba(255,190,26,0.08) !important;
            box-shadow: 0 0 12px rgba(255,190,26,0.25);
        }
        .modal-box {
            background: var(--bg-panel);
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            padding: 28px;
            width: 380px;
            position: relative;
            animation: modalIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.9); }
            to   { opacity: 1; transform: scale(1); }
        }
        .modal-close {
            position: absolute;
            top: 14px; right: 14px;
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
            border-radius: 6px;
            transition: color 0.2s;
        }
        .modal-close:hover { color: var(--text-primary); }
        .modal-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--text-primary);
        }
        .modal-title i { margin-right: 8px; color: var(--accent-blue); }
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 7px;
        }
        .form-input {
            width: 100%;
            padding: 10px 14px;
            background: var(--bg-input);
            border: 1px solid var(--border-subtle);
            border-radius: 9px;
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }
        .form-input:focus { border-color: var(--accent-blue); }
        .form-input:disabled { opacity: 0.5; cursor: not-allowed; }

        /* Submit btn */
        .btn-primary {
            width: 100%;
            padding: 11px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #4f8ef7);
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(79,142,247,0.3);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,142,247,0.4); }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        /* Toast */
        .admin-toast {
            position: fixed;
            bottom: 24px; right: 24px;
            background: var(--bg-panel);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 13px;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 2000;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .admin-toast.show { transform: translateX(0); }
        .admin-toast i { color: var(--accent-green); }
        .admin-toast.error i { color: var(--accent-red); }

        /* Spin */
        @keyframes spin { to { transform: rotate(360deg); } }
        .fa-spin { animation: spin 0.8s linear infinite; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--text-muted);
        }
        .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; opacity: 0.4; }
        .empty-state p { font-size: 14px; }

        /* Loading state */
        .loading-row td {
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
        }

        /* ===================== ADMIN SIDEBAR UPGRADES ===================== */
        .admin-sidebar {
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-nav-link {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            border: 1px solid transparent;
        }
        .sidebar-nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: var(--accent-purple);
            border-radius: 0 4px 4px 0;
            transition: height 0.25s ease;
        }
        .sidebar-nav-link.active::after {
            height: 60%;
        }
        .sidebar-nav-link:hover {
            transform: translateX(4px);
        }
        .sidebar-nav-link i {
            transition: transform 0.25s ease;
        }
        .sidebar-nav-link:hover i {
            transform: scale(1.1);
        }

        /* ===================== ADMIN LIGHT THEME ===================== */
        .light-theme {
            --bg-deep:        #f3f4f6;
            --bg-sidebar:     #ffffff;
            --bg-card:        #ffffff;
            --bg-panel:       #f9fafb;
            --bg-input:       #ffffff;
            --text-primary:   #111827;
            --text-secondary: #4b5563;
            --text-muted:     #9ca3af;
            --border-subtle:  #e5e7eb;
            --border-hover:   #cbd5e1;
        }

        .light-theme .admin-sidebar {
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.03);
        }

        .light-theme .admin-sidebar::before {
            background: radial-gradient(ellipse at top, rgba(139, 92, 246, 0.05) 0%, transparent 70%);
        }

        .light-theme .sidebar-nav-link:hover {
            background: rgba(139, 92, 246, 0.04);
            color: var(--accent-purple);
        }

        .light-theme .sidebar-nav-link.active {
            background: rgba(139, 92, 246, 0.08);
            color: var(--accent-purple);
            border-color: rgba(139, 92, 246, 0.2);
        }
        
        .light-theme .sidebar-nav-link.active i {
            color: var(--accent-purple);
        }

        .light-theme .sidebar-admin-card {
            background: rgba(139, 92, 246, 0.05);
            border-color: rgba(139, 92, 246, 0.12);
        }

        .light-theme .sidebar-logout-btn {
            color: #6b7280;
        }

        .light-theme .sidebar-logout-btn:hover {
            color: var(--accent-red);
        }

        .light-theme .panel,
        .light-theme .stat-card,
        .light-theme .modal-box {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            background: #ffffff;
            border-color: #e5e7eb;
        }

        .light-theme .form-input,
        .light-theme select {
            border: 1px solid #cbd5e1;
            color: #111827;
            background: #ffffff;
        }

        .light-theme .admin-table th {
            background: #f3f4f6;
            color: #4b5563;
            border-bottom: 1px solid #e5e7eb;
        }

        .light-theme .admin-table td {
            color: #111827;
            border-bottom: 1px solid #f3f4f6;
        }

        .light-theme .admin-table tbody tr:hover {
            background: #f9fafb;
        }

        .light-theme .admin-topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        .light-theme .admin-toast {
            background: #ffffff;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="admin-layout">

        <!-- ==================== SIDEBAR ==================== -->
        <aside class="admin-sidebar">
            <div class="sidebar-logo">
                <div class="logo-icon-wrap">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <div class="logo-text">
                    Aviator Admin
                    <small>Control Panel</small>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-label">Main</div>
                <button class="sidebar-nav-link active" id="nav-overview" onclick="switchTab('overview', this)">
                    <i class="fas fa-chart-pie"></i> Overview
                </button>
                <button class="sidebar-nav-link" id="nav-users" onclick="switchTab('users', this)">
                    <i class="fas fa-users"></i> User Management
                </button>
                <button class="sidebar-nav-link" id="nav-withdrawals" onclick="switchTab('withdrawals', this)">
                    <i class="fas fa-money-bill-transfer"></i> Withdrawal Requests
                </button>
                <button class="sidebar-nav-link" id="nav-deposits" onclick="switchTab('deposits', this)">
                    <i class="fas fa-circle-down"></i> Deposit Requests
                </button>
                <button class="sidebar-nav-link" id="nav-support" onclick="switchTab('support', this)">
                    <i class="fas fa-comments"></i> Support Chat <span class="badge-unread-total" id="admin-chat-unread-badge" style="display:none; background:var(--accent-red); color:#fff; font-size:10px; padding:2px 6px; border-radius:10px; margin-left:auto; font-weight:700;">0</span>
                </button>

                <div class="nav-section-label" style="margin-top:8px;">Game</div>
                <button class="sidebar-nav-link" id="nav-game" onclick="switchTab('game', this)">
                    <i class="fas fa-gamepad"></i> Game Settings
                </button>

                <div class="nav-section-label" style="margin-top:8px;">Tools</div>
                <button class="sidebar-nav-link" id="nav-gateways" onclick="switchTab('gateways', this)">
                    <i class="fas fa-circle-down"></i> Deposit Gateways Setup
                </button>
                <button class="sidebar-nav-link" id="nav-withdraw-gateways" onclick="switchTab('withdraw-gateways', this)">
                    <i class="fas fa-circle-up"></i> Withdraw Payment Setup
                </button>
                <button class="sidebar-nav-link" id="nav-settings" onclick="switchTab('settings', this)">
                    <i class="fas fa-percent"></i> Commission Setup
                </button>
                <a href="{{ route('play') }}" class="sidebar-nav-link" target="_blank">
                    <i class="fas fa-gamepad"></i> View Game
                </a>
                <a href="{{ route('home') }}" class="sidebar-nav-link" target="_blank">
                    <i class="fas fa-globe"></i> View Site
                </a>

                <!-- ⚡ FORCE CRASH BUTTON -->
                <div style="margin-top:16px; padding: 0 4px;">
                    <button
                        id="sidebar-force-crash-btn"
                        onclick="adminForceCrash()"
                        style="
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            gap: 8px;
                            width: 100%;
                            padding: 11px 12px;
                            border-radius: 10px;
                            border: 1px solid rgba(239,68,68,0.4);
                            background: linear-gradient(135deg, rgba(239,68,68,0.18), rgba(185,28,28,0.12));
                            color: #f87171;
                            font-family: 'Outfit', sans-serif;
                            font-size: 13px;
                            font-weight: 700;
                            cursor: pointer;
                            letter-spacing: 0.3px;
                            transition: all 0.2s;
                            animation: crashPulse 2s infinite;
                        "
                        onmouseover="this.style.background='linear-gradient(135deg,rgba(239,68,68,0.35),rgba(185,28,28,0.25))'; this.style.borderColor='rgba(239,68,68,0.7)'; this.style.color='#fca5a5';"
                        onmouseout="this.style.background='linear-gradient(135deg,rgba(239,68,68,0.18),rgba(185,28,28,0.12))'; this.style.borderColor='rgba(239,68,68,0.4)'; this.style.color='#f87171';"
                    >
                        <i class="fas fa-bolt"></i>
                        <span>Force Crash Game</span>
                    </button>
                </div>
            </nav>

            <!-- Admin info card -->
            <div class="sidebar-admin-card">
                <div class="admin-avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="admin-info">
                    <div class="admin-info-name">{{ auth()->user()->name }}</div>
                    <div class="admin-info-role">Super Admin</div>
                </div>
                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
                <button class="sidebar-logout-btn" onclick="document.getElementById('admin-logout-form').submit()" title="Logout">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                </button>
            </div>
        </aside>

        <!-- ==================== MAIN ==================== -->
        <div class="admin-main">

            <!-- Top bar -->
            <div class="admin-topbar">
                <div class="topbar-title" id="topbar-page-title">
                    Overview <span>/ Admin Dashboard</span>
                </div>
                <div class="topbar-actions">
                    <button id="admin-theme-toggle" onclick="toggleAdminTheme()" class="sidebar-nav-link" style="padding: 6px 12px; margin-bottom:0; display:inline-flex; align-items:center; gap:6px; cursor:pointer; width:auto; border:1px solid var(--border-subtle); border-radius:8px; background:rgba(255,255,255,0.03); color:var(--text-primary); font-size:12px; font-weight:600;">
                        <i class="fas fa-sun" id="admin-theme-icon"></i> <span id="admin-theme-text">Light Mode</span>
                    </button>
                    <div class="topbar-badge">
                        <div class="status-dot"></div>
                        System Online
                    </div>
                </div>
            </div>

            <!-- Scrollable content area -->
            <div class="admin-content">

                <!-- ========== TAB: OVERVIEW ========== -->
                <div class="tab-pane active" id="tab-overview">
                    <div class="page-header">
                        <h2>Platform Overview</h2>
                        <p>Real-time statistics and insights for the Aviator platform.</p>
                    </div>

                    <!-- Stats cards -->
                    <div class="stats-grid">
                        <div class="stat-card blue">
                            <div class="stat-card-icon"><i class="fas fa-users"></i></div>
                            <div class="stat-card-val" id="stat-total-users">{{ $totalUsers }}</div>
                            <div class="stat-card-label">Total Users</div>
                            <span class="stat-card-change change-up">Active</span>
                        </div>
                        <div class="stat-card green">
                            <div class="stat-card-icon"><i class="fas fa-wallet"></i></div>
                            <div class="stat-card-val" id="stat-total-balance">{{ number_format($totalDeposits, 0, '.', ',') }}</div>
                            <div class="stat-card-label">Total Wallet Balance</div>
                            <span class="stat-card-change change-up">BDT</span>
                        </div>
                        <div class="stat-card purple">
                            <div class="stat-card-icon"><i class="fas fa-user-plus"></i></div>
                            <div class="stat-card-val" id="stat-new-today">0</div>
                            <div class="stat-card-label">New Users Today</div>
                        </div>
                        <div class="stat-card orange">
                            <div class="stat-card-icon"><i class="fas fa-earth-asia"></i></div>
                            <div class="stat-card-val" id="stat-countries">—</div>
                            <div class="stat-card-label">Active Countries</div>
                        </div>
                    </div>

                    <!-- Recent users table -->
                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-clock-rotate-left"></i> Recently Registered Users</div>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>EMAIL</th>
                                        <th>MOBILE</th>
                                        <th>COUNTRY</th>
                                        <th>CURRENCY</th>
                                        <th>BALANCE</th>
                                        <th>REGISTERED</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody id="overview-users-tbody">
                                    @forelse($recentUsers as $user)
                                    <tr>
                                        <td><span style="color:var(--text-muted);font-family:'Roboto Mono',monospace;font-size:11px;">#{{ 50000 + $user->id }}</span></td>
                                        <td><strong style="color:var(--text-primary);">{{ $user->name }}</strong></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile ?? '—' }}</td>
                                        <td>{{ $user->country ?? '—' }}</td>
                                        <td><span class="currency-pill">{{ $user->currency }}</span></td>
                                        <td><span class="balance-val">{{ number_format($user->balance, 2, '.', ',') }}</span></td>
                                        <td style="color:var(--text-muted);font-size:12px;">{{ $user->created_at->format('d M Y') }}</td>
                                        <td><span class="status-badge badge-active"><i class="fas fa-circle" style="font-size:6px;"></i>Active</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9">
                                            <div class="empty-state">
                                                <i class="fas fa-users-slash"></i>
                                                <p>No users registered yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========== TAB: WITHDRAWAL REQUESTS ========== -->
                <div class="tab-pane" id="tab-withdrawals">
                    <div class="page-header">
                        <h2>Withdrawal Requests</h2>
                        <p>Approve or reject customer withdrawal requests. Rejected requests refund the user immediately.</p>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-money-bill-transfer"></i> Withdrawal Requests History</div>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>CUSTOMER</th>
                                        <th>GATEWAY</th>
                                        <th>ACCOUNT DETAIL</th>
                                        <th>AMOUNT</th>
                                        <th>FEE</th>
                                        <th>NET RECEIVABLE</th>
                                        <th>DATE & TIME</th>
                                        <th>STATUS</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="withdrawals-table-tbody">
                                    <tr class="loading-row">
                                        <td colspan="10"><i class="fas fa-spinner fa-spin"></i> Loading withdrawals...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========== TAB: DEPOSIT REQUESTS ========== -->
                <div class="tab-pane" id="tab-deposits">
                    <div class="page-header">
                        <h2>Deposit Requests</h2>
                        <p>Approve or reject manual deposit requests. Approved deposits credit the user wallet and distribute referral commissions.</p>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-circle-down"></i> Pending & Historical Deposits</div>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>CUSTOMER</th>
                                        <th>GATEWAY</th>
                                        <th>SENDER NUMBER</th>
                                        <th>TRANSACTION ID</th>
                                        <th>AMOUNT</th>
                                        <th>SCREENSHOT</th>
                                        <th>REJECTION REASON</th>
                                        <th>DATE & TIME</th>
                                        <th>STATUS</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="deposits-table-tbody">
                                    <tr class="loading-row">
                                        <td colspan="11"><i class="fas fa-spinner fa-spin"></i> Loading deposits...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========== TAB: USER MANAGEMENT ========== -->
                <div class="tab-pane" id="tab-users">
                    <div class="page-header">
                        <h2>User Management</h2>
                        <p>View, search, edit balances, and manage all registered user accounts.</p>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-users"></i> All Registered Users</div>
                            <div class="search-bar">
                                <i class="fas fa-search"></i>
                                <input type="text" class="search-input" id="user-search-input" placeholder="Search name, email..." oninput="filterUsers()">
                            </div>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>EMAIL / MOBILE</th>
                                        <th>COUNTRY</th>
                                        <th>CURRENCY</th>
                                        <th>BALANCE</th>
                                        <th>STATUS</th>
                                        <th>JOINED</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="users-table-tbody">
                                    <tr class="loading-row">
                                        <td colspan="9"><i class="fas fa-spinner fa-spin"></i> Loading users...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========== TAB: GAME SETTINGS ========== -->
                <div class="tab-pane" id="tab-game">
                    <div class="page-header">
                        <h2>Game Settings — Crash Points</h2>
                        <p>Manage the crash multiplier sequence. Active points are used in order. Customers cannot see this list.</p>
                    </div>

                    <!-- ⚡ LIVE GAME MONITOR PANEL -->
                    <div class="panel" style="border: 1px solid rgba(168, 85, 247, 0.3); background: linear-gradient(to right, rgba(17, 24, 39, 0.95), rgba(88, 28, 135, 0.15)); margin-bottom: 24px; border-radius: 12px; box-shadow: 0 4px 20px -2px rgba(168, 85, 247, 0.15);">
                        <div class="panel-header" style="border-bottom: 1px solid rgba(168, 85, 247, 0.2); padding: 16px 20px;">
                            <div class="panel-title" style="display:flex; align-items:center; gap:8px; font-weight:700; color:#fff; font-size:16px;">
                                <i class="fas fa-satellite-dish" style="color:#a855f7; font-size:18px;"></i>
                                Live Game Monitor
                            </div>
                            <span class="badge" id="live-monitor-state-badge" style="padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: uppercase; background: rgba(107, 114, 128, 0.2); color: #9ca3af;">
                                Offline
                            </span>
                        </div>
                        <div class="panel-body" style="padding: 20px;">
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 20px;">
                                
                                <!-- Card: Round ID -->
                                <div style="background: rgba(31, 41, 55, 0.5); padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                    <div style="font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Current Round ID</div>
                                    <div id="live-monitor-round-id" style="font-size: 18px; font-weight: 700; color: #fff; font-family: 'Roboto Mono', monospace;">Loading...</div>
                                </div>

                                <!-- Card: Sequence Index -->
                                <div style="background: rgba(31, 41, 55, 0.5); padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                    <div style="font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Sequence Index</div>
                                    <div id="live-monitor-seq-index" style="font-size: 18px; font-weight: 700; color: #facc15;">Loading...</div>
                                </div>

                                <!-- Card: Current Multiplier -->
                                <div style="background: rgba(31, 41, 55, 0.5); padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                    <div style="font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Live Multiplier</div>
                                    <div id="live-monitor-multiplier" style="font-size: 22px; font-weight: 800; color: #38ef7d; font-family: 'Roboto Mono', monospace;">1.00x</div>
                                </div>

                                <!-- Card: Real Bets -->
                                <div style="background: rgba(31, 41, 55, 0.5); padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.05);">
                                    <div style="font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Real Bets Total</div>
                                    <div id="live-monitor-bets-amount" style="font-size: 18px; font-weight: 700; color: #fff;">0.00 BDT</div>
                                    <div id="live-monitor-bets-count" style="font-size: 10px; color: #9ca3af; margin-top: 2px;">0 players</div>
                                </div>

                            </div>

                            <!-- Force Crash CTA Box -->
                            <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 16px; background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.15); border-radius: 10px;">
                                <div style="flex: 1; text-align: left;">
                                    <h4 style="margin: 0 0 4px 0; color: #fca5a5; font-size: 14px; font-weight: 700;">Emergency Force Crash</h4>
                                    <p style="margin: 0; color: #9ca3af; font-size: 12px; line-height: 1.4;">Clicking this button will instantly crash the currently running flight round for all players at the exact live multiplier value displayed above.</p>
                                </div>
                                <button 
                                    id="live-monitor-force-crash-btn"
                                    onclick="adminForceCrash()"
                                    style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; border: none; border-radius: 8px; background: #ef4444; color: #fff; font-family: 'Outfit', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);"
                                    onmouseover="this.style.background='#dc2626'; this.style.transform='translateY(-1px)';"
                                    onmouseout="this.style.background='#ef4444'; this.style.transform='translateY(0)';"
                                >
                                    <i class="fas fa-bolt"></i> Force Crash Game
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-list-ol"></i> Crash Point Sequence</div>
                            <button onclick="openAddPointModal()" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;border:none;background:linear-gradient(135deg,#2563eb,#4f8ef7);color:#fff;font-family:'Outfit',sans-serif;font-size:12px;font-weight:700;cursor:pointer;">
                                <i class="fas fa-plus"></i> Add New Point
                            </button>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>CRASH POINT</th>
                                        <th>STATUS</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="crash-points-tbody">
                                    <tr class="loading-row">
                                        <td colspan="4"><i class="fas fa-spinner fa-spin"></i> Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-circle-info" style="color:var(--accent-orange);"></i> How It Works</div>
                        </div>
                        <div class="panel-body">
                            <p style="font-size:13px;color:var(--text-secondary);line-height:1.8;">
                                <strong style="color:var(--text-primary);">Sequence Mode:</strong> The game engine reads crash points from this list in order (top to bottom). When the list ends, it loops back to the beginning.<br>
                                <strong style="color:var(--text-primary);">Active vs Inactive:</strong> Only <span style="color:var(--accent-green);">Active</span> points are used in the sequence. Inactive points are skipped.<br>
                                <strong style="color:var(--text-primary);">Fallback:</strong> If no active points exist, the game uses a random crash point automatically.<br>
                                <strong style="color:var(--accent-orange);">Security:</strong> Customers cannot see the crash point list or predict upcoming crashes. The crash point is only sent to the game at the moment the round begins.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ========== TAB: PAYMENT GATEWAYS ========== -->
                <div class="tab-pane" id="tab-gateways">
                    <div class="page-header">
                        <h2>Payment Gateways Management</h2>
                        <p>Configure manual and auto payment gateways, logos, receiver accounts, custom user deposit fields, and active status.</p>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-credit-card"></i> Payment Gateways</div>
                            <button onclick="openAddGatewayModal()" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;border:none;background:linear-gradient(135deg,#2563eb,#4f8ef7);color:#fff;font-family:'Outfit',sans-serif;font-size:12px;font-weight:700;cursor:pointer;">
                                <i class="fas fa-plus-circle"></i> Add New Gateway
                            </button>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>LOGO</th>
                                        <th>GATEWAY NAME</th>
                                        <th>TYPE</th>
                                        <th>SUPPORTED METHODS</th>
                                        <th>STATUS</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="gateways-table-tbody">
                                    <tr class="loading-row">
                                        <td colspan="6"><i class="fas fa-spinner fa-spin"></i> Loading gateways...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========== TAB: WITHDRAW GATEWAYS ========== -->
                <div class="tab-pane" id="tab-withdraw-gateways">
                    <div class="page-header">
                        <h2>Withdrawal Payment Methods</h2>
                        <p>Configure withdrawal payment methods, upload logos, set admin wallet/receiver numbers, and toggle active status.</p>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-wallet"></i> Withdrawal Methods</div>
                            <button onclick="openAddWithdrawGatewayModal()" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:9px;border:none;background:linear-gradient(135deg,#2563eb,#4f8ef7);color:#fff;font-family:'Outfit',sans-serif;font-size:12px;font-weight:700;cursor:pointer;">
                                <i class="fas fa-plus-circle"></i> Add Withdrawal Method
                            </button>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>LOGO</th>
                                        <th>METHOD NAME</th>
                                        <th>ADMIN WALLET NUMBER</th>
                                        <th>STATUS</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="withdraw-gateways-table-tbody">
                                    <tr class="loading-row">
                                        <td colspan="5"><i class="fas fa-spinner fa-spin"></i> Loading withdrawal methods...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========== TAB: SETTINGS (COMMISSIONS) ========== -->
                <div class="tab-pane" id="tab-settings">
                    <div class="page-header">
                        <h2>Commission Setup</h2>
                        <p>Configure referral commission percentages and withdrawal charge percentages, along with their active/inactive status.</p>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-percent"></i> Platform Commission Configurations</div>
                        </div>
                        <div class="panel-body">
                            <form id="platform-settings-form" onsubmit="savePlatformSettings(event)" style="max-width: 1000px;">
                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 20px;">
                                    <div style="background:rgba(255,255,255,0.02); padding:16px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <label class="form-label" style="font-size:11px;color:var(--accent-blue);margin-bottom:8px;font-weight:700;">LEVEL 1 REFERRAL</label>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Commission Percentage (%)</label>
                                            <input type="number" class="form-input" id="setting-ref-l1" min="0" max="100" step="0.01" required placeholder="e.g. 10.00">
                                        </div>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Status</label>
                                            <select class="form-input" id="setting-ref-l1-status" style="cursor:pointer;">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="background:rgba(255,255,255,0.02); padding:16px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <label class="form-label" style="font-size:11px;color:var(--accent-purple);margin-bottom:8px;font-weight:700;">LEVEL 2 REFERRAL</label>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Commission Percentage (%)</label>
                                            <input type="number" class="form-input" id="setting-ref-l2" min="0" max="100" step="0.01" required placeholder="e.g. 5.00">
                                        </div>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Status</label>
                                            <select class="form-input" id="setting-ref-l2-status" style="cursor:pointer;">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="background:rgba(255,255,255,0.02); padding:16px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <label class="form-label" style="font-size:11px;color:var(--accent-teal);margin-bottom:8px;font-weight:700;">LEVEL 3 REFERRAL</label>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Commission Percentage (%)</label>
                                            <input type="number" class="form-input" id="setting-ref-l3" min="0" max="100" step="0.01" required placeholder="e.g. 2.00">
                                        </div>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Status</label>
                                            <select class="form-input" id="setting-ref-l3-status" style="cursor:pointer;">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="background:rgba(255,255,255,0.02); padding:16px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <label class="form-label" style="font-size:11px;color:var(--accent-orange);margin-bottom:8px;font-weight:700;">WITHDRAW COMMISSION</label>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Commission Percentage (%)</label>
                                            <input type="number" class="form-input" id="setting-withdraw-fee" min="0" max="100" step="0.01" required placeholder="e.g. 5.00">
                                        </div>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Status</label>
                                            <select class="form-input" id="setting-withdraw-fee-status" style="cursor:pointer;">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div style="background:rgba(255,255,255,0.02); padding:16px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <label class="form-label" style="font-size:11px;color:var(--accent-teal);margin-bottom:8px;font-weight:700;">FLIGHT DESIGN SELECTOR</label>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Active Helicopter/Plane Design</label>
                                            <select class="form-input" id="setting-helicopter-design" style="cursor:pointer;" required>
                                                <option value="1">Design 1: Gold Fighter Jet</option>
                                                <option value="2">Design 2: Classic Chopper</option>
                                                <option value="3">Design 3: Space Rocket</option>
                                                <option value="4">Design 4: Alien UFO</option>
                                                <option value="5">Design 5: Stealth Bomber</option>
                                                <option value="6">Design 6: Cyber Drone</option>
                                                <option value="7">Design 7: Vintage Biplane</option>
                                                <option value="8">Design 8: Hot Air Balloon</option>
                                                <option value="9">Design 9: Future Skycar</option>
                                                <option value="10">Design 10: Phoenix Firebird</option>
                                            </select>
                                        </div>
                                        <button type="button" onclick="openViewHelicoptersModal()" class="btn-primary" style="background:linear-gradient(135deg, #14b8a6, #0d9488); box-shadow: none; font-size:11px; padding: 8px 12px; display:inline-flex; align-items:center; gap:6px; width:auto; height:34px;">
                                            <i class="fas fa-eye"></i> View 10 Designs
                                        </button>
                                    </div>

                                    <div style="background:rgba(255,255,255,0.02); padding:16px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <label class="form-label" style="font-size:11px;color:var(--accent-teal);margin-bottom:8px;font-weight:700;">LOBBY COUNTDOWN TIMER</label>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Countdown Wait Duration (seconds)</label>
                                            <input type="number" class="form-input" id="setting-countdown-time" min="2" max="60" placeholder="Enter wait duration in seconds" required>
                                        </div>
                                    </div>

                                    <div style="background:rgba(255,255,255,0.02); padding:16px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <label class="form-label" style="font-size:11px;color:var(--accent-blue);margin-bottom:8px;font-weight:700;">BACKGROUND MUSIC</label>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Active BG Music File Path</label>
                                            <input type="text" class="form-input" id="setting-bg-music" placeholder="No custom music uploaded yet" readonly style="background:rgba(255,255,255,0.02); color:var(--text-muted);">
                                        </div>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Upload New BG Music File (.mp3/.wav/.ogg)</label>
                                            <input type="file" class="form-input" id="setting-bg-music-file" accept="audio/*">
                                        </div>
                                    </div>

                                    <div style="background:rgba(255,255,255,0.02); padding:16px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <label class="form-label" style="font-size:11px;color:var(--accent-orange);margin-bottom:8px;font-weight:700;">COUNTDOWN TICK SOUND</label>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Active Tick Sound File Path</label>
                                            <input type="text" class="form-input" id="setting-countdown-sound" placeholder="No custom countdown tick uploaded yet" readonly style="background:rgba(255,255,255,0.02); color:var(--text-muted);">
                                        </div>
                                        <div class="form-group" style="margin-bottom:0;">
                                            <label class="form-label" style="font-size:10px;color:var(--text-muted);">Upload New Tick Sound File (.mp3/.wav/.ogg)</label>
                                            <input type="file" class="form-input" id="setting-countdown-sound-file" accept="audio/*">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn-primary" id="btn-save-settings" style="width:auto; padding: 12px 30px; margin-top: 10px;">
                                    <i class="fas fa-save"></i> Save Platform Configurations
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-circle-info"></i> Admin Account Information</div>
                        </div>
                        <div class="panel-body">
                            <table class="admin-table" style="max-width:560px;">
                                <tbody>
                                    <tr>
                                        <td style="color:var(--text-muted);width:160px;">Admin Name</td>
                                        <td><strong>{{ auth()->user()->name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--text-muted);">Admin Email</td>
                                        <td>{{ auth()->user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--text-muted);">Role</td>
                                        <td><span class="status-badge badge-active">Super Admin</span></td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--text-muted);">Platform</td>
                                        <td>Aviator P2P Sports Escrow</td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--text-muted);">Laravel Version</td>
                                        <td style="font-family:'Roboto Mono',monospace;font-size:12px;">{{ app()->version() }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--text-muted);">PHP Version</td>
                                        <td style="font-family:'Roboto Mono',monospace;font-size:12px;">{{ phpversion() }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:var(--text-muted);">Server Time</td>
                                        <td style="font-family:'Roboto Mono',monospace;font-size:12px;">{{ now()->format('d M Y, H:i:s T') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title"><i class="fas fa-triangle-exclamation" style="color:var(--accent-orange);"></i> Danger Zone</div>
                        </div>
                        <div class="panel-body">
                            <p style="font-size:13px;color:var(--text-secondary);margin-bottom:16px;">These actions are irreversible. Please proceed with caution.</p>
                            <form id="admin-logout-form-settings" action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" style="padding:10px 20px;border-radius:9px;border:1px solid rgba(239,68,68,0.3);background:rgba(239,68,68,0.1);color:var(--accent-red);font-family:'Outfit',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:all 0.2s;">
                                    <i class="fas fa-arrow-right-from-bracket"></i> Sign Out Admin Session
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Support Chat Tab Panel -->
                <div class="tab-pane" id="tab-support">
                    <div class="page-header">
                        <h2>Support Chat Center</h2>
                        <p>Chat with active players and help them resolve their queries in real-time.</p>
                    </div>

                    <div style="display: flex; gap: 20px; height: calc(100vh - 220px); min-height: 520px; background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: 14px; overflow: hidden;">
                        
                        <!-- Left Panel: Chat List -->
                        <div style="width: 320px; min-width: 320px; border-right: 1px solid var(--border-subtle); display: flex; flex-direction: column; background: rgba(0, 0, 0, 0.15);">
                            <div style="padding: 16px; border-bottom: 1px solid var(--border-subtle); font-weight: 700; font-size: 14px; color: var(--text-primary); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;">
                                <span>Conversations</span>
                                <button onclick="loadSupportChats()" style="background: none; border: none; color: var(--accent-blue); cursor: pointer; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;" title="Refresh conversations"><i class="fas fa-rotate"></i> Refresh</button>
                            </div>
                            <div id="admin-chat-users-list" style="flex: 1; overflow-y: auto; padding: 10px 0;">
                                <div style="padding: 20px; text-align: center; color: var(--text-muted);">
                                    <i class="fas fa-comments" style="font-size: 24px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                                    No active chats
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Active Message Window -->
                        <div id="admin-chat-window" style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: var(--text-muted); background: rgba(0, 0, 0, 0.05); position: relative;">
                            <div id="admin-chat-window-empty" style="padding: 40px;">
                                <i class="fas fa-message" style="font-size: 54px; margin-bottom: 18px; color: var(--text-muted); opacity: 0.25;"></i>
                                <h3 style="color: var(--text-primary); font-weight: 700; font-size: 16px;">Select a Conversation</h3>
                                <p style="font-size: 13px; margin-top: 6px; max-width: 320px; margin-left: auto; margin-right: auto; line-height: 1.4;">Choose a user from the list on the left to start chatting with them in real-time.</p>
                            </div>

                            <!-- Chat Box Wrapper (Hidden by default until user selected) -->
                            <div id="admin-chat-window-active" style="display: none; width: 100%; height: 100%; flex-direction: column; text-align: left;">
                                <!-- Active User Profile Header -->
                                <div style="padding: 14px 20px; border-bottom: 1px solid var(--border-subtle); background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;">
                                    <div>
                                        <h4 id="active-chat-user-name" style="color: var(--text-primary); font-size: 14.5px; font-weight: 700;">Customer Name</h4>
                                        <p id="active-chat-user-meta" style="color: var(--text-secondary); font-size: 11px; margin-top: 2px;">email@example.com / 01700000000</p>
                                    </div>
                                    <div style="font-size: 11px; background: rgba(79,142,247,0.1); border: 1px solid rgba(79,142,247,0.18); color: var(--accent-blue); padding: 4px 12px; border-radius: 20px; font-weight: 600;">
                                        Active Conversation
                                    </div>
                                </div>

                                <!-- Messages Box Scroll Area -->
                                <div id="admin-chat-messages-box" style="flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 12px; background: rgba(0,0,0,0.08);">
                                    <!-- Messages rendered here -->
                                </div>

                                <!-- Textarea Input Send Box -->
                                <form id="admin-chat-send-form" onsubmit="submitAdminChatMessage(event)" style="padding: 16px; border-top: 1px solid var(--border-subtle); background: var(--bg-card); display: flex; gap: 12px; align-items: center; flex-shrink: 0; margin-bottom: 0;">
                                    <input type="hidden" id="active-chat-user-id">
                                    <input type="text" id="admin-chat-input" placeholder="Type your reply here..." autocomplete="off" required style="flex: 1; padding: 12px 16px; background: var(--bg-input); border: 1px solid var(--border-subtle); border-radius: 10px; color: var(--text-primary); font-family: 'Outfit', sans-serif; font-size: 13.5px; outline: none; transition: border-color 0.2s;">
                                    <button type="submit" style="background: linear-gradient(135deg, #2563eb, #4f8ef7); border: none; border-radius: 10px; color: #fff; padding: 12px 22px; font-weight: 700; font-size: 13px; font-family: 'Outfit', sans-serif; cursor: pointer; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(79,142,247,0.25);">
                                        <span>Send</span> <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ==================== ADD/EDIT CRASH POINT MODAL ==================== -->
    <div class="modal-overlay" id="crash-point-modal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeCrashModal()"><i class="fas fa-times"></i></button>
            <div class="modal-title" id="cp-modal-title"><i class="fas fa-plus-circle"></i> Add Crash Point</div>
            <input type="hidden" id="cp-editing-id">
            <div class="form-group">
                <label class="form-label">Crash Multiplier Value (e.g. 1.5, 2.25, 10)</label>
                <input type="number" class="form-input" id="cp-point-input" min="1.00" max="1000" step="0.01" placeholder="e.g. 2.50">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select class="form-input" id="cp-status-input" style="cursor:pointer;">
                    <option value="active">Active (used in sequence)</option>
                    <option value="inactive">Inactive (skip this point)</option>
                </select>
            </div>
            <button class="btn-primary" id="btn-save-crash-point" onclick="saveCrashPoint()">
                <i class="fas fa-save"></i> Save Crash Point
            </button>
        </div>
    </div>

    <!-- ==================== ADD/EDIT PAYMENT GATEWAY MODAL ==================== -->
    <div class="modal-overlay" id="payment-gateway-modal" style="display:none; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(11,16,33,0.75); z-index:9999; padding:20px; box-sizing:border-box;">
        <div class="modal-box" style="max-width:800px; width:100%; max-height:90vh; overflow-y:auto; position:relative; background:var(--bg-secondary); border-radius:16px; border:1px solid rgba(255,255,255,0.08); padding:30px; box-shadow:0 20px 40px rgba(0,0,0,0.5);">
            <button class="modal-close" onclick="closeGatewayModal()" style="position:absolute; top:20px; right:20px; background:none; border:none; color:var(--text-muted); cursor:pointer; font-size:18px;"><i class="fas fa-times"></i></button>
            <div class="modal-title" id="gw-modal-title" style="font-family:'Outfit',sans-serif; font-size:20px; font-weight:700; color:#fff; margin-bottom:20px; display:flex; align-items:center; gap:10px;"><i class="fas fa-credit-card" style="color:var(--accent-purple);"></i> Add Payment Gateway</div>
            
            <form id="payment-gateway-form" onsubmit="savePaymentGateway(event)">
                <input type="hidden" id="gw-editing-id">
                
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label" style="font-size:12px;color:var(--text-muted);margin-bottom:6px;display:block;">Gateway Name</label>
                    <input type="text" class="form-input" id="gw-name-input" placeholder="e.g. bKash, USDT TRC20" required style="width:100%;">
                </div>
                
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label" style="font-size:12px;color:var(--text-muted);margin-bottom:6px;display:block;">Type</label>
                    <select class="form-input" id="gw-type-input" style="cursor:pointer; width:100%;" onchange="toggleGatewayTypeFields()">
                        <option value="manual">Manual</option>
                        <option value="auto">Auto</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label" style="font-size:12px;color:var(--text-muted);margin-bottom:6px;display:block;">Gateway Logo</label>
                    <input type="file" class="form-input" id="gw-logo-input" accept="image/*" style="width:100%;">
                    <div id="gw-logo-preview-wrap" style="margin-top:10px; display:none;">
                        <img id="gw-logo-preview" src="" style="max-height:60px; border-radius:6px; border:1px solid rgba(255,255,255,0.1);">
                    </div>
                </div>

                <!-- Settings Section -->
                <div class="panel" style="margin-top:20px; border:1px solid rgba(255,255,255,0.05); background:rgba(255,255,255,0.02); border-radius:10px; overflow:hidden;">
                    <div class="panel-header" style="padding:10px 15px; background:rgba(255,255,255,0.03); display:flex; justify-content:space-between; align-items:center;">
                        <div class="panel-title" style="font-size:13px; color:#fff; font-weight:600;"><i class="fas fa-cog" style="color:var(--accent-orange);"></i> Gateway Settings (Instructions/Info)</div>
                        <button type="button" onclick="addGatewaySettingRow()" style="background:var(--accent-purple); color:#fff; border:none; padding:5px 12px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:4px;">
                            <i class="fas fa-plus"></i> Add Setting
                        </button>
                    </div>
                    <div class="panel-body" id="gateway-settings-rows" style="padding:15px; display:flex; flex-direction:column; gap:10px;">
                        <!-- Rows injected here -->
                    </div>
                </div>

                <!-- User Deposit Form Fields Section -->
                <div class="panel" style="margin-top:20px; border:1px solid rgba(255,255,255,0.05); background:rgba(255,255,255,0.02); border-radius:10px; overflow:hidden;" id="gw-deposit-fields-panel">
                    <div class="panel-header" style="padding:10px 15px; background:rgba(255,255,255,0.03); display:flex; justify-content:space-between; align-items:center;">
                        <div class="panel-title" style="font-size:13px; color:#fff; font-weight:600;"><i class="fas fa-list" style="color:var(--accent-green);"></i> User Deposit Form Fields</div>
                        <button type="button" onclick="addGatewayFormRow()" style="background:var(--accent-purple); color:#fff; border:none; padding:5px 12px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:4px;">
                            <i class="fas fa-plus"></i> Add Form Field
                        </button>
                    </div>
                    <div class="panel-body" id="gateway-form-rows" style="padding:15px; display:flex; flex-direction:column; gap:10px;">
                        <!-- Rows injected here -->
                    </div>
                </div>

                <div class="form-group" style="margin-top:16px; margin-bottom:16px;">
                    <label class="form-label" style="font-size:12px;color:var(--text-muted);margin-bottom:6px;display:block;">Select Method</label>
                    <select class="form-input" id="gw-methods-input" style="cursor:pointer; width:100%;">
                        <option value="both">Withdraw + Deposit</option>
                        <option value="deposit">Deposit Only</option>
                        <option value="withdraw">Withdraw Only</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label" style="font-size:12px;color:var(--text-muted);margin-bottom:6px;display:block;">Status</label>
                    <select class="form-input" id="gw-status-input" style="cursor:pointer; width:100%;">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary" id="btn-save-gateway" style="margin-top:20px; width:100%; padding:12px; font-weight:700;">
                    <i class="fas fa-save"></i> Save Payment Gateway
                </button>
            </form>
        </div>
    </div>

    <!-- ==================== EDIT BALANCE MODAL ==================== -->
    <div class="modal-overlay" id="edit-balance-modal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeBalanceModal()"><i class="fas fa-times"></i></button>
            <div class="modal-title"><i class="fas fa-pen-to-square"></i> Edit User Balance</div>
            <input type="hidden" id="edit-user-id">
            <div class="form-group">
                <label class="form-label">User Name</label>
                <input type="text" class="form-input" id="edit-user-name" disabled>
            </div>
            <div class="form-group">
                <label class="form-label">New Balance</label>
                <input type="number" class="form-input" id="edit-user-balance" min="0" step="0.01" placeholder="Enter new balance">
            </div>
            <button class="btn-primary" id="btn-save-balance" onclick="saveUserBalance()">
                <i class="fas fa-save"></i> Save Changes
            </button>
        </div>
    </div>

    <!-- ==================== DEPOSIT REJECTION MODAL ==================== -->
    <div class="modal-overlay" id="deposit-rejection-modal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeDepositRejectionModal()"><i class="fas fa-times"></i></button>
            <div class="modal-title"><i class="fas fa-times-circle" style="color:var(--accent-red);"></i> Reject Deposit Request</div>
            <input type="hidden" id="reject-deposit-id">
            <div class="form-group">
                <label class="form-label">Rejection Reason</label>
                <textarea class="form-input" id="reject-deposit-reason" rows="3" placeholder="Enter reason for rejection" style="resize:vertical; min-height:80px; width:100%; box-sizing:border-box; padding:10px; border-radius:9px; background:rgba(0,0,0,0.2); border:1px solid var(--border-subtle); color:#fff; font-family:inherit;"></textarea>
            </div>
            <button class="btn-primary" id="btn-reject-deposit-submit" onclick="submitDepositRejection()" style="background:var(--accent-red); color:#fff; border:none; padding:10px 16px; border-radius:9px; font-weight:700; cursor:pointer; margin-top: 15px;">
                <i class="fas fa-circle-check"></i> Submit Rejection
            </button>
        </div>
    </div>

    <!-- ==================== ADD/EDIT WITHDRAWAL METHOD MODAL ==================== -->
    <div class="modal-overlay" id="withdraw-method-modal" style="display:none; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(11,16,33,0.75); z-index:9999; padding:20px; box-sizing:border-box;">
        <div class="modal-box" style="max-width:500px; width:100%; position:relative; background:var(--bg-card); border-radius:16px; border:1px solid rgba(255,255,255,0.08); padding:28px;">
            <button class="modal-close" onclick="closeWithdrawMethodModal()"><i class="fas fa-times"></i></button>
            <div class="modal-title" id="wm-modal-title" style="font-family:'Outfit',sans-serif; font-size:18px; font-weight:700; color:#fff; margin-bottom:20px; display:flex; align-items:center; gap:10px;"><i class="fas fa-wallet" style="color:var(--accent-teal);"></i> Add Withdrawal Method</div>
            
            <form id="withdraw-method-form" onsubmit="saveWithdrawMethod(event)">
                <input type="hidden" id="wm-editing-id">
                
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Method Name</label>
                    <input type="text" class="form-input" id="wm-name-input" placeholder="e.g. bKash Personal, Binance Pay" required style="width:100%;">
                </div>

                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Admin Wallet Number / Finance Address</label>
                    <input type="text" class="form-input" id="wm-number-input" placeholder="Enter admin number or Binance Pay/wallet address" required style="width:100%;">
                </div>
                
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Logo Image</label>
                    <input type="file" class="form-input" id="wm-logo-input" accept="image/*" style="width:100%;">
                    <div id="wm-logo-preview-wrap" style="margin-top:10px; display:none;">
                        <img id="wm-logo-preview" src="" style="max-height:60px; border-radius:6px; border:1px solid rgba(255,255,255,0.1);">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Status</label>
                    <select class="form-input" id="wm-status-input" style="cursor:pointer; width:100%;">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary" id="btn-save-withdraw-method" style="margin-top:20px; width:100%; padding:12px; font-weight:700;">
                    <i class="fas fa-save"></i> Save Withdrawal Method
                </button>
            </form>
        </div>
    </div>

    <!-- ==================== VIEW HELICOPTERS MODAL ==================== -->
    <div class="modal-overlay" id="view-helicopters-modal" style="display:none; align-items:center; justify-content:center; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(11,16,33,0.75); z-index:9999; padding:20px; box-sizing:border-box;">
        <div class="modal-box" style="max-width:900px; width:100%; max-height:90vh; overflow-y:auto; position:relative; background:var(--bg-card); border-radius:16px; border:1px solid rgba(255,255,255,0.08); padding:28px;">
            <button class="modal-close" onclick="closeViewHelicoptersModal()"><i class="fas fa-times"></i></button>
            <div class="modal-title" style="font-family:'Outfit',sans-serif; font-size:18px; font-weight:700; color:#fff; margin-bottom:20px; display:flex; align-items:center; gap:10px;"><i class="fas fa-helicopter" style="color:var(--accent-gold);"></i> 10 Helicopter Designs Preview</div>
            
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:20px;">
                <div class="panel design-preview-card" id="design-card-1" onclick="selectHelicopterDesignInPreview(1)">
                    <canvas id="design-canvas-1" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 1: Gold Fighter Jet</div>
                </div>
                <div class="panel design-preview-card" id="design-card-2" onclick="selectHelicopterDesignInPreview(2)">
                    <canvas id="design-canvas-2" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 2: Classic Chopper</div>
                </div>
                <div class="panel design-preview-card" id="design-card-3" onclick="selectHelicopterDesignInPreview(3)">
                    <canvas id="design-canvas-3" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 3: Space Rocket</div>
                </div>
                <div class="panel design-preview-card" id="design-card-4" onclick="selectHelicopterDesignInPreview(4)">
                    <canvas id="design-canvas-4" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 4: Alien UFO</div>
                </div>
                <div class="panel design-preview-card" id="design-card-5" onclick="selectHelicopterDesignInPreview(5)">
                    <canvas id="design-canvas-5" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 5: Stealth Bomber</div>
                </div>
                <div class="panel design-preview-card" id="design-card-6" onclick="selectHelicopterDesignInPreview(6)">
                    <canvas id="design-canvas-6" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 6: Cyber Drone</div>
                </div>
                <div class="panel design-preview-card" id="design-card-7" onclick="selectHelicopterDesignInPreview(7)">
                    <canvas id="design-canvas-7" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 7: Vintage Biplane</div>
                </div>
                <div class="panel design-preview-card" id="design-card-8" onclick="selectHelicopterDesignInPreview(8)">
                    <canvas id="design-canvas-8" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 8: Hot Air Balloon</div>
                </div>
                <div class="panel design-preview-card" id="design-card-9" onclick="selectHelicopterDesignInPreview(9)">
                    <canvas id="design-canvas-9" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 9: Future Skycar</div>
                </div>
                <div class="panel design-preview-card" id="design-card-10" onclick="selectHelicopterDesignInPreview(10)">
                    <canvas id="design-canvas-10" width="150" height="100" style="background:#080c1a; border-radius:8px; border:1px solid rgba(255,255,255,0.05);"></canvas>
                    <div style="margin-top:8px; font-weight:600; font-size:13px; color:#fff;">Design 10: Phoenix Firebird</div>
                </div>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" class="btn-primary" onclick="closeViewHelicoptersModal()" style="background:var(--text-muted); width:auto; padding:8px 24px;">Cancel</button>
                <button type="button" class="btn-primary" onclick="submitSelectedHelicopterDesign()" style="background:linear-gradient(135deg, #ffbe1a, #f06424); color:#000; font-weight:700; width:auto; padding:8px 24px;">Select & Save Design</button>
            </div>
        </div>
    </div>

    <!-- Toast notification -->
    <div class="admin-toast" id="admin-toast">
        <i class="fas fa-circle-check" id="toast-icon"></i>
        <span id="toast-msg">Done!</span>
    </div>

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let allUsers = [];

        // --- LIVE GAME MONITOR SYSTEM ---
        let liveMonitorInterval = null;

        function startLiveMonitor() {
            if (liveMonitorInterval) return;
            updateLiveMonitor();
            liveMonitorInterval = setInterval(updateLiveMonitor, 1000);
        }

        function stopLiveMonitor() {
            if (liveMonitorInterval) {
                clearInterval(liveMonitorInterval);
                liveMonitorInterval = null;
            }
        }

        function updateLiveMonitor() {
            fetch('/admin/game-status', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Update State Badge
                    const badge = document.getElementById('live-monitor-state-badge');
                    if (badge) {
                        badge.textContent = data.game_state;
                        badge.style.background = 'rgba(107, 114, 128, 0.2)';
                        badge.style.color = '#9ca3af';
                        
                        if (data.game_state === 'COUNTDOWN') {
                            badge.textContent = 'Countdown';
                            badge.style.background = 'rgba(234, 179, 8, 0.2)';
                            badge.style.color = '#facc15';
                        } else if (data.game_state === 'PLAYING') {
                            badge.textContent = 'In Flight';
                            badge.style.background = 'rgba(34, 197, 94, 0.2)';
                            badge.style.color = '#4ade80';
                        } else if (data.game_state === 'CRASHED') {
                            badge.textContent = 'Crashed';
                            badge.style.background = 'rgba(239, 68, 68, 0.2)';
                            badge.style.color = '#f87171';
                        }
                    }

                    // Update Round ID
                    const roundIdEl = document.getElementById('live-monitor-round-id');
                    if (roundIdEl) {
                        roundIdEl.textContent = data.current_round_id;
                    }

                    // Update Sequence Index
                    const seqIndexEl = document.getElementById('live-monitor-seq-index');
                    if (seqIndexEl) {
                        seqIndexEl.textContent = '#' + (data.sequence_index + 1);
                    }

                    // Update Multiplier
                    const multEl = document.getElementById('live-monitor-multiplier');
                    if (multEl) {
                        multEl.textContent = data.current_multiplier.toFixed(2) + 'x';
                        if (data.game_state === 'CRASHED') {
                            multEl.style.color = '#ef4444';
                        } else if (data.game_state === 'PLAYING') {
                            multEl.style.color = '#38ef7d';
                        } else {
                            multEl.style.color = '#9ca3af';
                        }
                    }

                    // Update Bets Count and Total Amount
                    const betsCountEl = document.getElementById('live-monitor-bets-count');
                    if (betsCountEl) {
                        betsCountEl.textContent = data.real_bets_count + ' player(s)';
                    }
                    const betsAmountEl = document.getElementById('live-monitor-bets-amount');
                    if (betsAmountEl) {
                        betsAmountEl.textContent = data.total_real_bets.toFixed(2) + ' BDT';
                    }
                }
            })
            .catch(err => console.error('[MONITOR] Sync failed:', err));
        }

        // Tab switcher
        function switchTab(tabId, btn) {
            document.querySelectorAll('.tab-pane').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.sidebar-nav-link').forEach(l => l.classList.remove('active'));
            document.getElementById('tab-' + tabId).classList.add('active');
            btn.classList.add('active');

            const titles = {
                overview: 'Overview <span>/ Admin Dashboard</span>',
                users:    'User Management <span>/ All Accounts</span>',
                withdrawals: 'Withdrawal Requests <span>/ Operational Requests</span>',
                deposits: 'Deposit Requests <span>/ Operational Requests</span>',
                game:     'Game Settings <span>/ Crash Point Sequence</span>',
                gateways: 'Payment Gateways <span>/ Gateway Configurations</span>',
                'withdraw-gateways': 'Withdrawal Payment Methods <span>/ Withdrawal Gateway Setup</span>',
                settings: 'Platform Settings <span>/ Configuration</span>',
                support: 'Support Live Chat <span>/ Customer Chats</span>',
            };
            document.getElementById('topbar-page-title').innerHTML = titles[tabId] || tabId;

            // Stop live monitor first (will be started if active)
            stopLiveMonitor();

            // Load users table when tab is opened
            if (tabId === 'users' && allUsers.length === 0) {
                loadUsers();
            }
            // Load support chats
            if (tabId === 'support') {
                loadSupportChats();
            }
            // Load withdrawals when withdrawals tab is opened
            if (tabId === 'withdrawals') {
                loadWithdrawals();
            }
            // Load deposits when deposits tab is opened
            if (tabId === 'deposits') {
                loadDeposits();
            }
            // Load crash points when game tab is opened
            if (tabId === 'game') {
                loadCrashPoints();
                startLiveMonitor();
            }
            // Load settings when settings tab is opened
            if (tabId === 'settings') {
                loadPlatformSettings();
            }
            // Load gateways when gateways tab is opened
            if (tabId === 'gateways') {
                loadPaymentGateways();
            }
            // Load withdraw gateways when withdraw-gateways tab is opened
            if (tabId === 'withdraw-gateways') {
                loadWithdrawPaymentGateways();
            }
        }


        // Load live stats
        function loadStats() {
            fetch('{{ route('admin.stats') }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('stat-total-users').textContent      = data.total_users;
                    document.getElementById('stat-total-balance').textContent    = parseInt(data.total_balance).toLocaleString();
                    document.getElementById('stat-new-today').textContent        = data.new_today;
                    document.getElementById('stat-countries').textContent        = data.active_countries;
                }
            })
            .catch(() => {});
        }

        // Load users list
        function loadUsers() {
            const tbody = document.getElementById('users-table-tbody');
            tbody.innerHTML = `<tr class="loading-row"><td colspan="9"><i class="fas fa-spinner fa-spin"></i> Loading users...</td></tr>`;

            fetch('{{ route('admin.users') }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    allUsers = data.users;
                    renderUsersTable(allUsers);
                }
            })
            .catch(() => {
                tbody.innerHTML = `<tr class="loading-row"><td colspan="9" style="color:var(--accent-red);">Failed to load users.</td></tr>`;
            });
        }

        // Load withdrawals list
        function loadWithdrawals() {
            const tbody = document.getElementById('withdrawals-table-tbody');
            if (!tbody) return;
            tbody.innerHTML = `<tr class="loading-row"><td colspan="10"><i class="fas fa-spinner fa-spin"></i> Loading withdrawals...</td></tr>`;

            fetch('{{ route('admin.withdrawals.index') }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    renderWithdrawalsTable(data.withdrawals);
                }
            })
            .catch(() => {
                tbody.innerHTML = `<tr class="loading-row"><td colspan="10" style="color:var(--accent-red);">Failed to load withdrawals.</td></tr>`;
            });
        }

        function renderWithdrawalsTable(withdrawals) {
            const tbody = document.getElementById('withdrawals-table-tbody');
            if (!tbody) return;
            if (withdrawals.length === 0) {
                tbody.innerHTML = `<tr><td colspan="10"><div class="empty-state"><i class="fas fa-money-bill-transfer"></i><p>No withdrawal requests found.</p></div></td></tr>`;
                return;
            }
            tbody.innerHTML = withdrawals.map(w => {
                let statusBadge = '';
                let actionsHtml = '—';

                if (w.status === 'Pending') {
                    statusBadge = `<span class="status-badge" style="background:rgba(255,190,26,0.1); border:1px solid rgba(255,190,26,0.2); color:var(--accent-gold);"><i class="fas fa-circle-notch fa-spin" style="font-size:6px;"></i> Pending</span>`;
                    actionsHtml = `
                        <div style="display:flex;gap:5px;">
                            <button class="action-btn edit" title="Approve Withdrawal" onclick="processWithdrawal(${w.id}, 'approve')" style="color:var(--accent-green); border-color:rgba(34,197,94,0.3); background:rgba(34,197,94,0.05); width:auto; padding: 4px 10px; font-weight: 600; font-size: 11px;">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button class="action-btn del" title="Reject Withdrawal" onclick="processWithdrawal(${w.id}, 'reject')" style="color:var(--accent-red); border-color:rgba(239,68,68,0.3); background:rgba(239,68,68,0.05); width:auto; padding: 4px 10px; font-weight: 600; font-size: 11px;">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </div>
                    `;
                } else if (w.status === 'Completed') {
                    statusBadge = `<span class="status-badge badge-active"><i class="fas fa-circle" style="font-size:6px;"></i> Approved</span>`;
                } else {
                    statusBadge = `<span class="status-badge" style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:var(--accent-red);"><i class="fas fa-circle" style="font-size:6px;"></i> Rejected</span>`;
                }

                return `
                    <tr id="withdraw-row-${w.id}">
                        <td><span style="color:var(--text-muted);font-family:'Roboto Mono',monospace;font-size:11px;">#${w.id}</span></td>
                        <td>
                            <strong style="color:var(--text-primary);">${escHtml(w.user_name)}</strong>
                            <div style="font-size:11px;color:var(--text-muted);">${escHtml(w.user_email)}</div>
                        </td>
                        <td><strong style="color:#fff;">${escHtml(w.gateway)}</strong></td>
                        <td><span style="font-family:'Roboto Mono',monospace; font-size:12px;">${escHtml(w.account_number)}</span></td>
                        <td><span class="balance-val">${parseFloat(w.amount).toFixed(2)}</span> <small style="color:var(--text-muted);">${w.user_currency}</small></td>
                        <td style="color:var(--accent-red); font-family:'Roboto Mono',monospace;">-${parseFloat(w.fee).toFixed(2)}</td>
                        <td><span style="font-family:'Roboto Mono',monospace; font-weight:700; color:var(--accent-teal);">${parseFloat(w.net_payable).toFixed(2)}</span> <small style="color:var(--text-muted);">${w.user_currency}</small></td>
                        <td style="color:var(--text-muted);font-size:12px;">${w.created_at}</td>
                        <td>${statusBadge}</td>
                        <td>${actionsHtml}</td>
                    </tr>
                `;
            }).join('');
        }

        function processWithdrawal(id, action) {
            const confirmed = confirm(`Are you sure you want to ${action} this withdrawal request?`);
            if (!confirmed) return;

            const row = document.getElementById(`withdraw-row-${id}`);
            const actionCell = row ? row.querySelector('td:last-child') : null;
            if (actionCell) {
                actionCell.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            }

            fetch(`/admin/withdrawals/${id}/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, false);
                    loadWithdrawals(); // Reload tab
                    loadStats(); // Update header stats
                } else {
                    showToast((data.errors || ['Error processing withdrawal.']).join(' '), true);
                    loadWithdrawals();
                }
            })
            .catch(() => {
                showToast('Connection error processing request.', true);
                loadWithdrawals();
            });
        }

        // Load deposits list
        function loadDeposits() {
            const tbody = document.getElementById('deposits-table-tbody');
            if (!tbody) return;
            tbody.innerHTML = `<tr class="loading-row"><td colspan="11"><i class="fas fa-spinner fa-spin"></i> Loading deposits...</td></tr>`;

            fetch('{{ route('admin.deposits.index') }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    renderDepositsTable(data.deposits);
                }
            })
            .catch(() => {
                tbody.innerHTML = `<tr class="loading-row"><td colspan="11" style="color:var(--accent-red);">Failed to load deposits.</td></tr>`;
            });
        }

        function renderDepositsTable(deposits) {
            const tbody = document.getElementById('deposits-table-tbody');
            if (!tbody) return;
            if (deposits.length === 0) {
                tbody.innerHTML = `<tr><td colspan="11"><div class="empty-state"><i class="fas fa-circle-down"></i><p>No deposit requests found.</p></div></td></tr>`;
                return;
            }
            tbody.innerHTML = deposits.map(d => {
                let statusBadge = '';
                let actionsHtml = '—';

                if (d.status === 'Pending') {
                    statusBadge = `<span class="status-badge" style="background:rgba(255,190,26,0.1); border:1px solid rgba(255,190,26,0.2); color:var(--accent-gold);"><i class="fas fa-circle-notch fa-spin" style="font-size:6px;"></i> Pending</span>`;
                    actionsHtml = `
                        <div style="display:flex;gap:5px;">
                            <button class="action-btn edit" title="Approve Deposit" onclick="processDeposit(${d.id}, 'approve')" style="color:var(--accent-green); border-color:rgba(34,197,94,0.3); background:rgba(34,197,94,0.05); width:auto; padding: 4px 10px; font-weight: 600; font-size: 11px;">
                                <i class="fas fa-check"></i> Approve
                            </button>
                            <button class="action-btn del" title="Reject Deposit" onclick="openDepositRejectionModal(${d.id})" style="color:var(--accent-red); border-color:rgba(239,68,68,0.3); background:rgba(239,68,68,0.05); width:auto; padding: 4px 10px; font-weight: 600; font-size: 11px;">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </div>
                    `;
                } else if (d.status === 'Completed') {
                    statusBadge = `<span class="status-badge badge-active"><i class="fas fa-circle" style="font-size:6px;"></i> Approved</span>`;
                } else {
                    statusBadge = `<span class="status-badge" style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2); color:var(--accent-red);"><i class="fas fa-circle" style="font-size:6px;"></i> Rejected</span>`;
                }

                let screenshotHtml = '—';
                if (d.screenshot) {
                    screenshotHtml = `<a href="${d.screenshot}" target="_blank" class="action-btn edit" style="width:auto; padding: 4px 8px; font-size: 11px; display:inline-flex; align-items:center; gap:4px; text-decoration:none;"><i class="fas fa-image"></i> View Screenshot</a>`;
                }

                return `
                    <tr id="deposit-row-${d.id}">
                        <td><span style="color:var(--text-muted);font-family:'Roboto Mono',monospace;font-size:11px;">#${d.id}</span></td>
                        <td>
                            <strong style="color:var(--text-primary);">${escHtml(d.user_name)}</strong>
                            <div style="font-size:11px;color:var(--text-muted);">${escHtml(d.user_email)}</div>
                        </td>
                        <td><strong style="color:#fff;">${escHtml(d.gateway)}</strong></td>
                        <td><span style="font-family:'Roboto Mono',monospace; font-size:12px;">${escHtml(d.sender_number)}</span></td>
                        <td><span style="font-family:'Roboto Mono',monospace; font-size:12px;">${escHtml(d.transaction_id)}</span></td>
                        <td><span class="balance-val" style="color:var(--accent-green);font-weight:700;">+${parseFloat(d.amount).toFixed(2)}</span> <small style="color:var(--text-muted);">${d.user_currency}</small></td>
                        <td>${screenshotHtml}</td>
                        <td><span style="font-size:12px;color:var(--text-secondary);">${escHtml(d.rejection_reason || '—')}</span></td>
                        <td style="color:var(--text-muted);font-size:12px;">${d.created_at}</td>
                        <td>${statusBadge}</td>
                        <td>${actionsHtml}</td>
                    </tr>
                `;
            }).join('');
        }

        function processDeposit(id, action) {
            const confirmed = confirm(`Are you sure you want to approve this deposit request?`);
            if (!confirmed) return;

            const row = document.getElementById(`deposit-row-${id}`);
            const actionCell = row ? row.querySelector('td:last-child') : null;
            if (actionCell) {
                actionCell.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            }

            fetch(`/admin/deposits/${id}/process`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ action: 'approve' })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, false);
                    loadDeposits(); // Reload tab
                    loadStats(); // Update header stats
                } else {
                    showToast((data.errors || ['Error processing deposit.']).join(' '), true);
                    loadDeposits();
                }
            })
            .catch(() => {
                showToast('Connection error processing request.', true);
                loadDeposits();
            });
        }

        function submitDepositRejection() {
            const id = document.getElementById('reject-deposit-id').value;
            const reason = document.getElementById('reject-deposit-reason').value;
            const btn = document.getElementById('btn-reject-deposit-submit');

            if (!reason) {
                alert('Please enter a rejection reason.');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rejecting...';

            fetch(`/admin/deposits/${id}/process`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ action: 'reject', rejection_reason: reason })
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-circle-check"></i> Submit Rejection';
                if (data.success) {
                    closeDepositRejectionModal();
                    showToast(data.message, false);
                    loadDeposits();
                    loadStats();
                } else {
                    showToast((data.errors || ['Error rejecting deposit.']).join(' '), true);
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-circle-check"></i> Submit Rejection';
                showToast('Connection error rejecting request.', true);
            });
        }

        function openDepositRejectionModal(id) {
            document.getElementById('reject-deposit-id').value = id;
            document.getElementById('reject-deposit-reason').value = '';
            document.getElementById('deposit-rejection-modal').classList.add('open');
        }
        function closeDepositRejectionModal() {
            document.getElementById('deposit-rejection-modal').classList.remove('open');
        }

        function renderUsersTable(users) {
            const tbody = document.getElementById('users-table-tbody');
            if (users.length === 0) {
                tbody.innerHTML = `<tr><td colspan="9"><div class="empty-state"><i class="fas fa-users-slash"></i><p>No users found.</p></div></td></tr>`;
                return;
            }
            tbody.innerHTML = users.map(u => `
                <tr id="user-row-${u.id}" class="${u.is_blocked ? 'user-row-blocked' : ''}">
                    <td><span style="color:var(--text-muted);font-family:'Roboto Mono',monospace;font-size:11px;">#${50000 + u.id}</span></td>
                    <td><strong style="color:var(--text-primary);">${escHtml(u.name)}</strong></td>
                    <td>
                        <div style="font-size:12.5px;">${escHtml(u.email)}</div>
                        <div style="font-size:11px;color:var(--text-muted);">${u.mobile || '—'}</div>
                    </td>
                    <td>${u.country || '—'}</td>
                    <td><span class="currency-pill">${u.currency}</span></td>
                    <td><span class="balance-val" id="bal-${u.id}">${parseFloat(u.balance).toLocaleString('en-US', {minimumFractionDigits: 2})}</span></td>
                    <td>
                        <span id="status-${u.id}" class="user-status-badge ${u.is_blocked ? 'blocked' : 'active'}">
                            <i class="fas ${u.is_blocked ? 'fa-ban' : 'fa-circle-check'}"></i>
                            ${u.is_blocked ? 'Blocked' : 'Active'}
                        </span>
                    </td>
                    <td style="color:var(--text-muted);font-size:12px;">${formatDate(u.created_at)}</td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <button class="action-btn edit" title="Edit Balance" onclick="openBalanceModal(${u.id}, '${escHtml(u.name)}', ${u.balance})">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button id="block-btn-${u.id}" class="action-btn ${u.is_blocked ? 'unblock' : 'block-user'}" title="${u.is_blocked ? 'Unblock User' : 'Block User'}" onclick="toggleBlockUser(${u.id})">
                                <i class="fas ${u.is_blocked ? 'fa-lock-open' : 'fa-ban'}"></i>
                            </button>
                            <button class="action-btn del" title="Delete User" onclick="deleteUser(${u.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Filter users by search
        function filterUsers() {
            const q = document.getElementById('user-search-input').value.toLowerCase();
            const filtered = allUsers.filter(u =>
                u.name.toLowerCase().includes(q) ||
                u.email.toLowerCase().includes(q) ||
                (u.mobile && u.mobile.includes(q))
            );
            renderUsersTable(filtered);
        }

        // Edit balance modal
        function openBalanceModal(id, name, balance) {
            document.getElementById('edit-user-id').value = id;
            document.getElementById('edit-user-name').value = name;
            document.getElementById('edit-user-balance').value = parseFloat(balance).toFixed(2);
            document.getElementById('edit-balance-modal').classList.add('open');
        }
        function closeBalanceModal() {
            document.getElementById('edit-balance-modal').classList.remove('open');
        }

        function saveUserBalance() {
            const id      = document.getElementById('edit-user-id').value;
            const balance = document.getElementById('edit-user-balance').value;
            const btn     = document.getElementById('btn-save-balance');

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            fetch(`/admin/users/${id}/balance`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ balance })
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
                if (data.success) {
                    closeBalanceModal();
                    showToast(data.message, false);
                    // Update in-memory data
                    const u = allUsers.find(u => u.id == id);
                    if (u) u.balance = parseFloat(balance);
                    const balEl = document.getElementById(`bal-${id}`);
                    if (balEl) balEl.textContent = parseFloat(balance).toLocaleString('en-US', { minimumFractionDigits: 2 });
                } else {
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
                showToast('Connection error.', true);
            });
        }

        // Toggle block / unblock user
        function toggleBlockUser(id) {
            const u = allUsers.find(u => u.id == id);
            if (!u) return;
            const action = u.is_blocked ? 'unblock' : 'block';
            if (!confirm(`Are you sure you want to ${action} this user (${u.name})?`)) return;

            const btn = document.getElementById(`block-btn-${id}`);
            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>'; }

            fetch(`/admin/users/${id}/toggle-block`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    u.is_blocked = data.is_blocked;
                    // Update status badge
                    const badge = document.getElementById(`status-${id}`);
                    if (badge) {
                        badge.className = `user-status-badge ${data.is_blocked ? 'blocked' : 'active'}`;
                        badge.innerHTML = `<i class="fas ${data.is_blocked ? 'fa-ban' : 'fa-circle-check'}"></i> ${data.is_blocked ? 'Blocked' : 'Active'}`;
                    }
                    // Update block button
                    if (btn) {
                        btn.disabled = false;
                        btn.className = `action-btn ${data.is_blocked ? 'unblock' : 'block-user'}`;
                        btn.title = data.is_blocked ? 'Unblock User' : 'Block User';
                        btn.innerHTML = `<i class="fas ${data.is_blocked ? 'fa-lock-open' : 'fa-ban'}"></i>`;
                    }
                    // Update row style
                    const row = document.getElementById(`user-row-${id}`);
                    if (row) { row.className = data.is_blocked ? 'user-row-blocked' : ''; }
                    showToast(data.message, false);
                } else {
                    if (btn) { btn.disabled = false; btn.innerHTML = `<i class="fas ${u.is_blocked ? 'fa-lock-open' : 'fa-ban'}"></i>`; }
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => {
                if (btn) { btn.disabled = false; btn.innerHTML = `<i class="fas ${u.is_blocked ? 'fa-lock-open' : 'fa-ban'}"></i>`; }
                showToast('Connection error.', true);
            });
        }

        // Delete user
        function deleteUser(id) {
            if (!confirm('Are you sure you want to permanently delete this user account? This action cannot be undone.')) return;

            fetch(`/admin/users/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    allUsers = allUsers.filter(u => u.id !== id);
                    const row = document.getElementById(`user-row-${id}`);
                    if (row) row.remove();
                    showToast(data.message, false);
                    loadStats();
                } else {
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => showToast('Connection error.', true));
        }

        // Toast notification
        function showToast(msg, isError = false) {
            const toast = document.getElementById('admin-toast');
            const icon  = document.getElementById('toast-icon');
            document.getElementById('toast-msg').textContent = msg;
            toast.className = 'admin-toast' + (isError ? ' error' : '');
            icon.className = isError ? 'fas fa-circle-exclamation' : 'fas fa-circle-check';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3500);
        }

        // Utility: escape html
        function escHtml(str) {
            return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }

        // Utility: format date
        function formatDate(dateStr) {
            const d = new Date(dateStr);
            const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
        }

        // ==================== CRASH POINTS ====================
        let allCrashPoints = [];

        function loadCrashPoints() {
            const tbody = document.getElementById('crash-points-tbody');
            if (!tbody) return;
            tbody.innerHTML = `<tr class="loading-row"><td colspan="4"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>`;

            fetch('{{ route('admin.crash-points.index') }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    allCrashPoints = data.points;
                    renderCrashPointsTable();
                }
            })
            .catch(() => {
                tbody.innerHTML = `<tr class="loading-row"><td colspan="4" style="color:var(--accent-red);">Failed to load.</td></tr>`;
            });
        }

        function renderCrashPointsTable() {
            const tbody = document.getElementById('crash-points-tbody');
            if (!tbody) return;
            if (allCrashPoints.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4"><div class="empty-state"><i class="fas fa-list-ol"></i><p>No crash points added yet. Click "Add New Point" to start.</p></div></td></tr>`;
                return;
            }
            tbody.innerHTML = allCrashPoints.map((cp, idx) => `
                <tr id="cp-row-${cp.id}">
                    <td style="color:var(--text-muted);font-family:'Roboto Mono',monospace;font-size:11px;">${idx + 1}</td>
                    <td>
                        <span style="font-family:'Roboto Mono',monospace;font-size:16px;font-weight:700;color:${parseFloat(cp.point) >= 2 ? 'var(--accent-gold)' : parseFloat(cp.point) >= 10 ? 'var(--accent-green)' : 'var(--text-primary)'}">${parseFloat(cp.point).toFixed(2)}x</span>
                    </td>
                    <td>
                        <span class="status-badge ${cp.status === 'active' ? 'badge-active' : ''}" style="${cp.status !== 'active' ? 'background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:var(--accent-red);' : ''}">
                            <i class="fas fa-circle" style="font-size:6px;"></i>
                            ${cp.status === 'active' ? 'Active' : 'Inactive'}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;">
                            <button class="action-btn edit" title="Edit" onclick="openEditPointModal(${cp.id}, ${cp.point}, '${cp.status}')">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="action-btn del" title="Delete" onclick="deleteCrashPoint(${cp.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function openAddPointModal() {
            document.getElementById('cp-editing-id').value = '';
            document.getElementById('cp-modal-title').innerHTML = '<i class="fas fa-plus-circle"></i> Add New Crash Point';
            document.getElementById('cp-point-input').value = '';
            document.getElementById('cp-status-input').value = 'active';
            document.getElementById('crash-point-modal').classList.add('open');
        }

        function openEditPointModal(id, point, status) {
            document.getElementById('cp-editing-id').value = id;
            document.getElementById('cp-modal-title').innerHTML = '<i class="fas fa-pen"></i> Edit Crash Point';
            document.getElementById('cp-point-input').value = parseFloat(point).toFixed(2);
            document.getElementById('cp-status-input').value = status;
            document.getElementById('crash-point-modal').classList.add('open');
        }

        function closeCrashModal() {
            document.getElementById('crash-point-modal').classList.remove('open');
        }

        function saveCrashPoint() {
            const id     = document.getElementById('cp-editing-id').value;
            const point  = document.getElementById('cp-point-input').value;
            const status = document.getElementById('cp-status-input').value;
            const btn    = document.getElementById('btn-save-crash-point');

            if (!point || isNaN(parseFloat(point)) || parseFloat(point) < 1) {
                showToast('Please enter a valid crash point (minimum 1.00)', true);
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            const isEdit = !!id;
            const url    = isEdit ? `/admin/crash-points/${id}` : `{{ route('admin.crash-points.create') }}`;
            const method = isEdit ? 'PUT' : 'POST';

            fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
                body: JSON.stringify({ point, status })
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Crash Point';
                if (data.success) {
                    closeCrashModal();
                    showToast(data.message);
                    loadCrashPoints();
                } else {
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Crash Point';
                showToast('Connection error.', true);
            });
        }

        function deleteCrashPoint(id) {
            if (!confirm('Delete this crash point from the sequence?')) return;
            fetch(`/admin/crash-points/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message);
                    loadCrashPoints();
                } else {
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => showToast('Connection error.', true));
        }

        // Close crash modal on backdrop click
        document.getElementById('crash-point-modal').addEventListener('click', function(e) {
            if (e.target === this) closeCrashModal();
        });

        // Close balance modal on backdrop click
        document.getElementById('edit-balance-modal').addEventListener('click', function(e) {
            if (e.target === this) closeBalanceModal();
        });

        // Close deposit rejection modal on backdrop click
        document.getElementById('deposit-rejection-modal').addEventListener('click', function(e) {
            if (e.target === this) closeDepositRejectionModal();
        });

        // ==============================================
        // SETTINGS & PAYMENT GATEWAY HANDLERS          
        // ==============================================
        let allGateways = [];

        function loadPlatformSettings() {
            fetch('{{ route('admin.settings.get') }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('setting-ref-l1').value = data.settings.referral_commission_l1;
                    document.getElementById('setting-ref-l1-status').value = data.settings.referral_commission_l1_status || 'active';
                    document.getElementById('setting-ref-l2').value = data.settings.referral_commission_l2;
                    document.getElementById('setting-ref-l2-status').value = data.settings.referral_commission_l2_status || 'active';
                    document.getElementById('setting-ref-l3').value = data.settings.referral_commission_l3;
                    document.getElementById('setting-ref-l3-status').value = data.settings.referral_commission_l3_status || 'active';
                    document.getElementById('setting-withdraw-fee').value = data.settings.withdraw_commission;
                    document.getElementById('setting-withdraw-fee-status').value = data.settings.withdraw_commission_status || 'active';
                    document.getElementById('setting-helicopter-design').value = data.settings.active_helicopter_design || '1';
                    document.getElementById('setting-bg-music').value = data.settings.game_bg_music || '';
                    document.getElementById('setting-countdown-sound').value = data.settings.game_countdown_sound || '';
                    document.getElementById('setting-countdown-time').value = data.settings.game_countdown_time || '10';
                }
            })
            .catch(() => showToast('Failed to load platform settings.', true));
        }

        function savePlatformSettings(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-save-settings');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            const formData = new FormData();
            formData.append('referral_commission_l1', document.getElementById('setting-ref-l1').value);
            formData.append('referral_commission_l1_status', document.getElementById('setting-ref-l1-status').value);
            formData.append('referral_commission_l2', document.getElementById('setting-ref-l2').value);
            formData.append('referral_commission_l2_status', document.getElementById('setting-ref-l2-status').value);
            formData.append('referral_commission_l3', document.getElementById('setting-ref-l3').value);
            formData.append('referral_commission_l3_status', document.getElementById('setting-ref-l3-status').value);
            formData.append('withdraw_commission', document.getElementById('setting-withdraw-fee').value);
            formData.append('withdraw_commission_status', document.getElementById('setting-withdraw-fee-status').value);
            formData.append('active_helicopter_design', document.getElementById('setting-helicopter-design').value);
            formData.append('game_countdown_time', document.getElementById('setting-countdown-time').value);

            const bgMusicFile = document.getElementById('setting-bg-music-file').files[0];
            if (bgMusicFile) {
                formData.append('game_bg_music_file', bgMusicFile);
            }
            const countdownSoundFile = document.getElementById('setting-countdown-sound-file').files[0];
            if (countdownSoundFile) {
                formData.append('game_countdown_sound_file', countdownSoundFile);
            }

            fetch('{{ route('admin.settings.save') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Platform Configurations';
                if (data.success) {
                    showToast(data.message);
                    // Clear the file inputs
                    document.getElementById('setting-bg-music-file').value = '';
                    document.getElementById('setting-countdown-sound-file').value = '';
                    loadPlatformSettings();
                } else {
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Platform Configurations';
                showToast('Connection error.', true);
            });
        }

        function loadPaymentGateways() {
            const tbody = document.getElementById('gateways-table-tbody');
            tbody.innerHTML = `<tr class="loading-row"><td colspan="6"><i class="fas fa-spinner fa-spin"></i> Loading gateways...</td></tr>`;

            fetch('{{ route('admin.gateways.index') }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    allGateways = data.gateways;
                    renderGatewaysTable(allGateways);
                }
            })
            .catch(() => {
                tbody.innerHTML = `<tr class="loading-row"><td colspan="6" style="color:var(--accent-red);">Failed to load gateways.</td></tr>`;
            });
        }

        function renderGatewaysTable(gateways) {
            const tbody = document.getElementById('gateways-table-tbody');
            if (gateways.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><i class="fas fa-credit-card"></i><p>No gateways configured yet.</p></div></td></tr>`;
                return;
            }
            const depositGateways = gateways.filter(g => g.methods === 'deposit' || g.methods === 'both');
            if (depositGateways.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6"><div class="empty-state"><i class="fas fa-credit-card"></i><p>No deposit gateways configured yet.</p></div></td></tr>`;
                return;
            }
            tbody.innerHTML = depositGateways.map(g => {
                const logoHtml = g.logo ? `<img src="${g.logo}" style="height:32px; border-radius:4px; max-width:80px; object-fit:contain;">` : `<i class="fas fa-credit-card" style="font-size:24px; color:var(--text-muted);"></i>`;
                const typeClass = g.type === 'auto' ? 'badge-active' : 'badge-inactive';
                const statusClass = g.status === 'active' ? 'badge-active' : 'badge-inactive';
                const methodLabel = g.methods === 'both' ? 'Deposit + Withdraw' : (g.methods === 'deposit' ? 'Deposit Only' : 'Withdraw Only');
                
                const settingsJson = JSON.stringify(g.settings || []).replace(/"/g, '&quot;');
                const fieldsJson = JSON.stringify(g.deposit_fields || []).replace(/"/g, '&quot;');
                
                return `
                    <tr>
                        <td>${logoHtml}</td>
                        <td><strong style="color:var(--text-primary);">${escHtml(g.name)}</strong></td>
                        <td><span class="status-badge ${typeClass}">${g.type.toUpperCase()}</span></td>
                        <td><span style="font-size:12.5px; font-weight:600; color:var(--text-secondary);">${methodLabel}</span></td>
                        <td><span class="status-badge ${statusClass}">${g.status.toUpperCase()}</span></td>
                        <td>
                            <div style="display:flex;gap:5px;">
                                <button class="action-btn edit" title="Edit Gateway" onclick="openEditGatewayModal(${g.id}, '${escHtml(g.name)}', '${g.type}', '${g.methods}', '${g.status}', '${settingsJson}', '${fieldsJson}', '${g.logo || ''}')">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="action-btn del" title="Delete Gateway" onclick="deleteGateway(${g.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function loadWithdrawPaymentGateways() {
            const tbody = document.getElementById('withdraw-gateways-table-tbody');
            if (!tbody) return;
            tbody.innerHTML = `<tr class="loading-row"><td colspan="5"><i class="fas fa-spinner fa-spin"></i> Loading withdrawal methods...</td></tr>`;

            fetch('{{ route('admin.gateways.index') }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    allGateways = data.gateways;
                    renderWithdrawGatewaysTable(allGateways);
                }
            })
            .catch(() => {
                tbody.innerHTML = `<tr class="loading-row"><td colspan="5" style="color:var(--accent-red);">Failed to load withdrawal methods.</td></tr>`;
            });
        }

        function renderWithdrawGatewaysTable(gateways) {
            const tbody = document.getElementById('withdraw-gateways-table-tbody');
            if (!tbody) return;
            const withdrawGateways = gateways.filter(g => g.methods === 'withdraw' || g.methods === 'both');
            if (withdrawGateways.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><i class="fas fa-wallet"></i><p>No withdrawal methods configured yet. Click "Add Withdrawal Method" to start.</p></div></td></tr>`;
                return;
            }
            tbody.innerHTML = withdrawGateways.map(g => {
                const logoHtml = g.logo ? `<img src="${g.logo}" style="height:32px; border-radius:4px; max-width:80px; object-fit:contain;">` : `<i class="fas fa-wallet" style="font-size:24px; color:var(--text-muted);"></i>`;
                const statusClass = g.status === 'active' ? 'badge-active' : 'badge-inactive';
                
                let adminNumber = 'N/A';
                if (g.settings) {
                    const settingsObj = typeof g.settings === 'string' ? JSON.parse(g.settings) : g.settings;
                    const walletSetting = settingsObj.find(s => s.key === 'wallet_number' || s.key === 'receiver_number');
                    if (walletSetting) adminNumber = walletSetting.value;
                }
                
                return `
                    <tr>
                        <td>${logoHtml}</td>
                        <td><strong style="color:var(--text-primary);">${escHtml(g.name)}</strong></td>
                        <td><span style="font-family:'Roboto Mono',monospace; font-size:12.5px; font-weight:600; color:var(--accent-gold);">${escHtml(adminNumber)}</span></td>
                        <td><span class="status-badge ${statusClass}">${g.status.toUpperCase()}</span></td>
                        <td>
                            <div style="display:flex;gap:5px;">
                                <button class="action-btn edit" title="Edit Method" onclick="openEditWithdrawMethodModal(${g.id}, '${escHtml(g.name)}', '${g.status}', '${escHtml(adminNumber)}', '${g.logo || ''}')">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="action-btn del" title="Delete Method" onclick="deleteWithdrawGateway(${g.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function openAddWithdrawGatewayModal() {
            document.getElementById('withdraw-method-form').reset();
            document.getElementById('wm-editing-id').value = '';
            document.getElementById('wm-modal-title').innerHTML = '<i class="fas fa-plus-circle" style="color:var(--accent-teal);"></i> Add Withdrawal Method';
            document.getElementById('wm-logo-preview-wrap').style.display = 'none';
            document.getElementById('wm-logo-preview').src = '';
            document.getElementById('withdraw-method-modal').style.display = 'flex';
        }

        function openEditWithdrawMethodModal(id, name, status, number, logoUrl) {
            document.getElementById('wm-editing-id').value = id;
            document.getElementById('wm-name-input').value = name;
            document.getElementById('wm-status-input').value = status;
            document.getElementById('wm-number-input').value = number;
            document.getElementById('wm-logo-input').value = '';
            
            if (logoUrl) {
                document.getElementById('wm-logo-preview').src = logoUrl;
                document.getElementById('wm-logo-preview-wrap').style.display = 'block';
            } else {
                document.getElementById('wm-logo-preview-wrap').style.display = 'none';
            }

            document.getElementById('wm-modal-title').innerHTML = '<i class="fas fa-pen-to-square" style="color:var(--accent-teal);"></i> Edit Withdrawal Method';
            document.getElementById('withdraw-method-modal').style.display = 'flex';
        }

        function closeWithdrawMethodModal() {
            document.getElementById('withdraw-method-modal').style.display = 'none';
        }

        function saveWithdrawMethod(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-save-withdraw-method');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Method...';

            const id = document.getElementById('wm-editing-id').value;
            const name = document.getElementById('wm-name-input').value;
            const number = document.getElementById('wm-number-input').value;
            const status = document.getElementById('wm-status-input').value;
            
            const settings = [{ key: 'wallet_number', label: 'Admin Number/Address', value: number }];
            
            const formData = new FormData();
            if (id) formData.append('id', id);
            formData.append('name', name);
            formData.append('type', 'manual');
            formData.append('methods', 'withdraw');
            formData.append('status', status);
            formData.append('settings', JSON.stringify(settings));
            formData.append('deposit_fields', JSON.stringify([]));

            const logoFile = document.getElementById('wm-logo-input').files[0];
            if (logoFile) {
                formData.append('logo', logoFile);
            }

            fetch('{{ route('admin.gateways.save') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Withdrawal Method';
                if (data.success) {
                    closeWithdrawMethodModal();
                    showToast(data.message);
                    loadPaymentGateways();
                    loadWithdrawPaymentGateways();
                    loadStats();
                } else {
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Withdrawal Method';
                showToast('Connection error.', true);
            });
        }

        function deleteWithdrawGateway(id) {
            if (!confirm('Are you sure you want to permanently delete this withdrawal method? This cannot be undone.')) return;
            fetch(`/admin/gateways/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message);
                    loadPaymentGateways();
                    loadWithdrawPaymentGateways();
                } else {
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => showToast('Connection error.', true));
        }

        // Close withdraw method modal on backdrop click
        document.getElementById('withdraw-method-modal').addEventListener('click', function(e) {
            if (e.target === this) closeWithdrawMethodModal();
        });

        function toggleGatewayTypeFields() {
            const type = document.getElementById('gw-type-input').value;
            const fieldsPanel = document.getElementById('gw-deposit-fields-panel');
            if (type === 'auto') {
                // Keep dynamic fields open or toggle as desired
            }
        }

        function openAddGatewayModal() {
            document.getElementById('payment-gateway-form').reset();
            document.getElementById('gw-editing-id').value = '';
            document.getElementById('gw-modal-title').innerHTML = '<i class="fas fa-plus-circle" style="color:var(--accent-purple);"></i> Add Payment Gateway';
            
            document.getElementById('gw-logo-preview-wrap').style.display = 'none';
            document.getElementById('gw-logo-preview').src = '';
            
            document.getElementById('gateway-settings-rows').innerHTML = '';
            document.getElementById('gateway-form-rows').innerHTML = '';
            
            addGatewaySettingRow('receiver_number', 'Receiver Number', '');
            addGatewaySettingRow('account_name', 'Account Name', '');
            addGatewaySettingRow('instructions', 'Instructions', '');
            addGatewayFormRow(1, 'transaction_id', 'Transaction ID', 'text', 'Yes', 'Enter transaction ID');
            
            document.getElementById('payment-gateway-modal').style.display = 'flex';
        }

        function openEditGatewayModal(id, name, type, methods, status, settingsStr, fieldsStr, logoUrl) {
            document.getElementById('gw-editing-id').value = id;
            document.getElementById('gw-name-input').value = name;
            document.getElementById('gw-type-input').value = type;
            document.getElementById('gw-methods-input').value = methods;
            document.getElementById('gw-status-input').value = status;
            document.getElementById('gw-logo-input').value = ''; 
            
            if (logoUrl) {
                document.getElementById('gw-logo-preview').src = logoUrl;
                document.getElementById('gw-logo-preview-wrap').style.display = 'block';
            } else {
                document.getElementById('gw-logo-preview-wrap').style.display = 'none';
            }

            document.getElementById('gw-modal-title').innerHTML = '<i class="fas fa-pen-to-square" style="color:var(--accent-purple);"></i> Edit Payment Gateway';
            
            const settingsRows = document.getElementById('gateway-settings-rows');
            settingsRows.innerHTML = '';
            const settings = typeof settingsStr === 'string' ? JSON.parse(settingsStr) : settingsStr;
            if (settings && settings.length > 0) {
                settings.forEach(s => addGatewaySettingRow(s.key, s.label, s.value));
            } else {
                addGatewaySettingRow('receiver_number', 'Receiver Number', '');
                addGatewaySettingRow('account_name', 'Account Name', '');
                addGatewaySettingRow('instructions', 'Instructions', '');
            }

            const formRows = document.getElementById('gateway-form-rows');
            formRows.innerHTML = '';
            const fields = typeof fieldsStr === 'string' ? JSON.parse(fieldsStr) : fieldsStr;
            if (fields && fields.length > 0) {
                fields.forEach(f => addGatewayFormRow(f.order, f.name, f.label, f.type, f.required, f.placeholder));
            } else {
                addGatewayFormRow(1, 'transaction_id', 'Transaction ID', 'text', 'Yes', 'Enter transaction ID');
            }

            document.getElementById('payment-gateway-modal').style.display = 'flex';
        }

        function closeGatewayModal() {
            document.getElementById('payment-gateway-modal').style.display = 'none';
        }

        function addGatewaySettingRow(key = '', label = '', value = '') {
            const wrap = document.getElementById('gateway-settings-rows');
            const row = document.createElement('div');
            row.className = 'gateway-setting-row';
            row.style.display = 'flex';
            row.style.gap = '10px';
            row.style.alignItems = 'center';
            
            row.innerHTML = `
                <input type="text" placeholder="Key" class="form-input setting-key" value="${key}" style="flex:1; margin-bottom: 0;" required>
                <input type="text" placeholder="Label" class="form-input setting-label" value="${label}" style="flex:1; margin-bottom: 0;" required>
                <input type="text" placeholder="Value" class="form-input setting-value" value="${value}" style="flex:1.5; margin-bottom: 0;">
                <button type="button" onclick="this.parentElement.remove()" style="background:var(--accent-red); color:#fff; border:none; padding:10px 14px; border-radius:9px; cursor:pointer;" title="Remove">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            wrap.appendChild(row);
        }

        function addGatewayFormRow(order = 1, name = '', label = '', type = 'text', required = 'Yes', placeholder = '') {
            const wrap = document.getElementById('gateway-form-rows');
            const row = document.createElement('div');
            row.className = 'gateway-form-row';
            row.style.display = 'flex';
            row.style.gap = '8px';
            row.style.alignItems = 'center';
            row.style.flexWrap = 'wrap';
            row.style.paddingBottom = '10px';
            row.style.borderBottom = '1px solid rgba(255,255,255,0.03)';
            
            row.innerHTML = `
                <input type="number" placeholder="Order" class="form-input field-order" value="${order}" style="width:70px; margin-bottom:0;" required>
                <input type="text" placeholder="Field Name" class="form-input field-name" value="${name}" style="flex:1; min-width:110px; margin-bottom:0;" required>
                <input type="text" placeholder="Field Label" class="form-input field-label" value="${label}" style="flex:1; min-width:110px; margin-bottom:0;" required>
                <select class="form-input field-type" style="width:100px; cursor:pointer; margin-bottom:0;">
                    <option value="text" ${type === 'text' ? 'selected' : ''}>Text</option>
                    <option value="number" ${type === 'number' ? 'selected' : ''}>Number</option>
                    <option value="file" ${type === 'file' ? 'selected' : ''}>Screenshot/File</option>
                </select>
                <select class="form-input field-required" style="width:90px; cursor:pointer; margin-bottom:0;">
                    <option value="Yes" ${required === 'Yes' ? 'selected' : ''}>Yes</option>
                    <option value="No" ${required === 'No' ? 'selected' : ''}>No</option>
                </select>
                <input type="text" placeholder="Placeholder Text" class="form-input field-placeholder" value="${placeholder}" style="flex:1.5; min-width:140px; margin-bottom:0;">
                <button type="button" onclick="this.parentElement.remove()" style="background:var(--accent-red); color:#fff; border:none; padding:10px 14px; border-radius:9px; cursor:pointer;" title="Remove">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            wrap.appendChild(row);
        }

        function savePaymentGateway(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-save-gateway');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Gateway...';

            const settings = [];
            document.querySelectorAll('.gateway-setting-row').forEach(row => {
                const key = row.querySelector('.setting-key').value;
                const label = row.querySelector('.setting-label').value;
                const val = row.querySelector('.setting-value').value;
                if (key) {
                    settings.push({ key, label, value: val });
                }
            });

            const fields = [];
            document.querySelectorAll('.gateway-form-row').forEach(row => {
                const order = row.querySelector('.field-order').value;
                const name = row.querySelector('.field-name').value;
                const label = row.querySelector('.field-label').value;
                const type = row.querySelector('.field-type').value;
                const req = row.querySelector('.field-required').value;
                const placeholder = row.querySelector('.field-placeholder').value;
                if (name) {
                    fields.push({ order: parseInt(order) || 1, name, label, type, required: req, placeholder });
                }
            });

            const formData = new FormData();
            const id = document.getElementById('gw-editing-id').value;
            if (id) formData.append('id', id);
            formData.append('name', document.getElementById('gw-name-input').value);
            formData.append('type', document.getElementById('gw-type-input').value);
            formData.append('methods', document.getElementById('gw-methods-input').value);
            formData.append('status', document.getElementById('gw-status-input').value);
            formData.append('settings', JSON.stringify(settings));
            formData.append('deposit_fields', JSON.stringify(fields));

            const logoFile = document.getElementById('gw-logo-input').files[0];
            if (logoFile) {
                formData.append('logo', logoFile);
            }

            fetch('{{ route('admin.gateways.save') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Payment Gateway';
                if (data.success) {
                    closeGatewayModal();
                    showToast(data.message);
                    loadPaymentGateways();
                    loadWithdrawPaymentGateways();
                    loadStats();
                } else {
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Payment Gateway';
                showToast('Connection error.', true);
            });
        }

        function deleteGateway(id) {
            if (!confirm('Are you sure you want to permanently delete this payment gateway? This cannot be undone.')) return;
            fetch(`/admin/gateways/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message);
                    loadPaymentGateways();
                    loadWithdrawPaymentGateways();
                } else {
                    showToast((data.errors || ['Error']).join(' '), true);
                }
            })
            .catch(() => showToast('Connection error.', true));
        }

        // Close gateway modal on backdrop click
        document.getElementById('payment-gateway-modal').addEventListener('click', function(e) {
            if (e.target === this) closeGatewayModal();
        });

        // ==============================================
        // ADMIN THEMING SYSTEM
        // ==============================================
        function updateAdminThemeUI(theme) {
            const btnIcon = document.getElementById('admin-theme-icon');
            const btnText = document.getElementById('admin-theme-text');
            if (!btnIcon || !btnText) return;
            if (theme === 'light') {
                btnIcon.className = 'fas fa-moon';
                btnText.textContent = 'Dark Mode';
            } else {
                btnIcon.className = 'fas fa-sun';
                btnText.textContent = 'Light Mode';
            }
        }

        function toggleAdminTheme() {
            const isLight = document.documentElement.classList.contains('light-theme');
            if (isLight) {
                document.documentElement.classList.remove('light-theme');
                localStorage.setItem('admin_theme', 'dark');
                updateAdminThemeUI('dark');
            } else {
                document.documentElement.classList.add('light-theme');
                localStorage.setItem('admin_theme', 'light');
                updateAdminThemeUI('light');
            }
        }

        // ==============================================
        // HELICOPTER PREVIEW MODAL DRAWING LOOP
        // ==============================================
        let previewAnimFrame = null;
        
        function openViewHelicoptersModal() {
            const activeId = document.getElementById('setting-helicopter-design').value;
            highlightHelicopterDesignInPreview(activeId);
            document.getElementById('view-helicopters-modal').style.display = 'flex';
            startHelicopterPreviews();
        }

        function closeViewHelicoptersModal() {
            document.getElementById('view-helicopters-modal').style.display = 'none';
            if (previewAnimFrame) {
                cancelAnimationFrame(previewAnimFrame);
                previewAnimFrame = null;
            }
        }

        function highlightHelicopterDesignInPreview(id) {
            document.querySelectorAll('.design-preview-card').forEach(card => {
                card.classList.remove('selected-design');
            });
            const activeCard = document.getElementById(`design-card-${id}`);
            if (activeCard) {
                activeCard.classList.add('selected-design');
            }
        }

        function selectHelicopterDesignInPreview(id) {
            highlightHelicopterDesignInPreview(id);
            document.getElementById('setting-helicopter-design').value = id;
            // Highlight it first, wait 250ms, then save and close automatically
            setTimeout(() => {
                submitSelectedHelicopterDesign();
            }, 250);
        }

        function submitSelectedHelicopterDesign() {
            closeViewHelicoptersModal();
            // Automatically submit the settings form
            const btnSave = document.getElementById('btn-save-settings');
            if (btnSave) {
                btnSave.click();
            }
        }

        document.getElementById('view-helicopters-modal').addEventListener('click', function(e) {
            if (e.target === this) closeViewHelicoptersModal();
        });

        function startHelicopterPreviews() {
            if (previewAnimFrame) {
                cancelAnimationFrame(previewAnimFrame);
            }
            const canvases = [];
            for (let i = 1; i <= 10; i++) {
                const canvas = document.getElementById(`design-canvas-${i}`);
                if (canvas) {
                    canvases.push({
                        el: canvas,
                        ctx: canvas.getContext('2d'),
                        index: i
                    });
                }
            }

            function loop() {
                const time = Date.now();
                canvases.forEach(item => {
                    const ctx = item.ctx;
                    const w = item.el.width;
                    const h = item.el.height;
                    ctx.clearRect(0, 0, w, h);
                    drawFlightDesign(ctx, item.index, 75, 50, true, time);
                });
                previewAnimFrame = requestAnimationFrame(loop);
            }
            loop();
        }

        function drawFlightDesign(ctx, designIndex, x, y, isFlying, time = Date.now()) {
            ctx.save();
            ctx.translate(x, y);
            ctx.scale(1.1, 1.1);

            let targetTilt = -20 * Math.PI / 180;
            if (isFlying && designIndex !== 4 && designIndex !== 8) {
                const tiltOsc = Math.sin(time * 0.015) * 0.02;
                ctx.rotate(targetTilt + tiltOsc);
            } else if (designIndex !== 4 && designIndex !== 8) {
                ctx.rotate(targetTilt);
            }

            switch(parseInt(designIndex)) {
                case 1: // Gold Fighter Jet
                    if (isFlying) {
                        ctx.save();
                        ctx.shadowColor = '#f06424';
                        ctx.shadowBlur = 20;
                        const flameLength = 24 + Math.sin(time * 0.055) * 8;
                        const fireGrad = ctx.createLinearGradient(-25 - flameLength, 0, -25, 0);
                        fireGrad.addColorStop(0, 'rgba(235, 64, 52, 0)');
                        fireGrad.addColorStop(0.5, '#f06424');
                        fireGrad.addColorStop(1, '#ffbe1a');
                        ctx.fillStyle = fireGrad;
                        ctx.beginPath();
                        ctx.moveTo(-24, -4);
                        ctx.lineTo(-24 - flameLength, 0);
                        ctx.lineTo(-24, 4);
                        ctx.closePath();
                        ctx.fill();
                        ctx.restore();
                    }
                    ctx.fillStyle = '#b28005';
                    ctx.beginPath();
                    ctx.moveTo(-8, 3);
                    ctx.lineTo(-18, 18);
                    ctx.lineTo(-5, 18);
                    ctx.lineTo(8, 3);
                    ctx.closePath();
                    ctx.fill();
                    
                    const goldGrad = ctx.createLinearGradient(-25, 0, 25, 0);
                    goldGrad.addColorStop(0, '#e5a910');
                    goldGrad.addColorStop(0.5, '#ffd13b');
                    goldGrad.addColorStop(1, '#ffffff');
                    ctx.fillStyle = goldGrad;
                    ctx.beginPath();
                    ctx.moveTo(28, -1);
                    ctx.bezierCurveTo(20, -5, 0, -7, -20, -5);
                    ctx.lineTo(-24, -4);
                    ctx.lineTo(-24, 2);
                    ctx.lineTo(-20, 3);
                    ctx.bezierCurveTo(0, 5, 20, 3, 28, -1);
                    ctx.closePath();
                    ctx.fill();
                    
                    ctx.fillStyle = '#3c3c3c';
                    ctx.fillRect(-25, -4, 2, 6);
                    ctx.fillStyle = '#ef4444';
                    ctx.beginPath();
                    ctx.arc(10.5, -2.0, 3.2, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.fillStyle = 'rgba(168, 225, 255, 0.55)';
                    ctx.beginPath();
                    ctx.moveTo(6, -4);
                    ctx.quadraticCurveTo(15, -4, 18, -1);
                    ctx.quadraticCurveTo(10, 2, 4, 1);
                    ctx.closePath();
                    ctx.fill();
                    ctx.fillStyle = '#f06424';
                    ctx.beginPath();
                    ctx.moveTo(-8, -5);
                    ctx.lineTo(-21, -19);
                    ctx.lineTo(-26, -19);
                    ctx.closePath();
                    ctx.fill();
                    break;

                case 2: // Classic Chopper
                    ctx.fillStyle = '#1e3a8a';
                    ctx.beginPath();
                    ctx.ellipse(0, 0, 20, 14, 0, 0, Math.PI * 2);
                    ctx.fill();
                    
                    ctx.strokeStyle = '#1e3a8a';
                    ctx.lineWidth = 4;
                    ctx.beginPath();
                    ctx.moveTo(-15, 0);
                    ctx.lineTo(-35, -5);
                    ctx.stroke();

                    ctx.fillStyle = '#ef4444';
                    ctx.fillRect(-37, -12, 4, 10);
                    ctx.save();
                    ctx.translate(-35, -7);
                    ctx.rotate(time * 0.15);
                    ctx.strokeStyle = '#ffffff';
                    ctx.lineWidth = 1.5;
                    ctx.beginPath();
                    ctx.moveTo(-8, 0); ctx.lineTo(8, 0);
                    ctx.moveTo(0, -8); ctx.lineTo(0, 8);
                    ctx.stroke();
                    ctx.restore();

                    ctx.strokeStyle = '#64748b';
                    ctx.lineWidth = 2.5;
                    ctx.beginPath();
                    ctx.moveTo(-10, 14); ctx.lineTo(-10, 20);
                    ctx.moveTo(10, 14); ctx.lineTo(10, 20);
                    ctx.moveTo(-18, 20); ctx.lineTo(18, 20);
                    ctx.stroke();

                    ctx.fillStyle = 'rgba(147, 197, 253, 0.6)';
                    ctx.beginPath();
                    ctx.arc(8, -2, 8, -Math.PI/2, Math.PI/2);
                    ctx.fill();

                    ctx.strokeStyle = '#475569';
                    ctx.lineWidth = 3;
                    ctx.beginPath();
                    ctx.moveTo(0, -14); ctx.lineTo(0, -19);
                    ctx.stroke();

                    ctx.save();
                    ctx.translate(0, -19);
                    const bladeScale = Math.cos(time * 0.1);
                    ctx.strokeStyle = 'rgba(255,255,255,0.7)';
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    ctx.moveTo(-35 * bladeScale, 0);
                    ctx.lineTo(35 * bladeScale, 0);
                    ctx.stroke();
                    ctx.restore();
                    break;

                case 3: // Space Rocket
                    ctx.rotate(Math.PI / 4);
                    if (isFlying) {
                        ctx.save();
                        const plume = 15 + Math.sin(time * 0.08) * 6;
                        const fire = ctx.createLinearGradient(0, 15, 0, 15 + plume);
                        fire.addColorStop(0, '#ffbe1a');
                        fire.addColorStop(0.5, '#f06424');
                        fire.addColorStop(1, 'rgba(239, 68, 68, 0)');
                        ctx.fillStyle = fire;
                        ctx.beginPath();
                        ctx.moveTo(-8, 15);
                        ctx.lineTo(0, 15 + plume);
                        ctx.lineTo(8, 15);
                        ctx.closePath();
                        ctx.fill();
                        ctx.restore();
                    }
                    ctx.fillStyle = '#f8fafc';
                    ctx.beginPath();
                    ctx.moveTo(0, -25);
                    ctx.bezierCurveTo(10, -10, 10, 10, 8, 15);
                    ctx.lineTo(-8, 15);
                    ctx.bezierCurveTo(-10, 10, -10, -10, 0, -25);
                    ctx.fill();

                    ctx.fillStyle = '#ef4444';
                    ctx.beginPath();
                    ctx.moveTo(0, -25);
                    ctx.bezierCurveTo(7, -15, 7, -10, 7, -8);
                    ctx.lineTo(-7, -8);
                    ctx.bezierCurveTo(-7, -10, -7, -15, 0, -25);
                    ctx.fill();

                    ctx.beginPath();
                    ctx.moveTo(-8, 5); ctx.lineTo(-16, 17); ctx.lineTo(-8, 15); ctx.fill();
                    ctx.beginPath();
                    ctx.moveTo(8, 5); ctx.lineTo(16, 17); ctx.lineTo(8, 15); ctx.fill();

                    ctx.fillStyle = '#0f172a';
                    ctx.beginPath();
                    ctx.arc(0, -2, 5, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.fillStyle = '#93c5fd';
                    ctx.beginPath();
                    ctx.arc(0, -2, 3.8, 0, Math.PI * 2);
                    ctx.fill();
                    break;

                case 4: // Alien UFO
                    if (isFlying) {
                        ctx.save();
                        const beamGrad = ctx.createLinearGradient(0, 5, 0, 45);
                        beamGrad.addColorStop(0, 'rgba(34, 197, 94, 0.4)');
                        beamGrad.addColorStop(1, 'rgba(34, 197, 94, 0.0)');
                        ctx.fillStyle = beamGrad;
                        ctx.beginPath();
                        ctx.moveTo(-10, 5);
                        ctx.lineTo(-25, 45);
                        ctx.lineTo(25, 45);
                        ctx.lineTo(10, 5);
                        ctx.closePath();
                        ctx.fill();
                        ctx.restore();
                    }
                    ctx.fillStyle = '#64748b';
                    ctx.beginPath();
                    ctx.ellipse(0, 2, 28, 9, 0, 0, Math.PI * 2);
                    ctx.fill();

                    const lightColor = Math.floor(time / 200) % 2 === 0 ? '#ffbe1a' : '#22c55e';
                    ctx.fillStyle = lightColor;
                    for (let angle = -2.5; angle <= 2.5; angle += 0.8) {
                        ctx.beginPath();
                        ctx.arc(Math.sin(angle) * 23, 2 + Math.cos(angle)*1.2, 2, 0, Math.PI*2);
                        ctx.fill();
                    }

                    ctx.fillStyle = 'rgba(52, 211, 153, 0.7)';
                    ctx.beginPath();
                    ctx.arc(0, -2, 11, Math.PI, 0);
                    ctx.fill();

                    ctx.fillStyle = '#064e3b';
                    ctx.beginPath();
                    ctx.arc(0, -5, 3, 0, Math.PI*2);
                    ctx.fill();
                    ctx.fillRect(-1.5, -3, 3, 4);
                    break;

                case 5: // Stealth Bomber
                    if (isFlying) {
                        ctx.save();
                        ctx.strokeStyle = '#8b5cf6';
                        ctx.lineWidth = 3;
                        ctx.beginPath();
                        ctx.moveTo(-10, 7);
                        ctx.lineTo(-25, 7);
                        ctx.stroke();
                        ctx.restore();
                    }
                    ctx.fillStyle = '#1e293b';
                    ctx.beginPath();
                    ctx.moveTo(30, 0);
                    ctx.lineTo(-25, 20);
                    ctx.lineTo(-12, 0);
                    ctx.lineTo(-25, -20);
                    ctx.closePath();
                    ctx.fill();

                    ctx.strokeStyle = 'rgba(255,255,255,0.06)';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(30, 0);
                    ctx.lineTo(-12, 0);
                    ctx.stroke();

                    ctx.fillStyle = '#ef4444';
                    ctx.beginPath();
                    ctx.arc(-22, 18, 1.5, 0, Math.PI*2);
                    ctx.arc(-22, -18, 1.5, 0, Math.PI*2);
                    ctx.fill();
                    break;

                case 6: // Cyber Drone
                    ctx.fillStyle = '#0f172a';
                    ctx.strokeStyle = '#06b6d4';
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    ctx.arc(0, 0, 8, 0, Math.PI*2);
                    ctx.fill();
                    ctx.stroke();

                    ctx.strokeStyle = '#475569';
                    ctx.lineWidth = 3;
                    ctx.beginPath();
                    ctx.moveTo(-6, -6); ctx.lineTo(-18, -18);
                    ctx.moveTo(6, -6); ctx.lineTo(18, -18);
                    ctx.moveTo(-6, 6); ctx.lineTo(-18, 18);
                    ctx.moveTo(6, 6); ctx.lineTo(18, 18);
                    ctx.stroke();

                    const rotAngle = time * 0.1;
                    const arms = [
                        {x: -18, y: -18}, {x: 18, y: -18},
                        {x: -18, y: 18}, {x: 18, y: 18}
                    ];
                    arms.forEach(arm => {
                        ctx.fillStyle = '#0f172a';
                        ctx.beginPath();
                        ctx.arc(arm.x, arm.y, 4, 0, Math.PI*2);
                        ctx.fill();

                        ctx.save();
                        ctx.translate(arm.x, arm.y);
                        ctx.rotate(rotAngle);
                        ctx.strokeStyle = 'rgba(255, 255, 255, 0.6)';
                        ctx.lineWidth = 1.5;
                        ctx.beginPath();
                        ctx.moveTo(-12, 0); ctx.lineTo(12, 0);
                        ctx.stroke();
                        ctx.restore();
                    });

                    ctx.fillStyle = '#22d3ee';
                    ctx.beginPath();
                    ctx.arc(0, 0, 3, 0, Math.PI*2);
                    ctx.fill();
                    break;

                case 7: // Vintage Biplane
                    ctx.save();
                    ctx.translate(22, 0);
                    ctx.fillStyle = '#e2e8f0';
                    ctx.beginPath();
                    ctx.arc(0, 0, 3, 0, Math.PI*2);
                    ctx.fill();
                    
                    ctx.rotate(time * 0.12);
                    ctx.strokeStyle = 'rgba(255, 255, 255, 0.7)';
                    ctx.lineWidth = 1.5;
                    ctx.beginPath();
                    ctx.moveTo(0, -22); ctx.lineTo(0, 22);
                    ctx.stroke();
                    ctx.restore();

                    ctx.fillStyle = '#b91c1c';
                    ctx.beginPath();
                    ctx.moveTo(20, -4);
                    ctx.lineTo(-24, -2);
                    ctx.lineTo(-24, 2);
                    ctx.lineTo(20, 4);
                    ctx.closePath();
                    ctx.fill();

                    ctx.fillStyle = '#facc15';
                    ctx.fillRect(-27, -8, 4, 16);
                    ctx.fillRect(-27, -10, 6, 4);

                    ctx.fillStyle = '#1e293b';
                    ctx.beginPath();
                    ctx.arc(8, 10, 4, 0, Math.PI*2);
                    ctx.fill();
                    ctx.strokeStyle = '#94a3b8';
                    ctx.beginPath();
                    ctx.moveTo(8, 2); ctx.lineTo(8, 8);
                    ctx.stroke();

                    ctx.fillStyle = '#facc15';
                    ctx.fillRect(-5, -16, 12, 4);
                    ctx.fillRect(-5, 12, 12, 4);
                    
                    ctx.strokeStyle = '#475569';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(1, -12); ctx.lineTo(1, 12);
                    ctx.moveTo(5, -12); ctx.lineTo(5, 12);
                    ctx.stroke();
                    break;

                case 8: // Hot Air Balloon
                    if (isFlying) {
                        ctx.fillStyle = '#f97316';
                        ctx.beginPath();
                        ctx.moveTo(-3, 10);
                        ctx.lineTo(0, 10 - (8 + Math.sin(time*0.05)*3));
                        ctx.lineTo(3, 10);
                        ctx.closePath();
                        ctx.fill();
                    }
                    const stripeColors = ['#ef4444', '#3b82f6', '#f59e0b', '#10b981'];
                    ctx.save();
                    ctx.translate(0, -12);
                    ctx.beginPath();
                    ctx.arc(0, 0, 20, 0.15 * Math.PI, 0.85 * Math.PI, true);
                    ctx.lineTo(-7, 22);
                    ctx.lineTo(7, 22);
                    ctx.closePath();
                    ctx.clip();

                    for (let i = -3; i <= 3; i++) {
                        ctx.fillStyle = stripeColors[Math.abs(i) % stripeColors.length];
                        ctx.fillRect(i * 7 - 3.5, -25, 7, 50);
                    }
                    ctx.restore();

                    ctx.strokeStyle = '#b45309';
                    ctx.lineWidth = 0.8;
                    ctx.beginPath();
                    ctx.moveTo(-6, 10); ctx.lineTo(-4, 18);
                    ctx.moveTo(6, 10); ctx.lineTo(4, 18);
                    ctx.stroke();

                    ctx.fillStyle = '#78350f';
                    ctx.fillRect(-5, 18, 10, 8);
                    break;

                case 9: // Future Skycar
                    if (isFlying) {
                        ctx.save();
                        ctx.shadowColor = '#06b6d4';
                        ctx.shadowBlur = 10;
                        ctx.fillStyle = 'rgba(6, 182, 212, 0.6)';
                        ctx.fillRect(-15, 6, 8, 4);
                        ctx.fillRect(7, 6, 8, 4);
                        ctx.restore();
                    }
                    ctx.fillStyle = '#6d28d9';
                    ctx.beginPath();
                    ctx.moveTo(24, 0);
                    ctx.bezierCurveTo(20, -8, -10, -9, -24, -4);
                    ctx.lineTo(-24, 4);
                    ctx.bezierCurveTo(-10, 9, 20, 8, 24, 0);
                    ctx.closePath();
                    ctx.fill();

                    ctx.strokeStyle = '#a78bfa';
                    ctx.lineWidth = 1.5;
                    ctx.beginPath();
                    ctx.moveTo(12, 2);
                    ctx.lineTo(-16, 2);
                    ctx.stroke();

                    ctx.fillStyle = 'rgba(34, 211, 238, 0.6)';
                    ctx.beginPath();
                    ctx.moveTo(4, -4);
                    ctx.quadraticCurveTo(15, -4, 17, 0);
                    ctx.quadraticCurveTo(10, 4, 3, 2);
                    ctx.closePath();
                    ctx.fill();
                    break;

                case 10: // Phoenix Firebird
                    const wingFlap = Math.sin(time * 0.02) * 0.4;
                    ctx.save();
                    const tailGrad = ctx.createLinearGradient(-12, 0, -32, 0);
                    tailGrad.addColorStop(0, '#f97316');
                    tailGrad.addColorStop(1, 'rgba(239, 68, 68, 0)');
                    ctx.fillStyle = tailGrad;
                    ctx.beginPath();
                    ctx.moveTo(-10, -3);
                    ctx.lineTo(-30, -10);
                    ctx.lineTo(-24, 0);
                    ctx.lineTo(-30, 10);
                    ctx.lineTo(-10, 3);
                    ctx.closePath();
                    ctx.fill();
                    ctx.restore();

                    ctx.fillStyle = '#ef4444';
                    ctx.beginPath();
                    ctx.moveTo(16, 0);
                    ctx.quadraticCurveTo(8, -6, -10, -3);
                    ctx.lineTo(-8, 3);
                    ctx.quadraticCurveTo(8, 6, 16, 0);
                    ctx.closePath();
                    ctx.fill();

                    ctx.fillStyle = '#facc15';
                    ctx.beginPath();
                    ctx.moveTo(16, -2);
                    ctx.lineTo(22, 0);
                    ctx.lineTo(16, 2);
                    ctx.closePath();
                    ctx.fill();

                    ctx.save();
                    ctx.translate(0, 0);
                    ctx.rotate(wingFlap);
                    const wingGrad = ctx.createLinearGradient(0, 0, 0, -25);
                    wingGrad.addColorStop(0, '#ef4444');
                    wingGrad.addColorStop(0.7, '#f97316');
                    wingGrad.addColorStop(1, '#facc15');
                    ctx.fillStyle = wingGrad;
                    ctx.beginPath();
                    ctx.moveTo(-4, 0);
                    ctx.quadraticCurveTo(-8, -15, 2, -26);
                    ctx.quadraticCurveTo(8, -12, 4, 0);
                    ctx.closePath();
                    ctx.fill();
                    ctx.restore();
                    break;
            }

            ctx.restore();
        }

        // ==============================================
        // Support Chat Logic (Admin Side)
        // ==============================================
        let activeChatUserId = null;
        let chatPollInterval = null;
        let generalChatListInterval = null;

        function loadSupportChats() {
            fetch('/admin/chats', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    renderChatsList(data.chats);
                    
                    // Update unread count in sidebar support badge
                    const totalUnread = data.chats.reduce((acc, c) => acc + parseInt(c.unread_count || 0), 0);
                    const badge = document.getElementById('admin-chat-unread-badge');
                    if (badge) {
                        if (totalUnread > 0) {
                            badge.textContent = totalUnread;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                }
            })
            .catch(err => console.error("Error loading support chats:", err));
        }

        function renderChatsList(chats) {
            const listContainer = document.getElementById('admin-chat-users-list');
            if (chats.length === 0) {
                listContainer.innerHTML = `
                    <div style="padding: 20px; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-comments" style="font-size: 24px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                        No active conversations
                    </div>
                `;
                return;
            }

            listContainer.innerHTML = chats.map(chat => {
                const isActive = activeChatUserId == chat.id ? 'background: rgba(79, 142, 247, 0.15); border-left: 3px solid var(--accent-blue);' : '';
                const unreadBadge = chat.unread_count > 0 ? `<span style="background: var(--accent-red); color:#fff; font-size:10px; font-weight:700; padding:2px 6px; border-radius:10px; margin-left: auto;">${chat.unread_count}</span>` : '';
                const truncatedMessage = chat.last_message ? (chat.last_message.length > 28 ? chat.last_message.substring(0, 25) + '...' : chat.last_message) : 'No messages';
                
                return `
                    <div class="chat-user-item" onclick="openSupportChat(${chat.id})" style="padding: 12px 16px; border-bottom: 1px solid var(--border-subtle); cursor: pointer; display: flex; align-items: center; gap: 10px; transition: background 0.2s; ${isActive}">
                        <div style="width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px; flex-shrink:0;">
                            ${chat.name.charAt(0).toUpperCase()}
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: baseline;">
                                <span style="font-weight: 700; font-size: 13px; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 140px;">${escHtml(chat.name)}</span>
                                <small style="font-size: 9px; color: var(--text-muted);">${new Date(chat.last_message_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</small>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 4px;">
                                <span style="font-size: 11.5px; color: var(--text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 170px;">${escHtml(truncatedMessage)}</span>
                                ${unreadBadge}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function openSupportChat(userId) {
            activeChatUserId = userId;
            document.getElementById('active-chat-user-id').value = userId;
            
            // Re-render chat list to highlight active item immediately
            loadSupportChats();

            fetch(`/admin/chats/${userId}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('admin-chat-window-empty').style.display = 'none';
                    document.getElementById('admin-chat-window-active').style.display = 'flex';
                    
                    document.getElementById('active-chat-user-name').textContent = data.user.name;
                    document.getElementById('active-chat-user-meta').textContent = `${data.user.email} / ${data.user.mobile || 'No Phone'}`;

                    renderChatMessages(data.messages);
                    
                    // Clear existing poll
                    if (chatPollInterval) clearInterval(chatPollInterval);
                    
                    // Poll specific chat messages every 3 seconds
                    chatPollInterval = setInterval(() => {
                        pollSupportChatMessages(userId);
                    }, 3000);
                }
            })
            .catch(err => console.error("Error opening support chat:", err));
        }

        function renderChatMessages(messages) {
            const box = document.getElementById('admin-chat-messages-box');
            
            if (messages.length === 0) {
                box.innerHTML = `<div style="text-align:center; padding: 20px; color: var(--text-muted); font-size:12px;">No messages in this chat.</div>`;
                return;
            }

            box.innerHTML = messages.map(msg => {
                const isAdmin = msg.sender === 'admin';
                const containerStyle = isAdmin ? 'align-self: flex-end; align-items: flex-end;' : 'align-self: flex-start; align-items: flex-start;';
                const bubbleStyle = isAdmin 
                    ? 'background: linear-gradient(135deg, #2563eb, #4f8ef7); color: #fff; border-radius: 14px 14px 2px 14px;' 
                    : 'background: var(--bg-card); color: var(--text-primary); border-radius: 14px 14px 14px 2px; border: 1px solid var(--border-subtle);';
                
                return `
                    <div style="display: flex; flex-direction: column; max-width: 70%; ${containerStyle}">
                        <div style="padding: 10px 14px; font-size: 13px; line-height: 1.4; box-shadow: 0 2px 6px rgba(0,0,0,0.05); ${bubbleStyle}">
                            ${escHtml(msg.message)}
                        </div>
                        <span style="font-size: 9.5px; color: var(--text-muted); margin-top: 4px; padding: 0 4px;">${msg.datetime}</span>
                    </div>
                `;
            }).join('');
            box.scrollTop = box.scrollHeight;
        }

        function pollSupportChatMessages(userId) {
            if (activeChatUserId != userId) return;

            fetch(`/admin/chats/${userId}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && activeChatUserId == userId) {
                    // Check if message count changed before re-rendering
                    const box = document.getElementById('admin-chat-messages-box');
                    const currentCount = box.children.length;
                    if (data.messages.length !== currentCount) {
                        renderChatMessages(data.messages);
                    }
                }
            })
            .catch(err => console.error("Error polling chat messages:", err));
        }

        function submitAdminChatMessage(e) {
            e.preventDefault();
            const input = document.getElementById('admin-chat-input');
            const message = input.value.trim();
            const userId = document.getElementById('active-chat-user-id').value;

            if (!message || !userId) return;

            input.value = '';

            fetch('/admin/chats/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ user_id: userId, message: message })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Instantly refresh this chat's messages
                    pollSupportChatMessages(userId);
                    // Also refresh the chat list on left
                    loadSupportChats();
                } else {
                    alert(data.errors ? data.errors.join('\n') : "Failed to send message.");
                }
            })
            .catch(err => {
                console.error("Error sending admin support message:", err);
                alert("Connection error sending reply.");
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            loadStats();
            
            // Check and update admin theme UI button state
            const currentTheme = localStorage.getItem('admin_theme') || 'dark';
            updateAdminThemeUI(currentTheme);

            // Poll for support chats list updates to display sidebar badge count
            loadSupportChats();
            generalChatListInterval = setInterval(loadSupportChats, 6000);
        });

        // ===================================================
        // FORCE CRASH — Admin instantly crashes the game round
        // ===================================================
        function adminForceCrash() {
            const btn = document.getElementById('sidebar-force-crash-btn');
            if (!btn) return;

            if (!confirm('⚡ Are you sure you want to FORCE CRASH the game right now?\n\nThis will immediately end the current round for all players!')) {
                return;
            }

            // Visual feedback
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Sending Signal...</span>';
            btn.style.opacity = '0.7';

            fetch('/admin/force-crash', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = '<i class="fas fa-check-circle"></i> <span>Crash Sent!</span>';
                    btn.style.background = 'linear-gradient(135deg, rgba(34,197,94,0.2), rgba(21,128,61,0.15))';
                    btn.style.borderColor = 'rgba(34,197,94,0.5)';
                    btn.style.color = '#4ade80';
                    showAdminToast('⚡ Force Crash signal sent! Game will crash instantly.', 'success');
                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-bolt"></i> <span>Force Crash Game</span>';
                        btn.style.background = 'linear-gradient(135deg, rgba(239,68,68,0.18), rgba(185,28,28,0.12))';
                        btn.style.borderColor = 'rgba(239,68,68,0.4)';
                        btn.style.color = '#f87171';
                        btn.style.opacity = '1';
                    }, 2500);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-bolt"></i> <span>Force Crash Game</span>';
                    btn.style.opacity = '1';
                    showAdminToast('Failed to send crash signal.', 'error');
                }
            })
            .catch(err => {
                console.error('Force crash error:', err);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-bolt"></i> <span>Force Crash Game</span>';
                btn.style.opacity = '1';
                showAdminToast('Connection error. Try again.', 'error');
            });
        }
    </script>
</body>
</html>
