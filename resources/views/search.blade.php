<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Search
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form action="/" method="GET">
                <x-text-input id="query" name="query" type="search" placeholder="Search...." class="block w-full"
                    value="{{ request()->get('query') }}" />
                <x-primary-button style="margin: 1rem 0">Search</x-button>
            </form>

            @if ($results)
                <div class="space-y-6">
                    @if ($results->count())
                        <em class="">Found {{ $results->total() }} results</em>
                        @foreach ($results as $result)
                            <div class="p-6 mb-4 border shadow-sm rounded-xl shadow-black">
                                <div class="flex items-center justify-between">
                                    <a href="{{ $result->link }}" class="underline" target="_blank">
                                        <h2 class="text-lg font-bold">{{ $result->title }}</h2>

                                    </a>
                                    <time datetime="{{ $result->published_at }}"
                                        class="text-sm">{{ $result->published_at }}</time>
                                </div>
                                <div class="mb-4">
                                    {{ $result->category }}
                                </div>
                                <div>
                                    <p>{!! mb_strimwidth($result->description, 0, 200, '...') !!}</p>
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
