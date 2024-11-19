<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-1/2 mx-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('transactions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4">
                            <x-input-label for="account_id" :value="__('Account')" />
                            <select id="account_id" name="account_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300">
                                @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="transaction_type_id" :value="__('Transaction Type')" />
                            <select id="transaction_type_id" name="transaction_type_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300">
                                @foreach ($transactionTypes as $transactionType)
                                <option value="{{ $transactionType->id }}">{{ $transactionType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4" id="to_account_div" style="display: none;">
                            <x-input-label for="to_account_id" :value="__('To Account')" />
                            <select id="to_account_id" name="to_account_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300">
                                @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="created_at" :value="__('Date and Time')" />
                            <x-text-input id="created_at" class="block mt-1 w-full" type="datetime-local" name="created_at" value="{{ old('created_at', now()->format('Y-m-d\TH:i')) }}" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="file" :value="__('Upload File (Image or PDF)')" />
                            <x-text-input id="file" class="block mt-1 w-full" type="file" name="file" accept="image/*,application/pdf" />
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <x-secondary-button onclick="window.history.back();">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button class="ml-4">
                                {{ __('Add Transaction') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('transaction_type_id').addEventListener('change', function() {
        var toAccountDiv = document.getElementById('to_account_div');
        var toAccountSelect = document.getElementById('to_account_id');
        var originAccountId = document.getElementById('account_id').value;

        if (this.value == 3) { // Assuming 3 is the ID for transfer type
            toAccountDiv.style.display = 'block';

            // Filter out the selected origin account and set the first available account as selected
            let firstAvailableAccount = null;
            Array.from(toAccountSelect.options).forEach(function(option) {
                if (option.value == originAccountId) {
                    option.style.display = 'none';
                } else {
                    option.style.display = 'block';
                    if (!firstAvailableAccount) {
                        firstAvailableAccount = option;
                    }
                }
            });

            if (firstAvailableAccount) {
                toAccountSelect.value = firstAvailableAccount.value;
            }
        } else {
            toAccountDiv.style.display = 'none';
        }
    });

    document.getElementById('account_id').addEventListener('change', function() {
        var toAccountSelect = document.getElementById('to_account_id');
        var originAccountId = this.value;

        // Filter out the selected origin account
        Array.from(toAccountSelect.options).forEach(function(option) {
            option.style.display = option.value == originAccountId ? 'none' : 'block';
        });

        // If the transaction type is transfer, update the To Account selection
        if (document.getElementById('transaction_type_id').value == 3) {
            let firstAvailableAccount = null;
            Array.from(toAccountSelect.options).forEach(function(option) {
                if (option.style.display !== 'none' && !firstAvailableAccount) {
                    firstAvailableAccount = option;
                }
            });

            if (firstAvailableAccount) {
                toAccountSelect.value = firstAvailableAccount.value;
            }
        }
    });
</script>