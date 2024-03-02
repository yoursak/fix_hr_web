<div>
    <div class="modal fade" id="livewire-present-modal" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Details</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card-header border-bottom-0 d-block">
                                <h5 class="">Timesheet: <span
                                        class="fs-14 mx-3 text-muted">{{ $PunchDate }}</span></h5>
                                <h6 class=""><span class="fs-14 text-dark">{{ $ShiftName }}</span>
                                    <span class="fs-14 text-dark">:</span>
                                    <span class="fs-14 mx-3 text-muted">{{ $ShiftStart }}</span>
                                    <span class="fs-14 text-muted">To</span>
                                    <span class="fs-14 mx-3 text-muted">{{ $ShiftEnd }}</span>
                                </h6>
                            </div>

                            <div class="col-sm-12 my-auto" style="height: 260px">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="p-3 text-center border border-muted">
                                            <h6 class="mb-1 fs-14 font-weight-semibold">{{ $InTime }}</h6>
                                            <small class="text-muted fs-14">Punch In</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="chart-circle chart-circle-md" data-value="100" data-thickness="8"
                                            data-color="#0dcd94" style="border:solid 5px #1877f2; border-radius:50px">
                                            <div class="chart-circle-value text-muted">{{ $TotalWork }}</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 text-center border border-muted">
                                            <h6 class="mb-1 fs-14 font-weight-semibold">{{ $OutTime }}</h6>
                                            <small class="text-muted fs-14">Punch Out</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-5">
                                    <div class="row">
                                        <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                            <small class="text-muted fs-13">Break Time</small>
                                            <p class="mb-1 fs-14 font-weight-semibold">{{ $BreakTime }}</p>
                                        </div>
                                        <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                            <small class="text-muted fs-13">Overtime</small>
                                            <p class="mb-1 fs-14 font-weight-semibold" id="modalOverTime">
                                                {{ $Overtime }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="col-sm-12">
                                <div class="">
                                    <h4 class="my-5">Timeline</h4>
                                </div>
                                <div class="col-sm-12 mt-5">
                                    <div class="tl-content tl-content-active">
                                        <div class="tl-header {{ $InTime == '--' ? 'd-none' : '' }}">
                                            <span class="tl-marker"></span>
                                            <div class="row">
                                                <div class="col-10">
                                                    <p class="tl-title">Punch In at {{ $InTime . ' | ' . $ShiftName }}
                                                        <br>
                                                        <span
                                                            class="text-muted fs-12 {{ $InAddress == '' ? 'd-none' : '' }}"><i
                                                                class="fa fa-map-marker mx-1"></i>
                                                            <span>{{ $InAddress }}</span>
                                                        </span>
                                                        <br />
                                                        <span class="tl-title">{{ $CorrectedBy }}</span>
                                                    <p>
                                                </div>
                                                <div class="col-2">
                                                    <button class=" btn my-auto" data-bs-toggle="modal" data-bs-target="#{{$InSelfie != null ? 'punchIn' : 'absentModal' }}">
                                                        <span class="avatar avatar-sm brround"
                                                            style="background-image: url('/upload_image/{{ $InSelfie }}'); border: solid 1px #1877f2;"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tl-header d-none" id="tapList">
                                            <div class="row">
                                                <p>
                                                <div class="col-10" style="overflow: scroll; height:7rem">
                                                    <p class="tl-title" id="TapListItem">

                                                    <p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tl-header {{ $OutTime == '--' ? 'd-none' : '' }}">
                                            <span class="tl-marker"></span>
                                            <div class="row">
                                                <div class="col-10">
                                                    <p class="tl-title">Punch Out at
                                                        {{ $OutTime . ' | ' . $ShiftName }}
                                                        <br>
                                                        <span
                                                            class="text-muted fs-12 {{ $OutAddress == '' ? 'd-none' : '' }}"><i
                                                                class="fa fa-map-marker mx-1"></i>
                                                            <span>{{ $OutAddress }}</span>
                                                        </span>
                                                        <br />
                                                        <span class="tl-title">{{ $CorrectedBy }}</span>
                                                    <p>
                                                </div>
                                                <div class="col-2">
                                                    <button class=" btn my-auto" data-bs-toggle="modal" data-bs-target="#{{$OutSelfie != null ? 'punchOut' : 'absentModal' }}">
                                                        <span class="avatar avatar-sm brround"
                                                            style="background-image: url('/upload_image/{{ $OutSelfie }}'); border: solid 1px #1877f2;"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">close</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="absentModal" wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row p-5">
                        <div class="col-xl-12 text-center">
                            <h1><i class="fa fa-frown-o fs-50"></i></h1>
                            <h1>Sorry, No Data Found</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="holidayModal" wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Details</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card-header border-bottom-0 d-block">
                                <h5 class="">Timesheet: <span
                                        class="fs-14 mx-3 text-muted">{{ $PunchDate }}</span></h5>
                                <h6 class=""><span class="fs-14 text-dark">{{ $ShiftName }}</span>
                                    <span class="fs-14 text-dark">:</span>
                                    <span class="fs-14 mx-3 text-muted">{{ $ShiftStart }}</span>
                                    <span class="fs-14 text-muted">To</span>
                                    <span class="fs-14 mx-3 text-muted">{{ $ShiftEnd }}</span>
                                </h6>
                            </div>
                            <div class="col-sm-12 my-auto" style="height: 200px">
                                <div class="row">
                                    <div class="col-xl-12 my-3 text-center">

                                        <h4 class="mt-5 fw-bold py-3"
                                            style="color:#1877f2; border:solid 1px #d0d6df;">
                                            {{ $EventType == 2 ? 'Leave' : 'Holiday' }}
                                        </h4>
                                    </div>
                                    <div class="col-xl-12 text-center">
                                        @if ($EventType == 2)
                                            <span class="fs-16" id="leaveLine">The Employee has applied for <span>{{ $Event }}</span>.</span>
                                        @else
                                            <span class="fs-16" id="holidayLine">Due to the <span>{{ $Event }}</span>, Office is not Functioning.</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-danger" data-bs-dismiss="modal">close</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="punchIn" wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="/upload_image/{{ $InSelfie }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="punchOut" wire:ignore.self>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="/upload_image/{{ $OutSelfie }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="CorrectionModal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{-- <span id="correctionEmpID">EIDXXX</span> - <span id="correctionEmpName">Aman Sahu</span> (<span id="correctionDate"> 05-Jul-2023 </span>) --}}
                        <span>{{$EmpId}} - {{$EmpName}}({{$PunchDate}})</span>
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>
                <form action="{{ route('correctPunchTime') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-5">
                                <span class="my-5"><span class="fw-bold fs-14">Shift Name : {{$ShiftName ?? 'N/A'}}</span><br>
                                <span class="my-5"><span class="fw-bold fs-14">Shift Start : {{$ShiftStart ?? 'N/A'}}</span><br><span class="fw-bold fs-14">Shift End : {{$ShiftEnd ?? 'N/A'}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Punch In</label>
                                    <div class="input-group">
                                        <input type="text" name="in_time" class="form-control timepicker" value="{{$InTime ?? '--'}}" required>
                                        <div class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Punch Out</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" onmouseover="clickHandle(this)" value="{{$OutTime ?? '--'}}" required>
                                        <div class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Reason</label>
                                    <div class="input-group">
                                        <textarea rows="3" class="form-control" name="reason" placeholder="Enter Reason" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input id="empID" name="emp_id" type="text" hidden>
                        <input id="punchDate" name="punch_date" type="text" hidden>
                    </div>
                    <div class="modal-footer d-flex">
                        <div class="ms-auto">
                            @if (in_array('Attendance Summary.Update', $permissions) || in_array('Attendance Summary.All', $permissions))
                                <button type="reset" class="btn btn-danger"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" id="CorrectionSubmit"
                                    class="btn btn-primary">Save</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
