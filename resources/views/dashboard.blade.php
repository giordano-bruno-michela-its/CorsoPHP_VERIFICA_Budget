<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <!--         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div> -->
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="w-full flex">
            <div class="w-1/4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Account Balances</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Account</th>
                                        <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Balance</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($accounts as $account)
                                    <tr>
                                        <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $account->name }}</td>
                                        <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $account->balance }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-3/4">
                <!-- Other content goes here -->
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="flex justify-end mb-4">

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="bg-blue-500 text-white p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg">
                    <ul>
                        <li class="px-4 py-2 border-b border-gray-200">
                            <a href="{{ route('transactions.create') }}" class="text-blue-500">Add Transaction</a>
                        </li>
                        <li class="px-4 py-2 border-b border-gray-200">
                            <a href="{{ route('accounts.create') }}" class="text-green-500">Add Account</a>
                        </li>
                        <li class="px-4 py-2">
                            <a href="{{ route('transaction-types.create') }}" class="text-purple-500">Add Transaction Type</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Manage Transaction Types</button>
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg">
                    <ul>
                        @foreach ($transactionTypes as $type)
                        <li class="px-4 py-2 border-b border-gray-200">
                            <span>{{ $type->name }}</span>
                            <a href="{{ route('transaction-types.edit', $type->id) }}" class="text-blue-500 ml-2">Edit</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="mb-6 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
                    Transactions
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 w-full" data-sort-dir="asc">
                        <thead>
                            <tr>
                                <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200" onclick="sortTable('created_at', toggleSortDirection('created_at'))">
                                    Date <span id="created_at_arrow" class="sort-arrow">&#9650;</span>
                                </th>
                                <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Account</th>
                                <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Type</th>
                                <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Description</th>
                                <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200" onclick="sortTable('amount', toggleSortDirection('amount'))">
                                    Amount <span id="amount_arrow" class="sort-arrow">&#9650;</span>
                                </th>
                                <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border border-gray-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="transactionsTable">
                            @foreach ($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->account->name }}</td>
                                <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->transactionType->name }}</td>
                                <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->description }}</td>
                                <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->amount }}</td>
                                <td class="px-6 py-1 whitespace-nowrap border border-gray-200">
                                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828zM4 12v4h4v-1H5v-3H4z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            function sortTable(column, direction) {
                $.ajax({
                    url: '{{ route('transactions.sort') }}',
                    type: 'GET',
                    data: {
                        column: column,
                        direction: direction
                    },
                    success: function(data) {
                        $('#transactionsTable').html(data);
                        document.getElementById("transactionsTable").setAttribute("data-sort-dir", direction);
                        updateSortArrows(column, direction);
                    }
                });
            }

            function toggleSortDirection(column) {
                const currentDirection = document.getElementById("transactionsTable").getAttribute("data-sort-dir");
                return currentDirection === 'asc' ? 'desc' : 'asc';
            }

            function updateSortArrows(column, direction) {
                const arrows = document.querySelectorAll('.sort-arrow');
                arrows.forEach(arrow => arrow.innerHTML = '&#9650;&#9660;'); // Reset all arrows to up and down

                const arrow = document.getElementById(column + '_arrow');
                if (direction === 'asc') {
                    arrow.innerHTML = '&#9650;'; // Up arrow
                } else {
                    arrow.innerHTML = '&#9660;'; // Down arrow
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById("transactionsTable").setAttribute("data-sort-dir", "desc");
                sortTable('created_at', 'desc');
            });
        </script>

    </div>



    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this transaction?')) {
                // Delete logic here
            }
        }
    </script>

</x-app-layout>