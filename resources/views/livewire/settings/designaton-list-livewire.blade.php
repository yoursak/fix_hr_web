<div>
    <div class="card-body p-2">
        <div class="row justify-content-end">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="form-group mb-3">
                        <input type="text" wire:model="searchFilter" placeholder="Search"
                            class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap  border-bottom ">
                <thead>
                    <tr>
                        <th class="border-bottom-0 w-10">S.No.</th>
                        <th class="border-bottom-0">Designation Name</th>
                        <th class="border-bottom-0"></th>
                        <th class="border-bottom-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Designation as $key => $item)

                        <tr>
                            <td class="font-weight-semibold text-center">{{ ++$key }}.</td>
                            <td class="font-weight-semibold text-center">{{ $item->desig_name }}</td>
                            <td class="font-weight-semibold text-center"><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($item->updated_at))}}</span></td>
                            <td class="d-flex justify-content-center">
                                @if (in_array('Designation Settings.Update', $permissions))
                                    <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#modaldemo1"
                                        onclick="openEditDesignation(this)" data-branch_id='<?= $item->branch_id ?>'
                                        data-id='<?= $item->desig_id ?>' data-depart_id='<?= $item->department_id ?>'
                                        data-desig_name='<?= $item->desig_name ?>' data-bs-toggle="modal"
                                        href="#">
                                        <i class='feather feather-edit'></i></a>
                                @endif
                                @if (in_array('Designation Settings.Delete', $permissions))
                                    <a class="btn action-btns btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#departDeletebtn{{ $item->desig_id }}" id="BranchEditbtn"
                                        title="Edit">
                                        <i class="feather feather-trash"></i>
                                @endif
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        <div class="d-flex justify-content-between">
            <div>
                <label for="perPage">Per Page:</label>

                <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                    <div class="input-group">
                        <select wire:model.debounce.350ms="perPage" class="form-control" x-on:focus="isOpen = true"
                            x-on:blur="isOpen = false">
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

                {!! $Designation->links() !!}
            </div>
        </div>
    </div>
</div>
