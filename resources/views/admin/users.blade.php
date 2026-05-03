<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50" x-data="{ openAdd: false, openEdit: false, currentUser: { id: '', name: '', email: '', role: '' } }">
    <div class="flex">
        <x-sidebar-admin />
        <main class="flex-1 p-10">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-black text-gray-900">Manajemen User</h1>
                <button @click="openAdd = true" class="bg-rose-500 text-white px-5 py-2.5 rounded-2xl font-bold text-sm shadow-lg shadow-rose-100">+ User Baru</button>
            </div>

            <div class="bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-sm">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">User Info</th>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest">Role</th>
                            <th class="px-8 py-5 text-xs font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-900">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-900">{{ $user->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $user->email }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-[10px] px-3 py-1 rounded-full font-black uppercase {{ $user->role === 'admin' ? 'bg-rose-50 text-rose-600' : 'bg-sky-50 text-sky-600' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex justify-end gap-2">
                                    <button @click="currentUser = { id: '{{ $user->id }}', name: '{{ addslashes($user->name) }}', email: '{{ $user->email }}', role: '{{ $user->role }}' }; openEdit = true" 
                                            class="p-2 bg-sky-50 text-sky-600 rounded-xl hover:bg-sky-500 hover:text-white transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-red-500 hover:text-white transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div x-show="openAdd" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-cloak>
        <div @click.away="openAdd = false" class="bg-white w-full max-w-md p-8 rounded-[2.5rem] shadow-2xl">
            <h2 class="text-2xl font-black mb-6 italic text-gray-900">User Baru</h2>
            <form action="{{ route('admin.users.create') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Nama" required class="w-full bg-gray-50 px-5 py-4 rounded-2xl border-none focus:ring-2 focus:ring-rose-500">
                <input type="email" name="email" placeholder="Email" required class="w-full bg-gray-50 px-5 py-4 rounded-2xl border-none focus:ring-2 focus:ring-rose-500">
                <input type="password" name="password" placeholder="Password" required class="w-full bg-gray-50 px-5 py-4 rounded-2xl border-none focus:ring-2 focus:ring-rose-500">
                <select name="role" class="w-full bg-gray-50 px-5 py-4 rounded-2xl border-none focus:ring-2 focus:ring-rose-500">
                    <option value="fundraiser">Fundraiser</option>
                    <option value="admin">Admin</option>
                </select>
                <div class="flex gap-3 pt-6">
                    <button type="submit" class="flex-1 bg-rose-500 text-white py-4 rounded-2xl font-black">Simpan</button>
                    <button type="button" @click="openAdd = false" class="flex-1 bg-gray-100 text-gray-500 py-4 rounded-2xl font-black">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" x-cloak>
        <div @click.away="openEdit = false" class="bg-white w-full max-w-md p-8 rounded-[2.5rem] shadow-2xl">
            <h2 class="text-2xl font-black mb-2 italic text-gray-900">Ubah Profil</h2>
            <p class="text-xs text-gray-400 mb-6">Role: <span class="font-bold text-rose-500 uppercase" x-text="currentUser.role"></span></p>
            
            <form :action="'/admin/users/' + currentUser.id" method="POST" class="space-y-4">
                @csrf @method('PUT')
                
                <label class="block text-[10px] font-black text-gray-400 uppercase ml-2">Nama Lengkap</label>
                <input type="text" name="name" x-model="currentUser.name" required class="w-full bg-gray-50 px-5 py-4 rounded-2xl border-none focus:ring-2 focus:ring-rose-500 font-bold">
                
                <label class="block text-[10px] font-black text-gray-400 uppercase ml-2">Alamat Email</label>
                <input type="email" name="email" x-model="currentUser.email" required class="w-full bg-gray-50 px-5 py-4 rounded-2xl border-none focus:ring-2 focus:ring-rose-500 font-bold">
                
                <label class="block text-[10px] font-black text-gray-400 uppercase ml-2">Password Baru (Kosongkan jika tetap)</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full bg-gray-50 px-5 py-4 rounded-2xl border-none focus:ring-2 focus:ring-rose-500">
                
                <div class="flex gap-3 pt-6">
                    <button type="submit" class="flex-1 bg-rose-500 text-white py-4 rounded-2xl font-black">Update Data</button>
                    <button type="button" @click="openEdit = false" class="flex-1 bg-gray-100 text-gray-500 py-4 rounded-2xl font-black">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <style>[x-cloak] { display: none !important; }</style>
</body>
</html>