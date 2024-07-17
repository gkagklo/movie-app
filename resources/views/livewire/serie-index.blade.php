<section class="container mx-auto p-6 font-mono">
  <div class="w-full mb-4 p-2 flex justify-end">
    <form class="flex shadow bg-white rounded-md m-2 p-2">
      <div class="p-1 flex items-center">
        <label for="tmdb_id_g" class="block text-sm font-medium text-gray-700 md:mr-4">Cast Tmdb Id</label>
        <div class="relative rounded-md shadow-sm">
          <input wire:model="serieTMDBId" id="tmdb_id_g" name="tmdb_id_g" class="px-3 py-2 border border-gray-300 rounded" placeholder="" />
        </div>
      </div>
      <div class="p-1">
        <button wire:click="generateSerie" type="button" class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-green-700 transition duration-150 ease-in-out disabled:opacity-50">
          <span>Generate</span>
        </button>
      </div>
    </form>
  </div>
  <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
    <div class="w-full overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Slug</th>
            <th class="px-4 py-3">Created Year</th>
            <th class="px-4 py-3">Poster Path</th>
            <th class="px-4 py-3">Manage</th>
          </tr>
        </thead>
        <tbody class="bg-white">
          @foreach($series as $serie)
          <tr class="text-gray-700">
            <td class="px-4 py-3 border">
              {{ $serie->name }}
            </td>
            <td class="px-4 py-3 text-ms font-semibold border">{{ $serie->slug }}</td>
            <td class="px-4 py-3 text-ms font-semibold border">{{ $serie->created_year }}</td>
            <td class="px-4 py-3 text-xs border">
              <img class="w-12 h-12 rounded" src="{{ asset('https://image.tmdb.org/t/p/w500/'. $serie->poster_path) }}">
            </td>
            <td class="px-4 py-3 text-sm border">
              <x-m-button wire:click="showEditModal({{$serie->id}})" class="bg-green-500 hover:bg-green-700 text-white">Edit</x-m-button>
              <x-m-button wire:click="deleteSerie({{$serie->id}})" class="bg-red-500 hover:bg-red-700 text-white">Delete</x-m-button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="m-2 p-2">
        {{ $series->links() }}
      </div>
    </div>
  </div>

  <x-dialog-modal wire:model="showSerieModal">
    <x-slot name="title">Update Serie</x-slot>
    <x-slot name="content">  
      <div class="border-b border-gray-900/10 pb-12">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">
          <div class="sm:col-span-3">
            <label for="" class="block text-sm font-medium leading-6 text-gray-900">Serie name</label>
            <div class="mt-2">
              <input wire:model="serieName" type="text" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              @error('serieName')
                  <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="sm:col-span-3">
            <label for="" class="block text-sm font-medium leading-6 text-gray-900">Created Year</label>
            <div class="mt-2">
              <input wire:model="createdYear" type="text" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              @error('createdYear')
                  <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="sm:col-span-3">
            <label for="" class="block text-sm font-medium leading-6 text-gray-900">Serie Poster</label>
            <div class="mt-2">
              <input wire:model="seriePosterPath" type="text" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              @error('seriePosterPath')
                  <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>
      </div>   
    </x-slot>

    <x-slot name="footer">
      <x-button wire:click="closeSerieModal">Cancel</x-button>
      <x-m-button wire:click="updateSerie">Update</x-m-button>
    </x-slot>
  </x-dialog-modal>

</section>