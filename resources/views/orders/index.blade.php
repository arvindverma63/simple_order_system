<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-yellow-300 via-pink-300 to-blue-300 p-4">
    <!-- Navigation Bar -->
    @include('partials.navbar')
    <!-- Orders Table -->
    <div class="bg-white/95 backdrop-blur-lg p-6 sm:p-8 rounded-2xl shadow-2xl max-w-4xl w-full mx-auto">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-center text-gray-800 mb-6 sm:mb-8">All Shirt Orders</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 font-bold text-gray-700">Name</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Phone</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Sizes</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Total Cost (with tax)</th>
                        <th class="px-4 py-3 font-bold text-gray-700">Date</th>
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
                                <ul class="list-disc list-inside">
                                    @foreach ($order->sizes as $size => $data)
                                        @if ($data['quantity'] > 0)
                                            <li>{{ ucwords(str_replace('-', ' ', $size)) }}: {{ $data['quantity'] }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-4 py-3">${{ number_format($order->total_cost, 2) }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
