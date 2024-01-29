<div class="modal fade" id="presentModal">
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
                            <h5 class="">Timesheet: <span class="fs-14 mx-3 text-muted"
                                    id="punchDateTime">{{ $punchDate }}</span></h5>
                            <h6 class=""><span class="fs-14 text-dark"
                                    id="attendanceShiftName">{{ $ShiftName }}</span><span
                                    class="fs-14 mx-3 text-muted"
                                    id="attendanceShiftStart">{{ $ShiftStart }}</span><span
                                    class="fs-14 text-muted">To</span><span class="fs-14 mx-3 text-muted"
                                    id="attendanceShiftEnd">{{ $shiftEnd }}</span></h6>
                        </div>

                        <div class="col-sm-12 my-auto" style="height: 260px">
                            <div class="row">
                                <div class="col-4">
                                    <div class="p-3 text-center border border-muted">
                                        <h6 class="mb-1 fs-14 font-weight-semibold" id="modalPunchIn">
                                            {{ $punchInTime }}</h6>
                                        <small class="text-muted fs-14">Punch In</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="chart-circle chart-circle-md" data-value="100" data-thickness="8"
                                        data-color="#0dcd94" style="border:solid 5px #1877f2; border-radius:50px">
                                        <div class="chart-circle-value text-muted" id="modalWorkingHr">
                                            {{ $totalWork }}</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 text-center border border-muted">
                                        <h6 class="mb-1 fs-14 font-weight-semibold" id="modalPunchOut">
                                            {{ $punchOutTime }}</h6>
                                        <small class="text-muted fs-14">Punch Out</small>
                                    </div>
                                </div>
                            </div>
                            <div class="my-5">
                                <div class="row">
                                    <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                        <small class="text-muted fs-13">Break Time</small>
                                        <p class="mb-1 fs-14 font-weight-semibold" id="modalBreakTime">
                                            {{ $BreakTime }}</p>
                                    </div>
                                    <div class="col-5 text-center border border-muted px-5 py-1 mx-3">
                                        <small class="text-muted fs-13">Overtime</small>
                                        <p class="mb-1 fs-14 font-weight-semibold" id="modalOverTime">
                                            {{ $overtime }}</p>
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

                                    <div class="tl-header {{ $punchInLoc ? '' : 'd-none' }}" id="timeline1">
                                        <span class="tl-marker"></span>
                                        <div class="row">
                                            <div class="col-10">
                                                <p class="tl-title">Punch In at <span id="puchInAt"></span> |
                                                    <span class="shiftName">{{ $ShiftName }}</span><br><span
                                                        class="text-muted fs-12" id="inLocationSection"><i
                                                            class="fa fa-map-marker mx-1 {{ !$punchInLoc ? 'd-none' : '' }}"></i><span
                                                            id="inLocation">{{ $punchInLoc }}</span></span>
                                                    <br /><span class="tl-title" id="inCorrectionHead">Corrected By:
                                                        <span class="text-primary">{{ $correctedBy }}</span></span>
                                                <p>
                                            </div>
                                            <div class="col-2">
                                                <a id="showInSelfie" onclick="showSelfie(this)" data-imgin=''
                                                    class="my-auto">
                                                    <span id="showInSelfieBg" class="avatar avatar-sm brround"
                                                        style="background-image: url(assets/images/users/1.jpg)"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tl-header {{ $punchOutLoc ? '' : 'd-none' }}" id="timeline2">
                                        <span class="tl-marker"></span>
                                        <div class="row">
                                            <div class="col-10">
                                                <p class="tl-title">Punch Out at <span id="punchOutAt"></span>
                                                    |<span class="shiftName"></span> <br><span class="text-muted fs-12"
                                                        id="outLocationSection"><i
                                                            class="fa fa-map-marker mx-1 {{ !$punchInLoc ? 'd-none' : '' }}"></i><span
                                                            id="punchOutLocation">{{ $punchOutLoc }}</span></span>
                                                    <br /><span class="tl-title" id="outCorrectionHead">Corrected By:
                                                        <span class="text-primary">{{ $correctedBy }}</span></span>
                                                <p>
                                            </div>
                                            <div class="col-2">
                                                <a id="showOutSelfie" onclick="showSelfie(this)" data-imgout=''
                                                    class="my-auto">
                                                    <span id="showOutSelfieBg" class="avatar avatar-sm brround"
                                                        style="background-image: url(assets/images/users/1.jpg)"></span>
                                                </a>
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
                <a href="javascript:void(0);" class="btn btn-outline-primary" data-bs-dismiss="modal">close</a>
            </div>
        </div>
    </div>
</div>
