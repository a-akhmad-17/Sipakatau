<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dasbor Admin' ?> - Kesbangpol Kab. Sinjai</title>
    <!-- Prevent Theme Flash (FOUC) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-grad: linear-gradient(135deg, #be123c 0%, #f43f5e 50%, #fb7185 100%);
            --accent-grad: linear-gradient(135deg, #ea580c 0%, #e11d48 60%, #fda4af 100%);
            --transition-smooth: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-fast: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Dark Theme Variables */
        html[data-theme="dark"], :root:not([data-theme="light"]) {
            --bg-color: #0b0f19;
            --card-bg: rgba(17, 24, 39, 0.75);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-main: #f3f4f6;
            --text-muted: #a1a1aa;
            --navbar-bg: rgba(11, 15, 25, 0.95);
            --navbar-link: #a1a1aa;
            --navbar-link-active: #ffffff;
            --navbar-link-hover-bg: rgba(255, 255, 255, 0.05);
            --navbar-brand-grad: linear-gradient(to right, #f43f5e, #fda4af);
            --navbar-brand-icon-color: #f43f5e;
            --navbar-btn-bg: var(--primary-grad);
            --navbar-btn-color: #ffffff;
            --navbar-btn-border: none;
            --navbar-btn-hover-bg: var(--primary-grad);
            --navbar-btn-hover-color: #ffffff;
            --navbar-border: rgba(255, 255, 255, 0.08);
            --input-bg: rgba(15, 23, 42, 0.6);
            --input-color: #ffffff;
            --input-border: rgba(255, 255, 255, 0.1);
            --table-header-bg: rgba(11, 15, 25, 0.85);
            --table-row-border: rgba(255, 255, 255, 0.04);
            --row-warning-bg: rgba(245, 158, 11, 0.08);
            --row-expired-bg: rgba(239, 68, 68, 0.12);
            --alert-success-bg: rgba(16, 185, 129, 0.15);
            --alert-success-text: #34d399;
            --alert-danger-bg: rgba(239, 68, 68, 0.15);
            --alert-danger-text: #f87171;
            --badge-target-bg: rgba(96, 165, 250, 0.15);
            --badge-target-color: #93c5fd;
            --badge-target-border: rgba(96, 165, 250, 0.3);
            --badge-realisasi-bg: rgba(52, 211, 153, 0.15);
            --badge-realisasi-color: #a7f3d0;
            --badge-realisasi-border: rgba(52, 211, 153, 0.3);
            --badge-warning-bg: rgba(245, 158, 11, 0.15);
            --badge-warning-color: #fde68a;
            --badge-warning-border: rgba(245, 158, 11, 0.3);
            --badge-danger-bg: rgba(239, 68, 68, 0.15);
            --badge-danger-color: #fca5a5;
            --badge-danger-border: rgba(239, 68, 68, 0.3);
            --badge-primary-bg: rgba(225, 29, 72, 0.15);
            --badge-primary-color: #fda4af;
            --badge-primary-border: rgba(225, 29, 72, 0.3);
            --card-hover-border: rgba(244, 63, 94, 0.3);
            --footer-bg: #111827;
            --footer-h5: #f43f5e;
            --footer-text: #f3f4f6;
            --footer-muted: #9ca3af;
            --footer-hover: #ffffff;
            --footer-wa-color: #34d399;
            --glow-color-1: rgba(244, 63, 94, 0.18);
            --glow-color-2: rgba(251, 113, 133, 0.15);
            --btn-outline-color: #ffffff;
            --btn-outline-border: rgba(255, 255, 255, 0.2);
            --btn-outline-hover-bg: rgba(255, 255, 255, 0.05);
            --hr-border: rgba(255, 255, 255, 0.1);
            --btn-close-filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Light Theme Variables */
        html[data-theme="light"] {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --border-color: rgba(0, 0, 0, 0.06);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --navbar-bg: rgba(225, 29, 72, 0.98);
            --navbar-link: #ffe4e6;
            --navbar-link-active: #ffffff;
            --navbar-link-hover-bg: rgba(255, 255, 255, 0.12);
            --navbar-brand-grad: linear-gradient(to right, #ffffff, #ffe4e6);
            --navbar-brand-icon-color: #ffffff;
            --navbar-btn-bg: #ffffff;
            --navbar-btn-color: #be123c;
            --navbar-btn-border: 1px solid #be123c;
            --navbar-btn-hover-bg: #ffe4e6;
            --navbar-btn-hover-color: #9f1239;
            --navbar-border: rgba(255, 255, 255, 0.15);
            --input-bg: #ffffff;
            --input-color: #0f172a;
            --input-border: rgba(0, 0, 0, 0.12);
            --table-header-bg: #f1f5f9;
            --table-row-border: rgba(0, 0, 0, 0.05);
            --row-warning-bg: rgba(245, 158, 11, 0.06);
            --row-expired-bg: rgba(239, 68, 68, 0.06);
            --alert-success-bg: #d1fae5;
            --alert-success-text: #065f46;
            --alert-danger-bg: #fee2e2;
            --alert-danger-text: #991b1b;
            --badge-target-bg: rgba(59, 130, 246, 0.1);
            --badge-target-color: #2563eb;
            --badge-target-border: rgba(59, 130, 246, 0.2);
            --badge-realisasi-bg: rgba(16, 185, 129, 0.1);
            --badge-realisasi-color: #059669;
            --badge-realisasi-border: rgba(16, 185, 129, 0.2);
            --badge-warning-bg: rgba(245, 158, 11, 0.1);
            --badge-warning-color: #d97706;
            --badge-warning-border: rgba(245, 158, 11, 0.2);
            --badge-danger-bg: rgba(239, 68, 68, 0.1);
            --badge-danger-color: #dc2626;
            --badge-danger-border: rgba(239, 68, 68, 0.2);
            --badge-primary-bg: rgba(225, 29, 72, 0.1);
            --badge-primary-color: #e11d48;
            --badge-primary-border: rgba(225, 29, 72, 0.2);
            --card-hover-border: rgba(225, 29, 72, 0.25);
            --footer-bg: #9f1239;
            --footer-h5: #ffffff;
            --footer-text: #fff1f2;
            --footer-muted: #fecdd3;
            --footer-hover: #ffffff;
            --footer-wa-color: #4ade80;
            --glow-color-1: rgba(244, 63, 94, 0.08);
            --glow-color-2: rgba(251, 113, 133, 0.06);
            --btn-outline-color: #0f172a;
            --btn-outline-border: rgba(0, 0, 0, 0.15);
            --btn-outline-hover-bg: rgba(0, 0, 0, 0.05);
            --hr-border: rgba(0, 0, 0, 0.08);
            --btn-close-filter: none;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            transition: var(--transition-smooth);
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* -------------------------------------------------------------------------- */
        /* Admin Wrapper & Sidebar Layout                                             */
        /* -------------------------------------------------------------------------- */

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        .admin-sidebar {
            width: 280px;
            background: var(--navbar-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            transition: var(--transition-smooth);
        }

        .admin-main {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            transition: var(--transition-smooth);
        }

        /* Ambient Glow Background - Enhanced Blur */
        .admin-main::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--glow-color-1) 0%, rgba(0,0,0,0) 75%);
            top: -150px;
            left: 100px;
            z-index: -1;
            pointer-events: none;
            filter: blur(40px);
            transition: var(--transition-smooth);
        }

        /* Brand / Logo Section */
        .sidebar-brand {
            padding: 24px;
            border-bottom: 1px solid var(--navbar-border);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand-link {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            background: var(--navbar-brand-grad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition-smooth);
        }

        .sidebar-brand-link i {
            color: var(--navbar-brand-icon-color) !important;
            -webkit-text-fill-color: var(--navbar-brand-icon-color);
        }

        /* Sidebar Navigation Menu */
        .sidebar-menu {
            padding: 20px 0;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
            border-radius: 2px;
        }

        .sidebar-label {
            padding: 10px 24px 5px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--navbar-link);
            opacity: 0.5;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: var(--navbar-link) !important;
            font-weight: 500;
            font-size: 0.92rem;
            text-decoration: none !important;
            border-left: 4px solid transparent;
            transition: var(--transition-fast);
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: var(--navbar-link-active) !important;
            background: var(--navbar-link-hover-bg);
            border-left-color: #fda4af;
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 1.05rem;
            opacity: 0.85;
            transition: var(--transition-fast);
        }
        .sidebar-link:hover i, .sidebar-link.active i {
            transform: scale(1.05);
            opacity: 1;
        }

        /* Top Navbar Header */
        .admin-header-nav {
            background: var(--navbar-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--navbar-border);
            padding: 15px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .admin-header-nav {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.25);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar-toggle-btn {
            background: var(--navbar-link-hover-bg);
            border: 1px solid var(--navbar-border);
            color: var(--navbar-link-active);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-fast);
        }
        .sidebar-toggle-btn:hover {
            background: rgba(255,255,255,0.15);
            transform: scale(1.05);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Widgets inside Header */
        .header-weather {
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--navbar-border);
            padding: 6px 14px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--navbar-link-active);
        }

        .header-zoom-controls {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--navbar-border);
            border-radius: 20px;
            overflow: hidden;
        }

        .zoom-btn {
            background: transparent;
            border: none;
            color: var(--navbar-link);
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-fast);
        }
        .zoom-btn:hover {
            background: var(--navbar-link-hover-bg);
            color: var(--navbar-link-active);
        }

        .btn-theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            transition: var(--transition-smooth);
            border: 1px solid var(--navbar-border) !important;
            color: var(--navbar-link) !important;
        }

        .btn-theme-toggle:hover {
            background-color: var(--navbar-link-hover-bg) !important;
            color: var(--navbar-link-active) !important;
            transform: scale(1.05);
        }

        html[data-theme="light"] .btn-theme-toggle {
            border-color: rgba(255, 255, 255, 0.45) !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }
        html[data-theme="light"] .btn-theme-toggle:hover {
            background-color: #ffffff !important;
            border-color: #ffffff !important;
            color: #be123c !important;
        }

        /* -------------------------------------------------------------------------- */
        /* Premium UI Components & General Styling                                    */
        /* -------------------------------------------------------------------------- */

        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px 0 rgba(0, 0, 0, 0.08);
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }

        html[data-theme="dark"] .glass-card {
            box-shadow: 0 10px 40px 0 rgba(0, 0, 0, 0.35);
        }

        .glass-card:hover {
            border-color: var(--card-hover-border);
            transform: translateY(-6px) scale(1.005);
            box-shadow: 0 15px 45px rgba(244, 63, 94, 0.12), 0 0 25px var(--glow-color-1);
        }

        .form-control-custom {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            color: var(--input-color) !important;
            border-radius: 10px;
            padding: 11px 16px;
            transition: var(--transition-smooth);
        }
        .form-control-custom::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.65;
        }
        .form-control-custom:focus {
            border-color: #f43f5e !important;
            box-shadow: 0 0 0 0.25rem rgba(244, 63, 94, 0.25) !important;
            animation: focusPulse 2.5s infinite ease-in-out;
        }

        /* Custom Solid Badge Styles */
        .badge-primary-bg { background-color: var(--badge-primary-bg) !important; color: var(--badge-primary-color) !important; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.72rem; }
        .badge-sekretariat { background-color: #6366f1 !important; color: #ffffff !important; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.72rem; }
        .badge-ideologi { background-color: #e11d48 !important; color: #ffffff !important; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.72rem; }
        .badge-poldagri { background-color: #10b981 !important; color: #ffffff !important; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.72rem; }
        .badge-ekososbud { background-color: #d97706 !important; color: #ffffff !important; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.72rem; }

        /* Table Custom — Override Bootstrap default to follow theme variables */
        .table-custom {
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-main);
            --bs-table-border-color: var(--border-color);
            color: var(--text-main) !important;
        }
        .table-custom thead th {
            background-color: var(--table-header-bg) !important;
            color: var(--text-main) !important;
            border-bottom: 1px solid var(--border-color) !important;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            padding: 14px 16px;
        }
        .table-custom tbody td {
            color: var(--text-main) !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 14px 16px;
            vertical-align: middle;
        }
        .table-custom tbody tr:hover td {
            background-color: rgba(127, 127, 127, 0.04) !important;
        }
        /* Ensure inline-styled color still wins */
        .table-custom tbody td [style*="color: var(--text-main)"] {
            color: var(--text-main) !important;
        }
        .table-custom tbody td [style*="color: var(--text-muted)"] {
            color: var(--text-muted) !important;
        }

        .btn-portal {
            background: var(--primary-grad);
            background-size: 200% auto;
            border: none;
            color: white !important;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 10px;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 15px rgba(244, 63, 94, 0.35);
        }

        .btn-portal:hover {
            background-position: right center;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(244, 63, 94, 0.55);
        }

        /* Contrast adapts for Light Theme */
        html[data-theme="light"] .text-white {
            color: var(--text-main) !important;
            transition: var(--transition-smooth);
        }
        
        html[data-theme="light"] .border-secondary-subtle {
            border-color: rgba(0, 0, 0, 0.08) !important;
        }

        /* Contrast & Theme-sensitive Typography Overrides */
        .text-muted { color: var(--text-muted) !important; }
        .text-primary { color: #be123c !important; }
        html[data-theme="dark"] .text-primary { color: #fda4af !important; }
        .text-warning { color: #d97706 !important; }
        html[data-theme="dark"] .text-warning { color: #fbbf24 !important; }
        .text-info { color: #0891b2 !important; }
        html[data-theme="dark"] .text-info { color: #22d3ee !important; }
        .text-success { color: #059669 !important; }
        html[data-theme="dark"] .text-success { color: #34d399 !important; }

        /* Nav Pills - Filter Tabs */
        .nav-pills .nav-link {
            color: var(--text-muted);
            transition: var(--transition-fast);
        }
        .nav-pills .nav-link:hover {
            color: var(--text-main);
            background-color: rgba(127, 127, 127, 0.1);
        }
        .nav-pills .nav-link.active {
            background-color: #e11d48 !important;
            color: #ffffff !important;
        }
        html[data-theme="dark"] .nav-pills .nav-link.active {
            background-color: rgba(244, 63, 94, 0.25) !important;
            color: #fda4af !important;
        }

        /* Modal btn-close adaptive filter */
        .btn-close {
            filter: var(--btn-close-filter, none);
        }
        html[data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .dropdown-menu {
            background-color: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 12px;
            overflow: hidden;
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .dropdown-menu {
            box-shadow: 0 10px 40px rgba(0,0,0,0.45);
        }
        .dropdown-item {
            color: var(--text-muted) !important;
            padding: 11px 20px !important;
            font-weight: 500;
            transition: var(--transition-smooth);
        }
        .dropdown-item:hover {
            color: var(--text-main) !important;
            background-color: rgba(255, 255, 255, 0.06) !important;
            transform: translateX(4px);
        }
        html[data-theme="light"] .dropdown-item:hover {
            background-color: rgba(0, 0, 0, 0.04) !important;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-color);
        }
        ::-webkit-scrollbar-thumb {
            background: #27272a;
            border-radius: 4px;
            transition: var(--transition-smooth);
        }
        html[data-theme="light"] ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #f43f5e;
        }

        /* Text-indigo definition (Bootstrap doesn't define this by default) */
        .text-indigo { color: #6366f1 !important; }
        html[data-theme="dark"] .text-indigo { color: #a5b4fc !important; }
        html[data-theme="light"] .text-indigo { color: #4338ca !important; }
        .border-indigo-subtle { border-color: rgba(99, 102, 241, 0.3) !important; }
        html[data-theme="light"] .border-indigo-subtle { border-color: rgba(99, 102, 241, 0.2) !important; }
        .bg-indigo-subtle { background-color: rgba(99, 102, 241, 0.15) !important; }
        html[data-theme="light"] .bg-indigo-subtle { background-color: #6366f1 !important; color: #ffffff !important; }

        @keyframes focusPulse {
            0%, 100% { box-shadow: 0 0 0 0.25rem rgba(244, 63, 94, 0.25); }
            50% { box-shadow: 0 0 0 0.38rem rgba(244, 63, 94, 0.45); }
        }

        /* -------------------------------------------------------------------------- */
        /* Responsive Overlay Sidebar                                                 */
        /* -------------------------------------------------------------------------- */

        /* -------------------------------------------------------------------------- */
        /* Theme Contrast Adjustments & Fixes (Comprehensive Two-Step Approach)       */
        /* -------------------------------------------------------------------------- */

        /* === STEP 1: Global Override ===
           In Light Mode, ALL .text-white elements switch to dark theme-aware color.
           This fixes the "tenggelam" (invisible) text problem on white/light backgrounds.
           This is the BASE rule — lower specificity, overridden by Step 2 below. */
        html[data-theme="light"] .text-white {
            color: var(--text-main) !important;
        }
        html[data-theme="light"] .text-white-50 {
            color: var(--text-muted) !important;
        }

        /* === STEP 2: Restore white text for components with SOLID DARK BACKGROUNDS ===
           These selectors are more specific, so they win over Step 1 above.
           Each rule targets a component that always has a colored solid background. */

        /* Solid-color action buttons (always have colored bg) */
        html[data-theme="light"] .btn-primary,
        html[data-theme="light"] .btn-primary.text-white {
            color: #ffffff !important;
        }
        html[data-theme="light"] .btn-danger,
        html[data-theme="light"] .btn-danger.text-white {
            color: #ffffff !important;
        }
        html[data-theme="light"] .btn-success,
        html[data-theme="light"] .btn-success.text-white {
            color: #ffffff !important;
        }
        html[data-theme="light"] .btn-secondary,
        html[data-theme="light"] .btn-secondary.text-white {
            color: #ffffff !important;
        }
        html[data-theme="light"] .btn-info,
        html[data-theme="light"] .btn-info.text-white {
            color: #ffffff !important;
        }
        /* btn-portal: gradient red background = always white text */
        html[data-theme="light"] .btn-portal,
        html[data-theme="light"] .btn-portal .text-white {
            color: #ffffff !important;
        }
        /* Warning button: amber background = dark text for legibility */
        html[data-theme="light"] .btn-warning {
            color: #212529 !important;
        }

        /* Custom solid-color badges */
        html[data-theme="light"] .badge-sekretariat,
        html[data-theme="light"] .badge-ideologi,
        html[data-theme="light"] .badge-poldagri,
        html[data-theme="light"] .badge-ekososbud {
            color: #ffffff !important;
        }

        /* Bootstrap solid bg badges */
        html[data-theme="light"] .badge.bg-primary,
        html[data-theme="light"] .badge.bg-danger,
        html[data-theme="light"] .badge.bg-success,
        html[data-theme="light"] .badge.bg-secondary,
        html[data-theme="light"] .badge.bg-info,
        html[data-theme="light"] .badge.bg-dark {
            color: #ffffff !important;
        }

        /* Sidebar: always RED background in Light Mode = white text */
        html[data-theme="light"] .admin-sidebar,
        html[data-theme="light"] .admin-sidebar .text-white,
        html[data-theme="light"] .admin-sidebar .fw-bold,
        html[data-theme="light"] .sidebar-profile .fw-bold {
            color: #ffffff !important;
        }
        html[data-theme="light"] .admin-sidebar .sidebar-link {
            color: var(--navbar-link) !important;
        }
        html[data-theme="light"] .admin-sidebar .sidebar-link.active,
        html[data-theme="light"] .admin-sidebar .sidebar-link:hover {
            color: var(--navbar-link-active) !important;
        }
        html[data-theme="light"] .admin-sidebar .sidebar-label {
            color: var(--navbar-link) !important;
        }

        /* Header / Top Nav: always RED background in Light Mode */
        html[data-theme="light"] .admin-header-nav .text-white {
            color: var(--navbar-link-active) !important;
        }
        html[data-theme="light"] .admin-header-nav a[title="Log Out"] {
            color: var(--navbar-link) !important;
        }
        html[data-theme="light"] .admin-header-nav a[title="Log Out"]:hover {
            color: var(--navbar-link-active) !important;
            background-color: rgba(255, 255, 255, 0.15) !important;
        }
        html[data-theme="light"] .admin-header-nav a[title="Log Out"].text-danger {
            color: var(--navbar-link) !important;
        }
        html[data-theme="light"] .admin-header-nav a[title="Log Out"].text-danger:hover {
            color: var(--navbar-link-active) !important;
        }
        html[data-theme="light"] .admin-sidebar .sidebar-link .text-danger {
            color: var(--navbar-link) !important;
            transition: var(--transition-smooth);
        }
        html[data-theme="light"] .admin-sidebar .sidebar-link:hover .text-danger {
            color: var(--navbar-link-active) !important;
        }

        /* Avatar circle: gradient background = always white text/initial */
        html[data-theme="light"] .avatar-circle {
            color: #ffffff !important;
        }

        /* Timeline completed step icon: gradient bg = white icon */
        html[data-theme="light"] .timeline-step.completed .timeline-icon {
            color: #ffffff !important;
        }

        /* === MODAL btn-close Adaptive Filter for Admin Layout ===
           In dark mode: invert btn-close to appear white. In light mode: leave as-is. */
        html[data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        /* btn-close-white is explicitly always inverted */
        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        html[data-theme="light"] .modal-content:not(.bg-dark) .btn-close-white {
            filter: none;
        }

        /* === ORG CHART badge subtle-bg fix in Light Mode (Admin context) === */
        html[data-theme="light"] .org-node .org-badge.bg-danger-subtle {
            background-color: #dc2626 !important;
            color: #ffffff !important;
            border: none !important;
        }
        html[data-theme="light"] .org-node .org-badge.bg-indigo-subtle {
            background-color: #6366f1 !important;
            color: #ffffff !important;
            border: none !important;
        }
        html[data-theme="light"] .org-node .org-badge.bg-primary-subtle {
            background-color: #e11d48 !important;
            color: #ffffff !important;
            border: none !important;
        }
        html[data-theme="light"] .org-node .org-badge.bg-success-subtle {
            background-color: #059669 !important;
            color: #ffffff !important;
            border: none !important;
        }
        html[data-theme="light"] .org-node .org-badge.bg-warning-subtle {
            background-color: #d97706 !important;
            color: #ffffff !important;
            border: none !important;
        }

        /* === LIGHT MODE: Outline button text-white fix ===
           All .btn-outline-* with .text-white class in light mode must use brand color */
        html[data-theme="light"] .btn-outline-primary {
            color: #be123c !important;
            border-color: #be123c !important;
        }
        html[data-theme="light"] .btn-outline-primary:hover {
            color: #ffffff !important;
            background-color: #be123c !important;
        }
        html[data-theme="light"] .btn-outline-warning {
            color: #92400e !important;
            border-color: #d97706 !important;
        }
        html[data-theme="light"] .btn-outline-warning:hover {
            color: #ffffff !important;
            background-color: #d97706 !important;
        }
        html[data-theme="light"] .btn-outline-info {
            color: #0891b2 !important;
            border-color: #0891b2 !important;
        }
        html[data-theme="light"] .btn-outline-info:hover {
            color: #ffffff !important;
            background-color: #0891b2 !important;
        }

        /* Unified Custom Search Bar Input Group */
        .input-group-text-custom {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            border-right: none !important;
            color: var(--text-muted) !important;
            border-radius: 10px 0 0 10px;
            padding: 11px 16px;
            display: flex;
            align-items: center;
        }

        /* Leaflet popup overrides to adapt dynamically to light/dark themes */
        .leaflet-popup-content-wrapper, .leaflet-popup-tip {
            background: var(--card-bg) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--border-color) !important;
        }
        
        /* Kanban Column background adjustment for contrast */
        .kanban-col {
            background: rgba(0, 0, 0, 0.02) !important;
        }
        html[data-theme="dark"] .kanban-col {
            background: rgba(255, 255, 255, 0.02) !important;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1035;
                backdrop-filter: blur(4px);
            }
            .sidebar-overlay.show {
                display: block;
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            }
        }

        /* === LIGHT THEME: Outline Buttons & Subtle Badges Fix ===
           Outline buttons have transparent/white backgrounds in light mode,
           so text-white on them becomes invisible. Apply themed text colors. */

        /* Back/secondary outline buttons: use dark text in light mode */
        html[data-theme="light"] .btn-outline-secondary {
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
        }
        html[data-theme="light"] .btn-outline-secondary:hover,
        html[data-theme="light"] .btn-outline-secondary.active {
            color: #ffffff !important;
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }

        /* Info outline buttons: use info color text in light mode */
        html[data-theme="light"] .btn-outline-info {
            color: #0dcaf0 !important;
            border-color: #0dcaf0 !important;
        }

        /* Subtle-background badges: bg-secondary-subtle is very pale in light mode */
        html[data-theme="light"] .badge.bg-secondary-subtle {
            color: var(--text-main) !important;
        }

        /* Input group icons with solid secondary bg: keep white icon */
        html[data-theme="light"] .input-group-text.bg-secondary {
            color: #ffffff !important;
        }

        /* badge-primary-bg: solid primary background = white text */
        html[data-theme="light"] .badge-primary-bg {
            background-color: #e11d48 !important;
            color: #ffffff !important;
        }

    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

    <?php
    $username = session()->get('username') ?? 'User';
    $role = session()->get('role') ?? 'admin';
    $initial = strtoupper(substr($username, 0, 1));
    $roleLabels = [
        'admin' => 'Administrator',
        'kabid' => 'Kepala Bidang',
        'kaban' => 'Kepala Badan'
    ];
    $roleText = $roleLabels[$role] ?? ucfirst($role);
    $uriString = uri_string();
    ?>

    <div class="admin-wrapper">
        <!-- Overlay for Mobile Toggling -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar Left -->
        <aside class="admin-sidebar" id="adminSidebar">
            <!-- Brand Logo -->
            <div class="sidebar-brand py-3">
                <a class="sidebar-brand-link" href="<?= site_url() ?>" style="font-size: 1.25rem; gap: 8px;">
                    <img src="<?= base_url('uploads/logo_kesbangpol.png') ?>" alt="Logo Kesbangpol" style="width: 32px; height: 32px; object-fit: contain; border-radius: 50%;">
                    SIPAKATAU
                </a>
            </div>

            <!-- Profile Info Card -->
            <div class="sidebar-profile p-4 border-bottom" style="border-color: var(--navbar-border) !important; display: flex; align-items: center; gap: 15px;">
                <div class="avatar-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; border-radius: 50%; background: var(--primary-grad); color: white; font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1.25rem; box-shadow: 0 4px 15px rgba(244, 63, 94, 0.3);">
                    <?= $initial ?>
                </div>
                <div class="profile-info min-w-0">
                    <div class="fw-bold text-white text-truncate" style="font-size: 0.95rem;" title="<?= esc(ucfirst($username)) ?>"><?= esc(ucfirst($username)) ?></div>
                    <span class="badge" style="font-size: 0.68rem; padding: 4px 8px; opacity: 0.9; background-color: rgba(255,255,255,0.08); color: var(--navbar-link-active) !important; border: 1px solid var(--navbar-border);"><?= $roleText ?></span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="sidebar-menu">
                <?php if ($role === 'admin'): ?>
                    <div class="sidebar-label">Utama</div>
                    <a href="<?= site_url('admin') ?>" class="sidebar-link sidebar-tab-link active" data-target-tab="ormas-tab" data-tab-hash="tab-ormas">
                        <i class="fa-solid fa-users"></i> Manajemen Ormas
                    </a>
                    <a href="<?= site_url('admin#tab-parpol') ?>" class="sidebar-link sidebar-tab-link" data-target-tab="parpol-tab" data-tab-hash="tab-parpol">
                        <i class="fa-solid fa-building-flag"></i> Partai Politik
                    </a>
                    <a href="<?= site_url('admin#tab-tracking-ormas') ?>" class="sidebar-link sidebar-tab-link" data-target-tab="tracking-ormas-tab" data-tab-hash="tab-tracking-ormas">
                        <i class="fa-solid fa-users-viewfinder"></i> Verifikasi Ormas
                    </a>
                    <a href="<?= site_url('admin#tab-tracking-rekomendasi') ?>" class="sidebar-link sidebar-tab-link" data-target-tab="tracking-rekomendasi-tab" data-tab-hash="tab-tracking-rekomendasi">
                        <i class="fa-solid fa-file-signature"></i> Verifikasi Rekomendasi
                    </a>
                    <a href="<?= site_url('admin#tab-gis') ?>" class="sidebar-link sidebar-tab-link" data-target-tab="gis-tab" data-tab-hash="tab-gis">
                        <i class="fa-solid fa-map-location-dot"></i> Peta GIS & Konflik
                    </a>
                    <a href="<?= site_url('admin#tab-pengaduan') ?>" class="sidebar-link sidebar-tab-link" data-target-tab="pengaduan-tab" data-tab-hash="tab-pengaduan">
                        <i class="fa-solid fa-bullhorn"></i> Pengaduan Masyarakat
                    </a>
                    <a href="<?= site_url('admin#tab-antrean') ?>" class="sidebar-link sidebar-tab-link" data-target-tab="antrean-tab" data-tab-hash="tab-antrean">
                        <i class="fa-solid fa-ticket"></i> Antrean MPP
                    </a>
                    
                    <div class="sidebar-label">Konfigurasi</div>
                    <a href="#settingsCollapse" data-bs-toggle="collapse" class="sidebar-link <?= (strpos($uriString, 'admin/settings') === 0) ? 'active' : '' ?>" role="button" aria-expanded="<?= (strpos($uriString, 'admin/settings') === 0) ? 'true' : 'false' ?>">
                        <i class="fa-solid fa-sliders"></i> Pengaturan Portal <i class="fa-solid fa-chevron-down ms-auto" style="font-size: 0.75rem;"></i>
                    </a>
                    <div class="collapse <?= (strpos($uriString, 'admin/settings') === 0) ? 'show' : '' ?>" id="settingsCollapse">
                        <a href="<?= site_url('admin/settings/visi-misi') ?>" class="sidebar-link ps-5 <?= ($uriString === 'admin/settings/visi-misi') ? 'active' : '' ?>">
                            <i class="fa-solid fa-quote-left" style="font-size: 0.8rem;"></i> Visi & Misi
                        </a>
                        <a href="<?= site_url('admin/settings/bidang') ?>" class="sidebar-link ps-5 <?= ($uriString === 'admin/settings/bidang') ? 'active' : '' ?>">
                            <i class="fa-solid fa-circle-nodes" style="font-size: 0.8rem;"></i> Bidang & Unit
                        </a>
                        <a href="<?= site_url('admin/settings/struktur') ?>" class="sidebar-link ps-5 <?= ($uriString === 'admin/settings/struktur') ? 'active' : '' ?>">
                            <i class="fa-solid fa-sitemap" style="font-size: 0.8rem;"></i> Struktur Org
                        </a>
                        <a href="<?= site_url('admin/settings/video') ?>" class="sidebar-link ps-5 <?= ($uriString === 'admin/settings/video') ? 'active' : '' ?>">
                            <i class="fa-solid fa-video" style="font-size: 0.8rem;"></i> Video & Dokumentasi
                        </a>
                        <a href="<?= site_url('admin/settings/berita') ?>" class="sidebar-link ps-5 <?= ($uriString === 'admin/settings/berita') ? 'active' : '' ?>">
                            <i class="fa-solid fa-newspaper" style="font-size: 0.8rem;"></i> Kelola Berita
                        </a>
                        <a href="<?= site_url('admin/settings/users') ?>" class="sidebar-link ps-5 <?= ($uriString === 'admin/settings/users') ? 'active' : '' ?>">
                            <i class="fa-solid fa-users-gear" style="font-size: 0.8rem;"></i> Kelola Pengguna
                        </a>
                    </div>

                <?php elseif ($role === 'kabid'): ?>
                    <div class="sidebar-label">Dasbor Kabid</div>
                    <a href="<?= site_url('bidang') ?>" class="sidebar-link active" id="menu-bidang-home">
                        <i class="fa-solid fa-chart-pie"></i> Ringkasan Dasbor
                    </a>
                    <a href="#" class="sidebar-link scroll-anchor-link" data-target-id="validasi-skt">
                        <i class="fa-solid fa-file-signature"></i> Penerbitan SKT / Tanggapan
                    </a>
                    <a href="#" class="sidebar-link scroll-anchor-link" data-target-id="gis-map">
                        <i class="fa-solid fa-map-location-dot"></i> Peta Geografis
                    </a>

                <?php elseif ($role === 'kaban'): ?>
                    <div class="sidebar-label">Eksekutif</div>
                    <a href="<?= site_url('eksekutif') ?>" class="sidebar-link <?= ($uriString === 'eksekutif') ? 'active' : '' ?>" id="menu-exec-home">
                        <i class="fa-solid fa-crown"></i> Ringkasan Eksekutif
                    </a>
                    <a href="<?= site_url('eksekutif/kinerja') ?>" class="sidebar-link <?= ($uriString === 'eksekutif/kinerja') ? 'active' : '' ?>">
                        <i class="fa-solid fa-chart-column"></i> Kinerja Bidang
                    </a>
                    <a href="<?= site_url('eksekutif/ormas-merah') ?>" class="sidebar-link <?= ($uriString === 'eksekutif/ormas-merah') ? 'active' : '' ?>">
                        <i class="fa-solid fa-circle-exclamation text-danger"></i> Ormas SK Merah
                    </a>
                    <a href="<?= site_url('eksekutif/gis') ?>" class="sidebar-link <?= ($uriString === 'eksekutif/gis') ? 'active' : '' ?>">
                        <i class="fa-solid fa-map-location-dot"></i> Peta Sebaran GIS
                    </a>
                    <a href="<?= site_url('eksekutif/kendala') ?>" class="sidebar-link <?= ($uriString === 'eksekutif/kendala') ? 'active' : '' ?>">
                        <i class="fa-solid fa-triangle-exclamation text-warning"></i> Kendala Bidang
                    </a>
                    <a href="<?= site_url('eksekutif/pengaduan') ?>" class="sidebar-link <?= ($uriString === 'eksekutif/pengaduan') ? 'active' : '' ?>">
                        <i class="fa-solid fa-bullhorn text-danger"></i> Aduan Masyarakat
                    </a>
                    
                    <div class="sidebar-label">Aksi</div>
                    <a href="<?= site_url('eksekutif/cetak-laporan') ?>" target="_blank" class="sidebar-link">
                        <i class="fa-solid fa-print"></i> Cetak Laporan Fisik
                    </a>
                <?php elseif ($role === 'ormas' || $role === 'user'): ?>
                    <?php if (strpos($uriString, 'user/rekomendasi') === 0): ?>
                        <div class="sidebar-label">Rekomendasi Kegiatan</div>
                        <a href="<?= site_url('user/rekomendasi') ?>" class="sidebar-link <?= ($uriString === 'user/rekomendasi') ? 'active' : '' ?>">
                            <i class="fa-solid fa-gauge-high"></i> Ringkasan Dasbor
                        </a>
                        <a href="<?= site_url('user/rekomendasi/baru') ?>" class="sidebar-link <?= ($uriString === 'user/rekomendasi/baru') ? 'active' : '' ?>">
                            <i class="fa-solid fa-calendar-plus"></i> Ajukan Rekomendasi
                        </a>
                        <hr class="sidebar-divider my-3" style="border-top: 1px solid rgba(255,255,255,0.06); margin-left: 1.5rem; margin-right: 1.5rem;">
                        <div class="sidebar-label text-muted">Alih Layanan</div>
                        <a href="<?= site_url('user/pengaduan') ?>" class="sidebar-link text-muted" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-bullhorn text-muted"></i> Alih ke Portal Pengaduan
                        </a>
                    <?php elseif (strpos($uriString, 'user/pengaduan') === 0): ?>
                        <div class="sidebar-label">Pengaduan Masyarakat</div>
                        <a href="<?= site_url('user/pengaduan') ?>" class="sidebar-link <?= ($uriString === 'user/pengaduan') ? 'active' : '' ?>">
                            <i class="fa-solid fa-gauge-high"></i> Ringkasan Dasbor
                        </a>
                        <a href="<?= site_url('user/pengaduan/baru') ?>" class="sidebar-link <?= ($uriString === 'user/pengaduan/baru') ? 'active' : '' ?>">
                            <i class="fa-solid fa-bullhorn"></i> Laporkan Pengaduan
                        </a>
                        <hr class="sidebar-divider my-3" style="border-top: 1px solid rgba(255,255,255,0.06); margin-left: 1.5rem; margin-right: 1.5rem;">
                        <div class="sidebar-label text-muted">Alih Layanan</div>
                        <a href="<?= site_url('user/rekomendasi') ?>" class="sidebar-link text-muted" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-calendar-check text-muted"></i> Alih ke Rekomendasi
                        </a>
                    <?php else: ?>
                        <div class="sidebar-label">Pendaftaran Ormas</div>
                        <a href="<?= site_url('user/ormas') ?>" class="sidebar-link <?= ($uriString === 'user/ormas' || $uriString === 'user') ? 'active' : '' ?>">
                            <i class="fa-solid fa-gauge-high"></i> Ringkasan Dasbor
                        </a>
                        <a href="<?= site_url('user/pengajuan') ?>" class="sidebar-link <?= ($uriString === 'user/pengajuan') ? 'active' : '' ?>">
                            <i class="fa-solid fa-file-pen"></i> Form Pengajuan
                        </a>
                        <hr class="sidebar-divider my-3" style="border-top: 1px solid rgba(255,255,255,0.06); margin-left: 1.5rem; margin-right: 1.5rem;">
                        <div class="sidebar-label text-muted">Alih Layanan</div>
                        <a href="<?= site_url('user/rekomendasi') ?>" class="sidebar-link text-muted" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-calendar-check text-muted"></i> Dasbor Rekomendasi
                        </a>
                        <a href="<?= site_url('user/pengaduan') ?>" class="sidebar-link text-muted" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-bullhorn text-muted"></i> Portal Pengaduan
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="sidebar-label">Sistem</div>
                <a href="<?= site_url() ?>" target="_blank" class="sidebar-link">
                    <i class="fa-solid fa-earth-southeast"></i> Lihat Portal Utama
                </a>
                <a href="<?= site_url('logout') ?>" class="sidebar-link text-danger-hover">
                    <i class="fa-solid fa-right-from-bracket text-danger"></i> Keluar
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="admin-main">
            <!-- Top Navbar Header -->
            <header class="admin-header-nav">
                <div class="header-left">
                    <button class="sidebar-toggle-btn d-lg-none" id="sidebarToggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h5 class="mb-0 text-white font-heading d-none d-md-inline-block">
                        <i class="fa-solid fa-gauge-high text-primary me-2"></i>Dasbor Panel Internal
                    </h5>
                </div>

                <div class="header-right">
                    <!-- Weather Widget -->
                    <div class="header-weather d-none d-sm-flex">
                        <i class="fa-solid fa-cloud-sun text-warning"></i>
                        <span>26°C - Sinjai</span>
                    </div>

                    <!-- Zoom Accessibility -->
                    <div class="header-zoom-controls d-none d-md-flex">
                        <button class="zoom-btn" id="zoom-in-btn" title="Perbesar Font"><i class="fa-solid fa-plus"></i></button>
                        <button class="zoom-btn" id="zoom-out-btn" title="Perkecil Font"><i class="fa-solid fa-minus"></i></button>
                        <button class="zoom-btn" id="zoom-reset-btn" title="Reset Font"><i class="fa-solid fa-arrows-rotate"></i></button>
                    </div>

                    <!-- Theme Toggle -->
                    <button type="button" id="theme-toggle" class="btn-theme-toggle">
                        <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
                    </button>

                    <!-- Quick Logout -->
                    <a href="<?= site_url('logout') ?>" class="sidebar-toggle-btn text-danger ms-1" title="Log Out">
                        <i class="fa-solid fa-power-off"></i>
                    </a>
                </div>
            </header>

            <!-- Content Area Wrapper -->
            <div class="admin-content container-fluid py-4 flex-grow-1">
                <!-- Success/Error Flash Alerts -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success bg-success-subtle border-success-subtle text-success p-3 rounded mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem;">
                        <i class="fa-solid fa-circle-check fa-lg me-2"></i><?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger bg-danger-subtle border-danger-subtle text-danger p-3 rounded mb-4" role="alert" style="border-radius: 12px; font-size: 0.95rem;">
                        <i class="fa-solid fa-triangle-exclamation fa-lg me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- Render view content -->
                <?= $this->renderSection('content') ?>
            </div>

            <!-- Footer minimal -->
            <footer class="py-3 mt-auto border-top text-center text-muted small" style="background: rgba(0,0,0,0.1); border-color: var(--border-color) !important;">
                <p class="mb-0">&copy; <?= date('Y') ?> SIPAKATAU. All Rights Reserved. Partner: <b>Diskominfo Sinjai</b></p>
            </footer>
        </div>
    </div>

    <!-- Global Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
        <div id="globalToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i id="globalToastIcon" class="fa-solid fa-lg"></i>
                    <span id="globalToastMessage" style="font-size: 0.9rem; font-weight: 500;"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Sidebar Mobile Toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const adminSidebar = document.getElementById('adminSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (sidebarToggle && adminSidebar && sidebarOverlay) {
                const toggle = () => {
                    adminSidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                };
                sidebarToggle.addEventListener('click', toggle);
                sidebarOverlay.addEventListener('click', toggle);
            }

            // Theme Toggle Logic
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleIcon = document.getElementById('theme-toggle-icon');
            
            function updateToggleIcon(theme) {
                if (theme === 'light') {
                    themeToggleIcon.classList.remove('fa-moon');
                    themeToggleIcon.classList.add('fa-sun');
                    themeToggleIcon.style.color = '#eab308'; // sun yellow
                } else {
                    themeToggleIcon.classList.remove('fa-sun');
                    themeToggleIcon.classList.add('fa-moon');
                    themeToggleIcon.style.color = ''; // reset to default
                }
            }

            // Init icon
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            updateToggleIcon(currentTheme);

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    const activeTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                    const targetTheme = activeTheme === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-theme', targetTheme);
                    localStorage.setItem('theme', targetTheme);
                    updateToggleIcon(targetTheme);
                });
            }

            // Font Zoom Accessibility Functionality
            let currentScale = 100;
            const zoomInBtn = document.getElementById('zoom-in-btn');
            const zoomOutBtn = document.getElementById('zoom-out-btn');
            const zoomResetBtn = document.getElementById('zoom-reset-btn');

            if (zoomInBtn && zoomOutBtn && zoomResetBtn) {
                zoomInBtn.addEventListener('click', () => {
                    if (currentScale < 130) {
                        currentScale += 5;
                        document.body.style.fontSize = (currentScale / 100) + 'em';
                    }
                });
                zoomOutBtn.addEventListener('click', () => {
                    if (currentScale > 80) {
                        currentScale -= 5;
                        document.body.style.fontSize = (currentScale / 100) + 'em';
                    }
                });
                zoomResetBtn.addEventListener('click', () => {
                    currentScale = 100;
                    document.body.style.fontSize = '1em';
                });
            }

            // Required asterisks labeling color injection (safely only targeting text nodes)
            document.querySelectorAll('label:not(.btn)').forEach(label => {
                const walk = document.createTreeWalker(label, NodeFilter.SHOW_TEXT, null, false);
                let node;
                const nodesToReplace = [];
                while (node = walk.nextNode()) {
                    if (node.nodeValue.includes('*')) {
                        const parentTagName = node.parentNode.tagName.toLowerCase();
                        if (parentTagName !== 'script' && parentTagName !== 'style') {
                            nodesToReplace.push(node);
                        }
                    }
                }
                nodesToReplace.forEach(node => {
                    const parent = node.parentNode;
                    const parts = node.nodeValue.split('*');
                    node.nodeValue = parts[0];
                    let refNode = node;
                    for (let i = 1; i < parts.length; i++) {
                        const span = document.createElement('span');
                        span.className = 'text-danger fw-bold';
                        span.textContent = '*';
                        parent.insertBefore(span, refNode.nextSibling);
                        
                        const textNode = document.createTextNode(parts[i]);
                        parent.insertBefore(textNode, span.nextSibling);
                        refNode = textNode;
                    }
                });
            });

            // --------------------------------------------------------------------------
            // Sidebar Navigation Click & Tab Synchronization                           
            // --------------------------------------------------------------------------
            const role = '<?= $role ?>';

            if (role === 'admin') {
                const tabLinks = document.querySelectorAll('.sidebar-tab-link');
                
                // Function to switch Bootstrap Tab
                const activateTab = (tabHash) => {
                    if (!tabHash) return;
                    
                    // Try to find the tab link trigger in sidebar matching the hash
                    const sidebarLink = document.querySelector(`.sidebar-tab-link[data-tab-hash="${tabHash}"]`);
                    if (sidebarLink) {
                        tabLinks.forEach(lnk => lnk.classList.remove('active'));
                        sidebarLink.classList.add('active');
                        
                        const targetId = sidebarLink.getAttribute('data-target-tab');
                        const tabBtn = document.getElementById(targetId);
                        if (tabBtn) {
                            const tab = new bootstrap.Tab(tabBtn);
                            tab.show();
                        }
                    }
                };

                // Listen to hash change
                window.addEventListener('hashchange', () => {
                    const hash = window.location.hash.substring(1);
                    if (hash) {
                        activateTab(hash);
                    }
                });

                // Check on page load
                let initialHash = window.location.hash.substring(1);
                if (!initialHash && window.location.pathname.endsWith('admin')) {
                    initialHash = 'tab-ormas';
                }
                if (initialHash) {
                    // Slight delay to ensure DOM is ready and bootstrap tabs initialized
                    setTimeout(() => {
                        activateTab(initialHash);
                    }, 100);
                }

                // Handle sidebar click triggers directly
                tabLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        const targetTabBtnId = link.getAttribute('data-target-tab');
                        const hash = link.getAttribute('data-tab-hash');
                        
                        // If we are currently on the dashboard page, trigger bootstrap tab switch directly
                        if (window.location.pathname.endsWith('admin') || window.location.pathname.endsWith('admin/')) {
                            e.preventDefault();
                            tabLinks.forEach(lnk => lnk.classList.remove('active'));
                            link.classList.add('active');
                            
                            const tabBtn = document.getElementById(targetTabBtnId);
                            if (tabBtn) {
                                const tab = new bootstrap.Tab(tabBtn);
                                tab.show();
                            }
                            window.location.hash = hash;
                            
                            // Close sidebar on mobile after choosing
                            if (adminSidebar.classList.contains('show')) {
                                sidebarToggle.click();
                            }
                        }
                    });
                });

                // Also sync tab switches from page clicks to sidebar links
                const pageTabBtns = document.querySelectorAll('#adminTabs button[data-bs-toggle="tab"]');
                pageTabBtns.forEach(btn => {
                    btn.addEventListener('shown.bs.tab', (e) => {
                        const activeTabBtnId = e.target.id;
                        const sidebarLink = document.querySelector(`.sidebar-tab-link[data-target-tab="${activeTabBtnId}"]`);
                        if (sidebarLink) {
                            tabLinks.forEach(lnk => lnk.classList.remove('active'));
                            sidebarLink.classList.add('active');
                            window.location.hash = sidebarLink.getAttribute('data-tab-hash');
                        }
                    });
                });

            } else if (role === 'kabid' || role === 'kaban') {
                // Scroll behavior for anchor links in dashboard
                const scrollLinks = document.querySelectorAll('.scroll-anchor-link');
                scrollLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const targetId = link.getAttribute('data-target-id');
                        const targetEl = document.getElementById(targetId) || document.querySelector(`.${targetId}`);
                        if (targetEl) {
                            // Highlight menu item
                            scrollLinks.forEach(lnk => lnk.classList.remove('active'));
                            link.classList.add('active');
                            
                            // Scroll smoothly
                            const offset = 85; // accounts for sticky header height
                            const bodyRect = document.body.getBoundingClientRect().top;
                            const elementRect = targetEl.getBoundingClientRect().top;
                            const elementPosition = elementRect - bodyRect;
                            const offsetPosition = elementPosition - offset;

                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });

                            // Close sidebar on mobile
                            if (adminSidebar.classList.contains('show')) {
                                sidebarToggle.click();
                            }
                        }
                    });
                });
            }
        });

        // Global Toast Notification Function
        window.showToast = function(message, type = 'success') {
            const toastEl = document.getElementById('globalToast');
            const toastIcon = document.getElementById('globalToastIcon');
            const toastMessage = document.getElementById('globalToastMessage');
            
            if (!toastEl) return;
            
            toastMessage.innerText = message;
            
            // Reset classes
            toastEl.className = 'toast align-items-center text-white border-0';
            toastIcon.className = 'fa-solid fa-lg';
            
            if (type === 'success') {
                toastEl.classList.add('bg-success');
                toastIcon.classList.add('fa-circle-check');
            } else if (type === 'error' || type === 'danger') {
                toastEl.classList.add('bg-danger');
                toastIcon.classList.add('fa-circle-xmark');
            } else if (type === 'warning') {
                toastEl.classList.add('bg-warning', 'text-dark');
                toastIcon.classList.add('fa-triangle-exclamation');
            } else {
                toastEl.classList.add('bg-primary');
                toastIcon.classList.add('fa-circle-info');
            }
            
            const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
            toast.show();
        };
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
