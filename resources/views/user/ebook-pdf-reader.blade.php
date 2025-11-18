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
    
    <title>{{ $ebook->title }} - PDF Reader</title>

    <!-- PDF.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -webkit-user-drag: none;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #2c3e50;
            overflow: hidden;
            position: relative;
        }

        /* Protection Overlay */
        .protection-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
            text-align: center;
        }

        /* Warning Message */
        .warning-message {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(231, 76, 60, 0.95);
            color: white;
            padding: 2rem 3rem;
            border-radius: 8px;
            font-size: 1.25rem;
            text-align: center;
            display: none;
            z-index: 10000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .warning-message.show {
            display: block;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
            25% { transform: translate(-50%, -50%) rotate(-5deg); }
            75% { transform: translate(-50%, -50%) rotate(5deg); }
        }

        /* Header */
        .pdf-header {
            background: #34495e;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 100;
        }

        .pdf-header h1 {
            font-size: 1.25rem;
            color: #ecf0f1;
            font-weight: 600;
        }

        .pdf-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .pdf-controls button {
            background: #3498db;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background 0.3s;
        }

        .pdf-controls button:hover {
            background: #2980b9;
        }

        .pdf-controls button:disabled {
            background: #7f8c8d;
            cursor: not-allowed;
        }

        .page-info {
            color: #ecf0f1;
            font-size: 0.9rem;
        }

        .back-btn {
            background: #e74c3c;
            padding: 0.5rem 1rem;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .back-btn:hover {
            background: #c0392b;
        }

        /* PDF Container */
        .pdf-container {
            width: 100%;
            height: calc(100vh - 70px);
            overflow: auto;
            background: #34495e;
            display: flex;
            justify-content: center;
            padding: 2rem 0;
            position: relative;
        }

        #pdf-canvas-wrapper {
            position: relative;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        #pdf-canvas {
            display: block;
            max-width: 100%;
            height: auto;
        }

        /* Watermark Overlay on Canvas */
        .watermark-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
        }

        .watermark-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 3rem;
            color: rgba(0, 0, 0, 0.08);
            white-space: nowrap;
            font-weight: bold;
            text-align: center;
            line-height: 1.5;
        }

        /* Loading */
        .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.5rem;
        }

        /* Hide scrollbar but keep functionality */
        .pdf-container::-webkit-scrollbar {
            width: 10px;
        }

        .pdf-container::-webkit-scrollbar-track {
            background: #2c3e50;
        }

        .pdf-container::-webkit-scrollbar-thumb {
            background: #34495e;
            border-radius: 5px;
        }

        @media print {
            body { display: none !important; }
        }
    </style>
