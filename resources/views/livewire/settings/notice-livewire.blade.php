<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  border-0">
                    <h4 class="card-title">Notice Summary</h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-end">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">From</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="date" class="form-control " wire:model="toDateFilter"
                                        placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">To</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="feather feather-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="date" class="form-control " wire:model="fromDateFilter"
                                        placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <div class="form-group">
                                <div class="form-group mb-3">
                                    <input type="text" wire:model="searchFilter" placeholder="Search"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table  table-vcenter text-nowrap border-bottom-3  " id="hr-notice">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 w-5">S.No</th>
                                    <th class="border-bottom-0">Title</th>
                                    <th class="border-bottom-0">Description</th>
                                    <th class="border-bottom-0">Date</th>
                                    <th class="border-bottom-0"></th>
                                    <th class="border-bottom-0 text-center">Uploaded Files</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($Notice ?? false)
                                    @foreach ($Notice as $key => $notice)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $notice->title }}</td>
                                            <td>{{ $notice->description }}</td>
                                            <td>{{ \Carbon\Carbon::parse($notice->date)->format('d-m-Y') }}</td>
                                            <td><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($notice->updated_at))}}</span></td>
                                            <td class="text-center"><a
                                                    href="{{ url('notice_uploads/' . $notice->file) }}"><span
                                                        class="text-primary">View file</span></a></td>
                                            <td>
                                                @if (in_array('Notice Board.Delete', $permissions))
                                                    <div class="d-flex">
                                                        <a type="" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deletenoticemodal{{ $notice->id }}"
                                                            title="Delete"><i
                                                                class="feather feather-trash-2 text-kight"></i></a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="deletenoticemodal{{ $notice->id }}"
                                            data-bs-backdrop="static">
                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirmation</h5>
                                                        <button class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('delete.notice', [$notice->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-body text-center">
                                                            <h4 class="mt-5">Are You Sure Want to Delete
                                                                {{ $notice->title }} ?
                                                            </h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="#" type="reset" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</a>
                                                            <button type="submit"
                                                                class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center">No Data Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="perPage">Per Page:</label>

                            <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                                <div class="input-group">
                                    <select wire:model.debounce.350ms="perPage" class="form-control"
                                        x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i x-show="isOpen" class="fa fa-caret-up"></i>
                                            <i x-show="!isOpen" class="fa fa-caret-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>

                            {!! $Notice->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
