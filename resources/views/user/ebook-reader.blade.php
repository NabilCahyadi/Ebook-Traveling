<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Prevent screenshot on some mobile browsers -->
    <meta name="screenshot" content="disabled">
    <meta name="screen-capture" content="disabled">
    
    <!-- Prevent caching -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Prevent iframe embedding -->
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none'">
    
    <title>{{ $ebook->title }} - Ebook Reader</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap"
        rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background: #f5f5f5;
            /* Disable text selection */
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            /* Prevent touch selection on mobile */
            -webkit-touch-callout: none;
            /* Prevent drag */
            -webkit-user-drag: none;
            /* Additional protection */
            pointer-events: auto;
        }

        /* Prevent any element from being dragged */
        * {
            -webkit-user-drag: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide scrollbar screenshots */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Reader Header */
        .reader-header {
            background: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reader-header h1 {
            font-size: 1.25rem;
            color: #333;
            font-weight: 600;
        }

        .back-btn {
            padding: 0.5rem 1rem;
            background: #7367f0;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #5e50ee;
        }

        /* Reader Container */
        .reader-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .reader-content {
            background: white;
            padding: 3rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            min-height: 70vh;
            font-size: 1.125rem;
            line-height: 1.8;
            color: #333;
            /* Add watermark protection */
            position: relative;
        }

        /* Watermark overlay */
        .reader-content::before {
            content: '{{ Auth::user()->email }} - {{ now()->format('Y-m-d H:i') }}';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 2rem;
            color: rgba(0, 0, 0, 0.05);
            white-space: nowrap;
            pointer-events: none;
            z-index: 1;
            font-weight: 600;
        }

        .content-text {
            position: relative;
            z-index: 2;
        }

        /* Loading state */
        .loading {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        /* Protection overlay (invisible but blocks interactions) */
        .protection-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: transparent;
            z-index: 9999;
            display: none;
        }

        /* Warning message */
        .warning-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(239, 68, 68, 0.95);
            color: white;
            padding: 2rem 3rem;
            border-radius: 8px;
            font-size: 1.125rem;
            text-align: center;
            display: none;
            z-index: 10000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .warning-message.show {
            display: block;
            animation: shake 0.5s;
        }

        /* Additional protection - hide on print */
        @media print {
            body {
                display: none !important;
            }
        }

        /* Hide content when inspecting */
        .devtools-open {
            filter: blur(20px) !important;
            pointer-events: none !important;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            25% {
                transform: translate(-50%, -50%) rotate(-5deg);
            }

            75% {
                transform: translate(-50%, -50%) rotate(5deg);
            }
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .reader-content {
                padding: 1.5rem;
                font-size: 1rem;
            }

            .reader-content::before {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Protection Overlay -->
    <div class="protection-overlay" id="protectionOverlay"></div>

    <!-- Warning Message -->
    <div class="warning-message" id="warningMessage">
        ⚠️ Screenshot/Recording Detected!<br>
        <small>This action is not allowed</small>
    </div>

    <!-- Reader Header -->
    <div class="reader-header">
        <h1>{{ $ebook->title }}</h1>
        <a href="{{ url()->previous() }}" class="back-btn">← Back</a>
    </div>

    <!-- Reader Content -->
    <div class="reader-container">
        <div class="reader-content" id="readerContent">
            <div class="loading">Loading content...</div>
        </div>
    </div>

    <script>
        // Store session token
        const ebookId = {{ $ebook->id }};
        const readerToken = '{{ Str::random(32) }}';

        // Save token to session
        fetch('/api/set-reader-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                ebook_id: ebookId,
                token: readerToken
            })
        });

        // Disable right-click
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            showWarning();
            return false;
        });

        // Disable keyboard shortcuts for screenshot/save/devtools
        document.addEventListener('keydown', function(e) {
            // Disable PrintScreen
            if (e.key === 'PrintScreen') {
                e.preventDefault();
                showWarning();
                navigator.clipboard.writeText('');
                return false;
            }

            // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C (DevTools)
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) ||
                (e.ctrlKey && e.shiftKey && (e.key === 'J' || e.key === 'j')) ||
                (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c')) ||
                (e.ctrlKey && e.shiftKey && (e.key === 'K' || e.key === 'k')) ||
                (e.metaKey && e.altKey && (e.key === 'I' || e.key === 'i')) || // Mac
                (e.metaKey && e.altKey && (e.key === 'J' || e.key === 'j')) || // Mac
                (e.metaKey && e.altKey && (e.key === 'C' || e.key === 'c'))    // Mac
            ) {
                e.preventDefault();
                e.stopPropagation();
                showWarning();
                return false;
            }

            // Disable Ctrl+U (View Source)
            if (e.ctrlKey && (e.key === 'u' || e.key === 'U')) {
                e.preventDefault();
                e.stopPropagation();
                showWarning();
                return false;
            }

            // Disable Ctrl+S (Save), Ctrl+P (Print)
            if (
                (e.ctrlKey && (e.key === 's' || e.key === 'S')) ||
                (e.ctrlKey && (e.key === 'p' || e.key === 'P'))
            ) {
                e.preventDefault();
                showWarning();
                return false;
            }

            // Disable Ctrl+A (Select All)
            if (e.ctrlKey && (e.key === 'a' || e.key === 'A')) {
                e.preventDefault();
                return false;
            }

            // Disable Ctrl+C, Ctrl+V, Ctrl+X (Copy, Paste, Cut)
            if (
                (e.ctrlKey && (e.key === 'c' || e.key === 'C')) ||
                (e.ctrlKey && (e.key === 'v' || e.key === 'V')) ||
                (e.ctrlKey && (e.key === 'x' || e.key === 'X'))
            ) {
                e.preventDefault();
                showWarning();
                return false;
            }
        }, true);

        // Detect screenshot attempts (when window loses focus)
        let lastFocusTime = Date.now();
        let screenshotAttempts = 0;
        
        window.addEventListener('blur', function() {
            lastFocusTime = Date.now();
            // Hide content when window loses focus
            document.getElementById('readerContent').style.opacity = '0.1';
        });

        window.addEventListener('focus', function() {
            const blurDuration = Date.now() - lastFocusTime;
            // Restore content
            document.getElementById('readerContent').style.opacity = '1';
            
            // If blur duration is very short, might be screenshot
            if (blurDuration < 100) {
                screenshotAttempts++;
                showWarning();
                
                // After 3 attempts, redirect
                if (screenshotAttempts >= 3) {
                    alert('Multiple screenshot attempts detected. You will be redirected.');
                    window.location.href = '/dashboard';
                }
            }
        });

        // Detect PrintScreen key via clipboard monitoring
        document.addEventListener('keyup', function(e) {
            if (e.key === 'PrintScreen') {
                navigator.clipboard.writeText('');
                showWarning();
                screenshotAttempts++;
                
                if (screenshotAttempts >= 3) {
                    alert('Multiple screenshot attempts detected. You will be redirected.');
                    window.location.href = '/dashboard';
                }
            }
        });

        // Advanced DevTools detection
        let devToolsOpen = false;
        const devToolsCheck = setInterval(function() {
            const widthThreshold = window.outerWidth - window.innerWidth > 160;
            const heightThreshold = window.outerHeight - window.innerHeight > 160;
            const orientation = widthThreshold ? 'vertical' : 'horizontal';

            if (widthThreshold || heightThreshold) {
                if (!devToolsOpen) {
                    devToolsOpen = true;
                    document.getElementById('protectionOverlay').style.display = 'block';
                    document.getElementById('readerContent').style.filter = 'blur(10px)';
                    showWarning();
                    
                    // Redirect after 3 seconds
                    setTimeout(() => {
                        window.location.href = '/dashboard';
                    }, 3000);
                }
            } else {
                if (devToolsOpen) {
                    devToolsOpen = false;
                    document.getElementById('protectionOverlay').style.display = 'none';
                    document.getElementById('readerContent').style.filter = 'none';
                }
            }
        }, 500);

        // Alternative DevTools detection using console
        const element = new Image();
        Object.defineProperty(element, 'id', {
            get: function() {
                devToolsOpen = true;
                document.getElementById('protectionOverlay').style.display = 'block';
                document.getElementById('readerContent').style.filter = 'blur(10px)';
                showWarning();
                throw new Error('DevTools detected');
            }
        });

        setInterval(() => {
            console.clear();
            console.log('%cStop!', 'color: red; font-size: 50px; font-weight: bold;');
            console.log('%cThis is a browser feature intended for developers.', 'font-size: 18px;');
            console.log('%cIf someone told you to copy-paste something here, it is a scam.', 'font-size: 18px;');
            console.log('%cPasting anything here could give attackers access to your account.', 'font-size: 18px; color: red;');
            console.log(element);
        }, 1000);

        // Show warning message
        function showWarning() {
            const warning = document.getElementById('warningMessage');
            warning.classList.add('show');
            setTimeout(() => {
                warning.classList.remove('show');
            }, 2000);
        }

        // Load content dynamically
        window.addEventListener('DOMContentLoaded', function() {
            // Simulate content loading with protection
            setTimeout(() => {
                const content = `
                    <div class="content-text">
                        <h2>{{ $ebook->title }}</h2>
                        <p style="color: #666; margin: 1rem 0;">
                            <strong>Category:</strong> {{ $ebook->category->name ?? 'N/A' }} |
                            <strong>Location:</strong> {{ $ebook->city->name ?? 'N/A' }}
                        </p>
                        <hr style="margin: 2rem 0; border: none; border-top: 1px solid #eee;">

                        <div style="white-space: pre-line;">{{ $ebook->preview_content ?? $ebook->description }}</div>

                        <div style="margin-top: 3rem; padding: 2rem; background: #f9f9f9; border-radius: 8px; text-align: center;">
                            <p style="color: #666; margin: 0;">
                                📚 This is a protected ebook. Content cannot be downloaded or copied.
                            </p>
                        </div>
                    </div>
                `;

                document.getElementById('readerContent').innerHTML = content;
            }, 500);
        });

        // Prevent drag and drop
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });

        // Prevent copying
        document.addEventListener('copy', function(e) {
            e.preventDefault();
            showWarning();
            return false;
        });

        // Clear clipboard periodically
        setInterval(function() {
            if (document.hasFocus()) {
                navigator.clipboard.writeText('').catch(() => {});
            }
        }, 1000);

        // Detect screen recording and block it
        if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
            const originalGetDisplayMedia = navigator.mediaDevices.getDisplayMedia;
            navigator.mediaDevices.getDisplayMedia = function() {
                showWarning();
                alert('Screen recording is not allowed on this page!');
                return Promise.reject(new Error('Screen recording is not allowed'));
            };
        }

        // Block getUserMedia (screen capture)
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const originalGetUserMedia = navigator.mediaDevices.getUserMedia;
            navigator.mediaDevices.getUserMedia = function(constraints) {
                if (constraints && constraints.video && constraints.video.displaySurface) {
                    showWarning();
                    alert('Screen recording is not allowed!');
                    return Promise.reject(new Error('Screen recording blocked'));
                }
                return originalGetUserMedia.call(this, constraints);
            };
        }

        // Detect if page is in an iframe (potential screen recording tool)
        if (window.self !== window.top) {
            document.body.innerHTML = '<h1 style="text-align:center;margin-top:50px;">This content cannot be displayed in a frame.</h1>';
        }

        // Watermark with user info
        setInterval(function() {
            const watermarks = document.querySelectorAll('.reader-content::before');
            // Watermark is in CSS, this just ensures it stays
        }, 5000);

        // Block right-click on all elements (backup)
        document.body.oncontextmenu = function() {
            showWarning();
            return false;
        };

        // Disable drag on images and links
        document.ondragstart = function() {
            return false;
        };

        // Disable selection start
        document.onselectstart = function() {
            return false;
        };

        // Monitor for debugger
        setInterval(function() {
            debugger;
        }, 100);

        // Prevent opening source with keyboard
        window.addEventListener('keypress', function(e) {
            if (e.ctrlKey && (e.key === 'u' || e.key === 'U')) {
                e.preventDefault();
                showWarning();
                return false;
            }
        });

        // Clear console periodically to remove any debugging info
        setInterval(() => {
            console.clear();
        }, 100);

        // Detect if running in mobile devtools
        const checkMobileDebug = () => {
            const threshold = 160;
            if (
                window.outerWidth - window.innerWidth > threshold ||
                window.outerHeight - window.innerHeight > threshold
            ) {
                document.body.innerHTML = '';
                alert('Developer tools detected! Page will be closed.');
                window.location.href = '/dashboard';
            }
        };
        setInterval(checkMobileDebug, 1000);

        // Prevent text selection via CSS manipulation
        document.addEventListener('DOMContentLoaded', function() {
            const style = document.createElement('style');
            style.textContent = `
                * {
                    -webkit-tap-highlight-color: transparent !important;
                    -webkit-touch-callout: none !important;
                }
            `;
            document.head.appendChild(style);
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            clearInterval(devToolsCheck);
        });
    </script>
</body>

</html>
