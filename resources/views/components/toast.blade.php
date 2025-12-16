<!-- Toast Notification Component -->
<div x-data="{ 
    show: false, 
    message: '', 
    type: 'success',
    init() {
        window.showToast = (msg, toastType = 'success') => {
            this.message = msg;
            this.type = toastType;
            this.show = true;
            setTimeout(() => { this.show = false }, 3000);
        }
    }
}" 
x-show="show" 
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0 transform translate-y-2"
x-transition:enter-end="opacity-100 transform translate-y-0"
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100 transform translate-y-0"
x-transition:leave-end="opacity-0 transform translate-y-2"
class="fixed top-4 right-4 z-50 max-w-sm w-full"
style="display: none;">
    <div class="rounded-lg shadow-lg p-4 flex items-center gap-3"
         :class="{
             'bg-green-100 border-l-4 border-green-500': type === 'success',
             'bg-red-100 border-l-4 border-red-500': type === 'error',
             'bg-yellow-100 border-l-4 border-yellow-500': type === 'warning',
             'bg-blue-100 border-l-4 border-blue-500': type === 'info'
         }">
        <!-- Icon -->
        <div class="flex-shrink-0">
            <template x-if="type === 'success'">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </template>
            <template x-if="type === 'error'">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </template>
            <template x-if="type === 'warning'">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </template>
            <template x-if="type === 'info'">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </template>
        </div>
        
        <!-- Message -->
        <div class="flex-1">
            <p class="font-medium" 
               :class="{
                   'text-green-800': type === 'success',
                   'text-red-800': type === 'error',
                   'text-yellow-800': type === 'warning',
                   'text-blue-800': type === 'info'
               }"
               x-text="message"></p>
        </div>
        
        <!-- Close Button -->
        <button @click="show = false" class="flex-shrink-0">
            <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>
