<!-- Icon Picker Modal -->
<div class="modal fade" id="iconPickerModal" tabindex="-1" aria-labelledby="iconPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iconPickerModalLabel">Select Icon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Search Box -->
                <div class="mb-3">
                    <input type="text" 
                           class="form-control" 
                           id="iconSearchInput" 
                           placeholder="Search icons... (e.g., whatsapp, email, phone)">
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" id="iconTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" 
                                id="tabler-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#tabler-icons" 
                                type="button" 
                                role="tab">
                            Tabler Icons
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" 
                                id="bootstrap-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#bootstrap-icons" 
                                type="button" 
                                role="tab">
                            Bootstrap Icons
                        </button>
                    </li>
                </ul>

                <!-- Icon Grid -->
                <div class="tab-content" id="iconTabsContent">
                    <!-- Tabler Icons -->
                    <div class="tab-pane fade show active" id="tabler-icons" role="tabpanel">
                        <div class="icon-grid" id="tablerIconGrid" style="max-height: 400px; overflow-y: auto;">
                            <div class="row g-2" id="tablerIconContainer">
                                <!-- Icons will be loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Bootstrap Icons -->
                    <div class="tab-pane fade" id="bootstrap-icons" role="tabpanel">
                        <div class="icon-grid" id="bootstrapIconGrid" style="max-height: 400px; overflow-y: auto;">
                            <div class="row g-2" id="bootstrapIconContainer">
                                <!-- Icons will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3" id="loadingIndicator" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div class="text-center mt-3" id="noResultsMessage" style="display: none;">
                    <p class="text-muted">No icons found</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.icon-item {
    cursor: pointer;
    padding: 15px;
    text-align: center;
    border: 2px solid transparent;
    border-radius: 8px;
    transition: all 0.2s;
}

.icon-item:hover {
    background-color: #f0f0f0;
    border-color: #696cff;
}

.icon-item.selected {
    background-color: #e7e7ff;
    border-color: #696cff;
}

.icon-item i {
    font-size: 2rem;
    display: block;
    margin-bottom: 5px;
}

.icon-item small {
    font-size: 0.7rem;
    color: #666;
    word-break: break-all;
}
</style>

<script>
// Icon data - Popular icons loaded first
const tablerIconsPopular = [
    'ti-brand-whatsapp', 'ti-mail', 'ti-phone', 'ti-brand-instagram', 'ti-brand-facebook',
    'ti-brand-twitter', 'ti-brand-youtube', 'ti-brand-linkedin', 'ti-brand-telegram', 'ti-brand-tiktok',
    'ti-map-pin', 'ti-location', 'ti-home', 'ti-building', 'ti-address-book',
    'ti-user', 'ti-users', 'ti-message', 'ti-message-circle', 'ti-send',
    'ti-phone-call', 'ti-device-mobile', 'ti-headset', 'ti-browser', 'ti-world',
    'ti-globe', 'ti-map', 'ti-compass', 'ti-navigation', 'ti-at',
    'ti-link', 'ti-share', 'ti-calendar', 'ti-clock', 'ti-help',
    'ti-info-circle', 'ti-alert-circle', 'ti-settings', 'ti-tool', 'ti-briefcase',
    'ti-building-store', 'ti-shopping-cart', 'ti-credit-card', 'ti-wallet', 'ti-currency-dollar',
    'ti-ticket', 'ti-qrcode', 'ti-barcode', 'ti-printer', 'ti-file',
    'ti-folder', 'ti-download', 'ti-upload', 'ti-cloud', 'ti-server',
    'ti-database', 'ti-code', 'ti-terminal', 'ti-device-laptop', 'ti-device-desktop',
    'ti-brand-github', 'ti-brand-gitlab', 'ti-brand-google', 'ti-brand-apple', 'ti-brand-windows',
    'ti-star', 'ti-heart', 'ti-bookmark', 'ti-flag', 'ti-bell',
    'ti-notification', 'ti-badge', 'ti-medal', 'ti-trophy', 'ti-certificate',
    'ti-award', 'ti-gift', 'ti-tag', 'ti-tags', 'ti-discount',
    'ti-speakerphone', 'ti-volume', 'ti-microphone', 'ti-camera', 'ti-photo',
    'ti-video', 'ti-playlist', 'ti-music', 'ti-book', 'ti-books',
    'ti-notebook', 'ti-pencil', 'ti-edit', 'ti-news', 'ti-article',
    'ti-note', 'ti-notes', 'ti-checklist', 'ti-checkbox', 'ti-list'
];

