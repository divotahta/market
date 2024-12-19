<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Kategori Pills -->
            <div class="flex flex-wrap gap-2 mb-6 px-4 sm:px-0">
                <button onclick="filterProducts('all')" 
                        class="category-filter px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-blue-600 hover:text-white transition"
                        data-category="all">
                    Semua
                </button>
                @foreach($categories as $category)
                    <button onclick="filterProducts({{ $category->id }})"
                            class="category-filter px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-blue-600 hover:text-white transition"
                            data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                    <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden"
                         data-category="{{ $product->category_id }}">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-56 object-cover">
                        @else
                            <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-xl font-bold text-blue-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                    {{ $product->condition }}
                                </span>
                            </div>
                            <a href="https://wa.me/{{ $product->whatsapp }}?text=Halo, saya tertarik dengan {{ $product->name }}" 
                               target="_blank" 
                               class="block w-full text-center bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function filterProducts(categoryId) {
            document.querySelectorAll('.category-filter').forEach(button => {
                if ((categoryId === 'all' && button.dataset.category === 'all') || 
                    (button.dataset.category === categoryId.toString())) {
                    button.classList.remove('bg-gray-200', 'text-gray-700');
                    button.classList.add('bg-blue-500', 'text-white');
                } else {
                    button.classList.remove('bg-blue-500', 'text-white');
                    button.classList.add('bg-gray-200', 'text-gray-700');
                }
            });

            document.querySelectorAll('.product-card').forEach(card => {
                if (categoryId === 'all' || card.dataset.category === categoryId.toString()) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Set kategori 'Semua' sebagai aktif saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            filterProducts('all');
        });
    </script>
    @endpush
</x-app-layout> 