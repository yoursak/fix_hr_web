<div>
    <div class="table-responsive hr-attlist">
        <div id="hr-attendance_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-vcenter text-nowrap border-bottom">
                            <thead>
                                <tr role="row" class="border-bottom">
                                    <th class="border-bottom-0 ">S.No.</th>
                                    <th class="border-bottom-0 ">Month</th>
                                    <th class="border-bottom-0 ">Created Date</th>
                                    <th class=" text-center border-bottom-0 ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($submittedData as $key => $item)
                                    <tr class="border-bottom">
                                        <td>{{ ++$key }}.</td>
                                        <td>{{ date('M', strtotime('2023-' . $item->month . '-01')) . '-' . $item->year }}
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($item->created)) }}</td>
                                        <td class="text-center">
                                            @if (in_array('Submit Attendance.Update', $permissions))
                                                <button class="btn btn-primary btn-icon btn-sm"
                                                    id="calenderbtn" data-bs-toggle="tooltip"
                                                    data-original-title="View"
                                                    {{ $item->submited == 1 ? 'disabled' : '' }}
                                                    style="border-radius: 8px">
                                                    <a href="{{ route('submitAttendancePage', [date('Y-m-d', strtotime($item->year . '-' . $item->month . '-01'))]) }}"
                                                        class="<?= $item->submited == 1 ? 'text-muted' : '' ?>"
                                                        onclick="" id="monthEvaluateBtn"
                                                        data-month="{{ $item->month }}"
                                                        data-year="{{ $item->year }}"
                                                        {{ $item->submited == 1 ? 'disabled' : '' }}>
                                                        <i class="feather feather-edit text-light"></i>
                                                    </a>
                                                </button>
                                            @endif
                                            <div class="btn btn-orange btn-icon btn-sm ml-2"
                                                style="border-radius: 8px;" id="calenderbtn"
                                                data-bs-toggle="tooltip" data-original-title="View">
                                                <a href="">
                                                    <i class="feather feather-download text-light"></i>
                                                </a>
                                            </div>
                                            @if (in_array('Submit Attendance.Update', $permissions))
                                                <div class="btn btn-sm" id=""
                                                    data-bs-toggle="tooltip" data-original-title="View">
                                                    <a data-bs-toggle="dropdown"
                                                        style="border-radius: 8px;"
                                                        class="option-dots border">
                                                        <span
                                                            class="feather feather-more-vertical"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-start">
                                                        <li>
                                                            <a
                                                                href="{{ route('defreezeAttendance', $item->id) }}">De-Freeze</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">View</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
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
                            {!! $submittedData->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
