<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-yellow-300 via-pink-300 to-blue-300 p-4">
    @include('partials.navbar')
    <!-- Custom Alert Dialog -->
    <div id="alert-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white/95 backdrop-blur-lg p-6 rounded-2xl shadow-2xl max-w-sm w-full text-center">
            <h3 id="alert-title" class="text-xl font-bold text-gray-800 mb-4"></h3>
            <p id="alert-message" class="text-gray-600 mb-6"></p>
            <button onclick="closeAlert()"
                class="bg-blue-600 text-white py-2 px-4 rounded-lg font-bold hover:bg-blue-700 transition duration-300">OK</button>
        </div>
    </div>
    <!-- Order Form -->
    <div class="bg-white/95 backdrop-blur-lg p-6 sm:p-8 rounded-2xl shadow-2xl max-w-lg w-full mx-auto">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-center text-gray-800 mb-6 sm:mb-8">Pick Your Shirts,
            {{ Auth::user()->name }}!</h2>
        <div class="space-y-6">
            <!-- Adult Sizes -->
            <div id="adult-sizes">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Adult Sizes ($15 each + tax)</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                    <button id="adult-small"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('adult-small')">Small</button>
                    <button id="adult-medium"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('adult-medium')">Medium</button>
                    <button id="adult-large"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('adult-large')">Large</button>
                    <button id="adult-xlarge"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('adult-xlarge')">X-Large</button>
                    <button id="adult-2xlarge"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('adult-2xlarge')">2X-Large</button>
                    <button id="adult-3xlarge"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('adult-3xlarge')">3X-Large</button>
                    <button id="adult-4xlarge"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('adult-4xlarge')">4X-Large</button>
                    <button id="adult-5xlarge"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('adult-5xlarge')">5X-Large</button>
                </div>
            </div>
            <!-- Youth Sizes -->
            <div id="youth-sizes">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Youth Sizes ($15 each + tax)</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    <button id="youth-xsmall"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('youth-xsmall')">X-Small</button>
                    <button id="youth-small"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('youth-small')">Small</button>
                    <button id="youth-medium"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('youth-medium')">Medium</button>
                    <button id="youth-large"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('youth-large')">Large</button>
                    <button id="youth-xlarge"
                        class="size-box py-3 bg-gray-100 rounded-lg text-sm font-medium text-gray-700 hover:bg-blue-200 w-full"
                        onclick="addToOrder('youth-xlarge')">X-Large</button>
                </div>
            </div>
            <!-- Selected Items Summary -->
            <div>
                <h3 class="text-xl font-bold text-gray-700 mb-3">Your Order</h3>
                <ul id="order-summary" class="text-base text-gray-600 space-y-2"></ul>
            </div>
            <!-- Total Cost -->
            <div class="text-center">
                <p class="text-xl font-bold text-gray-800">Total Cost (with tax): <span id="total-cost"
                        class="text-blue-600">$0.00</span></p>
            </div>
            <!-- Order Date -->
            <div>
                <label for="order_date" class="block text-lg font-bold text-gray-700">Payment Due Date</label>
                <input type="date" id="order_date"
                    class="mt-2 w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-lg"
                    min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
            </div>
            <button type="button" id="submit-button" onclick="submitOrder()"
                class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold text-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                <span id="button-text">Send Order</span>
                <svg id="button-spinner" class="hidden animate-spin h-5 w-5 mr-3 text-white" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </button>
        </div>
    </div>
    <script>
        const order = {};
        const TAX_RATE = 1.0973; // 9.73% tax

        function addToOrder(sizeId) {
            const button = document.getElementById(sizeId);
            if (!order[sizeId]) {
                order[sizeId] = {
                    quantity: 0,
                    selected: false
                };
            }
            order[sizeId].selected = !order[sizeId].selected;
            if (order[sizeId].selected) {
                button.classList.add('bg-blue-400', 'text-white');
                order[sizeId].quantity = 1;
            } else {
                button.classList.remove('bg-blue-400', 'text-white');
                order[sizeId].quantity = 0;
            }
            updateSummary();
        }

        function increment(sizeId) {
            if (order[sizeId] && order[sizeId].selected) {
                order[sizeId].quantity++;
                updateSummary();
            }
        }

        function decrement(sizeId) {
            if (order[sizeId] && order[sizeId].selected && order[sizeId].quantity > 0) {
                order[sizeId].quantity--;
                if (order[sizeId].quantity === 0) {
                    order[sizeId].selected = false;
                    document.getElementById(sizeId).classList.remove('bg-blue-400', 'text-white');
                }
                updateSummary();
            }
        }

        function updateSummary() {
            const summaryList = document.getElementById('order-summary');
            summaryList.innerHTML = '';
            let subtotal = 0;

            Object.keys(order).forEach(sizeId => {
                if (order[sizeId].selected && order[sizeId].quantity > 0) {
                    const li = document.createElement('li');
                    const category = sizeId.startsWith('adult') ? 'Adult' : 'Youth';
                    const sizeName = sizeId.replace(/^(adult|youth)-/, '').replace('-', ' ');
                    const quantity = order[sizeId].quantity;
                    li.innerHTML = `
                        <div class="flex items-center justify-between">
                            <span>${category} ${sizeName}: ${quantity} x $15</span>
                            <div class="flex items-center space-x-2">
                                <button type="button" onclick="decrement('${sizeId}')" class="w-8 h-8 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none">-</button>
                                <button type="button" onclick="increment('${sizeId}')" class="w-8 h-8 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none">+</button>
                            </div>
                        </div>
                    `;
                    summaryList.appendChild(li);
                    subtotal += quantity * 15;
                }
            });

            const total = subtotal * TAX_RATE;
            document.getElementById('total-cost').textContent = `$${total.toFixed(2)}`;
        }

        function showAlert(title, message) {
            document.getElementById('alert-title').textContent = title;
            document.getElementById('alert-message').textContent = message;
            document.getElementById('alert-modal').classList.remove('hidden');
        }

        function closeAlert() {
            document.getElementById('alert-modal').classList.add('hidden');
        }

        function toggleLoading(isLoading) {
            const button = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('button-spinner');

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

        function submitOrder() {
            const orderDate = document.getElementById('order_date').value;
            const sizes = {};

            Object.keys(order).forEach(sizeId => {
                if (order[sizeId].selected && order[sizeId].quantity > 0) {
                    sizes[sizeId] = {
                        quantity: order[sizeId].quantity
                    };
                }
            });

            if (!orderDate || Object.keys(sizes).length === 0) {
                showAlert('Oops!', 'Please select an order date and at least one shirt size with quantity.');
                return;
            }

            toggleLoading(true);

            fetch('/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        sizes: sizes,
                        order_date: orderDate,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    toggleLoading(false);
                    if (data.errors) {
                        showAlert('Oops!', 'There was an error: ' + JSON.stringify(data.errors));
                    } else {
                        showAlert('Yay!',
                            'Order placed successfully! You can check your order in the "See Orders" page.');
                        setTimeout(() => {
                            window.location.href = '/orders';
                        }, 2000);
                    }
                })
                .catch(error => {
                    toggleLoading(false);
                    console.error('Error:', error);
                    showAlert('Oops!', 'Something went wrong. Please try again.');
                });
        }
    </script>
</body>

</html>
