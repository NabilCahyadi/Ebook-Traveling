<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ebook->title }} - Reader</title>
    <!-- PDF.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf_viewer.min.css">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- Style Layout & Desain --- */
        body,
        html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #2c2c2c;
            /* Warna latar yang sedikit lebih terang */
            color: #d4d4d4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #pdf-container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- DESAIN ULANG TOTAL UNTUK KONTROL --- */
        #pdf-controls {
            padding: 12px 20px;
            background: linear-gradient(to bottom, #3a3a3a, #2e2e2e);
            /* Gradien modern */
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            /* Jangan pindah baris */
            gap: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            z-index: 10;
            border-bottom: 1px solid #4a4a4a;
        }

        /* --- DESAIN KHUSUS UNTUK NAVIGASI HALAMAN --- */
        .nav-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .control-btn {
            background-color: #5a5a5a;
            border: 1px solid #6a6a6a;
            color: #ffffff;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            min-height: 44px;
        }

        .control-btn:hover {
            background-color: #7a7a7a;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .control-btn:active {
            transform: translateY(0);
            /* Kembali ke posisi saat ditekan */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* --- DESAIN KHUSUS UNTUK INFO HALAMAN --- */
        .page-info {
            font-size: 16px;
            color: #ffffff;
            background-color: #4a4a4a;
            padding: 8px 16px;
            border-radius: 20px;
            /* Bentuk kapsul */
            user-select: none;
            font-weight: 500;
            min-width: 80px;
            text-align: center;
        }

        .zoom-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        #fit-width {
            min-width: 75px;
            font-size: 13px;
            padding: 10px 8px;
            text-align: center;
            background-color: #FF4C61;
            /* Warna berbeda untuk tombol fitur */
            border-color: #FF4C61;
        }

        #fit-width:hover {
            background-color: #e7384cff;
        }

        /* --- Responsif --- */
        @media (max-width: 768px) {
            #pdf-controls {
                padding: 8px 15px;
                gap: 10px;
            }

            .control-btn {
                padding: 8px 12px;
                font-size: 14px;
                min-width: 40px;
                min-height: 40px;
            }

            .page-info {
                font-size: 14px;
                padding: 6px 12px;
            }
        }

        #pdf-canvas-container {
            flex-grow: 1;
            overflow: auto;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background-color: #1a1a1a;
        }

        #pdf-canvas {
            border: 1px solid #444;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
            margin: 20px 0;
        }

        /* Loading Indicator */
        #loading-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(28, 28, 28, 0.95);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-size: 18px;
            color: #e0e0e0;
            z-index: 1000;
        }

        #loading-indicator i {
            font-size: 48px;
            margin-bottom: 20px;
        }

        /* --- Style Keamanan --- */
        body,
        #pdf-container,
        #pdf-canvas {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        img,
        canvas {
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            user-drag: none;
        }

        /* --- Watermark Background (Pola Berulang) --- */
        #watermark-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
            /* Di bawah watermark tengah */
            background-image: url('data:image/svg+xml;base64,{{ base64_encode(' <svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" ><text x="50%" y="50%" font-size="30" fill="rgba(255,255,255,0.08)" text-anchor="middle" dominant-baseline="middle" transform="rotate(-45 200 200)" >' . e(Auth::user()->email) . ' </text></svg>') }}');
            background-repeat: repeat;
            animation: watermark-move 30s linear infinite;
        }

        /* --- Animasi untuk watermark background --- */
        @keyframes watermark-move {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 400px 400px;
            }
        }

        /* --- TAMBAHKAN CSS INI --- */
        #watermark-center {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%) rotate(-90deg);
            pointer-events: none;
            z-index: 3;
            font-size: 1.3rem;
            font-weight: bold;
            color: rgba(133, 133, 133, 0.29);
            text-align: center;
            white-space: nowrap;
            border: 5px solid rgba(255, 255, 255, 0.1);
            padding: 10px 20px;
            border-radius: 10px;
        }

        /* --- GROUP KANAN UNTUK BOOKMARK INFO --- */
        .bookmark-info-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
        }

        .bookmark-info {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(64, 64, 64, 0.7);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            color: #e0e0e0;
            border: 1px solid #4a4a4a;
            white-space: nowrap;
        }

        .bookmark-info i {
            color: #FF4C61;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <!-- Loading Indicator -->
    <div id="loading-indicator">
        <i class="fas fa-spinner fa-spin"></i>
        <span>Loading Ebook...</span>
    </div>

    <div id="pdf-container">
        <div id="pdf-controls">
            <button id="fullscreen" class="control-btn" title="Fullscreen"><i class="fas fa-expand"></i></button>
            <button id="bookmark-btn" class="control-btn" style="background-color: #FF4C61; border-color: #FF4C61;" title="Mark as last read"><i class="fas fa-bookmark"></i></button>
            <div class="zoom-controls">
                <button id="zoom-out" class="control-btn" title="Zoom In"><i class="fas fa-search-minus"></i></button>
                <button id="fit-width" class="control-btn" title="Fit Width">100%</button>
                <button id="zoom-in" class="control-btn" title="Zoom Out"><i class="fas fa-search-plus"></i></button>
            </div>

            <div class="bookmark-info-container">
                <div class="bookmark-info">
                    <span>Last : Pg. {{ $startPage ?? 1 }}</span>
                </div>
            </div>
            <div class="nav-controls">
                <button id="prev-page" class="control-btn" title="Previous Page"><i class="fas fa-chevron-left"></i></button>
                <div class="page-info">
                    <span id="page-num">1</span> / <span id="page-count">-</span>
                </div>
                <button id="next-page" class="control-btn" title="Next page"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
        <div id="pdf-canvas-container">
            <!-- TAMBAHKAN WATERMARK BACKGROUND -->
            <div id="watermark-bg"></div>

            <!-- TAMBAHKAN WATERMARK TENGAH (INI YANG BARU) -->
            <div id="watermark-center">
                {{ Auth::user()->name }}<br>
                <span style="font-size: 2rem;">{{ Auth::user()->email }}</span>
            </div>

            <canvas id="pdf-canvas"></canvas>
        </div>
    </div>

    <!-- PDF.js JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        // Atur worker source untuk PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        // --- Logika PDF Viewer ---
        const url = "{{ $ebook->pdf_file_url }}"; // Gunakan accessor untuk handle storage path
        let pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            currentScale = 1.0,
            canvas = document.getElementById('pdf-canvas'),
            ctx = canvas.getContext('2d'),
            loadingIndicator = document.getElementById('loading-indicator'),
            fitWidthBtn = document.getElementById('fit-width');

        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({
                    scale: currentScale
                });
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                const renderTask = page.render(renderContext);
                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });
            document.getElementById('page-num').textContent = num;
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        function onPrevPage() {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        }

        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('prev-page').addEventListener('click', onPrevPage);
        document.getElementById('next-page').addEventListener('click', onNextPage);

        function fitToWidth() {
            if (!pdfDoc) return;
            pdfDoc.getPage(pageNum).then(function(page) {
                const viewport = page.getViewport({
                    scale: 1.0
                });
                const containerWidth = document.getElementById('pdf-canvas-container').clientWidth - 40;
                currentScale = containerWidth / viewport.width;
                fitWidthBtn.textContent = Math.round(currentScale * 100) + '%';
                queueRenderPage(pageNum);
            });
        }
        document.getElementById('fit-width').addEventListener('click', fitToWidth);
        document.getElementById('zoom-in').addEventListener('click', () => {
            currentScale += 0.25;
            fitWidthBtn.textContent = Math.round(currentScale * 100) + '%';
            queueRenderPage(pageNum);
        });
        document.getElementById('zoom-out').addEventListener('click', () => {
            if (currentScale <= 0.5) return;
            currentScale -= 0.25;
            fitWidthBtn.textContent = Math.round(currentScale * 100) + '%';
            queueRenderPage(pageNum);
        });
        document.getElementById('fullscreen').addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        });

        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
            loadingIndicator.style.display = 'none';
            fitToWidth();
        }).catch(function(error) {
            console.error('Error loading PDF:', error);
            loadingIndicator.innerHTML = '<i class="fas fa-exclamation-triangle"></i><span>Gagal memuat PDF. File mungkin rusak atau tidak ditemukan.</span>';
        });


        // --- LOGIKA KEAMANAN YANG DIPERKUAT ---
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', e => {
            if (e.ctrlKey || e.metaKey) {
                if ([67, 86, 88, 83, 80].includes(e.keyCode)) e.preventDefault();
            }
            if (e.keyCode == 123) e.preventDefault(); // F12
            if (e.key === 'PrintScreen') {
                alert('Screenshot tidak diperbolehkan.');
                e.preventDefault();
            }
        });
        document.addEventListener('copy', e => e.preventDefault());
        document.addEventListener('cut', e => e.preventDefault());

        // --- DETERREN 1: Kosongkan clipboard secara agresif ---
        setInterval(() => {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText('').catch(err => {});
            }
        }, 500); // Setiap 0.5 detik

        // --- DETERREN 2: Deteksi Pembukaan Developer Tools ---
        let devtools = {
            open: false,
            orientation: null
        };
        const threshold = 160;
        setInterval(() => {
            if (window.outerHeight - window.innerHeight > threshold || window.outerWidth - window.innerWidth > threshold) {
                if (!devtools.open) {
                    devtools.open = true;
                    // Kosongkan halaman jika DevTools terbuka
                    document.body.innerHTML = '<div style="display:flex; justify-content:center; align-items:center; height:100vh; background:#222; color:white; font-family:sans-serif; text-align:center; padding:20px;"><h1>Developer Tools Tidak Diizinkan</h1><p>Mohon tutup Developer Tools untuk melanjutkan membaca.</p></div>';
                }
            } else {
                devtools.open = false;
            }
        }, 500);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ✅ Ambil halaman awal dari URL
            const urlParams = new URLSearchParams(window.location.search);
            let currentPage = parseInt(urlParams.get('page')) || {
                {
                    $startPage ?? 1
                }
            };
            const ebookId = "{{ $ebook->id }}";
            const updateUrl = '{{ route("user.reader.updateProgress") }}';
            const csrfToken = '{{ csrf_token() }}';

            // ✅ Scroll ke halaman awal
            if (pdfDoc) {
                pageNum = currentPage;
                queueRenderPage(currentPage);
            }

            // ✅ Kirim progress saat halaman berubah
            function sendProgress(page) {
                fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        ebook_id: ebookId,
                        last_page: page
                    })
                }).catch(err => console.warn('Progress save:', err));
            }

            // ✅ Hook ke nextPage/prevPage
            document.getElementById('next-page').addEventListener('click', () => {
                if (pageNum < pdfDoc.numPages) {
                    pageNum++;
                    sendProgress(pageNum);
                }
            });

            document.getElementById('prev-page').addEventListener('click', () => {
                if (pageNum > 1) {
                    pageNum--;
                    sendProgress(pageNum);
                }
            });

            // ✅ Simpan saat unload
            window.addEventListener('beforeunload', () => {
                navigator.sendBeacon(updateUrl, JSON.stringify({
                    ebook_id: ebookId,
                    last_page: pageNum
                }));
            });
        });
    </script>
    <script>
        // Atur worker source untuk PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        // --- Variabel Utama ---
        const url = "{{ $ebook->pdf_file_url }}";
        let pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            currentScale = 1.0;

        // --- Elemen DOM ---
        const canvas = document.getElementById('pdf-canvas');
        const ctx = canvas.getContext('2d');
        const loadingIndicator = document.getElementById('loading-indicator');
        const fitWidthBtn = document.getElementById('fit-width');

        // --- Variabel untuk Progress ---
        const ebookId = "{{ $ebook->id }}";
        const updateUrl = '{{ route("user.reader.updateProgress") }}';
        const csrfToken = '{{ csrf_token() }}';

        // --- Fungsi untuk Mengirim Progress ke Server ---
        function sendProgress() {
            console.log(`Sending progress: ebook_id=${ebookId}, last_page=${pageNum}`);

            fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        ebook_id: ebookId,
                        last_page: pageNum
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Progress saved:', data.data);
                    } else {
                        console.error('Server returned an error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error saving progress:', error);
                });
        }

        // --- Logika Render Halaman PDF.js ---
        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({
                    scale: currentScale
                });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                const renderTask = page.render(renderContext);

                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update nomor halaman di UI
            document.getElementById('page-num').textContent = num;
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        // --- Event Listener untuk Navigasi Halaman ---
        function onPrevPage() {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
            sendProgress(); // Kirim progress saat halaman berubah
        }

        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
            sendProgress(); // Kirim progress saat halaman berubah
        }

        document.getElementById('prev-page').addEventListener('click', onPrevPage);
        document.getElementById('next-page').addEventListener('click', onNextPage);

        // Simpan progress saat pengguna akan menutup tab
        window.addEventListener('beforeunload', function(e) {
            navigator.sendBeacon(updateUrl, JSON.stringify({
                ebook_id: ebookId,
                last_page: pageNum
            }));
        });

        // --- Logika PDF.js Lainnya (Zoom, dll) ---
        function fitToWidth() {
            if (!pdfDoc) return;
            pdfDoc.getPage(pageNum).then(function(page) {
                const viewport = page.getViewport({
                    scale: 1.0
                });
                const containerWidth = document.getElementById('pdf-canvas-container').clientWidth - 40;
                currentScale = containerWidth / viewport.width;
                fitWidthBtn.textContent = Math.round(currentScale * 100) + '%';
                queueRenderPage(pageNum);
            });
        }
        document.getElementById('fit-width').addEventListener('click', fitToWidth);
        document.getElementById('zoom-in').addEventListener('click', () => {
            currentScale += 0.25;
            fitWidthBtn.textContent = Math.round(currentScale * 100) + '%';
            queueRenderPage(pageNum);
        });
        document.getElementById('zoom-out').addEventListener('click', () => {
            if (currentScale <= 0.5) return;
            currentScale -= 0.25;
            fitWidthBtn.textContent = Math.round(currentScale * 100) + '%';
            queueRenderPage(pageNum);
        });
        document.getElementById('fullscreen').addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        });

        // --- Muat Dokumen PDF ---
        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
            loadingIndicator.style.display = 'none';
            fitToWidth();
        }).catch(function(error) {
            console.error('Error loading PDF:', error);
            loadingIndicator.innerHTML = '<i class="fas fa-exclamation-triangle"></i><span>Gagal memuat PDF. File mungkin rusak atau tidak ditemukan.</span>';
        });
    </script>
    <script>
        document.getElementById('bookmark-btn').addEventListener('click', function() {
            const btn = this;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;

            // ✅ Ambil data dari DOM (lebih aman)
            const currentPage = parseInt(document.getElementById('page-num').textContent) || 1;
            const totalPages = parseInt(document.getElementById('page-count').textContent) || 1;
            const progress = Math.round((currentPage / totalPages) * 100);

            // ✅ Ambil CSRF dari meta tag (lebih aman)
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/user/reader/update-progress', { // ✅ URL langsung (bukan route())
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest' // ✅ Penting untuk Laravel
                    },
                    body: JSON.stringify({
                        ebook_id: '{{ $ebook->id }}',
                        last_page: currentPage,
                        progress_percentage: progress
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    btn.innerHTML = '<i class="fas fa-check text-success"></i>';
                    setTimeout(() => {
                        btn.innerHTML = '<i class="fas fa-bookmark"></i>';
                        btn.disabled = false;
                    }, 1500);
                })
                .catch(err => {
                    console.error('Bookmark error:', err);
                    btn.innerHTML = '<i class="fas fa-exclamation text-danger"></i>';
                    setTimeout(() => {
                        btn.innerHTML = '<i class="fas fa-bookmark"></i>';
                        btn.disabled = false;
                    }, 1500);
                });
        });
    </script>
</body>

</html>