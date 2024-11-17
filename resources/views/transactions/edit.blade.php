<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-1/2 mx-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="account_id" :value="__('Account')" />
                            <select id="account_id" name="account_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300">
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ $transaction->account_id == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="transaction_type_id" :value="__('Transaction Type')" />
                            <select id="transaction_type_id" name="transaction_type_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300">
                                @foreach($transactionTypes as $type)
                                @if($type->type !== 'transfer')
                                <option value="{{ $type->id }}" {{ $transaction->transaction_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $transaction->description }}" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" name="amount" value="{{ $transaction->amount }}" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="created_at" :value="__('Date and Time')" />
                            <x-text-input id="created_at" class="block mt-1 w-full" type="datetime-local" name="created_at" value="{{ $transaction->created_at->format('Y-m-d\TH:i') }}" />
                        </div>

                        <div class="flex items-center justify-center mt-4">
                            <x-secondary-button onclick="window.history.back();">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button class="ml-4">
                                {{ __('Update Transaction') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>