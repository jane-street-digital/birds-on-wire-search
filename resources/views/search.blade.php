<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Birds on a Wire Search
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="/" method="GET">
                        <x-text-input id="query" name="query" type="search" placeholder="Search...."
                            class="block w-full" />
                        <x-primary-button style="margin: 1rem 0">Search</x-button>
                    </form>

                    @if ($results)
                        <div class="space-y-4">
                            @if ($results->count())
                                @foreach ($results as $result)
                                    <div class="border">
                                        <h1>Title:{{ $result->title }}</h1>
                                        <p>Published: {{ $result->pubDate }}</p>
                                        <p>Description:{{ $result->description }}</p>
                                        <a href="{{ $result->link }}" class="underline">Link</a>
                                    </div>
                                @endforeach
                            @else
                                <p>No results found</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