const bootstrapIconsPopular = [
    'bi-whatsapp', 'bi-envelope', 'bi-telephone', 'bi-instagram', 'bi-facebook',
    'bi-twitter', 'bi-twitter-x', 'bi-youtube', 'bi-linkedin', 'bi-telegram',
    'bi-tiktok', 'bi-geo-alt', 'bi-pin-map', 'bi-house', 'bi-building',
    'bi-person', 'bi-people', 'bi-chat', 'bi-chat-dots', 'bi-send',
    'bi-phone', 'bi-telephone-fill', 'bi-headset', 'bi-browser-chrome', 'bi-globe',
    'bi-globe2', 'bi-map', 'bi-compass', 'bi-navigation', 'bi-at',
    'bi-link', 'bi-share', 'bi-calendar', 'bi-clock', 'bi-question-circle',
    'bi-info-circle', 'bi-exclamation-circle', 'bi-gear', 'bi-tools', 'bi-briefcase',
    'bi-shop', 'bi-cart', 'bi-credit-card', 'bi-wallet', 'bi-currency-dollar',
    'bi-ticket', 'bi-qr-code', 'bi-upc', 'bi-printer', 'bi-file-earmark',
    'bi-folder', 'bi-download', 'bi-upload', 'bi-cloud', 'bi-server',
    'bi-database', 'bi-code', 'bi-terminal', 'bi-laptop', 'bi-display',
    'bi-github', 'bi-git', 'bi-google', 'bi-apple', 'bi-windows',
    'bi-star', 'bi-heart', 'bi-bookmark', 'bi-flag', 'bi-bell',
    'bi-bell-fill', 'bi-badge', 'bi-award', 'bi-trophy', 'bi-patch-check',
    'bi-gift', 'bi-tag', 'bi-tags', 'bi-percent', 'bi-megaphone',
    'bi-volume-up', 'bi-mic', 'bi-camera', 'bi-image', 'bi-camera-video',
    'bi-collection-play', 'bi-music-note', 'bi-book', 'bi-journal',
    'bi-pencil', 'bi-pen', 'bi-newspaper', 'bi-file-text', 'bi-sticky',
    'bi-card-checklist', 'bi-check-square', 'bi-list-ul', 'bi-list-check', 'bi-menu-button'
];

// All icons will be populated on search
let allTablerIcons = [...tablerIconsPopular];
let allBootstrapIcons = [...bootstrapIconsPopular];
let currentLoadedIcons = { tabler: [], bootstrap: [] };

