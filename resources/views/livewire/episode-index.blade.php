<section class="container mx-auto p-6 font-mono">
  <div class="w-full mb-4 p-2 flex justify-end">
    <form class="flex shadow bg-white rounded-md m-2 p-2">
      <div class="p-1 flex items-center">
        <label for="tmdb_id_g" class="block text-sm font-medium text-gray-700 md:mr-4">Episode Number</label>
        <div class="relative rounded-md shadow-sm">
          <input wire:model="episodeNumber" id="tmdb_id_g" name="tmdb_id_g" class="px-3 py-2 border border-gray-300 rounded" placeholder="" />
        </div>
      </div>
      <div class="p-1">
        <button wire:click="generateEpisode" type="button" class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-green-700 transition duration-150 ease-in-out disabled:opacity-50">
          <span>Generate</span>
        </button>
      </div>
    </form>
  </div>
  <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">

    <div class="w-full shadow p-5 bg-white">
      <div class="relative">
          <div class="absolute flex items-center ml-2 h-full">
              <svg class="w-4 h-4 fill-current text-primary-gray-dark" viewBox="0 0 16 16" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                      d="M15.8898 15.0493L11.8588 11.0182C11.7869 10.9463 11.6932 10.9088 11.5932 10.9088H11.2713C12.3431 9.74952 12.9994 8.20272 12.9994 6.49968C12.9994 2.90923 10.0901 0 6.49968 0C2.90923 0 0 2.90923 0 6.49968C0 10.0901 2.90923 12.9994 6.49968 12.9994C8.20272 12.9994 9.74952 12.3431 10.9088 11.2744V11.5932C10.9088 11.6932 10.9495 11.7869 11.0182 11.8588L15.0493 15.8898C15.1961 16.0367 15.4336 16.0367 15.5805 15.8898L15.8898 15.5805C16.0367 15.4336 16.0367 15.1961 15.8898 15.0493ZM6.49968 11.9994C3.45921 11.9994 0.999951 9.54016 0.999951 6.49968C0.999951 3.45921 3.45921 0.999951 6.49968 0.999951C9.54016 0.999951 11.9994 3.45921 11.9994 6.49968C11.9994 9.54016 9.54016 11.9994 6.49968 11.9994Z">
                  </path>
              </svg>
          </div>

          <input wire:model.live="search" type="text" placeholder="Search by title"
              class="px-8 py-3 w-full md:w-2/6 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm" />
      </div>

      <div class="flex items-center justify-between mt-4">
          <p class="font-medium">Filters</p>

          <button wire:click="resetFilters"
              class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md">Reset
              Filter</button>
      </div>

      <div>
          <div class="flex justify-between space-x-4 mt-4">
              <select wire:model.live="sort"
                  class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                  <option value="asc">Asc</option>
                  <option value="desc">Desc</option>
              </select>

              <select wire:model.live="perPage"
                  class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0 text-sm">
                  <option value="5">5 Per Page</option>
                  <option value="10">10 Per Page</option>
                  <option value="15">15 Per Page</option>
              </select>
          </div>
      </div>
  </div>

    <div class="w-full overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Public</th>
            <th class="px-4 py-3">Episode Number</th>
            <th class="px-4 py-3">Manage</th>
          </tr>
        </thead>
        <tbody class="bg-white">
          @foreach($episodes as $tepisode)
          <tr class="text-gray-700">
            <td class="px-4 py-3 border">
              {{ $tepisode->name }}
            </td>
            <td class="px-4 py-3 text-ms font-semibold border">
              @if($tepisode->is_public)
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Published</span>
              @else
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">UnPublished</span>
              @endif
            </td>
            <td class="px-4 py-3 text-ms font-semibold border">{{ $tepisode->episode_number }}</td>
            <td class="px-4 py-3 text-sm border">
              <x-m-button wire:click="showTrailerModal({{ $tepisode->id }})"
                class="bg-indigo-500 hover:bg-indigo-700 text-white">Trailer</x-m-button>
              <x-m-button wire:click="showEditModal({{$tepisode->id}})" class="bg-green-500 hover:bg-green-700 text-white">Edit</x-m-button>
              <x-m-button wire:click="deleteEpisode({{$tepisode->id}})" class="bg-red-500 hover:bg-red-700 text-white">Delete</x-m-button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="m-2 p-2">
        {{ $episodes->links() }}
      </div>
    </div>
  </div>

  <x-dialog-modal wire:model="showEpisodeModal">
    <x-slot name="title">Update Episode</x-slot>
    <x-slot name="content">  
      <div class="border-b border-gray-900/10 pb-12">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">
          <div class="sm:col-span-3">
            <label for="" class="block text-sm font-medium leading-6 text-gray-900">Episode name</label>
            <div class="mt-2">
              <input wire:model="episodeName" type="text" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              @error('episodeName')
                  <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>
          </div>  
          <div class="sm:col-span-3">
            <label for="" class="block text-sm font-medium leading-6 text-gray-900">Episode Number</label>
            <div class="mt-2">
              <input wire:model="episodeNumber" type="text" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              @error('episodeNumber')
                  <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>
          </div>   
          <div class="sm:col-span-3">
            <label for="" class="block text-sm font-medium leading-6 text-gray-900">Overview</label>
            <div class="mt-2">
              <textarea class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ $overview }}</textarea>
              @error('overview')
                  <span class="text-red-500 text-sm">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="sm:col-span-3">
              <div class="flex items-center">
                <input wire:model="isPublic" type="checkbox" class="h-4 w-4 text-indigo-600 foccus:ring-indigo-500 border-gray-300 rounded">
                <label for="isPublic" class="ml-2 block text-sm text-gray-900">
                  Publish
                </label>
              </div>
          </div>
        </div>
      </div>   
    </x-slot>

    <x-slot name="footer">
      <x-button wire:click="closeEpisodeModal">Cancel</x-button>
      <x-m-button wire:click="updateEpisode">Update</x-m-button>
    </x-slot>
  </x-dialog-modal>

  <x-dialog-modal wire:model="showTrailer">
    <x-slot name="title">Trailer Movie</x-slot>
    <x-slot name="content">
        @if ($episode)
            <div class="flex space-x-4 space-y-2 m-2">
                @foreach ($episode->trailers as $trailer)
                    <x-button wire:click="deleteTrailer({{ $trailer->id }})" class="hover:bg-red-500">
                        {{ $trailer->name }}</x-button>
                @endforeach
            </div>
        @endif
        <div class="mt-10 sm:mt-0">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form>
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="flex flex-col">
                                <label for="first-name"
                                    class="block text-sm font-medium text-gray-700 mr-4">Name</label>
                                <input wire:model="trailerName" type="text"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                                @error('trailerName')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label for="embedHtml" class="block text-sm font-medium text-gray-700 mr-4">Embed
                                    Html</label>
                                <textarea wire:model="embedHtml"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                @error('embedHtml')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </x-slot>
    <x-slot name="footer">
        <x-m-button wire:click="closeEpisodeModal" class="bg-gray-600 hover:bg-gray-800 text-white">Cancel
        </x-m-button>
        <x-m-button wire:click="addTrailer">Add Trailer</x-m-button>
    </x-slot>
</x-dialog-modal>

</section>