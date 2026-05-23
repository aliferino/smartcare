<div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-blue-600">
                    <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">User Info</th>
                    <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500">Role</th>
                    <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-black text-white uppercase tracking-widest border-b border-blue-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 font-medium">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($user->citizen && $user->citizen->profile_picture)
                                <img src="{{ asset('storage/' . $user->citizen->profile_picture) }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-full bg-blue-100 border-2 border-white shadow-sm flex items-center justify-center text-xs font-black text-blue-600 uppercase flex-shrink-0">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $user->name }}</p>
                                <p class="text-[9px] text-blue-600 font-bold lowercase tracking-tighter">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->role === 'admin')
                            <span class="px-2 py-1 rounded bg-purple-50 text-purple-600 text-[10px] font-black uppercase tracking-tighter">
                                {{ $user->role }}
                            </span>
                        @else
                            <span class="px-2 py-1 rounded bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-tighter">
                                {{ $user->role }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="status-row-{{ $user->id }}">
                            @if($user->status === 'active')
                                <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-tighter">Active</span>
                            @elseif($user->status === 'inactive')
                                <span class="px-2 py-1 rounded bg-slate-50 text-slate-600 text-[10px] font-black uppercase tracking-tighter">Inactive</span>
                            @elseif($user->status === 'suspended')
                                <span class="px-2 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-black uppercase tracking-tighter">Suspended</span>
                            @else
                                <span class="px-2 py-1 rounded bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-tighter">Banned</span>
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex gap-2 justify-end">
                            <button class="btn-detail w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-blue-600 rounded-lg transition-all duration-200" data-id="{{ $user->id }}" title="View Details">
                                <i data-lucide="info" class="w-4 h-4"></i>
                            </button>
                            <button class="btn-edit w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-yellow-400 rounded-lg transition-all duration-200" data-id="{{ $user->id }}" title="Edit User">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </button>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200" title="Delete User">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
</div>
