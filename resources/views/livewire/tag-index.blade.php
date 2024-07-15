<section class="container mx-auto p-6 font-mono">
    <div class="w-full mb-4 p-2 flex justify-end">
        <x-button wire:click="showCreateModal">Create Tag</x-button>
    </div>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
      <div class="w-full overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
              <th class="px-4 py-3">Name</th>
              <th class="px-4 py-3">Slug</th>
              <th class="px-4 py-3">Manage</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            @forelse ($tags as $tag)
              <tr class="text-gray-700">
                <td class="px-4 py-3 border">
                  {{$tag->tag_name}}
                </td>
                <td class="px-4 py-3 text-ms font-semibold border">{{$tag->slug}}</td>
                <td class="px-4 py-3 text-sm border">
                  <x-m-button wire:click="showEditModal({{$tag->id}})" class="bg-green-500 hover:bg-green-700 text-white">Edit</x-m-button>
                  <x-m-button wire:click="deleteTag({{$tag->id}})" class="bg-red-500 hover:bg-red-700 text-white">Delete</x-m-button>
                </td>
              </tr>
            @empty
            <tr class="text-gray-700">
              <td class="px-4 py-3 border">
                Empty
              </td>
            </tr>
            @endforelse
         
          </tbody>
        </table>
      </div>
    </div>
    <x-dialog-modal wire:model="showTagModal">
      @if($tagId)
        <x-slot name="title">Update Tag</x-slot>
      @else 
        <x-slot name="title">Create Tag</x-slot>
      @endif
      <x-slot name="content">  
        <div class="border-b border-gray-900/10 pb-12">
          <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8">
            <div class="sm:col-span-3">
              <label for="" class="block text-sm font-medium leading-6 text-gray-900">Tag name</label>
              <div class="mt-2">
                <input wire:model="tagName" type="text" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
              </div>
            </div>
          </div>
        </div>   
      </x-slot>

      <x-slot name="footer">
        <x-button wire:click="closeTagModal">Cancel</x-button>
        @if($tagId)
          <x-m-button wire:click="updateTag">Update</x-m-button>
        @else
          <x-m-button wire:click="createTag">Create</x-m-button>
        @endif
      </x-slot>
    </x-dialog-modal>
    
  </section>
  