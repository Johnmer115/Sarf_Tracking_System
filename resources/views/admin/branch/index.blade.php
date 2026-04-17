@extends('admin.layout')

@section('title', 'Branch Management | SARF Tracking') 
@section('page-title', 'Branch Management') 

@section('content')
    <section class="panel" style="padding: 25px;">
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title"><i class="fas fa-users"></i> Branches List</div>
                    <div class="panel-controls">
                        <div class="search-wrap">
                            <i class="fas fa-search"></i>
                            <input class="search-input" type="text" placeholder="Search...">
                        </div>
                        <button class="btn btn-filter"><i class="fas fa-filter"></i> Filter</button>
                        <a href="{{ route('admin.branch.create') }}" class="btn btn-add"><i class="fas fa-plus"></i> Add Branch</a>
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
                                <th>Branch Name</th>
                                <th>Location</th>
                                <th>Created</th>
                                <th style="text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td>
                                        <span class="row-id">
                                            {{ $branch->code ?? '#' . str_pad($branch->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="td-name">{{ $branch->name }}</div>
                                    </td>
                                    <td class="td-muted">{{ $branch->location ?? '-' }}</td>
                                    <td class="td-muted">{{ $branch->created_at?->format('m/d/Y') ?? 'N/A' }}</td>
                                    <td>
                                        <div class="action-cell">
                                          
                                            <!-- EDIT -->
                                            <a href="{{ route('admin.branch.edit', $branch->id) }}" 
                                            class="abtn abtn-edit" 
                                            title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- DELETE -->
                                            <form action="{{ route('admin.branch.destroy', $branch->id) }}" 
                                                method="POST" 
                                                style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this Branch?');">
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
                        <span class="footer-info">Showing {{ $branches->firstItem() ?? 0 }}-{{ $branches->lastItem() ?? 0 }} of {{ $branches->total() }} entries</span>
                        <div class="show-wrap">
                            Show
                            <select><option>10</option><option>25</option><option>50</option></select>
                            entries
                        </div>
                    </div>
                    <div class="pagi">
                        @if($branches->onFirstPage())
                            <span class="pbtn pd">&#8249; Previous</span>
                        @else
                            <a class="pbtn" href="{{ $branches->previousPageUrl() }}">&#8249; Previous</a>
                        @endif
 
                        @foreach($branches->getUrlRange(1, $branches->lastPage()) as $page => $url)
                            @if($page == $branches->currentPage())
                                <span class="pbtn pa">{{ $page }}</span>
                            @else
                                <a class="pbtn" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
 
                        @if($branches->hasMorePages())
                            <a class="pbtn" href="{{ $branches->nextPageUrl() }}">Next &#8250;</a>
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
