<x-front-layout>
    <main class="max-w-6xl mx-auto mt-6 mb-6 min-h-screen">
        <section class="bg-gray-200 dark:bg-gray-900 dark:text-white mt-4 p-2 rounded">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 rounded">
                @foreach($casts as $cast)
                    <x-movie-card>
                        <x-slot name="image">
                            <a href="{{ route('casts.show', $cast->slug)}}">
                                <div class="aspect-w-2 aspect-h-3">
                                    <img class="object-cover" src="https://www.themoviedb.org/t/p/w220_and_h330_face/{{$cast->poster_path}}">
                                </div>                
                            </a>
                        </x-slot>
                        <a href="{{ route('casts.show', $cast->slug)}}">
                            <div class="dark:text-white font-bold group-hover:text-blue-400">
                                {{ $cast->name }}
                            </div>
                           
                        </a>
                    </x-movie-card>
                @endforeach
            </div>
            <div class="m-2 p-2">
                {{ $casts->links() }}
            </div>
        </section>
    </main>
</x-front-layout>   