<!DOCTYPE html>
<html lang="en" x-data="otpVerification()">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    @vite(['resources/css/app.css', 'resources/js/alpine.js'])
    <style>
        /* Custom Styles for Notifications */
        .notification {
            display: none;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%) translateY(-50px); /* Starts out of view */
            background-color: #64ab7e; /* WhatsApp green color */
            color: white;
            padding: 12px 20px;
            border-radius: 20px;
            font-size: 14px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .notification.show {
            display: block;
            opacity: 1;
            transform: translateX(-50%) translateY(0); /* Slides down into view */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    @if($errors->any())
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        @endif

    <!-- OTP Verification Container -->
    <div class="max-w-md mx-auto mt-12 p-6 sm:p-8 bg-white rounded-lg shadow-lg" x-cloak>
        <form action="" method="POST">
            @csrf
            <!-- Icon and Heading -->
            <div class="flex justify-center mb-6">
                <img src="https://github.com/EVANluasi/anl_team/blob/main/email_verify/assets/verification.png?raw=true" alt="Verify Email" class="w-20 h-20 sm:w-24 sm:h-24">
            </div>
            <h1 class="text-2xl font-semibold text-center text-indigo-600 mb-2">OTP Verification</h1>
            <p class="text-center text-sm text-gray-600 mb-6">Please enter the 6-digit OTP sent to your email.</p>
            
            <!-- OTP Inputs -->
            <div x-data="{ otpInputs: Array(6).fill('') }">
                <div class="flex justify-between mb-4 space-x-2">
                    @for ($index = 0; $index < 6; $index++)
                        <input type="text" name="otp[]" x-model="otpInputs[{{ $index }}]" class="w-12 p-3 text-2xl text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" maxlength="1" x-on:input="moveToNext($event, {{ $index }})" />
                    @endfor
                </div>
            </div>
            
            <!-- OTP Buttons -->
            <div class="flex justify-between mt-4">
                <button :disabled="isVerifyButtonDisabled" @click="verifyOTP" class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 transition duration-200">Verify OTP</button>
            </div>
            
            <!-- Send Code Button -->
            <div class="flex justify-between mt-4">
                <button @click="sendOTP" type="submit" class="w-full py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">Send Verification Code</button>
            </div>

            <!-- Timer -->
            <div x-show="isTimerRunning" class="mt-4 text-center text-sm text-gray-600">
                <p>Time left: <span x-text="timeFormatted"></span></p>
            </div>

            <!-- Notification Popup -->
            <div :class="{'show': showNotification}" class="notification" x-text="notificationMessage"></div>
        </form>
    </div>

    <script>
        function otpVerification() {
            return {
                otpInputs: ['', '', '', '', '', ''],
                timeLeft: 300, // 5 minutes in seconds
                timer: null,
                isTimerRunning: false,
                isVerifyButtonDisabled: true,
                notificationMessage: '',
                showNotification: false,

                get timeFormatted() {
                    const minutes = String(Math.floor(this.timeLeft / 60)).padStart(2, '0');
                    const seconds = String(this.timeLeft % 60).padStart(2, '0');
                    return `${minutes}:${seconds}`;
                },

                startTimer() {
                    this.timer = setInterval(() => {
                        if (this.timeLeft <= 0) {
                            clearInterval(this.timer);
                            this.isVerifyButtonDisabled = true;
                            this.showNotificationMessage("Time's up! The OTP sent cannot be used anymore.");
                            this.resetOTPInputs();
                        } else {
                            this.timeLeft--;
                        }
                    }, 1000);
                    this.isTimerRunning = true;
                },

                resetOTPInputs() {
                    this.otpInputs = ['', '', '', '', '', ''];
                },

                moveToNext(event, index) {
                    if (event.target.value.length === 1 && index < this.otpInputs.length - 1) {
                        this.$nextTick(() => {
                            this.$refs[`otp${index + 1}`].focus();
                        });
                    } else if (event.target.value.length === 0 && index > 0) {
                        this.$nextTick(() => {
                            this.$refs[`otp${index - 1}`].focus();
                        });
                    }

                    this.isVerifyButtonDisabled = this.otpInputs.some(input => input === '');
                },

                sendOTP() {
                    if (!this.isTimerRunning) {
                        this.showNotificationMessage("Verification code sent to your email!");
                        this.startTimer();
                        this.isVerifyButtonDisabled = false;
                    } else {
                        this.showNotificationMessage("The timer is already running. Please enter your OTP before the time expires.");
                    }
                },

                verifyOTP() {
                    const otpValue = this.otpInputs.join('');
                    if (otpValue.length === 6) {
                        this.showNotificationMessage("OTP Verified Successfully!");
                        clearInterval(this.timer);
                        this.isVerifyButtonDisabled = true;
                    } else {
                        this.showNotificationMessage("Please enter a valid 6-digit OTP.");
                    }
                },

                showNotificationMessage(message) {
                    this.notificationMessage = message;
                    this.showNotification = true;
                    setTimeout(() => {
                        this.showNotification = false;
                    }, 3000);
                }
            };
        }
    </script>

</body>
</html>