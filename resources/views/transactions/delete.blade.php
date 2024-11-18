<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Delete Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-1/2 mx-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('transactions.destroy', $transaction->id) }}">
                        @csrf
                        @method('DELETE')

                        <div>
                            <x-input-label for="account_id" :value="__('Account')" />
                            <x-text-input id="account_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300" type="text" name="account_id" value="{{ $transaction->account->name }}" disabled />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="transaction_type_id" :value="__('Transaction Type')" />
                            <x-text-input id="transaction_type_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300" type="text" name="transaction_type_id" value="{{ $transaction->transactionType->name }}" disabled />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $transaction->description }}" disabled />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="text" name="amount" value="{{ $transaction->amount }}" disabled />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="created_at" :value="__('Date and Time')" />
                            <x-text-input id="created_at" class="block mt-1 w-full" type="text" name="created_at" value="{{ $transaction->created_at->format('Y-m-d H:i') }}" disabled />
                        </div>

                        <div class="flex items-center justify-center mt-4">
                            <x-secondary-button onclick="window.history.back();">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-danger-button class="ml-4">
                                {{ __('Delete Transaction') }}
                            </x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>