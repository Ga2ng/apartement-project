@extends('admin.layout')

@section('title', 'Clients')
@section('heading', 'Clients')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <form action="{{ route('admin.clients.index') }}" method="get" class="flex gap-2 flex-1 max-w-md">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search name, email, phone..." class="flex-1 px-4 py-2 rounded-lg border border-border bg-background text-foreground">
            <button type="submit" class="btn-primary py-2 px-4">Search</button>
        </form>
        <a href="{{ route('admin.clients.create') }}" class="btn-primary shrink-0">
            <i class="fas fa-plus mr-2"></i>Add Client
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-surface border-b border-border">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-xs font-semibold text-muted uppercase tracking-wider w-24">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($clients as $client)
                        <tr class="hover:bg-surface/50">
                            <td class="px-6 py-4">
                                <span class="font-medium text-foreground">{{ $client->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-muted text-sm">
                                @if($client->email) {{ $client->email }}<br> @endif
                                @if($client->phone) {{ $client->phone }} @endif
                            </td>
                            <td class="px-6 py-4 text-muted text-sm">
                                @if($client->id_type) {{ $client->id_type }}: {{ $client->id_number }} @else – @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.clients.edit', $client) }}" class="text-primary hover:underline text-sm">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-muted">No clients yet. <a href="{{ route('admin.clients.create') }}" class="text-primary hover:underline">Add one</a>.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($clients->hasPages())
            <div class="px-6 py-3 border-t border-border">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
@endsection
