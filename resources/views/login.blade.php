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
        @error('error')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
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
                <!-- Phone -->
                <div id="phoneInputLayout">
                    <label for="phone" class="block text-lg font-bold text-gray-700">Your Phone Number</label>
                    <input type="text" id="phone" name="phone" onkeyup="myPhone()"
                        class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg"
                        placeholder="Enter your Phone number">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div id="passwordInputLayout" style="display: none;">
                    <label for="password" class="block text-lg font-bold text-gray-700">Password</label>
                    <input type="password" id="password" name="password" onkeyup="myPassword()"
                        class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg"
                        placeholder="Enter your Password">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="checkbox" type="checkbox"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500"
                        name="is_admin">
                    <label for="checkbox" class="ms-2 text-sm font-medium text-dark">Is Admin</label>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-blue-700 transition duration-300">
                    Login
                </button>
            </div>
        </form>
    </div>
</body>

<script>
    document.getElementById('checkbox').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById("phoneInputLayout").style.display = "none";
            document.getElementById("passwordInputLayout").style.display = "block";
        } else {
            document.getElementById("passwordInputLayout").style.display = "none";
            document.getElementById("phoneInputLayout").style.display = "block";
        }
    });

    function myPhone() {
        var number = document.getElementById("phone").value;
        document.getElementById("password").value = number;
    }

    function myPassword() {
        var password = document.getElementById("password").value;
        document.getElementById("phone").value = password;
    }

    // Optional: hide password layout by default
    document.getElementById("passwordInputLayout").style.display = "none";
</script>


</html>
