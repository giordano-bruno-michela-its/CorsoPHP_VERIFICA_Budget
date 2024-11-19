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
                    <div class="mb-4 text-red-600 font-bold">
                        {{ __('Warning: Deleting this account will also delete all related transactions.') }}
                    </div>
                    <form id="delete-account-form" method="POST" action="{{ route('accounts.destroy', $account->id) }}">
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
                            <x-danger-button class="ml-4"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-account-deletion')"
                            >{{ __('Delete Account') }}</x-danger-button>
                        </div>
                    </form>

                    <x-modal name="confirm-account-deletion" :show="false" focusable>
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Are you sure you want to delete this account?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Once this account is deleted, all of its resources and data will be permanently deleted.') }}
                            </p>

                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ml-4" x-on:click="$dispatch('close'); document.getElementById('delete-account-form').submit();">
                                    {{ __('Delete Account') }}
                                </x-danger-button>
                            </div>
                        </div>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>