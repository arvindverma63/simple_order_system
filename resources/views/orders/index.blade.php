<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script><!-- Simple-DataTables -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.css">

</head>

<body class="min-h-screen bg-gradient-to-br from-yellow-300 via-pink-300 to-blue-300 p-4">
    <!-- Navigation Bar -->
    @include('partials.navbar')
    <!-- Orders Table -->
    <div class="bg-white/95 backdrop-blur-lg p-6 sm:p-8 rounded-2xl shadow-2xl max-w-4xl w-full mx-auto">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-center text-gray-800 mb-6 sm:mb-8">All Shirt Orders</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600" id="ordersTable">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 font-bold text-gray-700">Name</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Phone</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Sizes</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Total Cost (with tax)</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Payment Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="border-b">
                            <td class="px-4 py-3">
                                {{ Auth::user()->is_admin == 1 ? \App\Models\User::find($order->user_id)->name : Auth::user()->name }}
                            </td>
                            <td class="px-4 py-3">{{ $order->phone }}</td>
                            <td class="px-4 py-3">
                                <button onclick="openModal('modal-{{ $order->id }}')"
                                    class="text-blue-600 hover:underline font-medium">View Sizes</button>
                            </td>

                            <td class="px-4 py-3">${{ number_format($order->total_cost, 2) }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}
                            </td>
                        </tr>

                        <!-- Modal Backdrop -->
                        <div id="modal-{{ $order->id }}"
                            class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center">
                            <!-- Modal Box -->
                            <div
                                class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative transform transition-all duration-300 scale-95 opacity-0 modal-content">
                                <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center border-b pb-2">Size Details
                                </h3>
                                <ul class="list-disc list-inside text-gray-700 text-base space-y-1">
                                    @foreach ($order->sizes as $size => $data)
                                        @if ($data['quantity'] > 0)
                                            <li>{{ ucwords(str_replace('-', ' ', $size)) }}: {{ $data['quantity'] }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <!-- Close Button (Top Right) -->
                                <button onclick="closeModal('modal-{{ $order->id }}')"
                                    class="absolute top-2 right-3 text-gray-400 hover:text-red-500 text-2xl leading-none">&times;</button>
                                <!-- Footer -->
                                <div class="text-center mt-6">
                                    <button onclick="closeModal('modal-{{ $order->id }}')"
                                        class="px-5 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition duration-300">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        const content = modal.querySelector('.modal-content');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        const content = modal.querySelector('.modal-content');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.querySelector("#ordersTable");
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

</html>
