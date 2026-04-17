@extends('admin.layout')

@section('title', 'Account Management | SARF Tracking') 
@section('page-title', 'Account Management') 

@section('content')
    <section class="panel" style="padding: 25px;">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title"><i class="fas fa-users"></i> Accounts List</div>
                    <div class="panel-controls">
                        <div class="search-wrap">
                            <i class="fas fa-search"></i>
                            <input class="search-input" type="text" placeholder="Search...">
                        </div>
                        <select class="filter-select">
                            <option>All Types</option>
                            <option>Admin</option>
                            <option>User</option>
                        </select>
                        <button class="btn btn-filter"><i class="fas fa-filter"></i> Filter</button>
                        <a href="{{ route('admin.account.create') }}" class="btn btn-add"><i class="fas fa-plus"></i> Add Account</a>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <b>{{ $message }}</b>
                    </div>
                @endif
                
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                 <th>Usertype</th>
                                <th>Organization</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th style="text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accounts as $account)
                                <tr>
                                    <td><span class="row-id">#{{ str_pad($account->id, 3, '0', STR_PAD_LEFT) }}</span></td>
                                    <td>
                                        <div class="td-name">{{ $account->username }}</div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $account->usertype === 'admin' ? 'b-admin' : 'b-user' }}">
                                            {{ ucfirst($account->usertype) }}
                                        </span>
                                    </td>
                                    <td class="td-muted">{{ $account->organization ?? '-' }}</td>
                                    <td class="td-muted">
                                        <span class="badge {{ $account->status === 'active' ? 'b-active' : 'b-inactive' }}">
                                            {{ ucfirst($account->status) }}
                                        </span>
                                    </td>
                                    <td class="td-muted">{{ $account->created_at?->format('m/d/Y') ?? 'N/A' }}</td>
                                    <td>
                                        <div class="action-cell">

                                            <!-- VIEW -->
                                            <a href="{{ route('admin.account.show', $account->id) }}" 
                                            class="abtn abtn-view" 
                                            title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- EDIT -->
                                            <a href="{{ route('admin.account.edit', $account->id) }}" 
                                            class="abtn abtn-edit" 
                                            title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- DELETE -->
                                            <form action="{{ route('admin.account.destroy', $account->id) }}" 
                                                method="POST" 
                                                style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this account?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="abtn abtn-del" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="td-muted">No accounts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
 
                <div class="panel-footer">
                    <div class="footer-left">
                        <span class="footer-info">Showing {{ $accounts->firstItem() ?? 0 }}-{{ $accounts->lastItem() ?? 0 }} of {{ $accounts->total() }} entries</span>
                        <div class="show-wrap">
                            Show
                            <select><option>10</option><option>25</option><option>50</option></select>
                            entries
                        </div>
                    </div>
                    <div class="pagi">
                        @if($accounts->onFirstPage())
                            <span class="pbtn pd">&#8249; Previous</span>
                        @else
                            <a class="pbtn" href="{{ $accounts->previousPageUrl() }}">&#8249; Previous</a>
                        @endif
 
                        @foreach($accounts->getUrlRange(1, $accounts->lastPage()) as $page => $url)
                            @if($page == $accounts->currentPage())
                                <span class="pbtn pa">{{ $page }}</span>
                            @else
                                <a class="pbtn" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
 
                        @if($accounts->hasMorePages())
                            <a class="pbtn" href="{{ $accounts->nextPageUrl() }}">Next &#8250;</a>
                        @else
                            <span class="pbtn pd">Next &#8250;</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
