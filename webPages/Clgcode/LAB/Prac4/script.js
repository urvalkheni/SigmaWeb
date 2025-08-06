// Static JSON data for FAQs and events
const faqData = [
    {
        id: 1,
        question: "How does the interactive portal work?",
        answer: "The portal uses vanilla JavaScript to manipulate the DOM, handle events, and create dynamic user interactions. All animations are CSS-based for optimal performance."
    },
    {
        id: 2,
        question: "What features are included?",
        answer: "Features include collapsible FAQs, image sliders, modal popups, notification banners, theme switching, and real-time statistics tracking."
    },
    {
        id: 3,
        question: "How is the data managed?",
        answer: "The application uses static JSON data structures stored in JavaScript variables, simulating real-world API responses while remaining lightweight."
    },
    {
        id: 4,
        question: "Is the design responsive?",
        answer: "Yes! The portal uses CSS Grid and Flexbox with media queries to ensure optimal viewing across all device sizes, from mobile to desktop."
    },
    {
        id: 5,
        question: "How are animations implemented?",
        answer: "Animations use CSS transitions and transforms for smooth performance, with JavaScript handling the state changes that trigger the visual effects."
    }
];

// Application state management
const state = {
    currentSlide: 0,
    totalClicks: 0,
    modalOpens: 0,
    themeChanges: 0,
    faqExpands: 0,
    isDarkMode: false
};

// DOM element references
const elements = {
    notificationBanner: document.getElementById('notificationBanner'),
    notificationText: document.getElementById('notificationText'),
    notificationClose: document.getElementById('notificationClose'),
    themeSwitcher: document.getElementById('themeSwitcher'),
    slider: document.getElementById('slider'),
    prevBtn: document.getElementById('prevBtn'),
    nextBtn: document.getElementById('nextBtn'),
    openModal: document.getElementById('openModal'),
    successNotif: document.getElementById('successNotif'),
    warningNotif: document.getElementById('warningNotif'),
    errorNotif: document.getElementById('errorNotif'),
    modalOverlay: document.getElementById('modalOverlay'),
    modalClose: document.getElementById('modalClose'),
    faqContainer: document.getElementById('faqContainer'),
    clickCounter: document.getElementById('clickCounter'),
    modalCounter: document.getElementById('modalOpens'),
    themeCounter: document.getElementById('themeChanges'),
    faqCounter: document.getElementById('faqExpands')
};

// Utility functions
function updateStatistics() {
    elements.clickCounter.textContent = state.totalClicks;
    elements.modalCounter.textContent = state.modalOpens;
    elements.themeCounter.textContent = state.themeChanges;
    elements.faqCounter.textContent = state.faqExpands;
}

function incrementClicks() {
    state.totalClicks++;
    updateStatistics();
}

function showNotification(message, type = 'success') {
    elements.notificationText.textContent = message;
    elements.notificationBanner.className = `notification-banner show ${type}`;
    
    // Auto-hide notification after 4 seconds
    setTimeout(() => {
        elements.notificationBanner.classList.remove('show');
    }, 4000);
}

// Theme switching functionality
function toggleTheme() {
    state.isDarkMode = !state.isDarkMode;
    state.themeChanges++;
    
    document.body.setAttribute('data-theme', state.isDarkMode ? 'dark' : 'light');
    elements.themeSwitcher.textContent = state.isDarkMode ? '☀️ Light Mode' : '🌙 Dark Mode';
    
    showNotification(`Switched to ${state.isDarkMode ? 'dark' : 'light'} mode`, 'success');
    incrementClicks();
    updateStatistics();
}

// Slider functionality
function updateSlider() {
    const translateX = -state.currentSlide * 100;
    elements.slider.style.transform = `translateX(${translateX}%)`;
}

function nextSlide() {
    state.currentSlide = (state.currentSlide + 1) % 3;
    updateSlider();
    incrementClicks();
}

function prevSlide() {
    state.currentSlide = state.currentSlide === 0 ? 2 : state.currentSlide - 1;
    updateSlider();
    incrementClicks();
}

// Modal functionality
function openModal() {
    state.modalOpens++;
    elements.modalOverlay.classList.add('show');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
    incrementClicks();
    updateStatistics();
}

