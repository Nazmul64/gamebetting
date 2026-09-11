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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-deep:        #060813;
            --bg-sidebar:     #080d1e;
            --bg-sidebar-nav: rgba(14, 22, 45, 0.6);
            --bg-card:        #0d1428;
            --bg-card-hover:  #121c37;
            --bg-panel:       #0f172a;
            --bg-input:       rgba(255, 255, 255, 0.045);
            --bg-input-focus: rgba(255, 255, 255, 0.08);
            
            --accent-cyan:    #00f2fe;
            --accent-blue:    #3b82f6;
            --accent-indigo:  #6366f1;
            --accent-purple:  #8b5cf6;
            --accent-pink:    #ec4899;
            --accent-orange:  #f97316;
            --accent-gold:    #fbbf24;
            --accent-green:   #10b981;
            --accent-red:     #ef4444;
            --accent-teal:    #14b8a6;
            
            --text-primary:   #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted:     #64748b;
            --border-subtle:  rgba(255, 255, 255, 0.07);
            --border-hover:   rgba(255, 255, 255, 0.16);
            --border-glow:    rgba(99, 102, 241, 0.35);
            
            --sidebar-width:  270px;
            --topbar-height:  68px;
            --radius-sm:      8px;
            --radius-md:      12px;
            --radius-lg:      16px;
            --radius-xl:      22px;
            
            --card-shadow:    0 10px 30px -5px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.06);
            --glow-indigo:    0 0 25px rgba(99, 102, 241, 0.25);
            --glow-gold:      0 0 25px rgba(251, 191, 36, 0.25);
            --glow-green:     0 0 25px rgba(16, 185, 129, 0.25);
            --glow-red:       0 0 25px rgba(239, 68, 68, 0.25);
        }

        html, body {
            height: 100%;
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-deep);
            color: var(--text-primary);
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Subtle mesh glow background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: 
                radial-gradient(circle at 15% 15%, rgba(99, 102, 241, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(6, 182, 212, 0.06) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(139, 92, 246, 0.03) 0%, transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        /* ===================== LAYOUT ===================== */
        .admin-layout {
            display: flex;
            height: 100vh;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        /* Backdrop overlay for mobile sidebar */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(4, 7, 16, 0.75);
            backdrop-filter: blur(8px);
            z-index: 998;
            opacity: 0;
            transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-backdrop.active {
            display: block;
            opacity: 1;
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
            z-index: 999;
            overflow-y: auto;
            backdrop-filter: blur(20px);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
        }

        .admin-sidebar::-webkit-scrollbar { width: 5px; }
        .admin-sidebar::-webkit-scrollbar-track { background: transparent; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 10px; }

        /* Sidebar glowing aura header */
        .admin-sidebar::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 220px;
            background: radial-gradient(ellipse at top, rgba(99, 102, 241, 0.15) 0%, rgba(6, 182, 212, 0.05) 50%, transparent 80%);
            pointer-events: none;
        }

        /* Sidebar logo */
        .sidebar-logo {
            padding: 22px 20px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-subtle);
            flex-shrink: 0;
            position: relative;
        }

        .sidebar-brand-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 18px rgba(79, 70, 229, 0.35), inset 0 1px 1px rgba(255, 255, 255, 0.4);
            position: relative;
            overflow: hidden;
        }

        .logo-icon-wrap::after {
            content: '';
            position: absolute;
            top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(60deg, transparent 30%, rgba(255,255,255,0.3) 50%, transparent 70%);
            animation: logoShine 4s infinite linear;
        }

        @keyframes logoShine {
            0% { transform: translate(-100%, -100%) rotate(45deg); }
            100% { transform: translate(100%, 100%) rotate(45deg); }
        }

        .logo-icon-wrap i {
            font-size: 19px;
            color: #ffffff;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        .logo-text {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: -0.3px;
            color: var(--text-primary);
            line-height: 1.15;
            font-family: 'Space Grotesk', sans-serif;
        }

        .logo-text small {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 700;
            color: var(--accent-cyan);
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-top: 3px;
            font-family: 'Outfit', sans-serif;
        }

        .logo-text small::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent-green);
            box-shadow: 0 0 8px var(--accent-green);
            animation: pulse 2s infinite;
        }

        .sidebar-close-btn {
            display: none;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            color: var(--text-secondary);
            font-size: 14px;
            width: 32px;
            height: 32px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .sidebar-close-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.1);
        }

        /* Sidebar nav */
        .sidebar-nav {
            flex: 1;
            padding: 18px 14px;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 800;
            color: var(--text-muted);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 12px 10px 6px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-subtle);
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            background: transparent;
            width: 100%;
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav-link i {
            width: 20px;
            text-align: center;
            font-size: 15px;
            opacity: 0.8;
            transition: transform 0.2s ease, opacity 0.2s ease, color 0.2s ease;
        }

        .sidebar-nav-link:hover {
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-primary);
            border-color: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
        }

        .sidebar-nav-link:hover i {
            opacity: 1;
            transform: scale(1.15);
            color: var(--accent-cyan);
        }

        .sidebar-nav-link.active {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.18), rgba(6, 182, 212, 0.1));
            color: #ffffff;
            border-color: rgba(99, 102, 241, 0.35);
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            font-weight: 700;
        }

        .sidebar-nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            bottom: 25%;
            width: 3.5px;
            background: linear-gradient(to bottom, var(--accent-cyan), var(--accent-indigo));
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px var(--accent-cyan);
        }

        .sidebar-nav-link.active i {
            color: var(--accent-cyan);
            opacity: 1;
        }

        .sidebar-badge-count {
            margin-left: auto;
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }

        /* Sidebar admin card at bottom */
        .sidebar-admin-card {
            margin: 14px;
            padding: 12px 14px;
            border-radius: var(--radius-lg);
            background: rgba(14, 22, 45, 0.7);
            border: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            backdrop-filter: blur(10px);
            transition: border-color 0.2s, background 0.2s;
        }

        .sidebar-admin-card:hover {
            border-color: var(--border-hover);
            background: rgba(18, 28, 58, 0.8);
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #fff;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
            position: relative;
        }

        .admin-avatar::after {
            content: '';
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--accent-green);
            border: 2px solid var(--bg-sidebar);
            box-shadow: 0 0 6px var(--accent-green);
        }

        .admin-info { flex: 1; min-width: 0; }
        .admin-info-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .admin-info-role {
            font-size: 10px;
            color: var(--accent-cyan);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 1px;
        }

        .sidebar-logout-btn {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171;
            cursor: pointer;
            font-size: 13px;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .sidebar-logout-btn:hover {
            background: var(--accent-red);
            color: #ffffff;
            border-color: var(--accent-red);
            transform: scale(1.05);
            box-shadow: 0 0 12px rgba(239, 68, 68, 0.4);
        }

        /* ===================== MAIN CONTENT ===================== */
        .admin-main {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: var(--bg-deep);
            position: relative;
        }

        /* Top bar */
        .admin-topbar {
            height: var(--topbar-height);
            min-height: var(--topbar-height);
            background: rgba(8, 13, 30, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            flex-shrink: 0;
            z-index: 10;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .mobile-toggle-btn {
            display: none;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            color: var(--text-primary);
            font-size: 15px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .mobile-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--border-hover);
        }

        .topbar-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-primary);
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: -0.2px;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .topbar-title span {
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-muted);
            font-family: 'Outfit', sans-serif;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        /* Digital Clock Widget */
        .topbar-clock-widget {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
        }
        .topbar-clock-widget i {
            color: var(--accent-cyan);
            font-size: 12px;
        }

        /* Quick View Site / Game Pills */
        .topbar-shortcut-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .topbar-shortcut-link:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--border-hover);
            color: var(--text-primary);
            transform: translateY(-1px);
        }

        /* Status Badge with Ping */
        .topbar-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 24px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #34d399;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }
        .status-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--accent-green);
            box-shadow: 0 0 10px var(--accent-green);
            animation: pulse 2s infinite;
        }

        .theme-toggle-btn {
            padding: 7px 14px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-primary);
            font-size: 12.5px;
            font-weight: 600;
            font-family: inherit;
            transition: all 0.2s;
        }
        .theme-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--border-hover);
            transform: translateY(-1px);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.45; transform: scale(0.85); }
        }
        @keyframes crashPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239,68,68,0); }
            50% { box-shadow: 0 0 16px 3px rgba(239,68,68,0.45); }
        }

        /* Content scroll area */
        .admin-content {
            flex: 1;
            overflow-y: auto;
            padding: 26px;
        }
        .admin-content::-webkit-scrollbar { width: 6px; }
        .admin-content::-webkit-scrollbar-track { background: transparent; }
        .admin-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

        /* ===================== TAB CONTENT ===================== */
        .tab-pane { display: none; }
        .tab-pane.active { 
            display: block; 
            animation: paneSlideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) both; 
        }
        @keyframes paneSlideIn { 
            from { opacity: 0; transform: translateY(10px); } 
            to { opacity: 1; transform: translateY(0); } 
        }

        /* Page header */
        .page-header {
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-header-title-group h2 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-primary);
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: -0.3px;
        }
        .page-header-title-group p {
            font-size: 13.5px;
            color: var(--text-secondary);
            margin-top: 4px;
            line-height: 1.4;
        }

        /* ===================== STAT CARDS ===================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 26px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            padding: 22px;
            position: relative;
            overflow: hidden;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(12px);
        }
        .stat-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-3px);
            background: var(--bg-card-hover);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }
        .stat-card.blue::before   { background: linear-gradient(90deg, #3b82f6, #06b6d4); }
        .stat-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #ec4899); }
        .stat-card.green::before  { background: linear-gradient(90deg, #10b981, #34d399); }
        .stat-card.orange::before { background: linear-gradient(90deg, #f97316, #fbbf24); }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .stat-card-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 19px;
            transition: transform 0.25s ease;
        }
        .stat-card:hover .stat-card-icon {
            transform: scale(1.1) rotate(4deg);
        }

        .stat-card.blue   .stat-card-icon { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25); box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2); }
        .stat-card.purple .stat-card-icon { background: rgba(139, 92, 246, 0.15); color: #c084fc; border: 1px solid rgba(139, 92, 246, 0.25); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2); }
        .stat-card.green  .stat-card-icon { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.25); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); }
        .stat-card.orange .stat-card-icon { background: rgba(249, 115, 22, 0.15); color: #fb923c; border: 1px solid rgba(249, 115, 22, 0.25); box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2); }

        .stat-card-val {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-primary);
            font-family: 'JetBrains Mono', monospace;
            line-height: 1.1;
            letter-spacing: -0.5px;
        }
        .stat-card-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .stat-card-change {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }
        .change-up { 
            background: rgba(16, 185, 129, 0.12); 
            color: #34d399; 
            border: 1px solid rgba(16, 185, 129, 0.25); 
        }

        /* ===================== PANELS ===================== */
        .panel {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            margin-bottom: 24px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(12px);
            transition: border-color 0.2s;
        }
        .panel:hover {
            border-color: var(--border-hover);
        }
        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border-subtle);
            background: rgba(255, 255, 255, 0.015);
            flex-wrap: wrap;
            gap: 12px;
        }
        .panel-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Space Grotesk', sans-serif;
        }
        .panel-title i { color: var(--accent-cyan); font-size: 16px; }
        .panel-body { padding: 22px; }

        /* ===================== TABLES ===================== */
        .table-wrap { 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }
        .table-wrap::-webkit-scrollbar { height: 6px; }
        .table-wrap::-webkit-scrollbar-track { background: transparent; }
        .table-wrap::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .admin-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 13px;
            min-width: 650px;
        }
        .admin-table thead tr {
            background: rgba(255, 255, 255, 0.025);
        }
        .admin-table th {
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            white-space: nowrap;
            border-bottom: 1px solid var(--border-subtle);
        }
        .admin-table td {
            padding: 13px 16px;
            border-bottom: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            vertical-align: middle;
            transition: background 0.15s ease;
        }
        .admin-table tbody tr {
            transition: all 0.15s ease;
        }
        .admin-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.035);
        }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .badge-active {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.28);
            color: #34d399;
        }

        /* Currency pill */
        .currency-pill {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 6px;
            background: rgba(251, 191, 36, 0.12);
            color: var(--accent-gold);
            font-weight: 700;
            border: 1px solid rgba(251, 191, 36, 0.22);
        }

        /* Balance value */
        .balance-val {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* Action buttons */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px; height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border-subtle);
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s;
        }
        .action-btn:hover { 
            color: var(--text-primary); 
            border-color: var(--border-hover); 
            background: rgba(255, 255, 255, 0.08); 
            transform: scale(1.05);
        }
        .action-btn.edit:hover { 
            color: var(--accent-cyan); 
            border-color: rgba(6, 182, 212, 0.4); 
            background: rgba(6, 182, 212, 0.1); 
            box-shadow: 0 0 10px rgba(6, 182, 212, 0.25);
        }
        .action-btn.del:hover { 
            color: var(--accent-red); 
            border-color: rgba(239, 68, 68, 0.4); 
            background: rgba(239, 68, 68, 0.1); 
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.25);
        }
        .action-btn.block-user { color: #fb923c; border-color: rgba(249, 115, 22, 0.3); }
        .action-btn.block-user:hover { color: #fed7aa; border-color: rgba(249, 115, 22, 0.6); background: rgba(249, 115, 22, 0.12); }
        .action-btn.unblock { color: #34d399; border-color: rgba(16, 185, 129, 0.3); }
        .action-btn.unblock:hover { color: #a7f3d0; border-color: rgba(16, 185, 129, 0.6); background: rgba(16, 185, 129, 0.12); }

        /* User status badge */
        .user-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .user-status-badge.active {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }
        .user-status-badge.blocked {
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }

        .user-row-blocked td {
            opacity: 0.65;
        }
        .user-row-blocked { background: rgba(239, 68, 68, 0.04); }

        /* ===================== SEARCH BAR ===================== */
        .search-bar {
            position: relative;
            max-width: 280px;
            width: 100%;
        }
        .search-bar i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 13px;
            pointer-events: none;
        }
        .search-input {
            width: 100%;
            padding: 9px 14px 9px 36px;
            background: var(--bg-input);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: all 0.2s;
        }
        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus { 
            border-color: var(--accent-cyan); 
            background: var(--bg-input-focus);
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.15);
        }

        /* ===================== MODALS ===================== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(3, 6, 15, 0.8);
            z-index: 1200;
            backdrop-filter: blur(10px);
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .modal-overlay.open { display: flex; }
        
        .design-preview-card {
            cursor: pointer;
            transition: all 0.22s ease !important;
            background: rgba(255,255,255,0.02) !important;
            padding: 12px;
            border-radius: var(--radius-md);
            border: 2px solid var(--border-subtle) !important;
            text-align: center;
        }
        .design-preview-card:hover {
            transform: translateY(-3px);
            border-color: rgba(6, 182, 212, 0.4) !important;
            background: rgba(255,255,255,0.05) !important;
        }
        .design-preview-card.selected-design {
            border-color: var(--accent-gold) !important;
            background: rgba(251, 191, 36, 0.1) !important;
            box-shadow: 0 0 16px rgba(251, 191, 36, 0.3);
        }
        
        .modal-box {
            background: var(--bg-panel);
            border: 1px solid var(--border-hover);
            border-radius: var(--radius-xl);
            padding: 30px;
            width: 100%;
            max-width: 440px;
            position: relative;
            animation: modalIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) both;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(255, 255, 255, 0.08);
            max-height: 90vh;
            overflow-y: auto;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.92) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-close {
            position: absolute;
            top: 18px; right: 18px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            color: var(--text-muted);
            cursor: pointer;
            font-size: 14px;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .modal-close:hover { 
            color: var(--text-primary); 
            background: rgba(255, 255, 255, 0.1); 
        }
        .modal-title {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 22px;
            color: var(--text-primary);
            font-family: 'Space Grotesk', sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal-title i { color: var(--accent-cyan); }
        
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            padding: 11px 16px;
            background: var(--bg-input);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        .form-input:focus { 
            border-color: var(--accent-cyan); 
            background: var(--bg-input-focus);
            box-shadow: 0 0 0 3px rgba(6, 182, 212, 0.15);
        }
        .form-input:disabled { opacity: 0.55; cursor: not-allowed; }

        /* Submit btn */
        .btn-primary {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            color: #fff;
            font-family: inherit;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 18px rgba(79, 70, 229, 0.35);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-primary:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 6px 24px rgba(6, 182, 212, 0.4); 
        }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }

        /* Toast Notification */
        .admin-toast {
            position: fixed;
            bottom: 24px; right: 24px;
            background: var(--bg-panel);
            border: 1px solid var(--border-hover);
            border-radius: var(--radius-lg);
            padding: 14px 20px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2500;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,255,255,0.1);
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            backdrop-filter: blur(16px);
        }
        .admin-toast.show { transform: translateX(0); }
        .admin-toast i { color: var(--accent-green); font-size: 16px; }
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
        .empty-state i { font-size: 42px; margin-bottom: 14px; display: block; opacity: 0.35; color: var(--accent-cyan); }
        .empty-state p { font-size: 14px; }

        /* Loading state */
        .loading-row td {
            text-align: center;
            padding: 42px;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* ===================== ADMIN LIGHT THEME ===================== */
        .light-theme {
            --bg-deep:        #f1f5f9;
            --bg-sidebar:     #ffffff;
            --bg-sidebar-nav: #f8fafc;
            --bg-card:        #ffffff;
            --bg-card-hover:  #f8fafc;
            --bg-panel:       #ffffff;
            --bg-input:       #f8fafc;
            --bg-input-focus: #ffffff;
            
            --text-primary:   #0f172a;
            --text-secondary: #475569;
            --text-muted:     #94a3b8;
            --border-subtle:  #e2e8f0;
            --border-hover:   #cbd5e1;
            --border-glow:    rgba(99, 102, 241, 0.2);
            --card-shadow:    0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 0 0 1px #e2e8f0;
        }

        .light-theme body::before {
            background: 
                radial-gradient(circle at 15% 15%, rgba(99, 102, 241, 0.04) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(6, 182, 212, 0.03) 0%, transparent 40%);
        }

        .light-theme .admin-sidebar {
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.04);
        }

        .light-theme .admin-sidebar::before {
            background: radial-gradient(ellipse at top, rgba(99, 102, 241, 0.06) 0%, transparent 70%);
        }

        .light-theme .sidebar-nav-link:hover {
            background: #f1f5f9;
            color: #4f46e5;
        }

        .light-theme .sidebar-nav-link.active {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(6, 182, 212, 0.06));
            color: #4f46e5;
            border-color: rgba(99, 102, 241, 0.25);
        }
        
        .light-theme .sidebar-nav-link.active i {
            color: #4f46e5;
        }

        .light-theme .sidebar-admin-card {
            background: #f8fafc;
            border-color: #e2e8f0;
        }

        .light-theme .admin-topbar {
            background: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid #e2e8f0;
        }

        .light-theme .admin-table thead tr {
            background: #f8fafc;
        }

        .light-theme .admin-table th {
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
        }

        .light-theme .admin-table td {
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .light-theme .admin-table tbody tr:hover {
            background: #f8fafc;
        }

        .light-theme .modal-box {
            background: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 0 0 0 1px #e2e8f0;
        }

        .light-theme .form-input,
        .light-theme select {
            border: 1px solid #cbd5e1;
            color: #0f172a;
            background: #ffffff;
        }

        .light-theme .admin-toast {
            background: #ffffff;
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.12), 0 0 0 1px #e2e8f0;
        }

        /* ===================== RESPONSIVE BREAKPOINTS ===================== */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                position: fixed;
                top: 0; left: 0; bottom: 0;
                width: 280px;
                transform: translateX(-100%);
                box-shadow: none;
            }
            .admin-sidebar.open {
                transform: translateX(0);
                box-shadow: 10px 0 50px rgba(0, 0, 0, 0.8);
            }
            .sidebar-close-btn {
                display: inline-flex;
            }
            .mobile-toggle-btn {
                display: inline-flex;
            }
            .topbar-clock-widget {
                display: none;
            }
            .admin-topbar {
                padding: 0 16px;
            }
            .admin-content {
                padding: 18px 14px;
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .page-header h2 {
                font-size: 20px;
            }
            .topbar-title span {
                display: none;
            }
            .topbar-shortcut-link span {
                display: none;
            }
            .topbar-badge {
                padding: 5px 10px;
                font-size: 10.5px;
            }
            .theme-toggle-btn span {
                display: none;
            }
            .panel-header {
                padding: 14px 16px;
            }
            .panel-body {
                padding: 16px;
            }
            .stat-card {
                padding: 18px;
            }
            .stat-card-val {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">

        <!-- Backdrop overlay for mobile drawer -->
        <div class="sidebar-backdrop" id="sidebar-backdrop" onclick="toggleMobileSidebar(false)"></div>

        <!-- ==================== SIDEBAR ==================== -->
        <aside class="admin-sidebar" id="admin-sidebar">
            <div class="sidebar-logo">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-wrapper">
                    <div class="logo-icon-wrap">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div class="logo-text">
                        Aviator Pro
                        <small>Control Center</small>
                    </div>
                </a>
                <button class="sidebar-close-btn" onclick="toggleMobileSidebar(false)" title="Close Menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section-label">Core Operations</div>
                <button class="sidebar-nav-link active" id="nav-overview" onclick="switchTab('overview', this)">
                    <i class="fas fa-chart-pie"></i>
                    <span>Overview</span>
                </button>
                <button class="sidebar-nav-link" id="nav-users" onclick="switchTab('users', this)">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
                </button>
                <button class="sidebar-nav-link" id="nav-withdrawals" onclick="switchTab('withdrawals', this)">
                    <i class="fas fa-money-bill-transfer"></i>
                    <span>Withdrawal Requests</span>
                </button>
                <button class="sidebar-nav-link" id="nav-deposits" onclick="switchTab('deposits', this)">
                    <i class="fas fa-circle-down"></i>
                    <span>Deposit Requests</span>
                </button>
                <button class="sidebar-nav-link" id="nav-support" onclick="switchTab('support', this)">
                    <i class="fas fa-comments"></i>
                    <span>Support Chat</span>
                    <span class="badge-unread-total sidebar-badge-count" id="admin-chat-unread-badge" style="display:none; background:var(--accent-red); color:#fff;">0</span>
                </button>

                <div class="nav-section-label">Platform Setup</div>
                <button class="sidebar-nav-link" id="nav-gateways" onclick="switchTab('gateways', this)">
                    <i class="fas fa-circle-arrow-down"></i>
                    <span>Deposit Gateways</span>
                </button>
                <button class="sidebar-nav-link" id="nav-withdraw-gateways" onclick="switchTab('withdraw-gateways', this)">
                    <i class="fas fa-circle-arrow-up"></i>
                    <span>Withdraw Payment Setup</span>
                </button>
                <button class="sidebar-nav-link" id="nav-settings" onclick="switchTab('settings', this)">
                    <i class="fas fa-percent"></i>
                    <span>Commission Setup</span>
                </button>

                <div class="nav-section-label">Casino Game Modules</div>
                <a href="{{ route('admin.casino.analytics') }}" class="sidebar-nav-link" target="_blank" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; margin-bottom: 8px;">
                    <i class="fas fa-heart-pulse" style="color: #34d399;"></i>
                    <span>Game Health & Analytics</span>
                    <span style="font-size: 9px; background: #10b981; color: #fff; padding: 1px 6px; border-radius: 4px; margin-left: auto; font-weight: 800;">LIVE</span>
                </a>
                <div style="background: rgba(14, 22, 45, 0.6); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 10px; margin-bottom: 6px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; cursor:pointer;" onclick="toggleGamesSubmenu()">
                        <div style="font-size:11px; font-weight:800; color:#cbd5e1; text-transform:uppercase; letter-spacing:0.8px; display:flex; align-items:center; gap:6px;">
                            <i class="fas fa-cubes" style="color:var(--accent-gold);"></i> 100+ Game Engines
                        </div>
                        <span style="background:rgba(251, 191, 36, 0.15); color:var(--accent-gold); font-size:9.5px; font-weight:800; padding:2px 7px; border-radius:10px; border:1px solid rgba(251, 191, 36, 0.3);">READY</span>
                    </div>
                    
                    <div id="games-module-submenu" style="display:flex; flex-direction:column; gap:4px;">
                        <!-- Active Game 1: Olympus Gold -->
                        <button class="sidebar-nav-link" id="nav-olympus" onclick="switchTab('olympus', this)" style="padding: 8px 10px; font-size: 12.5px; border-radius: 8px; background: rgba(251, 191, 36, 0.08); border: 1px solid rgba(251, 191, 36, 0.25);">
                            <i class="fas fa-bolt" style="color:var(--accent-gold); font-size:13px;"></i>
                            <span>Olympus Gold™</span>
                            <span style="font-size:9px; background:#10b981; color:#fff; padding:1px 6px; border-radius:4px; margin-left:auto; font-weight:800;">ACTIVE</span>
                        </button>

                        <!-- Active Game 2: Western Vault -->
                        <button class="sidebar-nav-link" id="nav-western" onclick="switchTab('western', this)" style="padding: 8px 10px; font-size: 12.5px; border-radius: 8px; background: rgba(249, 115, 22, 0.08); border: 1px solid rgba(249, 115, 22, 0.25);">
                            <i class="fas fa-vault" style="color:var(--accent-orange); font-size:13px;"></i>
                            <span>Western Vault™</span>
                            <span style="font-size:9px; background:#f97316; color:#fff; padding:1px 6px; border-radius:4px; margin-left:auto; font-weight:800;">ACTIVE</span>
                        </button>

                        <!-- Aviator Crash Settings -->
                        <button class="sidebar-nav-link" id="nav-game" onclick="switchTab('game', this)" style="padding: 8px 10px; font-size: 12.5px; border-radius: 8px;">
                            <i class="fas fa-plane-departure" style="color:#00f2fe; font-size:13px;"></i>
                            <span>Aviator Crash</span>
                            <span style="font-size:9px; background:#00f2fe; color:#000; padding:1px 6px; border-radius:4px; margin-left:auto; font-weight:800;">ACTIVE</span>
                        </button>

                        <!-- Active Game: Fortune Gems 2 -->
                        <a href="{{ route('admin.gems.index') }}" class="sidebar-nav-link" style="padding: 8px 10px; font-size: 12.5px; border-radius: 8px; background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.25); text-decoration:none; color:inherit;">
                            <i class="fas fa-gem" style="color:#f59e0b; font-size:13px;"></i>
                            <span>Fortune Gems 2™</span>
                            <span style="font-size:9px; background:#f59e0b; color:#000; padding:1px 6px; border-radius:4px; margin-left:auto; font-weight:800;">ACTIVE</span>
                        </a>
                        <!-- Active Game 3: Boxing King -->
                        <button class="sidebar-nav-link" id="nav-boxing-king" onclick="switchTab('boxing-king', this)" style="padding: 8px 10px; font-size: 12.5px; border-radius: 8px; background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25);">
                            <i class="fas fa-crown" style="color:#ef4444; font-size:13px;"></i>
                            <span>Boxing King™</span>
                            <span style="font-size:9px; background:#ef4444; color:#fff; padding:1px 6px; border-radius:4px; margin-left:auto; font-weight:800;">ACTIVE</span>
                        </button>

                        <!-- Active Game 4: Abyss of Glory / Temple of Fortune -->
                        <a href="{{ route('admin.abyss.index') }}" class="sidebar-nav-link" style="padding: 8px 10px; font-size: 12.5px; border-radius: 8px; background: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.25); text-decoration:none; color:inherit;">
                            <i class="fas fa-landmark" style="color:#fbbf24; font-size:13px;"></i>
                            <span>Abyss of Glory™</span>
                            <span style="font-size:9px; background:#f59e0b; color:#000; padding:1px 6px; border-radius:4px; margin-left:auto; font-weight:800;">ACTIVE</span>
                        </a>

                        <!-- Active Game 5: Heads or Tails (Mermaid / Octopus Gold Coin) -->
                        <a href="{{ route('admin.headstails.index') }}" class="sidebar-nav-link" style="padding: 8px 10px; font-size: 12.5px; border-radius: 8px; background: rgba(234, 179, 8, 0.08); border: 1px solid rgba(234, 179, 8, 0.25); text-decoration:none; color:inherit;">
                            <i class="fas fa-coins" style="color:#eab308; font-size:13px;"></i>
                            <span>Heads or Tails™</span>
                            <span style="font-size:9px; background:#eab308; color:#000; padding:1px 6px; border-radius:4px; margin-left:auto; font-weight:800;">ACTIVE</span>
                        </a>

                        <!-- Active Game 6: Lucky Joker 100 -->
                        <a href="{{ route('admin.joker.index') }}" class="sidebar-nav-link" style="padding: 8px 10px; font-size: 12.5px; border-radius: 8px; background: rgba(244, 63, 94, 0.08); border: 1px solid rgba(244, 63, 94, 0.25); text-decoration:none; color:inherit;">
                            <i class="fas fa-hat-cowboy-side" style="color:#f43f5e; font-size:13px;"></i>
                            <span>Lucky Joker 100™</span>
                            <span style="font-size:9px; background:#f43f5e; color:#fff; padding:1px 6px; border-radius:4px; margin-left:auto; font-weight:800;">ACTIVE</span>
                        </a>
                        <button class="sidebar-nav-link" onclick="showAdminToast('BonBon Bonanza engine module will load here.', 'info')" style="padding: 7px 10px; font-size: 12px; border-radius: 8px; opacity:0.7;">
                            <i class="fas fa-candy-cane" style="color:#e879f9; font-size:12px;"></i>
                            <span>BonBon Bonanza</span>
                        </button>
                    </div>
                </div>

                <div class="nav-section-label">Shortcuts & Control</div>
                <a href="{{ route('play') }}" class="sidebar-nav-link" target="_blank">
                    <i class="fas fa-gamepad" style="color:var(--accent-cyan);"></i>
                    <span>Launch Game</span>
                    <i class="fas fa-arrow-up-right-from-square" style="font-size:11px; margin-left:auto; opacity:0.5;"></i>
                </a>
                <a href="{{ route('home') }}" class="sidebar-nav-link" target="_blank">
                    <i class="fas fa-globe" style="color:var(--accent-indigo);"></i>
                    <span>View Site</span>
                    <i class="fas fa-arrow-up-right-from-square" style="font-size:11px; margin-left:auto; opacity:0.5;"></i>
                </a>

                <!-- ⚡ FORCE CRASH BUTTON -->
                <div style="margin-top:10px;">
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
                            border-radius: var(--radius-md);
                            border: 1px solid rgba(239, 68, 68, 0.45);
                            background: linear-gradient(135deg, rgba(239, 68, 68, 0.22), rgba(185, 28, 28, 0.15));
                            color: #fca5a5;
                            font-family: inherit;
                            font-size: 13px;
                            font-weight: 700;
                            cursor: pointer;
                            letter-spacing: 0.3px;
                            transition: all 0.2s;
                            animation: crashPulse 2s infinite;
                        "
                        onmouseover="this.style.background='linear-gradient(135deg,rgba(239,68,68,0.38),rgba(185,28,28,0.3))'; this.style.borderColor='rgba(239,68,68,0.8)';"
                        onmouseout="this.style.background='linear-gradient(135deg,rgba(239,68,68,0.22),rgba(185,28,28,0.15))'; this.style.borderColor='rgba(239,68,68,0.45)';"
                    >
                        <i class="fas fa-bolt" style="color:var(--accent-red);"></i>
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
                    <div class="admin-info-role">Super Administrator</div>
                </div>
                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
                <button class="sidebar-logout-btn" onclick="document.getElementById('admin-logout-form').submit()" title="Logout Admin Session">
                    <i class="fas fa-power-off"></i>
                </button>
            </div>
        </aside>

        <!-- ==================== MAIN ==================== -->
        <div class="admin-main">

            <!-- Top bar -->
            <div class="admin-topbar">
                <div class="topbar-left">
                    <button class="mobile-toggle-btn" id="mobile-sidebar-toggle" onclick="toggleMobileSidebar(true)" title="Open Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="topbar-title" id="topbar-page-title">
                        Overview <span>/ Admin Dashboard</span>
                    </div>
                </div>

                <div class="topbar-actions">
                    <!-- Live Digital Clock -->
                    <div class="topbar-clock-widget" id="topbar-clock-widget">
                        <i class="fas fa-clock"></i>
                        <span id="live-topbar-clock">--:--:--</span>
                    </div>

                    <!-- Quick Site Shortcuts -->
                    <a href="{{ route('play') }}" class="topbar-shortcut-link" target="_blank" title="Play Game">
                        <i class="fas fa-gamepad" style="color:var(--accent-cyan);"></i>
                        <span>Play</span>
                    </a>

                    <!-- Theme Toggle -->
                    <button id="admin-theme-toggle" onclick="toggleAdminTheme()" class="theme-toggle-btn" title="Toggle Light / Dark theme">
                        <i class="fas fa-sun" id="admin-theme-icon"></i> 
                        <span id="admin-theme-text">Light Mode</span>
                    </button>

                    <!-- Status Badge -->
                    <div class="topbar-badge">
                        <div class="status-dot"></div>
                        <span>Live • 99.9%</span>
                    </div>
                </div>
            </div>

            <!-- Scrollable content area -->
            <div class="admin-content">

                @hasSection('module_content')
                    <div style="padding: 10px 0;">
                        @yield('module_content')
                    </div>
                @else
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
                            <div class="stat-card-val" id="stat-total-users">{{ $totalUsers ?? 0 }}</div>
                            <div class="stat-card-label">Total Users</div>
                            <span class="stat-card-change change-up">Active</span>
                        </div>
                        <div class="stat-card green">
                            <div class="stat-card-icon"><i class="fas fa-wallet"></i></div>
                            <div class="stat-card-val" id="stat-total-balance">{{ number_format($totalDeposits ?? 0, 0, '.', ',') }}</div>
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

                    <!-- =========================================================
                         MULTI-GAME REAL PLAYERS & PROFIT BREAKDOWN MATRIX
                         ========================================================= -->
                    <div class="panel" style="margin-bottom: 26px; border: 1.5px solid rgba(99, 102, 241, 0.25); background: linear-gradient(180deg, rgba(13, 20, 40, 0.9), rgba(10, 16, 32, 0.95));">
                        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                            <div class="panel-title" style="font-size:16px;">
                                <i class="fas fa-cubes" style="color:var(--accent-gold);"></i> 
                                <span>Multi-Game Performance Matrix & Live Player Accounting</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <span style="font-size:11px; background:rgba(16, 185, 129, 0.15); color:#34d399; border:1px solid rgba(16, 185, 129, 0.3); padding:4px 10px; border-radius:20px; font-weight:700;">
                                    <i class="fas fa-circle" style="font-size:7px; margin-right:4px;"></i> Real-Time Accounting
                                </span>
                                <button type="button" onclick="refreshGameMatrix()" style="background:rgba(255,255,255,0.05); border:1px solid var(--border-subtle); color:var(--text-secondary); border-radius:8px; padding:5px 12px; font-size:12px; cursor:pointer; font-weight:700; transition:all 0.2s;" title="Refresh matrix">
                                    <i class="fas fa-sync-alt" id="matrix-refresh-icon"></i> Refresh
                                </button>
                            </div>
                        </div>

                        <div class="table-wrap">
                            <table class="admin-table" style="min-width: 820px;">
                                <thead>
                                    <tr>
                                        <th>GAME & ENGINE</th>
                                        <th>CATEGORY</th>
                                        <th style="text-align:center;">ACTIVE USERS</th>
                                        <th>TOTAL REAL STAKES</th>
                                        <th>TOTAL PAID OUT</th>
                                        <th>HOUSE PROFIT</th>
                                        <th style="text-align:center;">RTP %</th>
                                        <th style="text-align:center;">ENGINE STATUS</th>
                                        <th style="text-align:right;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody id="game-matrix-tbody">
                                    @if(isset($gameMatrix) && count($gameMatrix) > 0)
                                        @foreach($gameMatrix as $game)
                                        <tr>
                                            <td>
                                                <div style="display:flex; align-items:center; gap:10px;">
                                                    <div style="width:34px; height:34px; border-radius:8px; background:{{ $game['theme'] }}22; border:1px solid {{ $game['theme'] }}55; display:flex; align-items:center; justify-content:center; color:{{ $game['theme'] }}; font-size:14px; flex-shrink:0;">
                                                        <i class="{{ $game['icon'] }}"></i>
                                                    </div>
                                                    <div>
                                                        <strong style="color:var(--text-primary); font-size:13.5px;">{{ $game['name'] }}</strong>
                                                        <div style="font-size:10.5px; color:var(--text-muted); font-family:'Roboto Mono',monospace;">ID: {{ $game['id'] }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span style="font-size:11.5px; color:var(--text-secondary);">{{ $game['category'] }}</span></td>
                                            <td style="text-align:center;">
                                                <span style="display:inline-flex; align-items:center; gap:4px; font-family:'JetBrains Mono',monospace; font-weight:800; font-size:13px; color:var(--accent-cyan); background:rgba(0,242,254,0.1); border:1px solid rgba(0,242,254,0.25); padding:2px 8px; border-radius:12px;">
                                                    <i class="fas fa-user" style="font-size:10px;"></i> {{ $game['active_players'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong style="font-family:'JetBrains Mono',monospace; color:var(--text-primary); font-size:13px;">৳ {{ number_format($game['total_turnover'], 2) }}</strong>
                                            </td>
                                            <td>
                                                <span style="font-family:'JetBrains Mono',monospace; color:#38ef7d; font-size:13px; font-weight:700;">৳ {{ number_format($game['total_payout'], 2) }}</span>
                                            </td>
                                            <td>
                                                @php $profit = $game['admin_profit']; @endphp
                                                <span style="font-family:'JetBrains Mono',monospace; font-weight:800; font-size:13px; color:{{ $profit >= 0 ? '#10b981' : '#ef4444' }}; background:{{ $profit >= 0 ? 'rgba(16,185,129,0.12)' : 'rgba(239,68,68,0.12)' }}; padding:3px 8px; border-radius:6px; border:1px solid {{ $profit >= 0 ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)' }};">
                                                    {{ $profit >= 0 ? '+' : '' }}৳ {{ number_format($profit, 2) }}
                                                </span>
                                            </td>
                                            <td style="text-align:center;">
                                                <span style="font-family:'JetBrains Mono',monospace; font-size:12px; font-weight:700; color:var(--accent-gold);">
                                                    {{ number_format($game['rtp'], 2) }}%
                                                </span>
                                            </td>
                                            <td style="text-align:center;">
                                                @php $health = $game['health_status'] ?? 'healthy'; @endphp
                                                @if($health === 'healthy')
                                                    <span style="font-size:9.5px; font-weight:800; padding:3px 8px; border-radius:6px; background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3);">
                                                        <i class="fas fa-shield-check"></i> HEALTHY
                                                    </span>
                                                @elseif($health === 'balanced')
                                                    <span style="font-size:9.5px; font-weight:800; padding:3px 8px; border-radius:6px; background:rgba(0,242,254,0.15); color:#00f2fe; border:1px solid rgba(0,242,254,0.3);">
                                                        <i class="fas fa-scale-balanced"></i> BALANCED
                                                    </span>
                                                @else
                                                    <span style="font-size:9.5px; font-weight:800; padding:3px 8px; border-radius:6px; background:rgba(239,68,68,0.15); color:#f87171; border:1px solid rgba(239,68,68,0.3);">
                                                        <i class="fas fa-triangle-exclamation"></i> CRITICAL
                                                    </span>
                                                @endif
                                            </td>
                                            <td style="text-align:right;">
                                                <a href="{{ $game['route'] }}" target="_blank" class="action-btn" title="Launch Game" style="text-decoration:none; margin-right:4px;">
                                                    <i class="fas fa-external-link-alt" style="font-size:11px;"></i>
                                                </a>
                                                @if($game['id'] === 'boxing-king')
                                                    <button onclick="switchTab('boxing-king', document.getElementById('nav-boxing-king'))" class="action-btn edit" title="Manage Boxing King">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                @elseif($game['id'] === 'western-vault')
                                                    <button onclick="switchTab('western', document.getElementById('nav-western'))" class="action-btn edit" title="Manage Western Vault">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                @elseif($game['id'] === 'olympus')
                                                    <button onclick="switchTab('olympus', document.getElementById('nav-olympus'))" class="action-btn edit" title="Manage Olympus">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                @elseif($game['id'] === 'aviator')
                                                    <button onclick="switchTab('game', document.getElementById('nav-game'))" class="action-btn edit" title="Manage Aviator">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" style="text-align:center; padding:20px; color:var(--text-muted);">
                                                No game engine statistics found.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
                <!-- Support Chat Tab Panel -->
                <div class="tab-pane" id="tab-support">
                    <div class="page-header">
                        <div class="page-header-title-group">
                            <h2>Support Chat Center</h2>
                            <p>Chat with active players and help them resolve their queries in real-time.</p>
                        </div>
                    </div>

                    <div class="chat-container-layout" style="display: flex; gap: 0; height: calc(100vh - 210px); min-height: 520px; background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--card-shadow);">
                        
                        <!-- Left Panel: Chat List -->
                        <div class="chat-sidebar-pane" id="admin-chat-sidebar-pane" style="width: 320px; min-width: 320px; border-right: 1px solid var(--border-subtle); display: flex; flex-direction: column; background: rgba(0, 0, 0, 0.15);">
                            <div style="padding: 16px 18px; border-bottom: 1px solid var(--border-subtle); font-weight: 800; font-size: 14px; color: var(--text-primary); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; font-family: 'Space Grotesk', sans-serif;">
                                <span>Active Conversations</span>
                                <button onclick="loadSupportChats()" style="background: rgba(255,255,255,0.04); border: 1px solid var(--border-subtle); border-radius: 6px; padding: 4px 10px; color: var(--accent-cyan); cursor: pointer; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;" title="Refresh conversations"><i class="fas fa-rotate"></i> Refresh</button>
                            </div>
                            <div id="admin-chat-users-list" style="flex: 1; overflow-y: auto; padding: 6px 0;">
                                <div style="padding: 30px 20px; text-align: center; color: var(--text-muted);">
                                    <i class="fas fa-comments" style="font-size: 28px; margin-bottom: 10px; display: block; opacity: 0.4;"></i>
                                    No active conversations
                                </div>
                            </div>
                        </div>

                        <!-- Right Panel: Active Message Window -->
                        <div class="chat-window-pane" id="admin-chat-window" style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: var(--text-muted); background: rgba(0, 0, 0, 0.04); position: relative;">
                            <div id="admin-chat-window-empty" style="padding: 40px 20px;">
                                <div style="width: 70px; height: 70px; border-radius: 20px; background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2); display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; color: var(--accent-indigo); font-size: 28px;">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <h3 style="color: var(--text-primary); font-weight: 800; font-size: 17px; font-family: 'Space Grotesk', sans-serif;">Select a Conversation</h3>
                                <p style="font-size: 13.5px; margin-top: 6px; max-width: 320px; margin-left: auto; margin-right: auto; line-height: 1.5; color: var(--text-secondary);">Choose a user from the list on the left to start chatting with them in real-time.</p>
                            </div>

                            <!-- Chat Box Wrapper (Hidden by default until user selected) -->
                            <div id="admin-chat-window-active" style="display: none; width: 100%; height: 100%; flex-direction: column; text-align: left;">
                                <!-- Active User Profile Header -->
                                <div style="padding: 14px 20px; border-bottom: 1px solid var(--border-subtle); background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; gap: 12px;">
                                    <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                                        <button type="button" class="mobile-chat-back-btn" onclick="toggleAdminMobileChat(false)" style="display:none; background:rgba(255,255,255,0.06); border:1px solid var(--border-subtle); color:#fff; border-radius:8px; width:34px; height:34px; align-items:center; justify-content:center; cursor:pointer; flex-shrink:0;">
                                            <i class="fas fa-arrow-left"></i>
                                        </button>
                                        <div style="min-width: 0;">
                                            <h4 id="active-chat-user-name" style="color: var(--text-primary); font-size: 15px; font-weight: 800; font-family: 'Space Grotesk', sans-serif; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Customer Name</h4>
                                            <p id="active-chat-user-meta" style="color: var(--text-secondary); font-size: 11.5px; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">email@example.com / 01700000000</p>
                                        </div>
                                    </div>
                                    <div style="font-size: 11px; background: rgba(6, 182, 212, 0.12); border: 1px solid rgba(6, 182, 212, 0.28); color: var(--accent-cyan); padding: 5px 12px; border-radius: 20px; font-weight: 700; flex-shrink: 0;">
                                        Active Chat
                                    </div>
                                </div>

                                <!-- Messages Box Scroll Area -->
                                <div id="admin-chat-messages-box" style="flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 14px; background: rgba(0,0,0,0.08);">
                                    <!-- Messages rendered here -->
                                </div>

                                <!-- Textarea Input Send Box -->
                                <form id="admin-chat-send-form" onsubmit="submitAdminChatMessage(event)" style="padding: 16px 20px; border-top: 1px solid var(--border-subtle); background: var(--bg-card); display: flex; gap: 12px; align-items: center; flex-shrink: 0; margin-bottom: 0;">
                                    <input type="hidden" id="active-chat-user-id">
                                    <input type="text" id="admin-chat-input" placeholder="Type your reply here..." autocomplete="off" required style="flex: 1; padding: 12px 16px; background: var(--bg-input); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); color: var(--text-primary); font-family: inherit; font-size: 13.5px; outline: none; transition: border-color 0.2s;">
                                    <button type="submit" class="btn-primary" style="width: auto; padding: 12px 22px; flex-shrink: 0;">
                                        <span>Send</span> <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ==================== TAB: OLYMPUS SLOT CONTROL ==================== -->
                <div class="tab-pane" id="tab-olympus">
                    <div class="page-header">
                        <h2>Olympus Slot Game Management</h2>
                        <p>Configure Demo limits, Real money mode, RTP, Paytables, Multipliers, Free Spins, and review player spin history and audit logs.</p>
                    </div>

                    <!-- Row 1: Config Form -->
                    <div class="panel" style="margin-bottom: 24px;">
                        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
                            <div class="panel-title"><i class="fas fa-sliders" style="color:var(--accent-gold);"></i> Game & Feature Configuration</div>
                            <span class="badge" id="olympus-config-status-badge" style="padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 700; text-transform: uppercase; background: rgba(34, 197, 94, 0.2); color: #4ade80;">Active</span>
                        </div>
                        <div class="panel-body">
                            <form id="olympus-settings-form" onsubmit="saveOlympusConfig(event)">
                                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                                    
                                    <!-- Card: Game Status & Modes -->
                                    <div style="background:rgba(255,255,255,0.02); padding:18px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <h4 style="font-size:12px; font-weight:700; color:var(--accent-gold); margin-bottom:14px; text-transform:uppercase; letter-spacing:0.5px;"><i class="fas fa-power-off"></i> Status & Modes</h4>
                                        
                                        <div class="form-group">
                                            <label class="form-label">Game Status</label>
                                            <select class="form-input" id="olympus-game-status" required>
                                                <option value="active">Active (Available for all players)</option>
                                                <option value="maintenance">Maintenance (Temporarily Closed)</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Demo Mode Status</label>
                                            <select class="form-input" id="olympus-demo-enabled" required>
                                                <option value="1">Enabled (Players can play free demo)</option>
                                                <option value="0">Disabled</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Real Money Mode Status</label>
                                            <select class="form-input" id="olympus-real-enabled" required>
                                                <option value="1">Enabled (Real balance betting active)</option>
                                                <option value="0">Disabled</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Login/Register Popup</label>
                                            <select class="form-input" id="olympus-login-popup-enabled" required>
                                                <option value="1">Enabled (Show auth popup on demo limit)</option>
                                                <option value="0">Disabled</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Card: Demo Play Limit & Virtual Balance -->
                                    <div style="background:rgba(255,255,255,0.02); padding:18px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <h4 style="font-size:12px; font-weight:700; color:var(--accent-blue); margin-bottom:14px; text-transform:uppercase; letter-spacing:0.5px;"><i class="fas fa-gamepad"></i> Demo Free Play Limit</h4>
                                        
                                        <div class="form-group">
                                            <label class="form-label">Demo Free Play Limit (Spins)</label>
                                            <select class="form-input" id="olympus-demo-play-limit" required>
                                                <option value="1">1 Spin / Session (Default)</option>
                                                <option value="2">2 Spins</option>
                                                <option value="3">3 Spins</option>
                                                <option value="5">5 Spins</option>
                                                <option value="10">10 Spins</option>
                                                <option value="0">Unlimited Demo Spins</option>
                                            </select>
                                            <small style="color:var(--text-muted); font-size:11px; display:block; margin-top:4px;">When this limit is reached, user receives the auth popup to login/register.</small>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Starting Demo Virtual Balance</label>
                                            <input type="number" class="form-input" id="olympus-demo-starting-balance" step="100" min="10" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Volatility Level</label>
                                            <select class="form-input" id="olympus-volatility" required>
                                                <option value="high">High (⚡⚡⚡⚡⚡)</option>
                                                <option value="medium">Medium (⚡⚡⚡)</option>
                                                <option value="low">Low (⚡)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Card: Betting & Multipliers -->
                                    <div style="background:rgba(255,255,255,0.02); padding:18px; border-radius:12px; border:1px solid var(--border-subtle);">
                                        <h4 style="font-size:12px; font-weight:700; color:var(--accent-green); margin-bottom:14px; text-transform:uppercase; letter-spacing:0.5px;"><i class="fas fa-coins"></i> Betting & Multiplier Rules</h4>
                                        
                                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                                            <div class="form-group">
                                                <label class="form-label">Minimum Bet</label>
                                                <input type="number" class="form-input" id="olympus-min-bet" step="0.5" min="0.1" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Maximum Bet</label>
                                                <input type="number" class="form-input" id="olympus-max-bet" step="10" min="1" required>
                                            </div>
                                        </div>

                                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                                            <div class="form-group">
                                                <label class="form-label">Default Bet</label>
                                                <input type="number" class="form-input" id="olympus-default-bet" step="0.5" min="0.1" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">RTP Percentage (%)</label>
                                                <input type="number" class="form-input" id="olympus-rtp-percentage" step="0.1" min="50" max="100" required>
                                            </div>
                                        </div>

                                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                                            <div class="form-group">
                                                <label class="form-label">Buy Free Spins Cost (X)</label>
                                                <input type="number" class="form-input" id="olympus-buy-spins-mult" step="1" min="10" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Double Chance Ante (%)</label>
                                                <input type="number" class="form-input" id="olympus-double-chance-pct" step="1" min="0" required>
                                            </div>
                                        </div>

                                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                                            <div class="form-group">
                                                <label class="form-label">Required Scatters</label>
                                                <input type="number" class="form-input" id="olympus-req-scatters" min="3" max="6" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Free Spins Count</label>
                                                <input type="number" class="form-input" id="olympus-free-spins-count" min="1" max="50" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div style="margin-top:20px; display:flex; justify-content:flex-end;">
                                    <button type="submit" class="btn-primary" id="btn-save-olympus-config" style="width:auto; padding:12px 30px; display:inline-flex; align-items:center; gap:8px;">
                                        <i class="fas fa-floppy-disk"></i> Save Olympus Configuration
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Row 2: Live Player Spin History -->
                    <div class="panel" style="margin-bottom: 24px;">
                        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
                            <div class="panel-title"><i class="fas fa-clock-rotate-left"></i> Live Olympus Spins & Round History</div>
                            <div style="display:flex; gap:10px;">
                                <select id="olympus-rounds-filter-mode" onchange="loadOlympusRounds(1, this.value)" class="form-input" style="padding:4px 10px; font-size:12px; height:32px; width:130px;">
                                    <option value="">All Modes</option>
                                    <option value="real">Real Money</option>
                                    <option value="demo">Demo Spins</option>
                                </select>
                                <button onclick="loadOlympusRounds(1, document.getElementById('olympus-rounds-filter-mode').value)" class="btn-primary" style="width:auto; padding:4px 12px; font-size:12px; height:32px; display:inline-flex; align-items:center; gap:5px;">
                                    <i class="fas fa-rotate"></i> Refresh
                                </button>
                            </div>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ROUND ID</th>
                                        <th>MODE</th>
                                        <th>PLAYER</th>
                                        <th>BET AMOUNT</th>
                                        <th>TOTAL DEDUCTED</th>
                                        <th>TOTAL MULTIPLIER</th>
                                        <th>FINAL WIN</th>
                                        <th>PROFIT / LOSS</th>
                                        <th>TIME</th>
                                    </tr>
                                </thead>
                                <tbody id="olympus-rounds-tbody">
                                    <tr class="loading-row">
                                        <td colspan="9"><i class="fas fa-spinner fa-spin"></i> Loading round history...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="olympus-rounds-pagination" style="padding:14px; display:flex; justify-content:flex-end; gap:8px;"></div>
                    </div>

                    <!-- Row 3: Admin Configuration Audit Logs -->
                    <div class="panel">
                        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
                            <div class="panel-title"><i class="fas fa-shield"></i> Olympus Configuration Audit Trail</div>
                            <button onclick="loadOlympusAuditLogs()" class="btn-primary" style="width:auto; padding:4px 12px; font-size:12px; height:32px; display:inline-flex; align-items:center; gap:5px;">
                                <i class="fas fa-rotate"></i> Refresh Logs
                            </button>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ADMIN</th>
                                        <th>SETTING KEY</th>
                                        <th>OLD VALUE</th>
                                        <th>NEW VALUE</th>
                                        <th>IP ADDRESS</th>
                                        <th>TIMESTAMP</th>
                                    </tr>
                                </thead>
                                <tbody id="olympus-audit-tbody">
                                    <tr class="loading-row">
                                        <td colspan="6"><i class="fas fa-spinner fa-spin"></i> Loading audit logs...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- ==================== TAB: WESTERN VAULT CASINO MODULE ==================== -->
                <div class="tab-pane" id="tab-western">
                    <div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
                        <div>
                            <h2>Western Vault™ Management & Engine Controls</h2>
                            <p>Manage House Profit Algorithm, Fixed Win %, Bot Injection Simulation, Real Bets, Sound FX, and Real-time Audits.</p>
                        </div>
                        <div style="display:flex; gap:10px;">
                            <a href="{{ route('western') }}" target="_blank" class="btn-primary" style="text-decoration:none; width:auto; padding:8px 16px; font-size:12px; background:linear-gradient(135deg, #f97316, #ea580c); display:inline-flex; align-items:center; gap:6px;">
                                <i class="fas fa-arrow-up-right-from-square"></i> Open Game Window
                            </a>
                            <button onclick="loadWesternSettings(); loadWesternRounds(); loadWesternLedger();" class="btn-primary" style="width:auto; padding:8px 14px; font-size:12px; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fas fa-rotate"></i> Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Row 1: Analytics Counters -->
                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:16px; margin-bottom:24px;">
                        <div class="stat-card blue">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="stat-card-label">Total Bets Collected</span>
                                <div class="stat-card-icon"><i class="fas fa-coins"></i></div>
                            </div>
                            <div class="stat-card-val" id="wv-stat-collected">৳ 0.00</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Side A + Side B Real Player Stakes</div>
                        </div>

                        <div class="stat-card orange">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="stat-card-label">Total Payouts Distributed</span>
                                <div class="stat-card-icon"><i class="fas fa-hand-holding-dollar"></i></div>
                            </div>
                            <div class="stat-card-val" id="wv-stat-payout">৳ 0.00</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Real Cash Wins Paid to Users</div>
                        </div>

                        <div class="stat-card green">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="stat-card-label">House Net Profit</span>
                                <div class="stat-card-icon"><i class="fas fa-vault"></i></div>
                            </div>
                            <div class="stat-card-val" id="wv-stat-profit">৳ 0.00</div>
                            <div style="font-size:11px; color:#34d399; margin-top:4px;"><i class="fas fa-arrow-trend-up"></i> Protected System Revenue</div>
                        </div>

                        <div class="stat-card purple">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="stat-card-label">Active Bot Engine</span>
                                <div class="stat-card-icon"><i class="fas fa-robot"></i></div>
                            </div>
                            <div class="stat-card-val" id="wv-stat-bot-status" style="font-size:20px; text-transform:uppercase;">ACTIVE</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;" id="wv-stat-bot-desc">Triggers when players &lt; 10</div>
                        </div>
                    </div>

                    <!-- Row 2: Engine Config & Sounds -->
                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:20px; margin-bottom:24px;">
                        
                        <!-- Panel: Engine & Win Controls -->
                        <div class="panel" style="margin-bottom:0;">
                            <div class="panel-header">
                                <div class="panel-title"><i class="fas fa-sliders" style="color:var(--accent-orange);"></i> Game Algorithm & Win Controller</div>
                                <span class="badge" style="padding:4px 10px; border-radius:8px; font-size:11px; font-weight:700; background:rgba(249,115,22,0.15); color:var(--accent-orange); border:1px solid rgba(249,115,22,0.3);">1xBet Core</span>
                            </div>
                            <div class="panel-body">
                                <form id="wv-settings-form" onsubmit="saveWesternSettings(event)">
                                    <div class="form-group" style="margin-bottom:14px;">
                                        <label class="form-label" style="font-weight:700;">Algorithm Mode (কন্ট্রোল অ্যালগরিদম)</label>
                                        <select class="form-input" id="wv-control-mode" required style="cursor:pointer; width:100%;">
                                            <option value="house_profit">House Profit Mode (কম টাকার সাইড জিতবে — Admin Safe)</option>
                                            <option value="fixed_percentage">Fixed Win Rate % (কাস্টম উইন রেট অনুযায়ী জিতবে)</option>
                                            <option value="random">100% Random Mode (ন্যাচারাল র‍্যান্ডম আরটিপি)</option>
                                        </select>
                                        <small style="color:var(--text-muted); font-size:11px; display:block; margin-top:4px;">In House Profit mode, the server calculates real stakes on Side A vs Side B and always picks the side with less liability.</small>
                                    </div>

                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
                                        <div class="form-group">
                                            <label class="form-label">Player Win Chance (%)</label>
                                            <input type="number" class="form-input" id="wv-win-chance" min="1" max="100" step="1" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">House Edge (%)</label>
                                            <input type="number" class="form-input" id="wv-house-edge" min="0" max="50" step="0.5" required>
                                        </div>
                                    </div>

                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
                                        <div class="form-group">
                                            <label class="form-label">Min Bet (৳)</label>
                                            <input type="number" class="form-input" id="wv-min-bet" min="1" step="1" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Max Bet (৳)</label>
                                            <input type="number" class="form-input" id="wv-max-bet" min="10" step="10" required>
                                        </div>
                                    </div>

                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
                                        <div class="form-group">
                                            <label class="form-label">Round Duration (Seconds)</label>
                                            <input type="number" class="form-input" id="wv-round-duration" min="5" max="120" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Demo Starting Balance (৳)</label>
                                            <input type="number" class="form-input" id="wv-demo-balance" min="100" step="100" required>
                                        </div>
                                    </div>

                                    <!-- Bot Simulation Configuration -->
                                    <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:10px; padding:14px; margin-top:14px;">
                                        <div style="font-size:12px; font-weight:800; color:var(--accent-cyan); text-transform:uppercase; margin-bottom:10px; display:flex; align-items:center; gap:6px;">
                                            <i class="fas fa-robot"></i> Dynamic Bot Simulation
                                        </div>
                                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:12px;">
                                            <div class="form-group">
                                                <label class="form-label">Bot Status</label>
                                                <select class="form-input" id="wv-bot-status" required>
                                                    <option value="1">Enabled (অটোমেটিক বট সক্রিয়)</option>
                                                    <option value="0">Disabled (বট বন্ধ)</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Trigger Real Players Limit</label>
                                                <input type="number" class="form-input" id="wv-bot-trigger-count" min="1" max="100" required>
                                            </div>
                                        </div>
                                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                                            <div class="form-group">
                                                <label class="form-label">Bot Min Bet (৳)</label>
                                                <input type="number" class="form-input" id="wv-bot-min-bet" min="10" step="10" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Bot Max Bet (৳)</label>
                                                <input type="number" class="form-input" id="wv-bot-max-bet" min="50" step="50" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="margin-top:18px; display:flex; justify-content:flex-end;">
                                        <button type="submit" class="btn-primary" id="btn-save-wv-config" style="width:auto; padding:11px 24px; display:inline-flex; align-items:center; gap:8px;">
                                            <i class="fas fa-floppy-disk"></i> Save Western Vault Settings
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Panel: Sound & Audio Customization -->
                        <div class="panel" style="margin-bottom:0;">
                            <div class="panel-header">
                                <div class="panel-title"><i class="fas fa-music" style="color:var(--accent-indigo);"></i> Sound Effects & Audio Media</div>
                                <span class="badge" style="padding:4px 10px; border-radius:8px; font-size:11px; font-weight:700; background:rgba(99,102,241,0.15); color:var(--accent-indigo);">MP3 / WAV</span>
                            </div>
                            <div class="panel-body">
                                <p style="font-size:12.5px; color:var(--text-secondary); margin-bottom:18px;">
                                    Upload custom Western Vault soundtracks. When uploaded, sounds will automatically play during game ambiance, reel spinning, and big wins.
                                </p>

                                <!-- BG Music -->
                                <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:10px; padding:14px; margin-bottom:14px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                        <label style="font-size:12px; font-weight:700; color:var(--text-primary);"><i class="fas fa-volume-high" style="color:var(--accent-cyan); margin-right:6px;"></i> Background Music (Looping)</label>
                                        <span id="wv-audio-bg-status" style="font-size:11px; color:var(--text-muted);">Default Synth</span>
                                    </div>
                                    <form onsubmit="uploadWesternAudio(event, 'bg_music')" style="display:flex; gap:8px;">
                                        <input type="file" name="audio_file" accept="audio/*" class="form-input" style="flex:1; padding:6px 10px; font-size:12px;" required>
                                        <button type="submit" class="btn-primary" style="width:auto; padding:6px 14px; font-size:12px;">Upload</button>
                                    </form>
                                </div>

                                <!-- Spin Sound -->
                                <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:10px; padding:14px; margin-bottom:14px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                        <label style="font-size:12px; font-weight:700; color:var(--text-primary);"><i class="fas fa-dharmachakra" style="color:var(--accent-gold); margin-right:6px;"></i> Reel Spinning FX</label>
                                        <span id="wv-audio-spin-status" style="font-size:11px; color:var(--text-muted);">Default Ticking</span>
                                    </div>
                                    <form onsubmit="uploadWesternAudio(event, 'spin_sound')" style="display:flex; gap:8px;">
                                        <input type="file" name="audio_file" accept="audio/*" class="form-input" style="flex:1; padding:6px 10px; font-size:12px;" required>
                                        <button type="submit" class="btn-primary" style="width:auto; padding:6px 14px; font-size:12px;">Upload</button>
                                    </form>
                                </div>

                                <!-- Win Sound -->
                                <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:10px; padding:14px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                        <label style="font-size:12px; font-weight:700; color:var(--text-primary);"><i class="fas fa-trophy" style="color:var(--accent-green); margin-right:6px;"></i> Win Celebration FX</label>
                                        <span id="wv-audio-win-status" style="font-size:11px; color:var(--text-muted);">Default Chime</span>
                                    </div>
                                    <form onsubmit="uploadWesternAudio(event, 'win_sound')" style="display:flex; gap:8px;">
                                        <input type="file" name="audio_file" accept="audio/*" class="form-input" style="flex:1; padding:6px 10px; font-size:12px;" required>
                                        <button type="submit" class="btn-primary" style="width:auto; padding:6px 14px; font-size:12px;">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Row 3: Live Round History & Audit -->
                    <div class="panel" style="margin-bottom:24px;">
                        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
                            <div class="panel-title"><i class="fas fa-clock-rotate-left" style="color:var(--accent-gold);"></i> Recent Western Vault Rounds Audit</div>
                            <button onclick="loadWesternRounds()" class="btn-primary" style="width:auto; padding:4px 12px; font-size:12px; display:inline-flex; align-items:center; gap:5px;">
                                <i class="fas fa-rotate"></i> Refresh
                            </button>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ROUND ID</th>
                                        <th>STATUS</th>
                                        <th>REAL BETS (A / B)</th>
                                        <th>BOT BETS (A / B)</th>
                                        <th>WINNER</th>
                                        <th>TOTAL PAYOUT</th>
                                        <th>ADMIN PROFIT</th>
                                        <th>TIME</th>
                                    </tr>
                                </thead>
                                <tbody id="wv-rounds-tbody">
                                    <tr class="loading-row">
                                        <td colspan="8"><i class="fas fa-spinner fa-spin"></i> Loading rounds...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Row 4: Financial Transactions Ledger -->
                    <div class="panel">
                        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
                            <div class="panel-title"><i class="fas fa-receipt" style="color:var(--accent-teal);"></i> Western Vault Balance & Ledger Logs</div>
                            <button onclick="loadWesternLedger()" class="btn-primary" style="width:auto; padding:4px 12px; font-size:12px; display:inline-flex; align-items:center; gap:5px;">
                                <i class="fas fa-rotate"></i> Refresh Ledger
                            </button>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>USER</th>
                                        <th>TYPE</th>
                                        <th>AMOUNT</th>
                                        <th>OPENING BAL</th>
                                        <th>CLOSING BAL</th>
                                        <th>DESCRIPTION</th>
                                        <th>DATE / TIME</th>
                                    </tr>
                                </thead>
                                <tbody id="wv-ledger-tbody">
                                    <tr class="loading-row">
                                        <td colspan="7"><i class="fas fa-spinner fa-spin"></i> Loading ledger records...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- ========== TAB: BOXING KING (RING CHAMPION) ========== -->
                <div class="tab-pane" id="tab-boxing-king">
                    <div class="page-header">
                        <div class="page-header-title-group">
                            <h2>Boxing King (Ring Champion)™ Control Module</h2>
                            <p>Manage 5x3 reel slot math algorithms, House Profit protections, Fire-Burst animations, audio FX, and user spin audits.</p>
                        </div>
                        <div style="display:flex; gap:10px;">
                            <a href="{{ route('boxing-king') }}" target="_blank" class="btn-primary" style="width:auto; padding:8px 16px; font-size:12.5px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                                <i class="fas fa-gamepad"></i> Launch Game
                            </a>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="stats-grid">
                        <div class="stat-card blue">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="stat-card-label">Total Real Bets</span>
                                <div class="stat-card-icon"><i class="fas fa-coins"></i></div>
                            </div>
                            <div class="stat-card-val" id="bk-stat-collected">৳ 0.00</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Player Real Stakes Volume</div>
                        </div>

                        <div class="stat-card orange">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="stat-card-label">Total Payouts Distributed</span>
                                <div class="stat-card-icon"><i class="fas fa-trophy"></i></div>
                            </div>
                            <div class="stat-card-val" id="bk-stat-payout">৳ 0.00</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Real Cash Wins Paid to Users</div>
                        </div>

                        <div class="stat-card green">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="stat-card-label">House Net Profit</span>
                                <div class="stat-card-icon"><i class="fas fa-sack-dollar"></i></div>
                            </div>
                            <div class="stat-card-val" id="bk-stat-profit">৳ 0.00</div>
                            <div style="font-size:11px; color:#34d399; margin-top:4px;"><i class="fas fa-arrow-trend-up"></i> Protected System Revenue</div>
                        </div>

                        <div class="stat-card purple">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="stat-card-label">Algorithm Status</span>
                                <div class="stat-card-icon"><i class="fas fa-fire"></i></div>
                            </div>
                            <div class="stat-card-val" id="bk-stat-mode" style="font-size:18px; text-transform:uppercase;">HOUSE PROFIT</div>
                            <div style="font-size:11px; color:var(--text-muted); margin-top:4px;" id="bk-stat-winrate">30% Target Win Rate</div>
                        </div>
                    </div>

                    <!-- Config & Media Row -->
                    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:20px; margin-bottom:24px;">
                        
                        <!-- Panel: Engine & Win Controls -->
                        <div class="panel" style="margin-bottom:0;">
                            <div class="panel-header">
                                <div class="panel-title"><i class="fas fa-sliders" style="color:var(--accent-gold);"></i> Game Algorithm & Win/Loss Control</div>
                                <span class="badge" style="padding:4px 10px; border-radius:8px; font-size:11px; font-weight:700; background:rgba(239,68,68,0.15); color:#ef4444; border:1px solid rgba(239,68,68,0.3);">RNG Safe</span>
                            </div>
                            <div class="panel-body">
                                <form id="bk-settings-form" onsubmit="saveBoxingSettings(event)">
                                    <div class="form-group" style="margin-bottom:14px;">
                                        <label class="form-label" style="font-weight:700;">Algorithm Mode (অ্যালগরিদম মোড)</label>
                                        <select class="form-input" id="bk-control-mode" required style="cursor:pointer; width:100%;">
                                            <option value="house_profit">House Profit Mode (এডমিন ১০০% সেফ ও লাভজনক)</option>
                                            <option value="fixed_percentage">Fixed Percentage (নিচের টার্গেট উইন রেট অনুযায়ী)</option>
                                            <option value="random">100% Random Mode (ন্যাচারাল আরটিপি)</option>
                                        </select>
                                    </div>

                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
                                        <div class="form-group">
                                            <label class="form-label">User Win Chance Target (%)</label>
                                            <input type="number" class="form-input" id="bk-win-chance" min="1" max="99" step="1" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Demo Spin Limit (ফ্রি ট্রায়াল লিমিট)</label>
                                            <input type="number" class="form-input" id="bk-demo-limit" min="1" max="50" step="1" required>
                                        </div>
                                    </div>

                                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
                                        <div class="form-group">
                                            <label class="form-label">Min Bet (৳)</label>
                                            <input type="number" class="form-input" id="bk-min-bet" min="0.5" step="0.5" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Max Bet (৳)</label>
                                            <input type="number" class="form-input" id="bk-max-bet" min="10" step="10" required>
                                        </div>
                                    </div>

                                    <div style="margin-top:18px; display:flex; justify-content:flex-end;">
                                        <button type="submit" class="btn-primary" id="btn-save-bk-config" style="width:auto; padding:11px 24px; display:inline-flex; align-items:center; gap:8px;">
                                            <i class="fas fa-floppy-disk"></i> Save Boxing King Settings
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Panel: Sound & Audio Customization -->
                        <div class="panel" style="margin-bottom:0;">
                            <div class="panel-header">
                                <div class="panel-title"><i class="fas fa-music" style="color:var(--accent-cyan);"></i> Sound Effects & Audio FX</div>
                                <span class="badge" style="padding:4px 10px; border-radius:8px; font-size:11px; font-weight:700; background:rgba(99,102,241,0.15); color:var(--accent-indigo);">MP3 / WAV</span>
                            </div>
                            <div class="panel-body">
                                <p style="font-size:12.5px; color:var(--text-secondary); margin-bottom:18px;">
                                    Upload custom sound effects for Boxing King arena ambiance, reel spin, knockout wins, and Fire-Burst flame combo effects.
                                </p>

                                <!-- BG Music -->
                                <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:10px; padding:12px; margin-bottom:12px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                        <label style="font-size:12px; font-weight:700; color:var(--text-primary);"><i class="fas fa-volume-high" style="color:var(--accent-cyan); margin-right:6px;"></i> Background Arena Music</label>
                                        <span id="bk-audio-bg-status" style="font-size:11px; color:var(--text-muted);">Default</span>
                                    </div>
                                    <form onsubmit="uploadBoxingAudio(event, 'bg_music')" style="display:flex; gap:8px;">
                                        <input type="file" name="audio_file" accept="audio/*" class="form-input" style="flex:1; padding:6px 10px; font-size:12px;" required>
                                        <button type="submit" class="btn-primary" style="width:auto; padding:6px 14px; font-size:12px;">Upload</button>
                                    </form>
                                </div>

                                <!-- Spin Sound -->
                                <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:10px; padding:12px; margin-bottom:12px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                        <label style="font-size:12px; font-weight:700; color:var(--text-primary);"><i class="fas fa-dharmachakra" style="color:var(--accent-gold); margin-right:6px;"></i> Reel Spinning FX</label>
                                        <span id="bk-audio-spin-status" style="font-size:11px; color:var(--text-muted);">Default</span>
                                    </div>
                                    <form onsubmit="uploadBoxingAudio(event, 'spin_sound')" style="display:flex; gap:8px;">
                                        <input type="file" name="audio_file" accept="audio/*" class="form-input" style="flex:1; padding:6px 10px; font-size:12px;" required>
                                        <button type="submit" class="btn-primary" style="width:auto; padding:6px 14px; font-size:12px;">Upload</button>
                                    </form>
                                </div>

                                <!-- Win Sound -->
                                <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:10px; padding:12px; margin-bottom:12px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                        <label style="font-size:12px; font-weight:700; color:var(--text-primary);"><i class="fas fa-trophy" style="color:var(--accent-green); margin-right:6px;"></i> Win / Knockout FX</label>
                                        <span id="bk-audio-win-status" style="font-size:11px; color:var(--text-muted);">Default</span>
                                    </div>
                                    <form onsubmit="uploadBoxingAudio(event, 'win_sound')" style="display:flex; gap:8px;">
                                        <input type="file" name="audio_file" accept="audio/*" class="form-input" style="flex:1; padding:6px 10px; font-size:12px;" required>
                                        <button type="submit" class="btn-primary" style="width:auto; padding:6px 14px; font-size:12px;">Upload</button>
                                    </form>
                                </div>

                                <!-- Fire Burn Sound -->
                                <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-subtle); border-radius:10px; padding:12px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                        <label style="font-size:12px; font-weight:700; color:var(--text-primary);"><i class="fas fa-fire" style="color:var(--accent-orange); margin-right:6px;"></i> Fire-Burst & Combo Blast FX</label>
                                        <span id="bk-audio-fire-status" style="font-size:11px; color:var(--text-muted);">Default</span>
                                    </div>
                                    <form onsubmit="uploadBoxingAudio(event, 'fire_burn_sound')" style="display:flex; gap:8px;">
                                        <input type="file" name="audio_file" accept="audio/*" class="form-input" style="flex:1; padding:6px 10px; font-size:12px;" required>
                                        <button type="submit" class="btn-primary" style="width:auto; padding:6px 14px; font-size:12px;">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Row 3: Live Spins Audit History -->
                    <div class="panel">
                        <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center;">
                            <div class="panel-title"><i class="fas fa-clock-rotate-left" style="color:var(--accent-indigo);"></i> Recent Spins & Player Audit Ledger</div>
                            <button onclick="loadBoxingSpins()" class="btn-primary" style="width:auto; padding:4px 12px; font-size:12px; display:inline-flex; align-items:center; gap:5px;">
                                <i class="fas fa-rotate"></i> Refresh
                            </button>
                        </div>
                        <div class="table-wrap">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>SPIN ID</th>
                                        <th>PLAYER</th>
                                        <th>MODE</th>
                                        <th>BET AMOUNT</th>
                                        <th>WIN AMOUNT</th>
                                        <th>ADMIN PROFIT</th>
                                        <th>OUTCOME</th>
                                        <th>TIME</th>
                                    </tr>
                                </thead>
                                <tbody id="bk-spins-tbody">
                                    <tr class="loading-row">
                                        <td colspan="8"><i class="fas fa-spinner fa-spin"></i> Loading spins...</td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
                @endif
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

        // Mobile Sidebar Drawer Controller
        function toggleMobileSidebar(show) {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            if (!sidebar || !backdrop) return;
            const isOpen = (typeof show === 'boolean') ? show : !sidebar.classList.contains('open');
            if (isOpen) {
                sidebar.classList.add('open');
                backdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.remove('open');
                backdrop.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        // Live Digital Clock in Topbar
        function updateLiveClock() {
            const clockEl = document.getElementById('live-topbar-clock');
            if (!clockEl) return;
            const now = new Date();
            clockEl.textContent = now.toLocaleTimeString('en-US', { hour12: true, hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        setInterval(updateLiveClock, 1000);
        updateLiveClock();

        // Tab switcher
        function switchTab(tabId, btn) {
            // Automatically close mobile sidebar when navigating on mobile
            toggleMobileSidebar(false);

            document.querySelectorAll('.tab-pane').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.sidebar-nav-link').forEach(l => l.classList.remove('active'));
            document.getElementById('tab-' + tabId).classList.add('active');
            if (btn) btn.classList.add('active');

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
                olympus: 'Olympus Slot Game <span>/ Management & Engine Controls</span>',
                western: 'Western Vault™ <span>/ Management & Engine Controls</span>',
                'boxing-king': 'Boxing King™ <span>/ Management & Engine Controls</span>',
            };
            document.getElementById('topbar-page-title').innerHTML = titles[tabId] || tabId;

            // Stop live monitor first (will be started if active)
            stopLiveMonitor();

            // Load olympus settings when olympus tab is opened
            if (tabId === 'olympus') {
                loadOlympusSettings();
                loadOlympusRounds();
                loadOlympusAuditLogs();
            }

            // Load western vault settings when western tab is opened
            if (tabId === 'western') {
                loadWesternSettings();
                loadWesternRounds();
                loadWesternLedger();
            }

            // Load boxing king settings when boxing-king tab is opened
            if (tabId === 'boxing-king') {
                loadBoxingSettings();
                loadBoxingSpins();
            }

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

        function toggleAdminMobileChat(showChat) {
            const sidebarPane = document.getElementById('admin-chat-sidebar-pane');
            const windowPane = document.getElementById('admin-chat-window');
            if (!sidebarPane || !windowPane) return;
            
            if (window.innerWidth <= 768) {
                if (showChat) {
                    sidebarPane.style.display = 'none';
                    windowPane.style.display = 'flex';
                } else {
                    sidebarPane.style.display = 'flex';
                    windowPane.style.display = 'none';
                    activeChatUserId = null;
                }
            } else {
                sidebarPane.style.display = 'flex';
                windowPane.style.display = 'flex';
            }
        }

        function openSupportChat(userId) {
            activeChatUserId = userId;
            document.getElementById('active-chat-user-id').value = userId;
            
            // Switch view on mobile
            toggleAdminMobileChat(true);

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

        // =========================================================
        // OLYMPUS SLOT GAME MANAGEMENT JS
        // =========================================================
        let currentOlympusConfig = null;

        function loadOlympusSettings() {
            fetch('{{ route("admin.olympus.settings.get") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.config) {
                    currentOlympusConfig = data.config;
                    const c = data.config;

                    // Status badge
                    const badge = document.getElementById('olympus-config-status-badge');
                    if (badge) {
                        badge.textContent = c.game_status.toUpperCase();
                        badge.style.background = c.game_status === 'active' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(239, 68, 68, 0.2)';
                        badge.style.color = c.game_status === 'active' ? '#4ade80' : '#f87171';
                    }

                    // Form Fields
                    document.getElementById('olympus-game-status').value = c.game_status || 'active';
                    document.getElementById('olympus-demo-enabled').value = c.demo_enabled ? '1' : '0';
                    document.getElementById('olympus-real-enabled').value = c.real_enabled ? '1' : '0';
                    document.getElementById('olympus-login-popup-enabled').value = c.login_popup_enabled ? '1' : '0';

                    document.getElementById('olympus-demo-play-limit').value = c.demo_play_limit !== undefined ? c.demo_play_limit : 1;
                    document.getElementById('olympus-demo-starting-balance').value = c.demo_starting_balance || 10000;
                    document.getElementById('olympus-volatility').value = c.volatility || 'high';

                    document.getElementById('olympus-min-bet').value = c.min_bet || 1.00;
                    document.getElementById('olympus-max-bet').value = c.max_bet || 5000.00;
                    document.getElementById('olympus-default-bet').value = c.default_bet || 2.00;
                    document.getElementById('olympus-rtp-percentage').value = c.rtp_percentage || 96.50;

                    document.getElementById('olympus-buy-spins-mult').value = c.buy_free_spins_multiplier || 100;
                    document.getElementById('olympus-double-chance-pct').value = c.double_chance_ante_pct || 25;

                    document.getElementById('olympus-req-scatters').value = c.required_scatters_for_free_spins || 4;
                    document.getElementById('olympus-free-spins-count').value = c.free_spins_count || 10;
                }
            })
            .catch(err => console.error('Failed to load Olympus settings:', err));
        }

        function saveOlympusConfig(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-save-olympus-config');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            const payload = {
                game_status: document.getElementById('olympus-game-status').value,
                demo_enabled: document.getElementById('olympus-demo-enabled').value === '1',
                real_enabled: document.getElementById('olympus-real-enabled').value === '1',
                login_popup_enabled: document.getElementById('olympus-login-popup-enabled').value === '1',
                demo_play_limit: parseInt(document.getElementById('olympus-demo-play-limit').value),
                demo_starting_balance: parseFloat(document.getElementById('olympus-demo-starting-balance').value),
                volatility: document.getElementById('olympus-volatility').value,
                min_bet: parseFloat(document.getElementById('olympus-min-bet').value),
                max_bet: parseFloat(document.getElementById('olympus-max-bet').value),
                default_bet: parseFloat(document.getElementById('olympus-default-bet').value),
                rtp_percentage: parseFloat(document.getElementById('olympus-rtp-percentage').value),
                buy_free_spins_multiplier: parseFloat(document.getElementById('olympus-buy-spins-mult').value),
                double_chance_ante_pct: parseFloat(document.getElementById('olympus-double-chance-pct').value),
                required_scatters_for_free_spins: parseInt(document.getElementById('olympus-req-scatters').value),
                free_spins_count: parseInt(document.getElementById('olympus-free-spins-count').value),
                max_multiplier: currentOlympusConfig ? currentOlympusConfig.max_multiplier : 500,
            };

            fetch('{{ route("admin.olympus.settings.save") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-floppy-disk"></i> Save Olympus Configuration';

                if (data.success) {
                    showAdminToast('✅ Olympus Slot Configuration saved successfully!', 'success');
                    loadOlympusSettings();
                    loadOlympusAuditLogs();
                } else {
                    const err = (data.errors && data.errors.join(', ')) || data.message || 'Validation error.';
                    showAdminToast('Error: ' + err, 'error');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-floppy-disk"></i> Save Olympus Configuration';
                showAdminToast('Failed to save configuration.', 'error');
            });
        }

        function loadOlympusRounds(page = 1, mode = '') {
            const tbody = document.getElementById('olympus-rounds-tbody');
            if (!tbody) return;
            tbody.innerHTML = '<tr class="loading-row"><td colspan="9"><i class="fas fa-spinner fa-spin"></i> Loading spins...</td></tr>';

            let url = '{{ route("admin.olympus.rounds") }}?page=' + page;
            if (mode) url += '&mode=' + encodeURIComponent(mode);

            fetch(url, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.rounds && data.rounds.data) {
                    const rounds = data.rounds.data;
                    if (rounds.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; padding:30px; color:var(--text-muted);">No spin rounds recorded yet.</td></tr>';
                        return;
                    }

                    tbody.innerHTML = rounds.map(r => {
                        const isDemo = r.mode === 'demo';
                        const isWin = r.final_win > 0;
                        const netProfit = r.final_win - r.total_deducted;
                        const profitClass = netProfit >= 0 ? 'text-green' : 'text-red';
                        const profitSign = netProfit > 0 ? '+' : '';

                        return `
                            <tr>
                                <td style="font-family:'Roboto Mono',monospace; font-size:12px; color:var(--text-primary); font-weight:700;">${r.round_id}</td>
                                <td>
                                    <span style="font-size:10.5px; font-weight:800; padding:2px 8px; border-radius:12px; text-transform:uppercase; background:${isDemo ? 'rgba(148, 163, 184, 0.15)' : 'rgba(56, 239, 125, 0.15)'}; color:${isDemo ? '#94a3b8' : '#38ef7d'}; border:1px solid ${isDemo ? 'rgba(148,163,184,0.3)' : 'rgba(56,239,125,0.3)'};">
                                        ${r.mode}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight:600; font-size:12.5px; color:#fff;">${r.user ? r.user.name : (isDemo ? 'Guest (Demo)' : 'User #' + r.user_id)}</div>
                                    <div style="font-size:10px; color:var(--text-muted);">${r.user ? r.user.email : ''}</div>
                                </td>
                                <td style="font-family:'Roboto Mono',monospace; font-weight:700;">${parseFloat(r.bet_amount).toFixed(2)}</td>
                                <td style="font-family:'Roboto Mono',monospace; font-weight:700; color:var(--text-secondary);">${parseFloat(r.total_deducted).toFixed(2)}</td>
                                <td>
                                    ${r.total_multiplier > 0 ? `<span style="background:rgba(255,190,26,0.15); color:#ffbe1a; padding:2px 6px; border-radius:4px; font-weight:800; font-size:11px;">${r.total_multiplier}X</span>` : '<span style="color:var(--text-muted);">-</span>'}
                                </td>
                                <td style="font-family:'Roboto Mono',monospace; font-weight:700; color:${isWin ? '#4ade80' : 'var(--text-muted)'};">
                                    ${parseFloat(r.final_win).toFixed(2)}
                                </td>
                                <td style="font-family:'Roboto Mono',monospace; font-weight:700; color:${netProfit >= 0 ? '#4ade80' : '#f87171'};">
                                    ${profitSign}${netProfit.toFixed(2)}
                                </td>
                                <td style="font-size:11px; color:var(--text-muted);">
                                    ${new Date(r.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', second:'2-digit'})}
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
            })
            .catch(err => console.error('Failed to load Olympus rounds:', err));
        }

        function loadOlympusAuditLogs() {
            const tbody = document.getElementById('olympus-audit-tbody');
            if (!tbody) return;
            tbody.innerHTML = '<tr class="loading-row"><td colspan="6"><i class="fas fa-spinner fa-spin"></i> Loading audit logs...</td></tr>';

            fetch('{{ route("admin.olympus.audit-logs") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.logs) {
                    const logs = data.logs;
                    if (logs.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center; padding:30px; color:var(--text-muted);">No configuration changes recorded yet.</td></tr>';
                        return;
                    }

                    tbody.innerHTML = logs.map(l => `
                        <tr>
                            <td style="font-weight:600; color:#fff;">${l.admin ? l.admin.name : 'System Admin'}</td>
                            <td style="font-family:'Roboto Mono',monospace; font-size:11.5px; color:var(--accent-blue);">${l.setting_key}</td>
                            <td style="font-size:11.5px; color:#f87171; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${l.old_value || 'null'}</td>
                            <td style="font-size:11.5px; color:#4ade80; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${l.new_value || 'null'}</td>
                            <td style="font-size:11px; color:var(--text-muted);">${l.ip_address || '-'}</td>
                            <td style="font-size:11px; color:var(--text-muted);">${new Date(l.created_at).toLocaleString()}</td>
                        </tr>
                    `).join('');
                }
            })
            .catch(err => console.error('Failed to load Olympus audit logs:', err));
        }

        /* ==================== WESTERN VAULT FUNCTIONS ==================== */
        let currentWesternSettings = null;

        function loadWesternSettings() {
            fetch('{{ route("admin.western.index") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.settings) {
                    const s = data.settings;
                    currentWesternSettings = s;

                    document.getElementById('wv-control-mode').value = s.control_mode || 'house_profit';
                    document.getElementById('wv-win-chance').value = s.win_chance_percentage || 35;
                    document.getElementById('wv-house-edge').value = s.house_edge_percent || 5.00;
                    document.getElementById('wv-min-bet').value = s.min_bet || 10;
                    document.getElementById('wv-max-bet').value = s.max_bet || 50000;
                    document.getElementById('wv-round-duration').value = s.round_duration || 25;
                    document.getElementById('wv-demo-balance').value = s.demo_initial_balance || 10000;

                    document.getElementById('wv-bot-status').value = s.bot_status ? '1' : '0';
                    document.getElementById('wv-bot-trigger-count').value = s.bot_trigger_player_count || 10;
                    document.getElementById('wv-bot-min-bet').value = s.bot_min_bet || 50;
                    document.getElementById('wv-bot-max-bet').value = s.bot_max_bet || 2000;

                    // Update stats
                    document.getElementById('wv-stat-collected').textContent = '৳ ' + parseFloat(data.totalCollected || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    document.getElementById('wv-stat-payout').textContent = '৳ ' + parseFloat(data.totalPaidOut || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    document.getElementById('wv-stat-profit').textContent = '৳ ' + parseFloat(data.netProfit || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    document.getElementById('wv-stat-bot-status').textContent = s.bot_status ? 'ACTIVE' : 'DISABLED';
                    document.getElementById('wv-stat-bot-status').style.color = s.bot_status ? '#34d399' : '#f87171';
                    document.getElementById('wv-stat-bot-desc').textContent = 'Triggers when players < ' + s.bot_trigger_player_count;

                    // Audio status
                    if (s.bg_music) {
                        document.getElementById('wv-audio-bg-status').innerHTML = '<span style="color:#34d399;"><i class="fas fa-check-circle"></i> Custom File Uploaded</span>';
                    }
                    if (s.spin_sound) {
                        document.getElementById('wv-audio-spin-status').innerHTML = '<span style="color:#34d399;"><i class="fas fa-check-circle"></i> Custom File Uploaded</span>';
                    }
                    if (s.win_sound) {
                        document.getElementById('wv-audio-win-status').innerHTML = '<span style="color:#34d399;"><i class="fas fa-check-circle"></i> Custom File Uploaded</span>';
                    }
                }
            })
            .catch(err => console.error('Failed to load Western Vault settings:', err));
        }

        function saveWesternSettings(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-save-wv-config');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            const payload = {
                control_mode: document.getElementById('wv-control-mode').value,
                win_chance_percentage: parseInt(document.getElementById('wv-win-chance').value),
                house_edge_percent: parseFloat(document.getElementById('wv-house-edge').value),
                min_bet: parseFloat(document.getElementById('wv-min-bet').value),
                max_bet: parseFloat(document.getElementById('wv-max-bet').value),
                round_duration: parseInt(document.getElementById('wv-round-duration').value),
                demo_initial_balance: parseFloat(document.getElementById('wv-demo-balance').value),
                bot_status: document.getElementById('wv-bot-status').value === '1',
                bot_trigger_player_count: parseInt(document.getElementById('wv-bot-trigger-count').value),
                bot_min_bet: parseFloat(document.getElementById('wv-bot-min-bet').value),
                bot_max_bet: parseFloat(document.getElementById('wv-bot-max-bet').value),
            };

            fetch('{{ route("admin.western.settings") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-floppy-disk"></i> Save Western Vault Settings';

                if (data.success) {
                    showAdminToast('✅ Western Vault configuration updated successfully!', 'success');
                    loadWesternSettings();
                } else {
                    showAdminToast('Error: ' + (data.message || 'Could not save settings.'), 'error');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-floppy-disk"></i> Save Western Vault Settings';
                showAdminToast('Failed to save Western Vault settings.', 'error');
            });
        }

        function uploadWesternAudio(e, audioType) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const fileInput = form.querySelector('input[type="file"]');

            if (!fileInput.files || !fileInput.files[0]) {
                showAdminToast('Please choose an audio file first.', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('audio_type', audioType);
            formData.append('audio_file', fileInput.files[0]);

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch('{{ route("admin.western.audio") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Upload';

                if (data.success) {
                    showAdminToast('✅ Audio file uploaded successfully!', 'success');
                    loadWesternSettings();
                    form.reset();
                } else {
                    showAdminToast('Audio upload failed: ' + (data.message || 'Error'), 'error');
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Upload';
                showAdminToast('Upload failed due to network or server error.', 'error');
            });
        }

        function loadWesternRounds() {
            const tbody = document.getElementById('wv-rounds-tbody');
            if (!tbody) return;
            tbody.innerHTML = '<tr class="loading-row"><td colspan="8"><i class="fas fa-spinner fa-spin"></i> Loading rounds...</td></tr>';

            fetch('{{ route("admin.western.index") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.recentRounds) {
                    const rounds = data.recentRounds;
                    if (rounds.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:30px; color:var(--text-muted);">No Western Vault rounds recorded yet.</td></tr>';
                        return;
                    }

                    tbody.innerHTML = rounds.map(r => {
                        const totalReal = parseFloat(r.real_bets_total_a || 0) + parseFloat(r.real_bets_total_b || 0);
                        const totalBot = parseFloat(r.bot_bets_total_a || 0) + parseFloat(r.bot_bets_total_b || 0);
                        const payout = parseFloat(r.total_payout || 0);
                        const profit = parseFloat(r.admin_profit || 0);
                        const isProfit = profit >= 0;

                        return `
                            <tr>
                                <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:var(--accent-orange);">${r.round_id}</td>
                                <td>
                                    <span style="font-size:10px; font-weight:800; padding:2px 8px; border-radius:10px; text-transform:uppercase; background:${r.status === 'completed' ? 'rgba(16, 185, 129, 0.15)' : 'rgba(249, 115, 22, 0.15)'}; color:${r.status === 'completed' ? '#34d399' : '#fb923c'};">
                                        ${r.status}
                                    </span>
                                </td>
                                <td>
                                    <span style="font-family:'JetBrains Mono',monospace; font-size:11.5px; color:#60a5fa;">A: ৳${parseFloat(r.real_bets_total_a || 0).toFixed(2)}</span> / 
                                    <span style="font-family:'JetBrains Mono',monospace; font-size:11.5px; color:#f43f5e;">B: ৳${parseFloat(r.real_bets_total_b || 0).toFixed(2)}</span>
                                </td>
                                <td>
                                    <span style="font-family:'JetBrains Mono',monospace; font-size:11.5px; color:var(--text-muted);">A: ৳${parseFloat(r.bot_bets_total_a || 0).toFixed(2)}</span> / 
                                    <span style="font-family:'JetBrains Mono',monospace; font-size:11.5px; color:var(--text-muted);">B: ৳${parseFloat(r.bot_bets_total_b || 0).toFixed(2)}</span>
                                </td>
                                <td>
                                    ${r.winning_side ? `<span style="font-weight:800; font-size:11.5px; color:${r.winning_side === 'side_a' ? '#60a5fa' : '#f43f5e'}; text-transform:uppercase;">${r.winning_side.replace('_', ' ')}</span>` : '<span style="color:var(--text-muted);">-</span>'}
                                </td>
                                <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:#fca5a5;">৳ ${payout.toFixed(2)}</td>
                                <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:${isProfit ? '#34d399' : '#f87171'};">
                                    ${isProfit ? '+' : ''}৳ ${profit.toFixed(2)}
                                </td>
                                <td style="font-size:11px; color:var(--text-muted);">
                                    ${new Date(r.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', second:'2-digit'})}
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
            })
            .catch(err => console.error('Failed to load Western rounds:', err));
        }

        function loadWesternLedger() {
            const tbody = document.getElementById('wv-ledger-tbody');
            if (!tbody) return;
            tbody.innerHTML = '<tr class="loading-row"><td colspan="7"><i class="fas fa-spinner fa-spin"></i> Loading ledger records...</td></tr>';

            fetch('{{ route("admin.western.ledger") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.transactions && data.transactions.data) {
                    const txs = data.transactions.data;
                    if (txs.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:var(--text-muted);">No Western Vault transaction records found.</td></tr>';
                        return;
                    }

                    tbody.innerHTML = txs.map(t => {
                        const isWin = t.type === 'win_payout';
                        const sign = isWin ? '+' : '-';
                        const colorClass = isWin ? '#34d399' : '#fca5a5';

                        return `
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#fff; font-size:12.5px;">${t.user ? t.user.name : 'User #' + t.user_id}</div>
                                    <div style="font-size:10.5px; color:var(--text-muted);">${t.user ? t.user.email : ''}</div>
                                </td>
                                <td>
                                    <span style="font-size:10px; font-weight:800; padding:2px 8px; border-radius:10px; text-transform:uppercase; background:${isWin ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)'}; color:${colorClass};">
                                        ${t.type.replace('_', ' ')}
                                    </span>
                                </td>
                                <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:${colorClass};">
                                    ${sign}৳ ${parseFloat(t.amount).toFixed(2)}
                                </td>
                                <td style="font-family:'JetBrains Mono',monospace; color:var(--text-secondary); font-size:12px;">৳ ${parseFloat(t.opening_balance).toFixed(2)}</td>
                                <td style="font-family:'JetBrains Mono',monospace; color:#fff; font-weight:700; font-size:12px;">৳ ${parseFloat(t.closing_balance).toFixed(2)}</td>
                                <td style="font-size:11.5px; color:var(--text-secondary); max-width:240px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${t.description}</td>
                                <td style="font-size:11px; color:var(--text-muted);">${new Date(t.created_at).toLocaleString()}</td>
                            </tr>
                        `;
                    }).join('');
                }
            })
            .catch(err => console.error('Failed to load Western ledger:', err));
        }

        /* ==================== BOXING KING FUNCTIONS ==================== */
        let currentBoxingSettings = null;

        function loadBoxingSettings() {
            fetch('{{ route("admin.boxing.index") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.settings) {
                    const s = data.settings;
                    currentBoxingSettings = s;

                    document.getElementById('bk-control-mode').value = s.control_mode || 'house_profit';
                    document.getElementById('bk-win-chance').value = s.win_chance_percentage || 30;
                    document.getElementById('bk-demo-limit').value = s.demo_spin_limit || 3;
                    document.getElementById('bk-min-bet').value = s.min_bet || 3;
                    document.getElementById('bk-max-bet').value = s.max_bet || 10000;

                    // Update stats
                    document.getElementById('bk-stat-collected').textContent = '৳ ' + parseFloat(data.totalBets || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    document.getElementById('bk-stat-payout').textContent = '৳ ' + parseFloat(data.totalPayout || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    document.getElementById('bk-stat-profit').textContent = '৳ ' + parseFloat(data.adminProfit || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    document.getElementById('bk-stat-mode').textContent = (s.control_mode || 'house_profit').replace('_', ' ').toUpperCase();
                    document.getElementById('bk-stat-winrate').textContent = (s.win_chance_percentage || 30) + '% Target Win Rate';

                    // Audio status
                    if (s.bg_music) {
                        document.getElementById('bk-audio-bg-status').innerHTML = '<span style="color:#34d399;"><i class="fas fa-check-circle"></i> Custom Audio</span>';
                    }
                    if (s.spin_sound) {
                        document.getElementById('bk-audio-spin-status').innerHTML = '<span style="color:#34d399;"><i class="fas fa-check-circle"></i> Custom Audio</span>';
                    }
                    if (s.win_sound) {
                        document.getElementById('bk-audio-win-status').innerHTML = '<span style="color:#34d399;"><i class="fas fa-check-circle"></i> Custom Audio</span>';
                    }
                    if (s.fire_burn_sound) {
                        document.getElementById('bk-audio-fire-status').innerHTML = '<span style="color:#34d399;"><i class="fas fa-check-circle"></i> Custom Audio</span>';
                    }
                }
            })
            .catch(err => console.error('Failed to load Boxing King settings:', err));
        }

        function saveBoxingSettings(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-save-bk-config');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

            const payload = {
                control_mode: document.getElementById('bk-control-mode').value,
                win_chance_percentage: parseInt(document.getElementById('bk-win-chance').value),
                demo_spin_limit: parseInt(document.getElementById('bk-demo-limit').value),
                min_bet: parseFloat(document.getElementById('bk-min-bet').value),
                max_bet: parseFloat(document.getElementById('bk-max-bet').value),
            };

            fetch('{{ route("admin.boxing.settings") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-floppy-disk"></i> Save Boxing King Settings';

                if (data.success) {
                    showAdminToast('✅ Boxing King configuration updated successfully!', 'success');
                    loadBoxingSettings();
                } else {
                    showAdminToast('Error: ' + (data.message || 'Could not save settings.'), 'error');
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-floppy-disk"></i> Save Boxing King Settings';
                showAdminToast('Failed to save Boxing King settings.', 'error');
            });
        }

        function uploadBoxingAudio(e, audioType) {
            e.preventDefault();
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const fileInput = form.querySelector('input[type="file"]');

            if (!fileInput.files || !fileInput.files[0]) {
                showAdminToast('Please choose an audio file first.', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('audio_type', audioType);
            formData.append('audio_file', fileInput.files[0]);

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            fetch('{{ route("admin.boxing.audio") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Upload';

                if (data.success) {
                    showAdminToast('✅ Audio file uploaded successfully!', 'success');
                    loadBoxingSettings();
                    form.reset();
                } else {
                    showAdminToast('Audio upload failed: ' + (data.message || 'Error'), 'error');
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Upload';
                showAdminToast('Upload failed due to network or server error.', 'error');
            });
        }

        function loadBoxingSpins() {
            const tbody = document.getElementById('bk-spins-tbody');
            if (!tbody) return;
            tbody.innerHTML = '<tr class="loading-row"><td colspan="8"><i class="fas fa-spinner fa-spin"></i> Loading spins...</td></tr>';

            fetch('{{ route("admin.boxing.spins") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.spins && data.spins.data) {
                    const spins = data.spins.data;
                    if (spins.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:30px; color:var(--text-muted);">No Boxing King spins recorded yet.</td></tr>';
                        return;
                    }

                    tbody.innerHTML = spins.map(s => {
                        const isWin = s.is_win || parseFloat(s.win_amount) > 0;
                        const profit = parseFloat(s.admin_profit || 0);
                        const isProfit = profit >= 0;

                        return `
                            <tr>
                                <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:var(--accent-gold);">#${s.id}</td>
                                <td>
                                    <div style="font-weight:700; color:#fff; font-size:12.5px;">${s.user ? s.user.name : (s.is_demo ? 'Demo Player' : 'Guest')}</div>
                                    <div style="font-size:10.5px; color:var(--text-muted);">${s.user ? s.user.email : ''}</div>
                                </td>
                                <td>
                                    <span style="font-size:10px; font-weight:800; padding:2px 8px; border-radius:10px; text-transform:uppercase; background:${s.is_demo ? 'rgba(251,191,36,0.15)' : 'rgba(16,185,129,0.15)'}; color:${s.is_demo ? '#fbbf24' : '#34d399'};">
                                        ${s.is_demo ? 'DEMO' : 'REAL'}
                                    </span>
                                </td>
                                <td style="font-family:'JetBrains Mono',monospace; font-size:12px; color:#fff;">৳ ${parseFloat(s.bet_amount).toFixed(2)}</td>
                                <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:${isWin ? '#34d399' : 'var(--text-muted)'};">
                                    ৳ ${parseFloat(s.win_amount).toFixed(2)}
                                </td>
                                <td style="font-family:'JetBrains Mono',monospace; font-weight:700; color:${isProfit ? '#34d399' : '#f87171'};">
                                    ${isProfit ? '+' : ''}৳ ${profit.toFixed(2)}
                                </td>
                                <td>
                                    ${isWin ? '<span style="font-size:10.5px; font-weight:800; color:#34d399;"><i class="fas fa-fire" style="color:#ef4444;"></i> WIN</span>' : '<span style="font-size:10.5px; color:#f87171;">LOSS</span>'}
                                </td>
                                <td style="font-size:11px; color:var(--text-muted);">
                                    ${new Date(s.created_at).toLocaleString()}
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
            })
            .catch(err => console.error('Failed to load Boxing King spins:', err));
        }

        function refreshGameMatrix() {
            const tbody = document.getElementById('game-matrix-tbody');
            const icon = document.getElementById('matrix-refresh-icon');
            if (icon) icon.classList.add('fa-spin');

            fetch('{{ route("admin.game-matrix") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            })
            .then(r => r.json())
            .then(data => {
                if (icon) icon.classList.remove('fa-spin');
                if (data.success && data.matrix && tbody) {
                    tbody.innerHTML = data.matrix.map(game => {
                        const profit = parseFloat(game.admin_profit);
                        const isProfit = profit >= 0;
                        const profitColor = isProfit ? '#10b981' : '#ef4444';
                        const profitBg = isProfit ? 'rgba(16,185,129,0.12)' : 'rgba(239,68,68,0.12)';
                        const profitBorder = isProfit ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)';

                        let healthBadge = `<span style="font-size:9.5px; font-weight:800; padding:3px 8px; border-radius:6px; background:rgba(16,185,129,0.15); color:#34d399; border:1px solid rgba(16,185,129,0.3);"><i class="fas fa-shield-check"></i> HEALTHY</span>`;
                        if (game.health_status === 'balanced') {
                            healthBadge = `<span style="font-size:9.5px; font-weight:800; padding:3px 8px; border-radius:6px; background:rgba(0,242,254,0.15); color:#00f2fe; border:1px solid rgba(0,242,254,0.3);"><i class="fas fa-scale-balanced"></i> BALANCED</span>`;
                        } else if (game.health_status === 'critical_loss') {
                            healthBadge = `<span style="font-size:9.5px; font-weight:800; padding:3px 8px; border-radius:6px; background:rgba(239,68,68,0.15); color:#f87171; border:1px solid rgba(239,68,68,0.3);"><i class="fas fa-triangle-exclamation"></i> CRITICAL</span>`;
                        }

                        let manageBtn = '';
                        if (game.id === 'boxing-king') {
                            manageBtn = `<button onclick="switchTab('boxing-king', document.getElementById('nav-boxing-king'))" class="action-btn edit" title="Manage Boxing King"><i class="fas fa-cog"></i></button>`;
                        } else if (game.id === 'western-vault') {
                            manageBtn = `<button onclick="switchTab('western', document.getElementById('nav-western'))" class="action-btn edit" title="Manage Western Vault"><i class="fas fa-cog"></i></button>`;
                        } else if (game.id === 'olympus') {
                            manageBtn = `<button onclick="switchTab('olympus', document.getElementById('nav-olympus'))" class="action-btn edit" title="Manage Olympus"><i class="fas fa-cog"></i></button>`;
                        } else if (game.id === 'aviator') {
                            manageBtn = `<button onclick="switchTab('game', document.getElementById('nav-game'))" class="action-btn edit" title="Manage Aviator"><i class="fas fa-cog"></i></button>`;
                        }

                        return `
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div style="width:34px; height:34px; border-radius:8px; background:${game.theme}22; border:1px solid ${game.theme}55; display:flex; align-items:center; justify-content:center; color:${game.theme}; font-size:14px; flex-shrink:0;">
                                            <i class="${game.icon}"></i>
                                        </div>
                                        <div>
                                            <strong style="color:var(--text-primary); font-size:13.5px;">${game.name}</strong>
                                            <div style="font-size:10.5px; color:var(--text-muted); font-family:'Roboto Mono',monospace;">ID: ${game.id}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span style="font-size:11.5px; color:var(--text-secondary);">${game.category}</span></td>
                                <td style="text-align:center;">
                                    <span style="display:inline-flex; align-items:center; gap:4px; font-family:'JetBrains Mono',monospace; font-weight:800; font-size:13px; color:var(--accent-cyan); background:rgba(0,242,254,0.1); border:1px solid rgba(0,242,254,0.25); padding:2px 8px; border-radius:12px;">
                                        <i class="fas fa-user" style="font-size:10px;"></i> ${game.active_players}
                                    </span>
                                </td>
                                <td>
                                    <strong style="font-family:'JetBrains Mono',monospace; color:var(--text-primary); font-size:13px;">৳ ${parseFloat(game.total_turnover).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>
                                </td>
                                <td>
                                    <span style="font-family:'JetBrains Mono',monospace; color:#38ef7d; font-size:13px; font-weight:700;">৳ ${parseFloat(game.total_payout).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                </td>
                                <td>
                                    <span style="font-family:'JetBrains Mono',monospace; font-weight:800; font-size:13px; color:${profitColor}; background:${profitBg}; padding:3px 8px; border-radius:6px; border:1px solid ${profitBorder};">
                                        ${isProfit ? '+' : ''}৳ ${profit.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    <span style="font-family:'JetBrains Mono',monospace; font-size:12px; font-weight:700; color:var(--accent-gold);">
                                        ${parseFloat(game.rtp).toFixed(2)}%
                                    </span>
                                </td>
                                <td style="text-align:center;">
                                    ${healthBadge}
                                </td>
                                <td style="text-align:right;">
                                    <a href="${game.route}" target="_blank" class="action-btn" title="Launch Game" style="text-decoration:none; margin-right:4px;">
                                        <i class="fas fa-external-link-alt" style="font-size:11px;"></i>
                                    </a>
                                    ${manageBtn}
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
            })
            .catch(err => {
                if (icon) icon.classList.remove('fa-spin');
                console.error('Failed to refresh game matrix:', err);
            });
        }

        function toggleGamesSubmenu() {
            const submenu = document.getElementById('games-module-submenu');
            if (submenu) {
                submenu.style.display = (submenu.style.display === 'none') ? 'flex' : 'none';
            }
        }
    </script>
</body>
</html>
