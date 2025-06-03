<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Order Shirts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-yellow-300 via-pink-300 to-blue-300 p-4 flex items-center justify-center">
    <div class="bg-white/95 backdrop-blur-lg p-6 sm:p-8 rounded-2xl shadow-2xl max-w-md w-full">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-center text-gray-800 mb-6 sm:mb-8">Login to Start Ordering!
        </h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="space-y-6">
                <!-- Username -->
                <div>
                    <label for="name" class="block text-lg font-bold text-gray-700">Your Username</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg"
                        placeholder="Enter your username">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password -->
                <div>
                    <label for="password" class="block text-lg font-bold text-gray-700">Your Phone Number</label>
                    <input type="password" id="password" name="password"
                        class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg"
                        placeholder="Enter your password">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-blue-700 transition duration-300">
                    Login or Sign Up
                </button>
            </div>
        </form>
    </div>
</body>

</html>
