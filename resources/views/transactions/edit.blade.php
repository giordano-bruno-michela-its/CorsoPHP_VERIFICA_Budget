<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-1/2 mx-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" enctype="multipart/form-data">
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
                            <x-input-label for="file" :value="__('Upload File (Image or PDF)')" />
                            <x-text-input id="file" class="block mt-1 w-full" type="file" name="file" accept="image/*,application/pdf" />
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

        @if($transaction->file_path)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-1/2 mx-auto ml-4 mt-8">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight mb-4">{{ __('Uploaded File') }}</h3>
                @if(Str::endsWith($transaction->file_path, ['.jpg', '.jpeg', '.png', '.gif', '.svg']))
                <img src="{{ asset('storage/' . $transaction->file_path) }}" alt="Uploaded Image" class="w-full h-auto">
                @elseif(Str::endsWith($transaction->file_path, ['.pdf']))
                <a href="{{ asset('storage/' . $transaction->file_path) }}" target="_blank" class="text-blue-500 hover:underline mt-4 block">Download PDF</a>
                @endif
            </div>
        </div>
        @endif

    </div>
</x-app-layout>