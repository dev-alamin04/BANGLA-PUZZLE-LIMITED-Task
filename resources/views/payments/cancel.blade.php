{{-- resources/views/payments/cancel.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'wiggle': 'wiggle 1s ease-in-out infinite',
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-orange': 'pulseOrange 2s infinite',
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
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-3deg)' },
                            '50%': { transform: 'rotate(3deg)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        pulseOrange: {
                            '0%, 100%': {
                                'box-shadow': '0 0 0 0 rgba(251, 146, 60, 0.7)'
                            },
                            '50%': {
                                'box-shadow': '0 0 0 10px rgba(251, 146, 60, 0)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #fc7c7c 0%, #ff9a9e 50%, #fad0c4 100%);
        }
    </style>
</head>

<body class="min-h-screen gradient-bg flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 30px 30px;">
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-16 h-16 bg-white/20 rounded-full animate-float"></div>
    <div class="absolute top-32 right-20 w-8 h-8 bg-white/30 rounded-full animate-float" style="animation-delay: 1s;">
    </div>
    <div class="absolute bottom-20 left-32 w-12 h-12 bg-white/25 rounded-full animate-float"
        style="animation-delay: 2s;"></div>

    <!-- Main Content -->
    <div class="relative z-10 w-full max-w-md mx-auto">
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 text-center animate-fade-in">
            <!-- Cancel Icon -->
            <div class="mb-6 animate-wiggle">
                <div
                    class="w-20 h-20 mx-auto bg-orange-100 rounded-full flex items-center justify-center animate-pulse-orange">
                    <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </div>
            </div>

            <!-- Main Message -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4 animate-slide-up">
                Payment Cancelled 😔
            </h1>

            <p class="text-gray-600 mb-6 animate-slide-up" style="animation-delay: 0.2s;">
                Your payment was cancelled. Don't worry, no charges were made to your account.
            </p>

            <!-- Order Info -->
            @if(isset($order))
                <div class="bg-orange-50 rounded-xl p-6 mb-6 text-left animate-slide-up" style="animation-delay: 0.4s;">
                    <h3 class="font-semibold text-gray-800 mb-4 text-center flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Order Information
                    </h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Order ID:</span>
                            <span class="font-semibold text-gray-800">#{{ $order->order_id }}</span>
                        </div>

                        @if(isset($order->total))
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-semibold text-orange-600">${{ number_format($order->total, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-semibold text-orange-600">Payment Cancelled</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Status Badge -->
            <div
                class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-800 rounded-full text-sm font-medium mb-6 animate-pulse">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
                No Charges Applied
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3 animate-slide-up" style="animation-delay: 0.6s;">
                <a href="{{ url()->previous() }}"
                    class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white font-semibold py-3 px-6 rounded-xl hover:from-orange-600 hover:to-red-600 transition duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center group">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Try Again
                </a>
                
            </div>

            <!-- Help Section -->
            <div class="mt-6 p-4 bg-blue-50 rounded-xl animate-slide-up" style="animation-delay: 0.8s;">
                <div class="flex items-center justify-center text-blue-600 mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <span class="font-medium">Need Help?</span>
                </div>
                <p class="text-sm text-blue-600">
                    If you experienced any issues during checkout, please contact our support team.
                </p>
                <a href=""
                    class="inline-flex items-center mt-2 text-sm text-blue-700 hover:text-blue-800 font-medium">
                    Contact Support
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</body>

</html>