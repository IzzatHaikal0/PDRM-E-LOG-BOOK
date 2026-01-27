<div id="splash-screen" class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center transition-opacity duration-700 ease-out">
    
    {{-- 1. Logo Container with Pulse Animation --}}
    <div class="relative flex flex-col items-center">
        <div class="w-24 h-24 mb-4 drop-shadow-xl animate-bounce-slow">
            {{-- PDRM Logo / Shield Icon --}}
            <svg viewBox="0 0 24 24" fill="none" class="w-full h-full text-[#00205B]">
                <path fill="currentColor" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 6c1.4 0 2.8 1.1 2.8 2.5V11c.6 0 1.2.6 1.2 1.2v3.5c0 .7-.6 1.3-1.2 1.3H9.2c-.6 0-1.2-.6-1.2-1.2v-3.5c0-.7.6-1.2 1.2-1.2V9.5C9.2 8.1 10.6 7 12 7zm0 1c-.8 0-1.5.7-1.5 1.5V11h3V9.5c0-.8-.7-1.5-1.5-1.5z"/>
            </svg>
        </div>

        {{-- App Name --}}
        <h1 class="text-3xl font-bold text-[#00205B] tracking-tight">PDRM EP5</h1>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-[0.2em] mt-1">Sistem Pengurusan</p>
    </div>

    {{-- 2. Loading Bar --}}
    <div class="w-48 h-1.5 bg-gray-100 rounded-full mt-8 overflow-hidden relative">
        <div class="absolute top-0 left-0 h-full bg-[#00205B] animate-loading-bar rounded-full"></div>
    </div>

    {{-- 3. Footer Text --}}
    <div class="absolute bottom-8 text-center">
        <p class="text-[10px] text-gray-400">Hak Cipta Terpelihara &copy; {{ date('Y') }}</p>
        <p class="text-[10px] font-bold text-[#00205B]">Polis Diraja Malaysia</p>
    </div>
</div>

<style>
    @keyframes loading-bar {
        0% { width: 0%; }
        50% { width: 70%; }
        100% { width: 100%; }
    }
    .animate-loading-bar {
        animation: loading-bar 2s ease-in-out forwards;
    }
    
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(-5%); }
        50% { transform: translateY(5%); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 2s infinite;
    }
</style>

<script>
    (function() {
        // 1. Check if Splash was already shown in this session
        var splash = document.getElementById('splash-screen');
        var sessionKey = 'pdrm_splash_seen';

        if (sessionStorage.getItem(sessionKey)) {
            // ALREADY SEEN: Hide immediately (display: none) to prevent flash
            splash.style.display = 'none';
        } else {
            // NOT SEEN YET: Play animation
            window.addEventListener('load', function() {
                setTimeout(function() {
                    // Fade out
                    splash.style.opacity = '0';
                    
                    // Remove from DOM and Set Flag
                    setTimeout(function() {
                        splash.remove();
                        sessionStorage.setItem(sessionKey, 'true'); // Mark as seen
                    }, 700);
                }, 2000); // 2 seconds display time
            });
        }
    })();
</script>