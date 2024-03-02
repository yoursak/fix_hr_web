<div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table  table-vcenter text-nowrap  border-bottom ">
                <thead>
                    <tr>
                        <th class="border-bottom-0 w-10">S.No.</th>
                        <th class="border-bottom-0">Policy Name</th>
                        <th class="border-bottom-0">Week off Type</th>
                        <th class="border-bottom-0">Weekly</th>
                        <th class="border-bottom-0"></th>
                        <th class="border-bottom-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                    @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td class="font-weight-semibold">{{ $j++ }}.</td>
                            <td class="font-weight-semibold">{{ $item->name }}</td>
                            <td class="font-weight-semibold"> {{ $item->week_off_type_name }}</td>

                            <td class="font-weight-semibold">

                                @php
                                    $holidays = json_decode($item->days);

                                @endphp
                                @if (is_array($holidays) || is_object($holidays))
                                    @foreach ($holidays as $holiday)
                                        {{ $holiday }}
                                        @if (!$loop->last)
                                            |
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($item->updated_at))}}</span></td>
                            <td>
                                @php
                                    $masterendgame = 0;
                                @endphp

                                @foreach ($checkMaEnAssOrNot as $checkmaster)
                                    @if ($checkmaster->weekly_policy_ids_list == $item->id)
                                        @php
                                            $masterendgame = 1;
                                            // dd($masterendgame );
                                            break;
                                        @endphp
                                    @endif
                                @endforeach
                            @if (in_array('WeeklyHoliday Settings.Update', $permissions))
                                <button class="btn action-btns  btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                    {{ ($masterendgame == 1) ? 'disabled' : '' }} onclick="openEditModel(this)"
                                    data-id='<?= $item->id ?>' data-bs-toggle="modal"
                                    data-bs-target="#editBranchName">
                                    <i class="feather feather-edit" data-bs-toggle="tooltip"
                                        data-original-title="View/Edit"></i>
                                </button>
                                @endif
                            @if (in_array('WeeklyHoliday Settings.View', $permissions))

                                <button class="btn action-btns  btn-primary btn-icon btn-sm"
                                    href="javascript:void(0);" onclick="openViewModel(this)"
                                    data-id='<?= $item->id ?>' data-bs-toggle="modal"
                                    data-bs-target="#editBranchName">
                                    <i class="feather feather-eye   " data-bs-toggle="tooltip"
                                        data-original-title="View/Edit"></i>
                                </button>
                            @endif
                            @if (in_array('WeeklyHoliday Settings.Delete', $permissions))

                                <a class="btn action-btns  btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                    onclick="ItemDeleteModel(this)" data-id='<?= $item->id ?>'
                                    data-weekly_name='<?= $item->name ?>' data-bs-toggle="modal"
                                    data-bs-target="#editDeleteModel"><i class="feather feather-trash"></i>
                                </a>
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

                {!! $data->links() !!}
            </div>
        </div>
    </div>
</div>