// Icon Picker functionality
document.addEventListener('DOMContentLoaded', function() {
    const iconPickerModal = document.getElementById('iconPickerModal');
    const iconInput = document.getElementById('icon_class');
    const iconSearchInput = document.getElementById('iconSearchInput');
    const iconPreviewBtn = document.getElementById('iconPreviewBtn');
    const selectedIconPreview = document.getElementById('selectedIconPreview');

    // Open modal on icon preview button click
    if (iconPreviewBtn) {
        iconPreviewBtn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(iconPickerModal);
            modal.show();
            loadPopularIcons();
        });
    }

    // Search functionality with debounce
    let searchTimeout;
    iconSearchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const searchTerm = this.value.toLowerCase().trim();
            const activeTab = document.querySelector('#iconTabs .nav-link.active').id;
            
            if (searchTerm.length > 0) {
                searchIcons(searchTerm, activeTab === 'tabler-tab' ? 'tabler' : 'bootstrap');
            } else {
                loadPopularIcons();
            }
        }, 300);
    });

    // Tab switch handler
    document.querySelectorAll('#iconTabs button').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function() {
            iconSearchInput.value = '';
            loadPopularIcons();
        });
    });

    function loadPopularIcons() {
        renderIcons(tablerIconsPopular, 'tabler');
        renderIcons(bootstrapIconsPopular, 'bootstrap');
        document.getElementById('noResultsMessage').style.display = 'none';
    }

    function searchIcons(searchTerm, type) {
        document.getElementById('loadingIndicator').style.display = 'block';
        
        // Simulate API call or comprehensive search
        setTimeout(() => {
            let icons;
            if (type === 'tabler') {
                icons = expandTablerIconSearch(searchTerm);
            } else {
                icons = expandBootstrapIconSearch(searchTerm);
            }
            
            renderIcons(icons, type);
            document.getElementById('loadingIndicator').style.display = 'none';
            
            if (icons.length === 0) {
                document.getElementById('noResultsMessage').style.display = 'block';
            } else {
                document.getElementById('noResultsMessage').style.display = 'none';
            }
        }, 300);
    }

    function expandTablerIconSearch(searchTerm) {
        // Extended search - add more icons based on search term
        const baseIcons = [...tablerIconsPopular];
        const additionalIcons = [];
        
        // Add context-based icons
        if (searchTerm.includes('social') || searchTerm.includes('media')) {
            additionalIcons.push('ti-brand-discord', 'ti-brand-slack', 'ti-brand-pinterest', 'ti-brand-reddit', 'ti-brand-snapchat');
        }
        if (searchTerm.includes('mail') || searchTerm.includes('email') || searchTerm.includes('envelope')) {
            additionalIcons.push('ti-mail-opened', 'ti-mail-forward', 'ti-inbox', 'ti-outbox');
        }
        if (searchTerm.includes('phone') || searchTerm.includes('call') || searchTerm.includes('contact')) {
            additionalIcons.push('ti-phone-incoming', 'ti-phone-outgoing', 'ti-phone-off', 'ti-phone-plus');
        }
        
        const allIcons = [...new Set([...baseIcons, ...additionalIcons])];
        return allIcons.filter(icon => icon.toLowerCase().includes(searchTerm));
    }

    function expandBootstrapIconSearch(searchTerm) {
        // Extended search - add more icons based on search term
        const baseIcons = [...bootstrapIconsPopular];
        const additionalIcons = [];
        
        // Add context-based icons
        if (searchTerm.includes('social') || searchTerm.includes('media')) {
            additionalIcons.push('bi-discord', 'bi-slack', 'bi-pinterest', 'bi-reddit', 'bi-snapchat');
        }
        if (searchTerm.includes('mail') || searchTerm.includes('email') || searchTerm.includes('envelope')) {
            additionalIcons.push('bi-envelope-open', 'bi-envelope-fill', 'bi-inbox', 'bi-mailbox');
        }
        if (searchTerm.includes('phone') || searchTerm.includes('call') || searchTerm.includes('contact')) {
            additionalIcons.push('bi-telephone-inbound', 'bi-telephone-outbound', 'bi-telephone-x', 'bi-telephone-plus');
        }
        
        const allIcons = [...new Set([...baseIcons, ...additionalIcons])];
        return allIcons.filter(icon => icon.toLowerCase().includes(searchTerm));
    }

    function renderIcons(icons, type) {
        const container = type === 'tabler' ? 
            document.getElementById('tablerIconContainer') : 
            document.getElementById('bootstrapIconContainer');
        
        container.innerHTML = '';
        
        icons.forEach(icon => {
            const iconClass = type === 'tabler' ? `ti ${icon}` : `bi ${icon}`;
            const iconItem = document.createElement('div');
            iconItem.className = 'col-2';
            iconItem.innerHTML = `
                <div class="icon-item" data-icon="${iconClass}">
                    <i class="${iconClass}"></i>
                    <small>${icon}</small>
                </div>
            `;
            
            iconItem.querySelector('.icon-item').addEventListener('click', function() {
                selectIcon(iconClass);
            });
            
            container.appendChild(iconItem);
        });
    }

    function selectIcon(iconClass) {
        iconInput.value = iconClass;
        
        // Update preview
        if (selectedIconPreview) {
            selectedIconPreview.innerHTML = `<i class="${iconClass}"></i>`;
        }
        
        // Highlight selected
        document.querySelectorAll('.icon-item').forEach(item => {
            item.classList.remove('selected');
        });
        document.querySelector(`[data-icon="${iconClass}"]`)?.classList.add('selected');
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(iconPickerModal);
        modal.hide();
    }

    // Initialize preview on page load
    if (iconInput && iconInput.value && selectedIconPreview) {
        selectedIconPreview.innerHTML = `<i class="${iconInput.value}"></i>`;
    }
});
</script>
<?php /**PATH C:\laragon\www\ebook_traveling\resources\views/admin/contact-info/partials/_icon-picker.blade.php ENDPATH**/ ?>