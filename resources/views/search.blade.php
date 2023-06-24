<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Search
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="/" method="GET">
                <x-text-input id="query" name="query" type="search" placeholder="Search...."
                    class="block w-full" value="{{ request()->get('query') }}" />
                <x-primary-button style="margin: 1rem 0">Search</x-button>
            </form>

            @if ($results)
                <div class="space-y-6">
                    @if ($results->count())
                        <em class="">Found {{ $results->total() }} results</em>
                        @foreach ($results as $result)
                            <div class="border mb-4 p-6 rounded-xl">
                                <div class="flex justify-between items-center mb-4">
                                    <a href="{{ $result->link }}" class="underline" target="_blank">
                                        <h2 class="text-lg font-bold">{{ $result->title }}</h2>
                                    </a>
                                    <time datetime="{{ $result->published_at }}" class="text-sm">{{ $result->published_at }}</time>
                                </div>
                                <div>
                                    <p>{!! $result->description !!}</p>
                                </div>
                            </div>
                        @endforeach

                        {{ $results->links() }}
                    @else
                        <p>No results found</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
