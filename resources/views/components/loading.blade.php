<!-- Loading State Component -->
<div x-data="{ loading: false }" x-init="
    // Intercept form submissions
    document.addEventListener('submit', (e) => {
        if (e.target.tagName === 'FORM' && !e.target.hasAttribute('data-no-loading')) {
            loading = true;
        }
    });
">
    <!-- Full Page Loading Overlay -->
    <div x-show="loading" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center"
         style="display: none;">
        <div class="bg-white rounded-lg p-6 flex flex-col items-center">
            <!-- Spinner -->
            <svg class="animate-spin h-12 w-12 text-blue-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-700 font-medium">Memproses...</p>
        </div>
    </div>
</div>

<!-- Button Loading State Directive -->
<style>
    .btn-loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }
    
    .btn-loading::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spinner 0.6s linear infinite;
    }
    
    @keyframes spinner {
        to { transform: rotate(360deg); }
    }
    
    /* Skeleton Loading */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s ease-in-out infinite;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>

<!-- Alpine.js Helper for Button Loading -->
<script>
    // Add loading state to buttons
    document.addEventListener('alpine:init', () => {
        Alpine.directive('loading', (el, { expression }, { evaluateLater, effect }) => {
            let getLoading = evaluateLater(expression);
            
            effect(() => {
                getLoading(loading => {
                    if (loading) {
                        el.classList.add('btn-loading');
                        el.disabled = true;
                    } else {
                        el.classList.remove('btn-loading');
                        el.disabled = false;
                    }
                });
            });
        });
    });
    
    // Global loading function
    window.setLoading = function(state) {
        window.dispatchEvent(new CustomEvent('loading-state', { detail: state }));
    };
</script>
