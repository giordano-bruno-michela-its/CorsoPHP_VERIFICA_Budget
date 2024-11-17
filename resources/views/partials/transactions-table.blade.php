@foreach ($transactions as $transaction)
<tr>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->id }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->account->name }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->transactionType->name }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->description }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-200">{{ $transaction->amount }}</td>
    <td class="px-6 py-1 whitespace-nowrap border border-gray-200">
        <!-- Actions buttons here -->
    </td>
</tr>
@endforeach