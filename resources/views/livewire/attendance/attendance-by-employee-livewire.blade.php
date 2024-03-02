<div>
    @php
        $Days = 0;
        $root = new App\Helpers\Central_unit();
        $ruleManagement = new App\Helpers\MasterRulesManagement\RulesManagement();
    @endphp
    <div class="page-header d-xl-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Attendance By <span
                    class="text-primary">{{ $empDetails->emp_name . ' ' . $empDetails->emp_mname . ' ' . $empDetails->emp_lname }}({{ $empDetails->emp_id }})</span>
            </div>
        </div>
        <input type="text" id="currentDayGet" value="{{ date('Y-m') }}" hidden>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="row">
                    <div class="form-group">
                        <div class="form-group mb-3">
                            <input type="month" class="form-control" wire:model="monthFilter"
                                value="{{ now()->format('Y-m') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:attendance.attendance-modal-livewire />
    <div class="row">
        <div class="col-xl-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="row mb-0 pb-0">
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5 ">
                                    <span class="avatar avatar-md bradius fs-20 present-status-badge"
                                        id="getPresentCount">{{ $monthlyCount['present'] }}</span>
                                    <h5 class="mb-0 mt-3">Present Days</h5>
                                    {{-- @dd(); --}}
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 absent-status-badge"
                                        id="getAbsentCount">{{ $monthlyCount['absent'] }}</span>
                                    <h5 class="mb-0 mt-3">Absent Days</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 halfday-status-badge"
                                        id="getHalfDayCount">{{ $monthlyCount['halfday'] }}</span>
                                    <h5 class="mb-0 mt-3">Half Days</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 holiday-status-badge"
                                        id="getHolidayCount">{{ $monthlyCount['holiday'] }}</span>
                                    <h5 class="mb-0 mt-3">Holidays</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5 ">
                                    <span class="avatar avatar-md bradius fs-20 late-status-badge"
                                        id="getLateCount">{{ $monthlyCount['late'] }}</span>
                                    <h5 class="mb-0 mt-3">Late Days</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 bg-danger-transparent"
                                        id="getEarlyCount">{{ $monthlyCount['early'] }}</span>
                                    <h5 class="mb-0 mt-3">Early Exit</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 mispunch-status-badge"
                                        id="getMisPunchCount">{{ $monthlyCount['mispunch'] }}</span>
                                    <h5 class="mb-0 mt-3">Mis-punch</h5>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6 text-center py-5">
                                    <span class="avatar avatar-md bradius fs-20 leave-status-badge"
                                        id="getLeaveRemainCount">{{ $monthlyCount['leave'] }}</span>
                                    <h5 class="mb-0 mt-3">Leave</h5>
                                </div>
                            </div>
                        </div>
                        <input type="text" id="empJoiningMY"
                            value="{{ date('m-Y', strtotime($empDetails->emp_date_of_joining)) }}" hidden>
                        <div class="col-xl-4">
                            <div class="">
                                <h4 class="my-5">Statistics</h4>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <div class="d-flex justify-content-between">
                                    <h6>This Month</h6>
                                    <h6><b><span
                                                id="getcwhCount">{{ number_format($byAttendanceCalculation[1]) }}</span>
                                            hr / <span
                                                id="gettwhCount">{{ number_format($byAttendanceCalculation[0]) }}</span>
                                            hr</b></h6>
                                </div>
                                <div class="progress progress-md mb-3" style="border-radius:0px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="progress1"
                                        style="width: {{ number_format($byAttendanceCalculation[2]) }}%; border-radius:0px; background-color:#1877f2">
                                        {{ number_format($byAttendanceCalculation[2], 1) }}%</div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6>Remaining</h6>
                                    <h6><b><span
                                                id="getrwhCount">{{ number_format($byAttendanceCalculation[6]) }}</span>
                                            hr /<span
                                                id="gettrwhCount">{{ number_format($byAttendanceCalculation[0]) }}</span>
                                            hr</b></h6>
                                </div>
                                <div class="progress progress-md mb-3" style="border-radius:0px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="progress2"
                                        style="width: {{ $byAttendanceCalculation[7] }}%;border-radius:0px;background-color:#A52A2A">
                                        {{ number_format($byAttendanceCalculation[7], 1) }}%</div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6>Overtime</h6>
                                    <h6><b><span
                                                id="getotwhCount">{{ number_format($byAttendanceCalculation[4]) }}</span>
                                            hr/<span
                                                id="gettotwhCount">{{ number_format($byAttendanceCalculation[3]) }}</span>
                                            hr</b></h6>
                                </div>
                                <div class="progress progress-md" style="border-radius:0px">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-green"
                                        id="progress3"
                                        style="width: {{ $byAttendanceCalculation[5] }}%;border-radius:0px">
                                        {{ number_format($byAttendanceCalculation[5], 1) }}%
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="table-responsive">
                        <table class="table table-vcenter text-center border-bottum">
                            {{-- //id="basic-datatable" --}}
                            <thead>
                                <tr>
                                    <th class="border-bottom-0 text-center">Date</th>
                                    <th class="border-bottom-0 text-center">Day</th>
                                    <th class="border-bottom-0 text-center">Status</th>
                                    <th class="border-bottom-0 text-center">Punch In</th>
                                    <th class="border-bottom-0 text-center">Punch Out</th>
                                    <th class="border-bottom-0 text-center">Working Hour</th>
                                    <th class="border-bottom-0 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($AllDatas as $item)
                                    @php
                                        $TimeLog = $root->getTimeLog($empDetails->emp_id, $item['Date']);
                                    @endphp
                                    <tr>
                                        <td>{{ date('d-M-Y', strtotime($item['Date'])) }}</td>
                                        <td>{{ date('d-M-Y', strtotime($item['Date'])) }}</td>
                                        <td>{{ date('l', strtotime($item['Date'])) }}</td>
                                        <td>
                                            @php
                                                $load = implode(
                                                    ', ',
                                                    $TimeLog
                                                        ->map(function ($log) {
                                                            return $log->changer_name . '(' . $log->changer_role . ')';
                                                        })
                                                        ->toArray(),
                                                );
                                                $loadArray = explode(', ', $load);
                                                $CorrectedBy = end($loadArray);
                                            @endphp
                                            <span class="{{ $item['StatusColor'] }}">{{ $item['Event'] }}</span>
                                        </td>
                                        <td>{{ $item['PunchIn'] }}
                                            @if ($item['Late'] > 0)
                                                <br><span class="late-status fs-10 fw-bolder">
                                                    {{ $item['Late'] > 0 ? 'Late By: ' . (intval($item['Late'] / 60) ? intval($item['Late'] / 60) . ' Hr ' : '') . (intval($item['Late'] % 60) ? intval($item['Late'] % 60) . ' Min' : '') : '' }}
                                                </span>
                                            @endif
                                            <small
                                                class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                data-bs-trigger="hover" style="background-color:transparent;"
                                                data-bs-container="body"
                                                data-bs-content="{{ count($TimeLog) != 0? implode(' ',$TimeLog->map(function ($log) {return 'From ' . ($log->prev_in_time ?? '---') . ' to ' . ($log->changed_in_time ?? '---') . '<br/> By ' . '<b>' . $log->changer_name . ' </b>' . '(' . $log->changer_role . ')' . '<br> Created at ' . date('d-M-Y', strtotime($log->change_date)) . '<br><b>' . $log->reason . '</b><br/><hr/>';})->toArray()): '' }}."
                                                data-bs-placement="right" data-bs-popover-color="primary"
                                                data-bs-toggle="popover" data-bs-html="true" title=""
                                                data-bs-original-title="Attendance Log">
                                                <i class="fa fa-info-circle"></i>
                                            </small>

                                        </td>
                                        <td>{{ $item['PunchOut'] }}
                                            @if ($item['Early'] > 0)
                                                <br><span class="late-status fs-10 fw-bolder">
                                                    {{ $item['Early'] > 0 ? 'Early Exit By: ' . (intval($item['Early'] / 60) ? intval($item['Early'] / 60) . ' Hr ' : '') . (intval($item['Early'] % 60) ? intval($item['Early'] % 60) . ' Min' : '') : '' }}
                                                </span>
                                            @endif

                                            <small
                                                class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                data-bs-trigger="hover" style="background-color:transparent;"
                                                data-bs-container="body"
                                                data-bs-content="{{ count($TimeLog) != 0? implode(' ',$TimeLog->map(function ($log) {return 'From ' . ($log->prev_out_time ?? '---') . ' to ' . ($log->changed_out_time ?? '---') . '<br/> By ' . '<b>' . $log->changer_name . ' </b>' . '(' . $log->changer_role . ')' . '<br> Created at ' . date('d-M-Y', strtotime($log->change_date)) . '<br><b>' . $log->reason . '</b><br/><hr/>';})->toArray()): '' }}."
                                                data-bs-placement="right" data-bs-popover-color="primary"
                                                data-bs-toggle="popover" data-bs-html="true" title=""
                                                data-bs-original-title="Attendance Log">
                                                <i class="fa fa-info-circle"></i>
                                            </small>
                                        </td>
                                        <td>{{ $item['TotalWorking'] ?? '--' }}
                                            @if ($item['Overtime'])
                                                <br><span class="overtime-status fs-10 fw-bolder">
                                                    {{ $item['Overtime'] > 0 ? 'OT: ' . (intval($item['Overtime'] / 60) ? intval($item['Overtime'] / 60) . ' Hr ' : '') . (intval($item['Overtime'] % 60) ? intval($item['Overtime'] % 60) . ' Min' : '') : '' }}
                                                </span>
                                            @endif

                                            <small
                                                class="badge badge-info-light {{ count($TimeLog) != 0 ? '' : 'd-none' }}"
                                                data-bs-trigger="hover" style="background-color:transparent;"
                                                data-bs-container="body"
                                                data-bs-content="{{ count($TimeLog) != 0? implode(' ',$TimeLog->map(function ($log) {return 'From ' . ($log->prev_total_work ?? '---') . ' Hrs. to ' . ($log->changed_total_work ?? '---') . ' Hrs. <br/> By ' . '<b>' . $log->changer_name . '</b>' . ' (' . $log->changer_role . ')' . '<br> Created at ' . date('d-M-Y', strtotime($log->change_date)) . '<br><b>' . $log->reason . '</b><br/><hr/>';})->toArray()): '' }}."
                                                data-bs-placement="right" data-bs-popover-color="primary"
                                                data-bs-toggle="popover" data-bs-html="true" title=""
                                                data-bs-original-title="Attendance Log">
                                                <i class="fa fa-info-circle"></i>
                                            </small>
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <?php $sendData = [$item['PunchIn'], $item['PunchOut'], $item['TotalWorking'], $item['InAddress'], $item['OutAddress'], $item['ShiftName'], $item['Break'], $item['Overtime'], $item['InSelfie'], $item['OutSelfie'], $CorrectedBy, $item['Date'], $item['ShiftStart'], $item['ShiftEnd'], $empDetails->emp_id, $item['Status'], $item['Event'],$item['EventType'],$item['HolidayType']]; ?>
                                            @if (in_array('Attendance Summary.All', $permissions) || in_array('Attendance Summary.Update', $permissions))
                                                <button class="btn btn-light btn-icon btn-sm m-1"
                                                    data-bs-toggle="modal" data-bs-target="#CorrectionModal"
                                                    wire:click="showPresentModel('<?php echo htmlentities(json_encode($sendData)); ?>')">
                                                    <i class="feather feather-edit" data-bs-toggle="tooltip"
                                                        data-original-title="View"></i>
                                                </button>
                                            @endif
                                            <a type="button" class="btn btn-light btn-icon btn-sm m-1"
                                                data-bs-toggle="modal" data-bs-target="#{{ in_array($item['Status'],[1,3,4,8,9,12]) ? 'livewire-present-modal' : ( in_array($item['Status'],[6,7,10,11]) ? 'holidayModal' : 'absentModal')}}"
                                                wire:click="showPresentModel('<?php echo htmlentities(json_encode($sendData)); ?>')">
                                                <i class="feather feather-eye" data-bs-toggle="tooltip"
                                                    data-original-title="View"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <div>
                                <label for="perPage">Per Page:</label>

                                <div class="form-group mb-3" x-data="{ isOpen: false }"
                                    x-on:click.away="isOpen = false">
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

                                {!! $AllDatas->links() !!}
                            </div>
                        </div>

                    </div>
                </div>
                {{-- @foreach ($AllDatas as $item1) --}}
                {{-- <livewire:attendance.attendance-modal-livewire :id="$empDetails->emp_id . $item1['Date']" :in="$item1['PunchIn']" :out="$item1['PunchOut']"
                        :twh="$item1['TotalWorking']" :inloc="$item1['InAddress']" :outloc="$item1['OutAddress']" :shiftname="$item1['ShiftStart']" :breakmin="$item1['Break']"
                        :overtime="$item1['Overtime']" :inselfie="$item1['InSelfie']" :outselfie="$item1['OutSelfie']" :corrected_by="$CorrectedBy" :date="$item1['Date']"
                        :shiftstart="$item1['ShiftStart']" :shiftend="$item1['ShiftEnd']" :emp_id="$empDetails->emp_id" :status="$item1['Status']"
                        :leavename="$item1['Event']" /> --}}
                {{-- @endforeach --}}
            </div>
        </div>
    </div>
</div>
