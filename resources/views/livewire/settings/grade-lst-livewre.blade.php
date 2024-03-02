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
            <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                <thead>
                    <tr>
                        <th class="border-bottom-0 w-10">S.No.</th>
                        <th class="border-bottom-0 text-center">Grade Name</th>
                        <th class="border-bottom-0 text-center"></th>
                        <th class="border-bottom-0 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $items)
                        <tr>
                            <td class="font-weight-semibold">{{ ++$key }}</td>
                            <td class="font-weight-semibold text-center">{{ $items->grade_name }}</td>
                            <td class="font-weight-semibold text-center"><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($items->updated_at))}}</span></td>
                            <td class="d-flex justify-content-center">

                                <a class="btn action-btns btn-sm btn-primary" data-bs-target="#modaldemo1"
                                    onclick="openGradeEditBtn(this)" data-id='<?= $items->id ?>'
                                    data-grade_name='<?= $items->grade_name ?>' data-bs-toggle="modal"
                                    href="#">
                                    <i class='feather feather-edit'></i>
                                </a>

                                <a class="action-btns btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-grade_name='<?= $items->grade_name ?>' onclick="openDeleteBtn(this)"
                                    data-id='<?= $items->id ?>' data-bs-target="#gradeDeleteBtn"
                                    id="BranchEditbtn">
                                    <i class="feather feather-trash"></i>
                                </a>

                            </td>

                        </tr>
                    @endforeach
                    <?php ?>
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
                {!! $data->links() !!}
            </div>
        </div>
    </div>
</div>
