<x-admin-layout>
    <div class="flex">
        <div class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-semibold">Kategori Produk</h2>
                            <button onclick="openModal()" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-150">
                                Tambah Kategori
                            </button>
                        </div>
                        <!-- Kategori Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th> --}}
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Kategori
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah Produk
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($categories as $category)
                                        <tr>
                                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                #{{ $category->id }}
                                            </td> --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $category->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $category->products_count }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <button onclick="editCategory('{{ $category->id }}', '{{ $category->name }}')"
                                                            class="text-blue-600 hover:text-blue-900">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                          method="POST" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                Belum ada kategori
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Kategori -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">
                    Tambah Kategori
                </h3>
                <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}" class="mt-4">
                    @csrf
                    <div id="methodField"></div>
                    <div class="mt-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nama Kategori
                        </label>
                        <input type="text" name="name" id="categoryName"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="mt-2">
                        <label for="slug" class="block text-sm font-medium text-gray-700">
                            Slug
                        </label>
                        <input type="text" name="slug" id="categorySlug"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="flex justify-end mt-4 gap-2">
                        <button type="button" 
                                onclick="closeModal()"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Kategori';
            document.getElementById('categoryForm').action = "{{ route('admin.categories.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('categoryName').value = '';
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function editCategory(id, name) {
            document.getElementById('modalTitle').textContent = 'Edit Kategori';
            document.getElementById('categoryForm').action = `/admin/categories/${id}`;
            document.getElementById('methodField').innerHTML = '@method("PUT")';
            document.getElementById('categoryName').value = name;
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('categoryModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
    @endpush
</x-admin-layout> 