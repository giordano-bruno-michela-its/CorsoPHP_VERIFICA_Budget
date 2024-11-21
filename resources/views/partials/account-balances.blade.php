<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 flex-grow">
    <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col justify-between h-full">
        <h3 class="pb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Account Balances</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700">Account</th>
                        <th class="px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700">Balance</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($accounts as $account)
                    <tr class="bg-white dark:bg-gray-900 hover:bg-gray-600 cursor-pointer" onclick="filterTransactions('{{ $account->id }}')">
                        <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $account->name }}</td>
                        <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ number_format($account->balance, 2) }} &euro;</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">Total Balance: {{ number_format($totalBalance, 2) }} &euro;</h4>
        </div>
        <div class="pt-6">
            <button onclick="resetFilter()" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Reset</button>
        </div>
    </div>
</div>

<script>
    function filterTransactions(accountId) {
        const url = new URL(window.location.href);
        url.searchParams.set('account_id', accountId);
        window.location.href = url.toString();
    }

    function resetFilter() {
        const url = new URL(window.location.href);
        url.searchParams.delete('account_id');
        window.location.href = url.toString();
    }
</script>