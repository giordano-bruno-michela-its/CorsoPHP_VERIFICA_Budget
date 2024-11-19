<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <span class="text-red-500">{{ __('Delete Account') }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-1/2 mx-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('accounts.destroy', $account->id) }}">
                        @csrf
                        @method('DELETE')

                        <div>
                            <x-input-label for="name" :value="__('Account Name')" />
                            <x-text-input id="name" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300" type="text" name="name" value="{{ $account->name }}" disabled />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300" type="text" name="description" value="{{ $account->description }}" disabled />
                        </div>

                        <div class="flex items-center justify-center mt-4">
                            <x-secondary-button onclick="window.history.back();">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-danger-button class="ml-4">
                                {{ __('Delete Account') }}
                            </x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>