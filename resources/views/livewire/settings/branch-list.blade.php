<div>
    <div class="row justify-content-end">
        <div class="col-md-3">
            <div class="form-group">
                <div class="form-group mb-3">
                    <input type="text" wire:model="searchFilter" placeholder="Search" class="form-control" />
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table  table-vcenter text-nowrap  border-bottom ">
            <thead>
                <tr>
                    <th class="border-bottom-0">S. No.</th>
                    <th class="border-bottom-0">Branch Name</th>
                    <th class="border-bottom-0">Branch Email</th>
                    <th class="border-bottom-0"></th>
                    <th class="border-bottom-0">Action</th>
                </tr>
            </thead>
            <tbody>
                @php

                $count = 1;
                @endphp
                @foreach ($branch as $item)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $item->branch_name }}</td>
                    <td>{{ $item->branch_email }}</td>
                    <td><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($item->updated_at))}}</span></td>

                    <td>
                        <div class="d-flex">

                            @if (in_array('Branch Settings.Update', $permissions))
                            <a class="btn action-btns  btn-sm btn-primary" data-bs-target="#editBranchName" onclick="openEditDesignation(this)" data-id='<?= $item->id ?>' data-branch_name='<?= $item->branch_name ?>' data-branch_email='<?= $item->branch_email ?>' data-address='<?= $item->address ?>' data-logitude='<?= $item->logitude ?>' data-latitude='<?= $item->latitude ?>' data-bs-toggle="modal" href="#">
                                <i class='feather feather-edit'></i></a>
                            @endif
                            @if (in_array('Branch Settings.Delete', $permissions))
                            <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal" onclick="ItemDeleteModel(this)" data-branch_id='<?= $item->branch_id ?>' data-branch_name='<?= $item->branch_name ?>' data-bs-target="#branchDeletebtn" id="BranchEditbtn" title="Edit">
                                <i class="feather feather-trash "></i>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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

                {!! $branch->links() !!}
            </div>
        </div>
    </div>
</div>
