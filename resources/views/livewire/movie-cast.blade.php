<div>
    <div class="w-full m-2">
        @forelse ($movie->casts as $mcast)
            <x-button wire:click="detachCast({{ $mcast->id }})" class="hover:bg-red-500">{{ $mcast->name }}
            </x-button>
        @empty
            No Casts
        @endforelse
    </div>
    <input wire:model.live="queryCast" type="text" class="rounded w-full" placeholder="Search Cast">
    @if (!empty($queryCast))
        <div class="w-full">
            @if (!empty($casts))
                @foreach ($casts as $cast)
                    <div wire:click="addCast({{ $cast->id }})"
                        class="w-full p-2 m-2 bg-green-300 hover:bg-green-400 cursor-pointer">
                        {{ $cast->name }}</div>
                @endforeach
            @endif
        </div>
    @endif
</div>