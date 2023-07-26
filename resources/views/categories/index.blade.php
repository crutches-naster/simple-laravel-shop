<x-app-layout>
    <section class="bg-white">

        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12 border-b-gray-200">
            @foreach($categories as $category)
            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                <p class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl ">
                    Category:
                </p>
                <a class="uppercase tracking-wide underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                    {{  $category->name }}
                </a>
            </div>

            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                <p class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " >
                    Description:
                </p>
            </div>

            {{  $category->description }}

            @if( count( $category->children ) )

                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                    <p class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl ">
                        Child categories
                    </p>
                </div>
                <div class="w-full container mx-auto flex flex-wrap items-center justify-start mt-0 px-2 py-3">
                    @foreach($category->children as $child)
                        <a class="tracking-wide no-underline hover:no-underline text-gray-500 text-xl mr-3 border-solid border-2 border-gray-300 rounded-full px-4 py-1 inline-block" href="{{ route('categories.show', $child) }}">{{ $child->name }}</a>
                    @endforeach
                </div>
            @endif

                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                    <span class="w-full p-0.5 bg-black "></span>
                </div>
        @endforeach

        </div>
    </section>
</x-app-layout>
