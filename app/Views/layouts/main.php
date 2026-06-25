<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SIPAKATAU' ?> - Kesbangpol Kab. Sinjai</title>
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
            --navbar-bg: rgba(11, 15, 25, 0.85);
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
        }

        /* Light Theme Variables */
        html[data-theme="light"] {
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --border-color: rgba(0, 0, 0, 0.06);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --navbar-bg: rgba(225, 29, 72, 0.96);
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
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
            transition: var(--transition-smooth);
        }

        /* Ambient Glow Background - Enhanced Blur */
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--glow-color-1) 0%, rgba(0,0,0,0) 75%);
            top: -150px;
            left: -150px;
            z-index: -1;
            pointer-events: none;
            filter: blur(40px);
            transition: var(--transition-smooth);
        }

        body::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--glow-color-2) 0%, rgba(0,0,0,0) 75%);
            bottom: 5%;
            right: -200px;
            z-index: -1;
            pointer-events: none;
            filter: blur(40px);
            transition: var(--transition-smooth);
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Glassmorphism Navbar */
        .navbar-custom {
            background: var(--navbar-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--navbar-border);
            padding: 15px 0;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }
        html[data-theme="dark"] .navbar-custom {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.25);
        }

        .navbar-brand-custom {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.55rem;
            background: var(--navbar-brand-grad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition-smooth);
        }
        .navbar-brand-custom:hover {
            opacity: 0.9;
            transform: scale(1.02);
        }
        .navbar-brand-custom i {
            color: var(--navbar-brand-icon-color) !important;
            transition: var(--transition-smooth);
        }
        .navbar-brand-custom:hover i {
            transform: rotate(15deg);
        }

        .nav-link-custom {
            color: var(--navbar-link) !important;
            font-weight: 600;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: var(--transition-smooth);
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            color: var(--navbar-link-active) !important;
            background: var(--navbar-link-hover-bg) !important;
            transform: translateY(-1px);
        }

        .navbar-custom .btn-portal {
            background: var(--navbar-btn-bg) !important;
            color: var(--navbar-btn-color) !important;
            border: var(--navbar-btn-border) !important;
            box-shadow: none !important;
        }
        .navbar-custom .btn-portal:hover {
            background: var(--navbar-btn-hover-bg) !important;
            color: var(--navbar-btn-hover-color) !important;
        }

        /* Premium Pulsing Gradient Button */
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
        
        .btn-portal:active {
            transform: translateY(0);
        }

        /* Premium Glass Card - Advanced Hover Glow */
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

        /* Global Adaptive Form Input Styles with Glow Pulsing on Focus */
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
        .input-group-text-custom {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            color: var(--text-muted) !important;
            border-radius: 10px;
        }

        /* Global adaptive hr */
        hr {
            border-top: 1px solid var(--hr-border) !important;
            opacity: 1;
            transition: var(--transition-smooth);
        }

        /* Footer Style */
        footer, .main-footer {
            background: var(--footer-bg) !important;
            border-top: 1px solid var(--border-color);
            padding: 50px 0 25px;
            margin-top: auto;
            color: var(--footer-text) !important;
            font-size: 0.92rem;
            transition: var(--transition-smooth);
        }

        .footer-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.35rem;
            color: var(--footer-h5) !important;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer-logo {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--footer-h5);
            margin-bottom: 15px;
        }

        footer h5, .footer-section-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--footer-h5) !important;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-size: 1.05rem !important;
            letter-spacing: 0.5px;
        }

        footer .text-muted, footer p.text-muted, .footer-copyright {
            color: var(--footer-muted) !important;
        }

        .footer-text-highlight {
            color: var(--footer-h5) !important;
        }

        .footer-icon {
            color: var(--footer-h5) !important;
        }

        .footer-label {
            color: var(--footer-h5) !important;
            font-size: 0.78rem;
            letter-spacing: 0.8px;
        }

        .footer-wa-num {
            color: var(--footer-wa-color) !important;
        }

        .footer-links a, footer a, .footer-link {
            color: var(--footer-muted) !important;
            text-decoration: none !important;
            transition: var(--transition-smooth);
        }

        .footer-links a:hover, footer a:hover, .footer-link:hover {
            color: var(--footer-hover) !important;
            transform: translateX(3px);
        }

        /* Custom scrollbar */
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

        /* Contrast & Theme-sensitive Typography Overrides */
        .text-muted {
            color: var(--text-muted) !important;
            transition: var(--transition-smooth);
        }
        .text-primary {
            color: #be123c !important;
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .text-primary {
            color: #fda4af !important;
        }
        .text-warning {
            color: #d97706 !important;
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .text-warning {
            color: #fbbf24 !important;
        }
        .text-info {
            color: #0891b2 !important;
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .text-info {
            color: #22d3ee !important;
        }
        .text-success {
            color: #059669 !important;
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .text-success {
            color: #34d399 !important;
        }
        .text-primary-light {
            color: var(--text-muted) !important;
        }
        .badge-custom-primary {
            background: rgba(225, 29, 72, 0.15) !important;
            color: #e11d48 !important;
            border: 1px solid rgba(225, 29, 72, 0.3) !important;
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .badge-custom-primary {
            color: #fda4af !important;
        }

        /* Adapt text-white to change to text-main in Light Mode */
        html[data-theme="light"] .text-white {
            color: var(--text-main) !important;
            transition: var(--transition-smooth);
        }

        /* Light-mode adapt for border-secondary-subtle and secondary buttons */
        html[data-theme="light"] .border-secondary-subtle {
            border-color: rgba(0, 0, 0, 0.08) !important;
            transition: var(--transition-smooth);
        }
        html[data-theme="light"] .btn-outline-secondary {
            color: #0f172a !important;
            border-color: rgba(0, 0, 0, 0.15) !important;
            transition: var(--transition-smooth);
        }
        html[data-theme="light"] .btn-outline-secondary:hover {
            background-color: rgba(0, 0, 0, 0.05) !important;
        }
        html[data-theme="dark"] .btn-outline-secondary {
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .btn-outline-secondary:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        /* Dropdown custom design */
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

        /* Hover dropdowns on desktop with transition */
        @media (min-width: 992px) {
            .nav-item.dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0;
                animation: fadeInUp 0.25s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            }
        }

        /* Floating Accessibility & Weather Widget */
        .accessibility-widget {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1050;
            animation: widgetFloat 5s ease-in-out infinite;
        }
        .widget-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.12);
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .widget-card {
            box-shadow: 0 10px 35px rgba(0,0,0,0.35);
        }
        .widget-weather-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
            text-align: center;
            width: 100%;
        }
        .widget-temp {
            font-size: 0.92rem;
            font-weight: 700;
            margin-top: 4px;
            color: var(--text-main);
        }
        .widget-condition {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-muted);
        }
        html[data-theme="light"] .widget-condition {
            color: #475569 !important;
        }
        .widget-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-smooth);
        }
        .widget-btn:hover {
            background: var(--primary-grad);
            color: white;
            border-color: transparent;
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(244, 63, 94, 0.35);
        }

        /* Social Media Circle Buttons */
        .social-circle-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid var(--footer-muted) !important;
            background: rgba(255, 255, 255, 0.08);
            color: var(--footer-muted) !important;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: var(--transition-smooth);
        }
        .social-circle-btn:hover {
            background: var(--primary-grad);
            color: var(--footer-hover) !important;
            border-color: transparent !important;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 15px rgba(244, 63, 94, 0.35);
        }
        
        /* Breadcrumbs styling and contrast fix */
        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--text-muted) !important;
        }
        .breadcrumb-item a {
            color: #be123c !important;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition-smooth);
        }
        html[data-theme="dark"] .breadcrumb-item a {
            color: #fda4af !important;
        }
        html[data-theme="light"] .breadcrumb-item a {
            color: #be123c !important;
        }
        .breadcrumb-item a:hover {
            color: #f43f5e !important;
            text-decoration: underline !important;
        }

        /* -------------------------------------------------------------------------- */
        /* Keyframe Animations & Animation Helpers                                    */
        /* -------------------------------------------------------------------------- */
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes focusPulse {
            0%, 100% {
                box-shadow: 0 0 0 0.25rem rgba(244, 63, 94, 0.25);
            }
            50% {
                box-shadow: 0 0 0 0.38rem rgba(244, 63, 94, 0.45);
            }
        }

        @keyframes widgetFloat {
            0%, 100% {
                transform: translateY(-50%) translateY(0);
            }
            50% {
                transform: translateY(-50%) translateY(-8px);
            }
        }

        /* Global Animation Class */
        .animate-fade-up {
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        /* Delay helper for list/grid items */
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        /* Custom Solid Badge Styles (Global) */
        .badge-sekretariat {
            background-color: #6366f1 !important;
            color: #ffffff !important;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.72rem;
            border: none !important;
            display: inline-block;
        }
        .badge-ideologi {
            background-color: #e11d48 !important;
            color: #ffffff !important;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.72rem;
            border: none !important;
            display: inline-block;
        }
        .badge-poldagri {
            background-color: #10b981 !important;
            color: #ffffff !important;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.72rem;
            border: none !important;
            display: inline-block;
        }
        .badge-ekososbud {
            background-color: #d97706 !important;
            color: #ffffff !important;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.72rem;
            border: none !important;
            display: inline-block;
        }

        /* Override Bootstrap subtles inside Light Mode to solid contrast (ONLY for .org-badge elements) */
        html[data-theme="light"] .org-badge.bg-indigo-subtle {
            background-color: #6366f1 !important;
            color: #ffffff !important;
        }
        html[data-theme="light"] .org-badge.bg-primary-subtle {
            background-color: #e11d48 !important;
            color: #ffffff !important;
        }
        html[data-theme="light"] .org-badge.bg-success-subtle {
            background-color: #10b981 !important;
            color: #ffffff !important;
        }
        html[data-theme="light"] .org-badge.bg-warning-subtle {
            background-color: #d97706 !important;
            color: #ffffff !important;
        }
        /* Only override bg-indigo-subtle globally (not standard Bootstrap classes) */
        html[data-theme="light"] .bg-indigo-subtle {
            background-color: #6366f1 !important;
            color: #ffffff !important;
        }
        html[data-theme="light"] .navbar-custom .bg-primary-subtle {
            background-color: rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
        }
        /* In org-badge context only, text colors become white (they sit on solid bg) */
        html[data-theme="light"] .org-badge.text-indigo,
        html[data-theme="light"] .org-badge.text-primary,
        html[data-theme="light"] .org-badge.text-success,
        html[data-theme="light"] .org-badge.text-warning {
            color: #ffffff !important;
        }
        /* Remove borders from org-badge subtle elements */
        html[data-theme="light"] .org-badge.border-indigo-subtle,
        html[data-theme="light"] .org-badge.border-primary-subtle,
        html[data-theme="light"] .org-badge.border-success-subtle,
        html[data-theme="light"] .org-badge.border-warning-subtle {
            border: none !important;
        }

        /* Custom Theme Toggle Button Styles */
        .btn-theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            transition: var(--transition-smooth);
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
        }

        .navbar-custom .btn-theme-toggle {
            border-color: var(--navbar-border) !important;
            color: var(--navbar-link) !important;
        }

        .navbar-custom .btn-theme-toggle:hover {
            background-color: var(--navbar-link-hover-bg) !important;
            color: var(--navbar-link-active) !important;
            transform: scale(1.05);
        }

        /* Light mode adjustments for navbar buttons to avoid color clashes */
        html[data-theme="light"] .navbar-custom .btn-theme-toggle {
            border-color: rgba(255, 255, 255, 0.45) !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }
        
        html[data-theme="light"] .navbar-custom .btn-theme-toggle:hover {
            background-color: #ffffff !important;
            border-color: #ffffff !important;
            color: #be123c !important;
        }

        /* Logout button style inside navbar for Light Mode (Red theme) */
        html[data-theme="light"] .navbar-custom .btn-outline-danger {
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
            transition: var(--transition-smooth);
        }
        
        html[data-theme="light"] .navbar-custom .btn-outline-danger:hover {
            color: #be123c !important;
            background-color: #ffffff !important;
            border-color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* === LIGHT THEME: COMPREHENSIVE TEXT CONTRAST FIX ===
           Step 1: Global Override — all .text-white → dark color in light mode.
           Step 2: Restore — specific solid-background components keep white text. */

        /* STEP 1: Global */
        html[data-theme="light"] .text-white {
            color: var(--text-main) !important;
        }
        html[data-theme="light"] .text-white-50 {
            color: var(--text-muted) !important;
        }

        /* STEP 2: Solid-color action buttons */
        html[data-theme="light"] .btn-primary,
        html[data-theme="light"] .btn-primary.text-white,
        html[data-theme="light"] .btn-danger,
        html[data-theme="light"] .btn-danger.text-white,
        html[data-theme="light"] .btn-success,
        html[data-theme="light"] .btn-success.text-white,
        html[data-theme="light"] .btn-secondary,
        html[data-theme="light"] .btn-secondary.text-white,
        html[data-theme="light"] .btn-info,
        html[data-theme="light"] .btn-info.text-white,
        html[data-theme="light"] .btn-portal,
        html[data-theme="light"] .btn-portal .text-white {
            color: #ffffff !important;
        }

        /* Exception: btn-portal INSIDE navbar has WHITE background (not gradient),
           so its text must use the dark red variable to stay visible.
           This selector is more specific than the rule above, so it wins. */
        html[data-theme="light"] .navbar-custom .btn-portal {
            color: var(--navbar-btn-color) !important; /* = #be123c (dark red) */
            background: var(--navbar-btn-bg) !important; /* = #ffffff */
            border: var(--navbar-btn-border) !important;
        }
        html[data-theme="light"] .navbar-custom .btn-portal:hover {
            color: var(--navbar-btn-hover-color) !important;
            background: var(--navbar-btn-hover-bg) !important;
        }
        html[data-theme="light"] .btn-warning {
            color: #212529 !important;
        }

        /* STEP 2: Custom and Bootstrap solid badges */
        html[data-theme="light"] .badge-sekretariat,
        html[data-theme="light"] .badge-ideologi,
        html[data-theme="light"] .badge-poldagri,
        html[data-theme="light"] .badge-ekososbud,
        html[data-theme="light"] .badge.bg-primary,
        html[data-theme="light"] .badge.bg-danger,
        html[data-theme="light"] .badge.bg-success,
        html[data-theme="light"] .badge.bg-secondary,
        html[data-theme="light"] .badge.bg-info,
        html[data-theme="light"] .badge.bg-dark {
            color: #ffffff !important;
        }

        /* STEP 2: Public Navbar — navbar handles its own color via CSS vars (.nav-link-custom already
           uses --navbar-link / --navbar-link-active). .btn-portal inside navbar already gets
           the correct color via .navbar-custom .btn-portal { color: var(--navbar-btn-color) }.
           NO additional overrides needed here. */

        /* STEP 2: Navbar toggler icon stays white on red navbar background */
        .navbar-toggler.border-0 {
            color: var(--navbar-link-active) !important;
        }
        html[data-theme="light"] .navbar-custom .navbar-toggler {
            color: #ffffff !important;
        }

        /* STEP 2: Footer (dark background) */
        html[data-theme="light"] .main-footer .text-white {
            color: var(--footer-text) !important;
        }
        html[data-theme="light"] .footer-copyright .text-white {
            color: var(--footer-text) !important;
        }

        /* STEP 2: Contact circles on homepage (red solid bg) */
        html[data-theme="light"] .contact-circle {
            color: #ffffff !important;
        }

        /* STEP 2: Video player modal header (dark overlay) — preserve white text */
        html[data-theme="light"] .glass-card .ratio .position-absolute .text-white {
            color: #ffffff !important;
        }

        /* === LIGHT THEME: Outline Buttons & Subtle Badges Fix ===
           Outline buttons (transparent bg) must not have invisible white text.
           Each outline variant: remove white text, use its own brand color. */
        html[data-theme="light"] .btn-outline-secondary {
            color: var(--text-main) !important;
            border-color: rgba(0, 0, 0, 0.2) !important;
        }
        html[data-theme="light"] .btn-outline-secondary:hover,
        html[data-theme="light"] .btn-outline-secondary.active {
            color: #ffffff !important;
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }
        /* Outline primary: use brand crimson color */
        html[data-theme="light"] .btn-outline-primary {
            color: #be123c !important;
            border-color: #be123c !important;
        }
        html[data-theme="light"] .btn-outline-primary:hover {
            color: #ffffff !important;
            background-color: #be123c !important;
        }
        /* Outline warning in light mode: amber color with dark text */
        html[data-theme="light"] .btn-outline-warning {
            color: #92400e !important;
            border-color: #d97706 !important;
        }
        html[data-theme="light"] .btn-outline-warning:hover {
            color: #ffffff !important;
            background-color: #d97706 !important;
        }
        /* Outline info in light mode */
        html[data-theme="light"] .btn-outline-info {
            color: #0891b2 !important;
            border-color: #0891b2 !important;
        }
        html[data-theme="light"] .btn-outline-info:hover {
            color: #ffffff !important;
            background-color: #0891b2 !important;
        }

        /* Subtle-bg badges are very pale in light mode */
        html[data-theme="light"] .badge.bg-secondary-subtle {
            color: var(--text-main) !important;
        }

        /* Input group icons with solid secondary bg */
        html[data-theme="light"] .input-group-text.bg-secondary {
            color: #ffffff !important;
        }

        /* badge-primary-bg: solid primary background */
        html[data-theme="light"] .badge-primary-bg {
            color: #ffffff !important;
        }

        /* === MODAL btn-close Adaptive Filter ===
           In dark mode: btn-close is black by default, must invert to show on dark bg.
           In light mode: btn-close is black by default, works fine on white modal. */
        html[data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        /* btn-close-white (inside dark overlays/video) always inverted */
        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        html[data-theme="light"] .modal-content:not(.bg-dark):not([style*="background: rgba(0"]) .btn-close-white {
            filter: none;
        }

        /* === ORG CHART: Kaban & Sekretaris badge subtle-bg fix in Light Mode ===
           Kaban uses bg-danger-subtle text-danger (not .org-badge class, so
           the org-badge override doesn't apply). Force solid backgrounds here. */
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

        /* Nav Pills - Filter/Navigation Tabs */
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

    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="<?= site_url() ?>" style="font-size: 1.45rem; display: flex; align-items: center; gap: 8px;">
                <img src="<?= base_url('uploads/logo_kesbangpol.png') ?>" alt="Logo Kesbangpol" style="width: 36px; height: 36px; object-fit: contain; border-radius: 50%;">
                SIPAKATAU
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <?php 
                    $uriString = uri_string();
                    $path = $path ?? $uriString;
                    $isHome = ($uriString === '' || $uriString === '/');
                    $isDashboard = (
                        strpos($uriString, 'admin') === 0 || 
                        strpos($uriString, 'bidang') === 0 || 
                        strpos($uriString, 'eksekutif') === 0
                    );
                    $isLoggedIn = session()->get('logged_in');
                    $role = session()->get('role');
                    
                    $isProfilActive = ($uriString === 'profil' || $uriString === 'struktur');
                    $isInformasiActive = (strpos($uriString, 'informasi/') === 0);
                    $isLayananActive = ($uriString === 'maklumat' || strpos($uriString, 'layanan/') === 0);
                    ?>
 
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom <?= $isHome ? 'active' : '' ?>" href="<?= site_url() ?>">Beranda</a>
                    </li>
 
                    <!-- Dropdown Profil -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle <?= $isProfilActive ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profil
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= site_url('profil') ?>">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('struktur') ?>">Struktur Organisasi</a></li>
                        </ul>
                    </li>
 
                    <!-- Dropdown Bidang -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bidang
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= site_url('bidang/sekretariat') ?>">Sekretariat</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('bidang/ideologi') ?>">Bidang Ideologi Pancasila & Wasbang</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('bidang/poldagri') ?>">Bidang Politik Dalam Negeri & Ormas</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('bidang/ekososbud') ?>">Bidang Ketahanan Ekonomi, Sosbud & Agama</a></li>
                        </ul>
                    </li>
 
                    <!-- Dropdown Informasi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle <?= $isInformasiActive ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= site_url('informasi/video') ?>">Video Edukasi</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('informasi/dokumentasi') ?>">Dokumentasi Kegiatan</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('informasi/pengaduan') ?>">Portal Pengaduan</a></li>
                        </ul>
                    </li>
 
                    <!-- Dropdown Layanan -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle <?= $isLayananActive ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Layanan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= site_url('maklumat') ?>">Maklumat Pelayanan</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('layanan/ormas') ?>">Form Registrasi Ormas</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('layanan/rekomendasi') ?>">Rekomendasi Kegiatan</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('layanan/info-registrasi') ?>">Informasi Registrasi Ormas</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('layanan/info-rekomendasi') ?>">Informasi Rekomendasi Kegiatan</a></li>
                        </ul>
                    </li>
 
                    <?php if ($isLoggedIn): ?>
                        <?php
                        $dashUrl = '';
                        $dashLabel = '';
                        if ($role === 'admin') {
                            $dashUrl = 'admin';
                            $dashLabel = 'Dasbor Admin';
                        } elseif ($role === 'pptk') {
                            $dashUrl = 'bidang';
                            $dashLabel = 'Dasbor Bidang';
                        } elseif ($role === 'kaban') {
                            $dashUrl = 'eksekutif';
                            $dashLabel = 'Dasbor Pimpinan';
                        }
                        ?>
                        <?php if (!empty($dashUrl)): ?>
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom <?= ($path === $dashUrl) ? 'active' : '' ?>" href="<?= site_url($dashUrl) ?>">
                                    <i class="fa-solid fa-chart-pie me-1"></i> <?= $dashLabel ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
 
                    <li class="nav-item ms-lg-2">
                        <button type="button" id="theme-toggle" class="btn-theme-toggle">
                            <i id="theme-toggle-icon" class="fa-solid fa-moon"></i>
                        </button>
                    </li>
 
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item ms-lg-3">
                            <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger">
                                <i class="fa-solid fa-right-from-bracket me-2"></i> Log Out
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3">
                            <a href="<?= site_url('login') ?>" class="btn btn-portal">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Log In
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
 
    <!-- Floating Accessibility & Weather Widget -->
    <div class="accessibility-widget d-none d-md-block">
        <div class="widget-card">
            <div class="widget-weather-box">
                <i class="fa-solid fa-cloud-sun fa-lg"></i>
                <div class="widget-temp">26°C</div>
                <div class="widget-condition">Cerah Berawan</div>
            </div>
            <button class="widget-btn" id="zoom-in" title="Perbesar Font"><i class="fa-solid fa-plus"></i></button>
            <button class="widget-btn" id="zoom-out" title="Perkecil Font"><i class="fa-solid fa-minus"></i></button>
            <button class="widget-btn" id="zoom-reset" title="Reset Font"><i class="fa-solid fa-arrows-rotate"></i></button>
        </div>
    </div>
 
    <!-- Breadcrumbs Section -->
    <?php if (!$isHome && $path !== 'login' && $path !== 'logout'): ?>
        <div class="container mt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url() ?>" class="text-decoration-none text-primary"><i class="fa-solid fa-house me-1"></i>Beranda</a></li>
                    <li class="breadcrumb-item active text-muted" aria-current="page"><?= $title ?? 'Halaman' ?></li>
                </ol>
            </nav>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="my-5">
        <div class="container">
            <!-- Flash Message Alerts -->
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

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Footer -->
    <?php if (!$isDashboard): ?>
        <footer class="main-footer" style="border-top: 1px solid var(--border-color); padding: 50px 0 20px;">
            <div class="container">
                <div class="row g-4 mb-4">
                    <!-- Column 1: Info Badan -->
                    <div class="col-lg-5 col-md-12">
                        <div class="footer-title">
                            Badan Kesatuan Bangsa dan Politik Kabupaten Sinjai
                        </div>
                        <p style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px;">
                            Sistem Pelayanan Kesbangpol Terpadu dan Akurat Kabupaten Sinjai. Menyediakan pendaftaran ormas digital, rekomendasi kegiatan, dan monitoring kinerja bidang Kesbangpol secara transparan.
                        </p>
                        <p style="font-size: 0.85rem;" class="footer-text-highlight fw-semibold mb-0">
                            <i class="fa-solid fa-location-dot footer-icon me-2"></i> Jl. Sinjai - Watampone, Biringere, Sinjai, Kabupaten Sinjai, Sulawesi Selatan 92600
                        </p>
                    </div>

                    <!-- Column 2: Kontak Detail -->
                    <div class="col-lg-3 col-md-6">
                        <h5 class="footer-section-title">
                            Kontak
                        </h5>
                        <div class="d-flex flex-column gap-3" style="font-size: 0.9rem;">
                            <div>
                                <div class="footer-label fw-bold mb-1">TELP / WHATSAPP</div>
                                <a href="https://wa.me/628117671545" target="_blank" class="footer-link">
                                    WhatsApp (Chat Only) : <span class="footer-wa-num fw-semibold">0811-7671-545</span>
                                </a>
                            </div>
                            <div>
                                <div class="footer-label fw-bold mb-1">EMAIL RESMI</div>
                                <a href="mailto:kesbangpol@sinjaikab.go.id" class="footer-link">
                                    kesbangpol@sinjaikab.go.id
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Lokasi Maps & Social Media -->
                    <div class="col-lg-4 col-md-6">
                        <h5 class="footer-section-title">
                            Lokasi Kantor
                        </h5>
                        <div class="mb-3 overflow-hidden rounded shadow-sm border" style="border-color: var(--border-color) !important;">
                            <!-- Embedded Google Maps mapping to Bakesbangpol Sinjai with new coordinates -->
                            <iframe src="https://maps.google.com/maps?q=-5.1326246,120.2500688&hl=id&z=16&output=embed" width="100%" height="130" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        
                        <!-- Social Media Links -->
                        <div class="d-flex gap-2">
                            <a href="https://facebook.com" target="_blank" class="social-circle-btn"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://twitter.com" target="_blank" class="social-circle-btn"><i class="fa-brands fa-twitter"></i></a>
                            <a href="https://instagram.com" target="_blank" class="social-circle-btn"><i class="fa-brands fa-instagram"></i></a>
                            <a href="https://youtube.com" target="_blank" class="social-circle-btn"><i class="fa-brands fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-3 text-center footer-copyright small" style="border-color: var(--border-color) !important;">
                    <p class="mb-0">&copy; <?= date('Y') ?> SIPAKATAU. All Rights Reserved. Developer Partner Identity: <b>Diskominfo Sinjai</b></p>
                </div>
            </div>
        </footer>
    <?php else: ?>
        <footer class="py-3 mt-auto border-top main-footer" style="border-color: var(--border-color) !important;">
            <div class="container text-center footer-copyright small">
                <p class="mb-0">&copy; <?= date('Y') ?> SIPAKATAU. All Rights Reserved. Developer Partner Identity: <b>Diskominfo Sinjai</b></p>
            </div>
        </footer>
    <?php endif; ?>

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
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleIcon = document.getElementById('theme-toggle-icon');
            
            function updateToggleIcon(theme) {
                if (theme === 'light') {
                    themeToggleIcon.classList.remove('fa-moon');
                    themeToggleIcon.classList.add('fa-sun');
                    themeToggleIcon.style.color = '#eab308'; // sun yellow color
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

            // Accessibility Font Zoom functionality
            let currentScale = 100;
            const zoomInBtn = document.getElementById('zoom-in');
            const zoomOutBtn = document.getElementById('zoom-out');
            const zoomResetBtn = document.getElementById('zoom-reset');

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

            // Red required asterisks handler for form labels
            document.querySelectorAll('label').forEach(label => {
                if (label.innerHTML.includes('*')) {
                    label.innerHTML = label.innerHTML.replace(/\s*\*/g, ' <span class="text-danger fw-bold">*</span>');
                }
            });
        });

        // Global Dynamic Toast Function
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
