<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Spot prices') }}
        </h2>
    </x-slot>
    <div class="py-12">
        @if(@isset($data))

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="bg-white  graph-output">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                            <div class="ml-4 mt-2">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ __('Spot prices') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        Her
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-spotprices.form />
            </div>
        </div>
    </div>
</x-app-layout>