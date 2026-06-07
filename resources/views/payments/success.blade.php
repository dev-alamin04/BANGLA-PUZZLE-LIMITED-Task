<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'bounce-slow': 'bounce 2s infinite',
                        'pulse-slow': 'pulse 3s infinite',
                        'fade-in': 'fadeIn 0.8s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'confetti': 'confetti 3s ease-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(50px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        confetti: {
                            '0%': { transform: 'translateY(-100vh) rotate(0deg)', opacity: '1' },
                            '100%': { transform: 'translateY(100vh) rotate(360deg)', opacity: '0' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="min-h-screen gradient-bg flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Confetti Animation -->
    <div class="fixed inset-0 pointer-events-none">
        @for($i = 0; $i < 50; $i++)
            <div class="confetti animate-confetti" style="left: {{ rand(0, 100) }}%; 
                            animation-delay: {{ rand(0, 3000) }}ms; 
                            animation-duration: {{ rand(2000, 4000) }}ms;">
            </div>
        @endfor
    </div>

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 20px 20px;">
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-md mx-auto">
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 text-center animate-fade-in">
            <!-- Success Icon -->
            <div class="mb-6 animate-bounce-slow">
                <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Main Message -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4 animate-slide-up">
                Payment Successful! 🎉
            </h1>

            <p class="text-gray-600 mb-6 animate-slide-up" style="animation-delay: 0.2s;">
                Thank you for your purchase! Your payment has been processed successfully.
            </p>

            <!-- Order Details -->
            @if(isset($order))
                <div class="bg-pink-50 rounded-xl p-6 mb-6 text-left animate-slide-up" style="animation-delay: 0.4s;">
                    <h3 class="font-semibold text-gray-800 mb-4 text-center">Order Details</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Order ID:</span>
                            <span class="font-semibold text-gray-800">#{{ $order->order_id }}</span>
                        </div>

                        @if(isset($order->total))
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-semibold text-green-600">${{ number_format($order->total, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-semibold text-gray-800">{{ now()->format('M d, Y') }}</span>
                        </div>

                        @if(isset($session_id))
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Transaction ID:</span>
                                <span class="font-semibold text-gray-800 text-xs">{{ substr($session_id, -8) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Status Badge -->
            <div
                class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium mb-6 animate-pulse-slow">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                Payment Confirmed
            </div>
            

            
        </div>
    </div>

    <!-- Auto redirect script (optional) -->
    <script>
        // Optional: Auto-redirect after 10 seconds
        // setTimeout(() => {
        // }, 10000);
    </script>
</body>

</html>