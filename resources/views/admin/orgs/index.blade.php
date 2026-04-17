@extends('admin.layout')

@section('title', 'Organization Management | SARF Tracking') 
@section('page-title', 'Organization Management') 

@section('content')
    <section class="panel" style="padding: 25px;">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title"><i class="fas fa-users"></i> Organization List</div>
                    <div class="panel-controls">
                        <div class="search-wrap">
                            <i class="fas fa-search"></i>
                            <input class="search-input" type="text" placeholder="Search...">
                        </div>
                        <button class="btn btn-filter"><i class="fas fa-filter"></i> Filter</button>
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
                                <th>ID Code</th>
                                <th>Organization Name</th>
                                <th>Account Name</th>
                                <th>Department</th>
                                <th>Branch</th>
                                <th>Created</th>
                                <th style="text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($organizations as $organization)
                                <tr>
                                    <td>
                                        <span class="row-id">
                                            {{ $organization->code ?? '#' . str_pad($organization->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="td-name">{{ $organization->name }}</div>
                                    </td>
                                    <td class="td-muted">{{ $organization->account->username ?? 'N/A' }}</td>
                                    <td class="td-muted">{{ $organization->department->name ?? 'N/A' }}</td>
                                    <td class="td-muted">{{ $organization->department->branch->name ?? 'N/A' }}</td>
                                    <td class="td-muted">{{ $organization->created_at?->format('m/d/Y') ?? 'N/A' }}</td>
                                    <td>
                                        <div class="action-cell">

                                             <!-- View -->
                                            <a href="{{ route('admin.orgs.show', $organization->id) }}" 
                                            class="abtn abtn-view" 
                                            title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- EDIT -->
                                            <a href="{{ route('admin.orgs.edit', $organization->id) }}" 
                                            class="abtn abtn-edit" 
                                            title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- DELETE -->
                                            <form action="{{ route('admin.orgs.destroy', $organization->id) }}" 
                                                method="POST" 
                                                style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this Organization?');">
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
                                    <td colspan="6" class="td-muted">No organizations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
 
                <div class="panel-footer">
                    <div class="footer-left">
                        <span class="footer-info">Showing {{ $organizations->firstItem() ?? 0 }}-{{ $organizations->lastItem() ?? 0 }} of {{ $organizations->total() }} entries</span>
                        <div class="show-wrap">
                            Show
                            <select><option>10</option><option>25</option><option>50</option></select>
                            entries
                        </div>
                    </div>
                    <div class="pagi">
                        @if($organizations->onFirstPage())
                            <span class="pbtn pd">&#8249; Previous</span>
                        @else
                            <a class="pbtn" href="{{ $organizations->previousPageUrl() }}">&#8249; Previous</a>
                        @endif
 
                        @foreach($organizations->getUrlRange(1, $organizations->lastPage()) as $page => $url)
                            @if($page == $organizations->currentPage())
                                <span class="pbtn pa">{{ $page }}</span>
                            @else
                                <a class="pbtn" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
 
                        @if($organizations->hasMorePages())
                            <a class="pbtn" href="{{ $organizations->nextPageUrl() }}">Next &#8250;</a>
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
