<x-app-layout>
    <section class="bg-white py-8">

        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                <p class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                    Category:
                </p>
                <a class="uppercase tracking-wide underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                     {{  $category->name }}
                </a>
            </div>

            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                <p class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                    Description:
                </p>
            </div>

            {{  $category->description }}

            @if( count( $category->children ) )

            <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                <p class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
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
                <p class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                    Products
                </p>
            </div>

            @if( count( $products ) )
                @foreach($products as $product)
                    <x-products-grid :product="$product" />
                @endforeach
            @else
                No Products
            @endif

            @if( $category->parent )
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                    <p class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                        Parent category
                    </p>
                </div>
                <div class="w-full container mx-auto flex flex-wrap items-center justify-start mt-0 px-2 py-3">
                        <a class="tracking-wide no-underline hover:no-underline text-gray-500 text-xl mr-3 border-solid border-2 border-gray-300 rounded-full px-4 py-1 inline-block" href="{{ route('categories.show', $category->parent) }}">{{ $category->parent->name }}</a>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
