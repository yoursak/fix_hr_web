<div>
    @php
        $power = new App\Helpers\MasterRulesManagement\RulesManagement();
    @endphp
    <div class="card-body">
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap  border-bottom ">
                <thead>
                    <tr>
                        <th class="border-bottom-0 w-10">S.No.</th>
                        <th class="border-bottom-0">Shift Name</th>
                        <th class="border-bottom-0">Shift Type</th>
                        <th class="border-bottom-0"></th>
                        <th class="border-bottom-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @empty(!$attendaceShift)
                        @php

                            $j = 1;
                        @endphp
                        @foreach ($attendaceShift as $item)
                            <tr>
                                <td class="font-weight-semibold">{{ $j++ }}.</td>
                                <td class="font-weight-semibold">
                                    <?= $item->shift_type_name ?>
                                </td>

                                <td class="font-weight-semibold">
                                    <?php
                                $loadss = DB::table('policy_attendance_shift_type_items')
                                    ->where('attendance_shift_id', $item->id)
                                    ->first();
                                $ShiftHour = (int) ($loadss->shift_hr ?? 0);
                                $ShiftMin = (int) ($loadss->shift_min ?? 0);
                                //   print_r($ShiftMin);

                                //   dd($ShiftMin);
                                if ($power->AttedanceShiftCheckItems($item->id) == 1) {
                                    echo 'Fixed Shift: ' . $power->Convert24To12($loadss->shift_start) . '-' . $power->Convert24To12($loadss->shift_end);
                                }
                                if ($power->AttedanceShiftCheckItems($item->id) == 2) {
                                    echo 'Rotational Shift: ';
                                    foreach (DB::table('policy_attendance_shift_type_items')->where('attendance_shift_id', $item->id)->where('business_id', Session::get('business_id'))->get() as $value) { ?>
                                    <?= '' . $power->Convert24To12($value->shift_start) . '-' .
                                    $power->Convert24To12($value->shift_end) ?> @if (!$loop->last)
                                        ||
                                    @endif
                                    <?php }
                                }
                                if ($power->AttedanceShiftCheckItems($item->id) == 3) {
                                    echo 'Open Shift Total Work: ' . str_pad($ShiftHour, 2, '0', STR_PAD_LEFT) . ' Hour ' . str_pad($ShiftMin, 2, '0', STR_PAD_LEFT)  . ' Min';
                                }
                                ?>
                                </td>
                                <td><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($item->updated_at))}}</span></td>
                                <td>
                                    @if (in_array('Shift Settings.All', $permissions) || in_array('Shift Settings.Update', $permissions))
                                        @if ($item->shift_type == 1)
                                            {{-- @dd($item->shift_weekly_repeat); --}}
                                            <a class="btn action-btns  btn-primary btn-icon btn-sm"
                                                href="javascript:void(0);"
                                                onclick="openEditFixedShiftModel(this)"
                                                data-id='<?= $item->id ?>'
                                                data-shift_name='<?= $item->shift_type_name ?>'
                                                data-shift_type='<?= $power->AttedanceShiftCheckItems($item->id) ?>'
                                                data-shift_start='<?= $loadss->shift_start ?>'
                                                data-shift_end='<?= $loadss->shift_end ?>'
                                                data-break_min='<?= $loadss->break_min ?>'
                                                data-is_paid='<?= (int) $loadss->is_paid ?? 0 ?>'
                                                data-work_hr='<?= $loadss->work_hr ?>'
                                                data-work_min='<?= $loadss->work_min ?>' data-bs-toggle="modal"
                                                data-bs-target="#fixiedshift">
                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                    data-original-title="View/Edit"></i>
                                            </a>
                                        @endif

                                        @if ($item->shift_type == 2)
                                            <a class="btn action-btns  btn-primary btn-icon btn-sm"
                                                href="javascript:void(0);"
                                                onclick="openEditRotationalModel(this)"
                                                data-id='<?= $item->id ?>'
                                                data-shift_name='<?= $item->shift_type_name ?>'
                                                data-shift_type='<?= $power->AttedanceShiftCheckItems($item->id) ?>'
                                                data-shift_start='<?= $loadss->shift_start ?? 0 ?>'
                                                data-shift_end='<?= $loadss->shift_end ?? 0 ?>'
                                                data-break_min='<?= $loadss->break_min ?? 0 ?>'
                                                data-is_paid='<?= $loadss->is_paid ?? 0 ?>'
                                                data-work_hr='<?= $loadss->work_hr ?? 0 ?>'
                                                data-work_min='<?= $loadss->work_min ?? 0 ?>'
                                                data-bs-toggle="modal"
                                                data-bs-target="#openEditRotationalModel">
                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                    data-original-title="View/Edit"></i>
                                            </a>
                                        @endif

                                        @if ($item->shift_type == 3)
                                            <a class="btn action-btns  btn-primary btn-icon btn-sm"
                                                href="javascript:void(0);"
                                                onclick="openEditOpenShiftModel(this)"
                                                data-id='<?= $item->id ?>'
                                                data-shift_name='<?= $item->shift_type_name ?? 0 ?>'
                                                data-shift_type='<?= $power->AttedanceShiftCheckItems($item->id) ?>'
                                                data-shift_hour='<?= $ShiftHour ?>'
                                                data-shift_min='<?= $ShiftMin ?>'
                                                data-break_min='<?= $loadss->break_min ?? 0 ?>'
                                                data-is_paid='<?= $loadss->is_paid ?? 0 ?>'
                                                data-work_hr='<?= $loadss->work_hr ?? 0 ?>'
                                                data-work_min='<?= $loadss->work_min ?? 0 ?>'
                                                data-bs-toggle="modal" data-bs-target="#openshiftModel">
                                                <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                    data-original-title="View/Edit"></i>
                                            </a>
                                        @endif
                                    @endif
                                    @if (in_array('Shift Settings.All', $permissions) || in_array('Shift Settings.Delete', $permissions))
                                        <a class="btn action-btns  btn-danger btn-icon btn-sm"
                                            href="javascript:void(0);"
                                            data-shift_type='<?= $power->AttedanceShiftCheckItems($item->id) ?>'
                                            onclick="DeleteModel(this)" data-bs-toggle="modal"
                                            data-id='<?= $item->id ?>'
                                            data-shift_type_name='<?= $item->shift_type_name ?>'
                                            data-bs-target="#deleteModal">
                                            <i class="feather feather-trash" data-bs-toggle="tooltip"
                                                data-original-title="View/Edit"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endempty
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

                {!! $attendaceShift->links() !!}
            </div>
        </div>
    </div>
</div>