</head>
<body>
    <!-- Protection Overlay -->
    <div class="protection-overlay" id="protectionOverlay">
        <div>
            <h2>⚠️ Developer Tools Detected</h2>
            <p>Please close developer tools to continue</p>
        </div>
    </div>

    <!-- Warning Message -->
    <div class="warning-message" id="warningMessage">
        ⚠️ Action Not Allowed!<br>
        <small>This content is protected</small>
    </div>

    <!-- PDF Header -->
    <div class="pdf-header">
        <h1>📖 {{ $ebook->title }}</h1>
        <div class="pdf-controls">
            <button id="prev-page" onclick="prevPage()">← Previous</button>
            <span class="page-info">
                Page <span id="current-page">1</span> of <span id="total-pages">0</span>
            </span>
            <button id="next-page" onclick="nextPage()">Next →</button>
            <button onclick="zoomIn()">🔍 +</button>
            <button onclick="zoomOut()">🔍 -</button>
        </div>
        <a href="{{ url()->previous() }}" class="back-btn">✕ Close</a>
    </div>

    <!-- PDF Container -->
    <div class="pdf-container" id="pdf-container">
        <div id="pdf-canvas-wrapper">
            <canvas id="pdf-canvas"></canvas>
            <div class="watermark-overlay">
                <div class="watermark-text">
                    {{ Auth::user()->email }}<br>
                    {{ now()->format('Y-m-d H:i') }}
                </div>
            </div>
        </div>
        <div class="loading" id="loading">Loading PDF...</div>
    </div>

    <script>
        // PDF.js Configuration
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        let pdfDoc = null;
        let currentPage = 1;
        let scale = 1.5;
        let isRendering = false;

        // Session token for security
        const ebookId = {{ $ebook->id }};
        const pdfToken = '{{ Str::random(32) }}';

        // Save token to session
        fetch('/api/set-pdf-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                ebook_id: ebookId,
                token: pdfToken
            })
        });

        // ============= SECURITY PROTECTIONS =============

        // Disable right-click
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            showWarning();
            return false;
        }, true);

        // Disable all keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // PrintScreen
            if (e.key === 'PrintScreen') {
                e.preventDefault();
                showWarning();
                navigator.clipboard.writeText('');
                return false;
            }

            // F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C (DevTools)
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i')) ||
                (e.ctrlKey && e.shiftKey && (e.key === 'J' || e.key === 'j')) ||
                (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c')) ||
                (e.ctrlKey && e.shiftKey && (e.key === 'K' || e.key === 'k'))
            ) {
                e.preventDefault();
                e.stopPropagation();
                showWarning();
                return false;
            }

            // Ctrl+U (View Source)
            if (e.ctrlKey && (e.key === 'u' || e.key === 'U')) {
                e.preventDefault();
                showWarning();
                return false;
            }

            // Ctrl+S (Save), Ctrl+P (Print)
            if ((e.ctrlKey && (e.key === 's' || e.key === 'S')) || 
                (e.ctrlKey && (e.key === 'p' || e.key === 'P'))) {
                e.preventDefault();
                showWarning();
                return false;
            }

            // Ctrl+A, Ctrl+C, Ctrl+X (Select, Copy, Cut)
            if (e.ctrlKey && ((e.key === 'a' || e.key === 'A') || 
                              (e.key === 'c' || e.key === 'C') || 
                              (e.key === 'x' || e.key === 'X'))) {
                e.preventDefault();
                showWarning();
                return false;
            }
        }, true);

        // Detect screenshot via PrintScreen
        document.addEventListener('keyup', function(e) {
            if (e.key === 'PrintScreen') {
                navigator.clipboard.writeText('');
                showWarning();
            }
        });

        // Hide content when window loses focus (screenshot attempt)
        let screenshotAttempts = 0;
        window.addEventListener('blur', function() {
            document.getElementById('pdf-canvas-wrapper').style.opacity = '0.05';
        });

        window.addEventListener('focus', function() {
            document.getElementById('pdf-canvas-wrapper').style.opacity = '1';
        });

        // DevTools Detection
        let devToolsOpen = false;
        const devToolsCheck = setInterval(function() {
            const widthThreshold = window.outerWidth - window.innerWidth > 160;
            const heightThreshold = window.outerHeight - window.innerHeight > 160;

            if (widthThreshold || heightThreshold) {
                if (!devToolsOpen) {
                    devToolsOpen = true;
                    document.getElementById('protectionOverlay').style.display = 'flex';
                    document.getElementById('pdf-canvas-wrapper').style.filter = 'blur(20px)';
                    showWarning();
                }
            } else {
                if (devToolsOpen) {
                    devToolsOpen = false;
                    document.getElementById('protectionOverlay').style.display = 'none';
                    document.getElementById('pdf-canvas-wrapper').style.filter = 'none';
                }
            }
        }, 500);

        // Prevent screen recording
        if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
            const originalGetDisplayMedia = navigator.mediaDevices.getDisplayMedia;
            navigator.mediaDevices.getDisplayMedia = function() {
                showWarning();
                alert('Screen recording is not allowed!');
                return Promise.reject(new Error('Screen recording blocked'));
            };
        }

        // Block iframe embedding
        if (window.self !== window.top) {
            document.body.innerHTML = '<h1 style="text-align:center;margin-top:50px;color:white;">This content cannot be displayed in a frame.</h1>';
        }

        // Disable drag
        document.ondragstart = function() { return false; };
        document.onselectstart = function() { return false; };

        // Clear console periodically
        setInterval(() => console.clear(), 100);

        // Show warning message
        function showWarning() {
            const warning = document.getElementById('warningMessage');
            warning.classList.add('show');
            setTimeout(() => warning.classList.remove('show'), 2000);
        }

        // ============= PDF RENDERING =============

        // Load PDF from server
        const pdfUrl = '/api/ebook/{{ $ebook->id }}/pdf?token=' + pdfToken;

        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
            pdfDoc = pdf;
            document.getElementById('total-pages').textContent = pdf.numPages;
            document.getElementById('loading').style.display = 'none';
            renderPage(currentPage);
        }).catch(function(error) {
            document.getElementById('loading').innerHTML = 
                '<div style="color: #e74c3c;">Failed to load PDF. Please refresh the page.</div>';
            console.error('Error loading PDF:', error);
        });

        // Render specific page
        function renderPage(pageNum) {
            if (isRendering) return;
            isRendering = true;

            pdfDoc.getPage(pageNum).then(function(page) {
                const canvas = document.getElementById('pdf-canvas');
                const context = canvas.getContext('2d');
                const viewport = page.getViewport({ scale: scale });

                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };

                page.render(renderContext).promise.then(function() {
                    isRendering = false;
                    document.getElementById('current-page').textContent = pageNum;
                    updateButtons();
                });
            });
        }

        // Navigation functions
        function prevPage() {
            if (currentPage <= 1) return;
            currentPage--;
            renderPage(currentPage);
        }

        function nextPage() {
            if (currentPage >= pdfDoc.numPages) return;
            currentPage++;
            renderPage(currentPage);
        }

        function zoomIn() {
            scale += 0.25;
            renderPage(currentPage);
        }

        function zoomOut() {
            if (scale <= 0.5) return;
            scale -= 0.25;
            renderPage(currentPage);
        }

        function updateButtons() {
            document.getElementById('prev-page').disabled = currentPage <= 1;
            document.getElementById('next-page').disabled = currentPage >= pdfDoc.numPages;
        }

        // Cleanup
        window.addEventListener('beforeunload', function() {
            clearInterval(devToolsCheck);
        });
    </script>
</body>
</html>
