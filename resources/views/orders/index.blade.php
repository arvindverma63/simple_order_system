<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3/dist/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="min-h-screen bg-gradient-to-br from-yellow-300 via-pink-300 to-blue-300 p-4">
    @include('partials.navbar')
    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white/95 backdrop-blur-lg p-6 rounded-2xl shadow-2xl max-w-sm w-full text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Confirm Delete</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to delete this order?</p>
            <div class="flex justify-center space-x-4">
                <button id="confirm-delete"
                    class="bg-red-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-red-700 transition duration-300 flex items-center justify-center">
                    <span id="delete-button-text">Delete</span>
                    <svg id="delete-button-spinner" class="hidden animate-spin h-5 w-5 mr-2 text-white"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </button>
                <button onclick="closeDeleteModal()"
                    class="bg-gray-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-gray-700 transition duration-300">Cancel</button>
            </div>
        </div>
    </div>
    <!-- Status Change Modal -->
    <div id="status-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white/95 backdrop-blur-lg p-6 rounded-2xl shadow-2xl max-w-sm w-full text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Change Status</h3>
            <select id="status-select"
                class="w-full px-4 py-2 mb-4 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="pending">Pending</option>
                <option value="accept">Accept</option>
                <option value="cancel">Cancel</option>
            </select>
            <div class="flex justify-center space-x-4">
                <button id="confirm-status"
                    class="bg-blue-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                    <span id="status-button-text">Update</span>
                    <svg id="status-button-spinner" class="hidden animate-spin h-5 w-5 mr-2 text-white"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </button>
                <button onclick="closeStatusModal()"
                    class="bg-gray-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-gray-700 transition duration-300">Cancel</button>
            </div>
        </div>
    </div>
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
                        <th class="px-4 py-3 font-bold text-gray-700">Total</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Payment Due</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Status</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Action</th>
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
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                            <td>
                                <span
                                    class="
                                        text-xs font-medium px-2.5 py-0.5 rounded-sm
                                        @if ($order->status === 'accept') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif ($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @elseif ($order->status === 'cancel') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif
                                    ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if (Auth::user()->is_admin === 1)
                                    <button onclick="openStatusModal({{ $order->id }})"
                                        class="text-blue-600 hover:underline font-medium mr-2">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                @endif
                                <button onclick="openDeleteModal({{ $order->id }})"
                                    class="text-red-600 hover:underline font-medium">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Size Details Modal -->
                        <div id="modal-{{ $order->id }}"
                            class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm rounded-2xl flex items-center justify-center">
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
                                <button onclick="closeModal('modal-{{ $order->id }}')"
                                    class="absolute top-2 right-3 text-gray-400 hover:text-red-500 text-2xl leading-none">×</button>
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
    let currentOrderId = null;

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

    function openDeleteModal(orderId) {
        currentOrderId = orderId;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        currentOrderId = null;
    }

    function openStatusModal(orderId) {
        currentOrderId = orderId;
        document.getElementById('status-modal').classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('status-modal').classList.add('hidden');
        currentOrderId = null;
    }

    function toggleDeleteButtonLoading(isLoading) {
        const button = document.getElementById('confirm-delete');
        const buttonText = document.getElementById('delete-button-text');
        const spinner = document.getElementById('delete-button-spinner');

        if (isLoading) {
            button.disabled = true;
            button.classList.add('opacity-75', 'cursor-not-allowed');
            buttonText.classList.add('hidden');
            spinner.classList.remove('hidden');
        } else {
            button.disabled = false;
            button.classList.remove('opacity-75', 'cursor-not-allowed');
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
        }
    }

    function toggleStatusButtonLoading(isLoading) {
        const button = document.getElementById('confirm-status');
        const buttonText = document.getElementById('status-button-text');
        const spinner = document.getElementById('status-button-spinner');

        if (isLoading) {
            button.disabled = true;
            button.classList.add('opacity-75', 'cursor-not-allowed');
            buttonText.classList.add('hidden');
            spinner.classList.remove('hidden');
        } else {
            button.disabled = false;
            button.classList.remove('opacity-75', 'cursor-not-allowed');
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
        }
    }

    document.getElementById('confirm-delete').addEventListener('click', function() {
        if (currentOrderId) {
            toggleDeleteButtonLoading(true);
            fetch(`/orders/${currentOrderId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    toggleDeleteButtonLoading(false);
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Error deleting order: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    toggleDeleteButtonLoading(false);
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                });
            closeDeleteModal();
        }
    });

    document.getElementById('confirm-status').addEventListener('click', function() {
        if (currentOrderId) {
            toggleStatusButtonLoading(true);
            const status = document.getElementById('status-select').value;
            fetch('/orders/status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        order_id: currentOrderId,
                        status: status
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    toggleStatusButtonLoading(false);
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Error updating status: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    toggleStatusButtonLoading(false);
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                });
            closeStatusModal();
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const table = document.querySelector("#ordersTable");
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>

</html>
