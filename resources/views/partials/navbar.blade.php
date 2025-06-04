    <!-- Navigation Bar -->
    <nav class="bg-white/95 backdrop-blur-lg p-4 rounded-2xl shadow-2xl max-w-4xl mx-auto mb-4">
        <div class="flex justify-center space-x-4">
            @if (Auth::user()->is_admin === 0)
                <a href="/"
                    class="text-lg font-bold text-blue-600 bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200 transition duration-300">Order
                    Shirts</a>
            @endif

            <a href="/orders"
                class="text-lg font-bold text-blue-600 bg-blue-100 px-4 py-2 rounded-lg hover:bg-blue-200 transition duration-300">See
                Orders</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-lg font-bold text-red-600 bg-red-100 px-4 py-2 rounded-lg hover:bg-red-200 transition duration-300">Logout</button>
            </form>
        </div>
    </nav>
