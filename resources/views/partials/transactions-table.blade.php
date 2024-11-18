@foreach ($transactions as $transaction)
<tr class="bg-white dark:bg-gray-900 {{ $transaction->transactionType->type === 'expense' ? 'text-red-500' : ($transaction->transactionType->type === 'income' ? 'text-green-500' : 'text-blue-500') }}">
    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->account->name }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->transactionType->name }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->description }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $transaction->transactionType->type === 'expense' ? '-' : '' }}{{ number_format($transaction->amount, 2) }} &euro;</td>
    <td class="px-5 py-1 whitespace-nowrap border border-gray-700">
        <div class="flex space-x-2">
            <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-blue-500 hover:text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828zM4 12v4h4v-1H5v-3H4z" />
                </svg>
            </a>
            <a href="{{ route('transactions.delete', $transaction->id) }}" class="text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h1v11a2 2 0 002 2h8a2 2 0 002-2V6h1a1 1 0 100-2h-2V3a1 1 0 00-1-1H6zm3 4a1 1 0 112 0v9a1 1 0 11-2 0V6z" />
                </svg>
            </a>
        </div>
    </td>
</tr>
@endforeach