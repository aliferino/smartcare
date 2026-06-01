<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-blue-600">
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Name</th>
                <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 font-medium">
            @forelse($categories as $category)
            <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-4 text-sm font-black text-slate-900 uppercase tracking-tight">{{ $category->name }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}')" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-yellow-400 rounded-lg transition-all duration-200">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button onclick="deleteCategory({{ $category->id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="px-6 py-10 text-center text-slate-500 text-[10px] uppercase font-bold italic tracking-widest">
                    No Categories Found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $categories->links() }}
