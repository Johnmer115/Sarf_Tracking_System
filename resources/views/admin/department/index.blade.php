@extends('admin.layout')

@section('title', 'Department Management | SARF Tracking') 
@section('page-title', 'Department Management') 

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
                        <a href="{{ route('admin.department.create') }}" class="btn btn-add"><i class="fas fa-plus"></i> Add Department</a>
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
                                <th>Department Name</th>
                                <th>Department Dean</th>
                                <th>Branch</th>
                                <th>Created</th>
                                <th style="text-align:center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $department)
                                <tr>
                                    <td>
                                        <span class="row-id">
                                            {{ $department->code ?? '#' . str_pad($department->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="td-name">{{ $department->name }}</div>
                                    </td>
                                    <td class="td-muted">{{ $department->dept_dean ?? 'N/A' }}</td>
                                    <td class="td-muted">{{ $department->branch->name ?? '-' }}</td>
                                    <td class="td-muted">{{ $department->created_at?->format('m/d/Y') ?? 'N/A' }}</td>
                                    <td>
                                        <div class="action-cell">

                                             <!-- View -->
                                            <a href="{{ route('admin.department.show', $department->id) }}" 
                                            class="abtn abtn-view" 
                                            title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- EDIT -->
                                            <a href="{{ route('admin.department.edit', $department->id) }}" 
                                            class="abtn abtn-edit" 
                                            title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- DELETE -->
                                            <form action="{{ route('admin.department.destroy', $department->id) }}" 
                                                method="POST" 
                                                style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this Department?');">
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
                                    <td colspan="6" class="td-muted">No departments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
 
                <div class="panel-footer">
                    <div class="footer-left">
                        <span class="footer-info">Showing {{ $departments->firstItem() ?? 0 }}-{{ $departments->lastItem() ?? 0 }} of {{ $departments->total() }} entries</span>
                        <div class="show-wrap">
                            Show
                            <select><option>10</option><option>25</option><option>50</option></select>
                            entries
                        </div>
                    </div>
                    <div class="pagi">
                        @if($departments->onFirstPage())
                            <span class="pbtn pd">&#8249; Previous</span>
                        @else
                            <a class="pbtn" href="{{ $departments->previousPageUrl() }}">&#8249; Previous</a>
                        @endif
 
                        @foreach($departments->getUrlRange(1, $departments->lastPage()) as $page => $url)
                            @if($page == $departments->currentPage())
                                <span class="pbtn pa">{{ $page }}</span>
                            @else
                                <a class="pbtn" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
 
                        @if($departments->hasMorePages())
                            <a class="pbtn" href="{{ $departments->nextPageUrl() }}">Next &#8250;</a>
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
