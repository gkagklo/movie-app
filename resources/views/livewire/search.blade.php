<div class="relative pointer-events-auto">
    <button type="button" wire:click="showSearch"
        class="w-52 md:w-72 flex items-center text-sm leading-6 text-gray-400 rounded-md ring-1 ring-gray-900/10 shadow-sm py-1.5 pl-2 pr-3 hover:ring-gray-300 dark:bg-gray-700 dark:highlight-white/5 dark:hover:bg-gray-900"><svg
            width="24" height="24" fill="none" aria-hidden="true" class="mr-3 flex-none">
            <path d="m19 19-3.5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round"></path>
            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round"></circle>
        </svg>Quick search...</button>
    <x-search-modal wire:model="showSearchModal">
        <x-slot name="title">Search Movies</x-slot>
        <x-slot name="content">

            <div class="flex flex-col">
                <input wire:model.live="search" type="text" class="rounded w-full dark:bg-gray-700"
                    placeholder="Search Movie">
                <div wire:loading class="border border-blue-300 shadow rounded-md p-4 w-full mx-auto mt-4">
                    <div class="animate-pulse flex space-x-4">
                        <div class="rounded-full bg-gray-200 h-10 w-10"></div>
                        <div class="flex-1 space-y-6 py-1"> 
                            <div class="h-2 bg-gray-200 rounded"></div>
                            <div class="space-y-3">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="h-2 bg-gray-200 rounded col-span-2"></div>
                                    <div class="h-2 bg-gray-200 rounded col-span-1"></div>
                                </div>
                                <div class="h-2 bg-gray-200 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (!empty($search))
                    <div class="" wire:loading.remove>
                        @forelse($results->groupByType() as $type => $modelSearchResults)
                        <div class="font-bold mt-2 mb-2">{{ ucfirst($type) }}</div>
                        <ul class="list-inside">
                            @foreach($modelSearchResults as $searchResult)
                            <a href="{{ $searchResult->url }}">
                                <div
                                    class="p-2 m-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-500 dark:hover:bg-gray-700 cursor-pointer rounded-md">
                                    {{ $searchResult->title }}</div>
                            </a>
                            @endforeach
                        </ul>
                    @empty
                        No results.
                    @endforelse
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-m-button wire:click="closeSearchModal" class="bg-gray-600 hover:bg-gray-800 text-white">Cancel
            </x-m-button>
        </x-slot>
    </x-search-modal>
</div>