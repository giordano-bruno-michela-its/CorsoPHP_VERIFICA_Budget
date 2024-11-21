<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        {{--  --}}
    </div>

    <div class="w-full text-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full flex justify-center">
                <div class="w-1/3 mr-6 flex flex-col">
                    @include('partials.account-balances')
                </div>
                <div class="w-1/3 flex flex-col">
                    @include('partials.period-selector')
                </div>
            </div>
        </div>
    </div>

    <div class="w-full text-center mt-6">
        <div class="w-auto mx-auto sm:px-6 lg:px-8 mt-6 inline-block">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 relative">
                    <h2 class="mb-6 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
                        Transactions
                    </h2>
                    <div class="absolute top-0 right-0 mt-4 mr-7">
                        <a href="{{ route('transactions.create') }}" class="bg-blue-500 text-white p-2 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </a>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <label for="per_page" class="text-gray-700 dark:text-gray-300">Rows per page:</label>
                            <select id="per_page" name="per_page" class="ml-2 dark:bg-gray-900 dark:text-gray-300" onchange="updatePerPage()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                        <div>
                            {{ $transactions->links() }}
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 w-full" data-sort-dir="asc">
                            <thead>
                                <tr>
                                    <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700" onclick="sortTable('created_at', toggleSortDirection('created_at'))">
                                        Date <span id="created_at_arrow" class="sort-arrow">&#9650;</span>
                                    </th>
                                    <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700">Account</th>
                                    <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700">Type</th>
                                    <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700">Description</th>
                                    <th class="cursor-pointer px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700" onclick="sortTable('amount', toggleSortDirection('amount'))">
                                        Amount <span id="amount_arrow" class="sort-arrow">&#9650;</span>
                                    </th>
                                    <th class="cursor-pointer px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700 w-16"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="transactionsTable">
                                @foreach ($transactions as $transaction)
                                <tr class="bg-white dark:bg-gray-900 hover:bg-gray-600 {{ $transaction->transactionType->type === 'expense' ? 'text-red-500' : ($transaction->transactionType->type === 'income' ? 'text-green-500' : 'text-blue-500') }} cursor-pointer" onclick="window.location='{{ route('transactions.edit', $transaction->id) }}'">
                                    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->account->name }}</td>
                                    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->transactionType->name }}</td>
                                    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->description }}</td>
                                    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->transactionType->type === 'expense' ? '-' : '' }}{{ number_format($transaction->amount, 2) }} &euro;</td>
                                    <td class="px-5 py-1 whitespace-nowrap border border-gray-700" onclick="event.stopPropagation();">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('transactions.delete', $transaction->id) }}" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v11a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 4a1 1 0 112 0v9a1 1 0 11-2 0V6z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var transactionsSortUrl = "{{ route('transactions.sort') }}";
    </script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
        function updatePerPage() {
            const perPage = document.getElementById('per_page').value;
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            url.searchParams.set('page', 1); 
            window.location.href = url.toString();
        }
    </script>

</x-app-layout>