function closeModal() {
    elements.modalOverlay.classList.remove('show');
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// FAQ functionality
function createFAQItems() {
    elements.faqContainer.innerHTML = faqData.map(faq => `
        <div class="faq-item" data-faq-id="${faq.id}">
            <div class="faq-question">
                <span>${faq.question}</span>
                <span class="faq-icon">▼</span>
            </div>
            <div class="faq-answer">
                <p>${faq.answer}</p>
            </div>
        </div>
    `).join('');
}

function toggleFAQ(faqElement) {
    const isActive = faqElement.classList.contains('active');
    
    // Close all FAQ items first (accordion behavior)
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Open clicked item if it wasn't already active
    if (!isActive) {
        faqElement.classList.add('active');
        state.faqExpands++;
        updateStatistics();
    }
    
    incrementClicks();
}

// Auto-slider functionality
function startAutoSlider() {
    setInterval(() => {
        nextSlide();
    }, 5000); // Auto-advance every 5 seconds
}

// Ripple effect for buttons
function createRippleEffect(event) {
    const button = event.currentTarget;
    const ripple = document.createElement('span');
    const rect = button.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    ripple.style.cssText = `
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple 0.6s linear;
        left: ${x}px;
        top: ${y}px;
        width: ${size}px;
        height: ${size}px;
        pointer-events: none;
    `;
    
    button.style.position = 'relative';
    button.style.overflow = 'hidden';
    button.appendChild(ripple);
    
    // Remove ripple element after animation
    setTimeout(() => {
        if (ripple.parentNode) {
            ripple.remove();
        }
    }, 600);
}

// Event listeners setup
function setupEventListeners() {
    // Theme switcher
    elements.themeSwitcher.addEventListener('click', (e) => {
        toggleTheme();
        createRippleEffect(e);
    });
    
    // Notification banner close
    elements.notificationClose.addEventListener('click', () => {
        elements.notificationBanner.classList.remove('show');
        incrementClicks();
    });
    
    // Slider controls
    elements.nextBtn.addEventListener('click', (e) => {
        nextSlide();
        createRippleEffect(e);
    });
    
    elements.prevBtn.addEventListener('click', (e) => {
        prevSlide();
        createRippleEffect(e);
    });
    
    // Modal controls
    elements.openModal.addEventListener('click', (e) => {
        openModal();
        createRippleEffect(e);
    });
    
    elements.modalClose.addEventListener('click', closeModal);
    
    // Close modal when clicking overlay
    elements.modalOverlay.addEventListener('click', (e) => {
        if (e.target === elements.modalOverlay) {
            closeModal();
        }
    });
    
    // Notification buttons
    elements.successNotif.addEventListener('click', (e) => {
        showNotification('Operation completed successfully!', 'success');
        incrementClicks();
        createRippleEffect(e);
    });
    
    elements.warningNotif.addEventListener('click', (e) => {
        showNotification('Please review your settings', 'warning');
        incrementClicks();
        createRippleEffect(e);
    });
    
    elements.errorNotif.addEventListener('click', (e) => {
        showNotification('An error occurred. Please try again.', 'error');
        incrementClicks();
        createRippleEffect(e);
    });
    
    // FAQ event delegation
    elements.faqContainer.addEventListener('click', (e) => {
        const faqItem = e.target.closest('.faq-item');
        if (faqItem && e.target.closest('.faq-question')) {
            toggleFAQ(faqItem);
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        switch(e.key) {
            case 'Escape':
                closeModal();
                elements.notificationBanner.classList.remove('show');
                break;
            case 'ArrowLeft':
                if (!elements.modalOverlay.classList.contains('show')) {
                    prevSlide();
                }
                break;
            case 'ArrowRight':
                if (!elements.modalOverlay.classList.contains('show')) {
                    nextSlide();
                }
                break;
            case 'Enter':
                // Focus management for accessibility
                if (document.activeElement === elements.openModal) {
                    openModal();
                }
                break;
        }
    });
    
    // Add ripple effect to all interactive buttons
    document.addEventListener('click', (e) => {
        if (e.target.matches('.btn:not(.btn-applied), .slider-btn:not(.btn-applied)')) {
            createRippleEffect(e);
            e.target.classList.add('btn-applied'); // Prevent double application
            setTimeout(() => e.target.classList.remove('btn-applied'), 100);
        }
    });
}

// Performance optimization: Debounced resize handler
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Handle window resize for responsive behavior
const handleResize = debounce(() => {
    // Recalculate slider position on resize
    updateSlider();
}, 250);

// Initialize application
function initializeApp() {
    console.log('🚀 Initializing Interactive Portal...');
    
    try {
        // Create FAQ items from JSON data
        createFAQItems();
        
        // Setup all event listeners
        setupEventListeners();
        
        // Initialize statistics display
        updateStatistics();
        
        // Setup window resize handler
        window.addEventListener('resize', handleResize);
        
        // Start auto-slider
        startAutoSlider();
        
        // Show welcome notification after a short delay
        setTimeout(() => {
            showNotification('Interactive portal loaded successfully!', 'success');
        }, 1000);
        
        console.log('✅ Portal initialized successfully!');
        
    } catch (error) {
        console.error('❌ Error initializing portal:', error);
        showNotification('Error loading portal. Please refresh the page.', 'error');
    }
}

// Error handling for uncaught errors
window.addEventListener('error', (e) => {
    console.error('Global error:', e.error);
    showNotification('An unexpected error occurred', 'error');
});

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeApp);
} else {
    initializeApp();
}