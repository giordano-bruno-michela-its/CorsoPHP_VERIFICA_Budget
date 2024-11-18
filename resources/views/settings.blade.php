<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg w-1/2 mx-auto">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="pb-4 text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Transaction types') }}</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead>
                                <tr>
                                    <th class="px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700">Name</th>
                                    <th class="px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700">Description</th>
                                    <th class="px-6 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider border border-gray-700">Type</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($transactionTypes as $type)
                                <tr class="bg-white dark:bg-gray-900">
                                    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $type->name }}</td>
                                    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ $type->description }}</td>
                                    <td class="px-6 py-1 whitespace-nowrap border border-gray-700">{{ ucfirst($type->type) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>