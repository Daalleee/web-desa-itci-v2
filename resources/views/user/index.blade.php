@extends('layouts.admin')

@section('title', 'Daftar Pengguna')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Manajemen Pengguna</h2>
        <a href="{{ route('users.create') }}" class="px-5 py-2.5 bg-green-700 hover:bg-green-600 text-white rounded-xl text-sm font-semibold transition">
            <i class="fa-solid fa-plus"></i> Tambah Pengguna
        </a>
    </div>
    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 bg-red-50 rounded-lg border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-400 text-xs uppercase font-bold">
                        <th class="py-4 px-6">ID</th>
                        <th class="py-4 px-6">Nama</th>
                        <th class="py-4 px-6">Username</th>
                        <th class="py-4 px-6">Email</th>
                        <th class="py-4 px-6">Peran</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6">{{ $user->id }}</td>
                            <td class="py-4 px-6 font-medium text-slate-800">{{ $user->name }}</td>
                            <td class="py-4 px-6">{{ $user->username }}</td>
                            <td class="py-4 px-6">{{ $user->email }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex rounded-lg shadow-sm">
                                    <a href="{{ route('users.edit', $user) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-l-lg border border-slate-200 text-xs font-semibold transition">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-r-lg border-y border-r border-slate-200 text-xs font-semibold transition">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-users-slash text-4xl mb-3"></i>
                                <p class="text-sm">Belum ada pengguna yang terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
