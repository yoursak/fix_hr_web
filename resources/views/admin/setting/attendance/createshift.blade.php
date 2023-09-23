@extends('admin.setting.setting')
@section('subtitle')
Attendance / Create Shift
@endsection

@section('css')
<style>
    .nav-link.icon {
        line-height: 0;
    }

    .modal-header,
    .modal-footer {
        background-color: #f8f8ff;
        /* color: #fff; */
    }

    .modal-open {
        overflow: hidden
    }

    .modal-open .modal {
        overflow-x: hidden;
        overflow-y: auto
    }

    .modal {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1050;
        display: none;
        width: 100%;
        height: 100%;
        overflow: hidden;
        outline: 0
    }

    .modal-dialog {
        position: relative;
        width: auto;
        margin: .5rem;
        pointer-events: none
    }

    .modal.fade .modal-dialog {
        transition: -webkit-transform .3s ease-out;
        transition: transform .3s ease-out;
        transition: transform .3s ease-out, -webkit-transform .3s ease-out;
        -webkit-transform: translate(0, -50px);
        transform: translate(0, -50px)
    }

    @media (prefers-reduced-motion:reduce) {
        .modal.fade .modal-dialog {
            transition: none
        }
    }

    .modal.show .modal-dialog {
        -webkit-transform: none;
        transform: none
    }

    .modal.modal-static .modal-dialog {
        -webkit-transform: scale(1.02);
        transform: scale(1.02)
    }

    .modal-dialog-scrollable {
        display: -ms-flexbox;
        display: flex;
        max-height: calc(100% - 1rem)
    }

    .modal-dialog-scrollable .modal-content {
        max-height: calc(100vh - 1rem);
        overflow: hidden
    }

    .modal-dialog-scrollable .modal-footer,
    .modal-dialog-scrollable .modal-header {
        -ms-flex-negative: 0;
        flex-shrink: 0
    }

    .modal-dialog-scrollable .modal-body {
        overflow-y: auto
    }

    .modal-dialog-centered {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        min-height: calc(100% - 1rem)
    }

    .modal-dialog-centered::before {
        display: block;
        height: calc(100vh - 1rem);
        height: -webkit-min-content;
        height: -moz-min-content;
        height: min-content;
        content: ""
    }

    .modal-dialog-centered.modal-dialog-scrollable {
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        height: 100%
    }

    .modal-dialog-centered.modal-dialog-scrollable .modal-content {
        max-height: none
    }

    .modal-dialog-centered.modal-dialog-scrollable::before {
        content: none
    }

    .modal-content {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: .3rem;
        outline: 0
    }

    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
        background-color: #000
    }

    .modal-backdrop.fade {
        opacity: 0
    }

    .modal-backdrop.show {
        opacity: .5
    }

    .modal-header {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 1rem 1rem;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: calc(.3rem - 1px);
        border-top-right-radius: calc(.3rem - 1px)
    }

    .modal-header .close {
        padding: 1rem 1rem;
        margin: -1rem -1rem -1rem auto
    }

    .modal-title {
        margin-bottom: 0;
        line-height: 1.5
    }

    .modal-body {
        position: relative;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1rem
    }

    .modal-footer {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: end;
        justify-content: flex-end;
        padding: .75rem;
        border-top: 1px solid #dee2e6;
        border-bottom-right-radius: calc(.3rem - 1px);
        border-bottom-left-radius: calc(.3rem - 1px)
    }

    .modal-footer>* {
        margin: .25rem
    }

    .modal-scrollbar-measure {
        position: absolute;
        top: -9999px;
        width: 50px;
        height: 50px;
        overflow: scroll
    }

    @media (min-width:576px) {
        .modal-dialog {
            max-width: 500px;
            margin: 1.75rem auto
        }

        .modal-dialog-scrollable {
            max-height: calc(100% - 3.5rem)
        }

        .modal-dialog-scrollable .modal-content {
            max-height: calc(100vh - 3.5rem)
        }

        .modal-dialog-centered {
            min-height: calc(100% - 3.5rem)
        }

        .modal-dialog-centered::before {
            height: calc(100vh - 3.5rem);
            height: -webkit-min-content;
            height: -moz-min-content;
            height: min-content
        }

        .modal-sm {
            max-width: 300px
        }
    }

    @media (min-width:992px) {

        .modal-lg,
        .modal-xl {
            max-width: 800px
        }
    }

    @media (min-width:1200px) {
        .modal-xl {
            max-width: 1140px
        }
    }
</style>
@endsection
@section('settings')
<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title">Create Shift</h4>
                <div class="page-rightheader ms-auto">
                    <div class="align-items-end flex-wrap my-auto right-content breadcrumb-right">
                        <div class="btn-list d-flex">
                            <a class="modal-effect btn btn-primary btn-block mx-3" data-effect="effect-scale"
                                data-bs-toggle="modal" href="#additionalModal" id="btnOpen">Add New shift</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        {{-- @dd($fixShift); --}}
        @foreach ($fixShift as $fix)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-xl-4 text-secondary my-auto">

                        <h5 class="my-auto">{{ $fix->shift_name }}</h5>
                    </div>
                    <div class="col-5 col-xl-3 text-muted my-auto text-center">
                        <h6 class="my-auto text-primary">Fixed Shift</h6>
                        <span class="my-auto">{{ $fix->shift_start }} - {{ $fix->shift_end }}</span>
                    </div>
                    <div class="col-5 col-xl-3 text-muted my-auto">
                        <p class="my-auto">Assigned to 15 Employees</p>
                    </div>
                    <div class="col-1 col-xl-1 btn">

                        <div class="flex justify-content-between">
                            <button type="reset" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#fixShiftEdit{{$fix->fixed_id}}"><i
                                    class="fe fe-edit fs-18"></i></button>

                            <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#fixDelete{{$fix->fixed_id}}"><i class="fe fe-trash fs-18"></i></button>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            {{-- create modal  --}}
            <div class="modal fade" id="fixShiftEdit{{$fix->fixed_id}}">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">

                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Shift Policy</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('update.shift')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                        <input type="text" name="fixedId" value="{{ $fix->fixed_id }}" hidden>
                                        <h3 class="card-title">Update Shift</h3>
                                    </div>

                                    <div class="card-body">
                                        {{-- fixed shift  --}}
                                        <input type="text" id="fu_WorkHour{{ $fix->fixed_id }}" name="fu_WorkHour"
                                            value="{{ $fix->work_hr }}" hidden>
                                        <input type="text" id="fu_WorkMin{{ $fix->fixed_id }}" name="fu_WorkMin"
                                            value="{{ $fix->work_min }}" hidden>

                                        

                                        <div class="form-group">
                                            <label class="form-label">Shift Type</label>
                                            <select onchange="load(this.value)" name="shiftType"
                                                class="form-control custom-select select2"
                                                data-placeholder="Select Country" id="shifttype" disabled required>
                                                <option value="fixed">Fixed Shift</option>
                                                <option value="rotational">Rotational Shift</option>
                                                <option value="open">Open Shift</option>
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">Shift Name</label>
                                                    <input class="form-control mb-4" placeholder="Enter Shift Name"
                                                        value="{{ $fix->shift_name }}" type="text"
                                                        name="UpdatedFixedshiftName">

                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Start Time</label>
                                                    <input class="form-control"
                                                        id="updated_start_time{{ $fix->fixed_id }}"
                                                        value="{{ $fix->shift_start }}"
                                                        onchange="timeCalculate({{ $fix->fixed_id }})"
                                                        placeholder="Set time" type="time" name="UpdatedFixShiftStart">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">End Time</label>
                                                    <input class="form-control"
                                                        id="updated_end_time{{ $fix->fixed_id }}"
                                                        value="{{ $fix->shift_end}}"
                                                        onchange="timeCalculate({{ $fix->fixed_id }})"
                                                        placeholder="Set time" type="time" name="UpdatedFixShiftEnd">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Break(Min)</label>
                                                    <input class="form-control"
                                                        id="updated_break_time{{ $fix->fixed_id }}"
                                                        value="{{ $fix->break_min }}"
                                                        onchange="timeCalculate({{ $fix->fixed_id }})"
                                                        placeholder="Set time" type="number"
                                                        name="UpdatedFixShiftBreak">
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break is</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            @if ($fix->is_paid==1)
                                                            @php
                                                            $check= 'checked';
                                                            $uncheck='';
                                                            @endphp
                                                            @else
                                                            @php
                                                            $check= '';
                                                            $uncheck='checked';
                                                            @endphp
                                                            @endif
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio"
                                                                    id="updated_paid{{ $fix->fixed_id }}"
                                                                    class="custom-control-input"
                                                                    onchange="timeCalculate({{ $fix->fixed_id }})"
                                                                    name="UpdatedFixpaid" value="1" {{$check}}>
                                                                <span class="custom-control-label">Paid</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio"
                                                                    id="updated_unpaid{{ $fix->fixed_id }}"
                                                                    class="custom-control-input"
                                                                    onchange="timeCalculate({{ $fix->fixed_id }})"
                                                                    name="UpdatedFixpaid" value="0" {{$uncheck}}>
                                                                <span class="custom-control-label">Unpaid</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <span id="UpdateFixedWorkHour{{ $fix->fixed_id }}" class="mb-5 fs-12 text-muted">Total Work Hour: {{$fix->work_hr}} Hr {{$fix->work_min}} Min</span>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            function timeCalculate(id) {
                                                // alert(id);
                                            let updated_start_time = document.getElementById("updated_start_time"+id).value;
                                            let updated_end_time = document.getElementById("updated_end_time"+id).value;
                                            let updated_break_time = document.getElementById("updated_break_time"+id).value;
                                            
                                            // Example time inputs
                                            const updated_startTime = updated_start_time;
                                            const updated_endTime = updated_end_time;
                                            const updated_breakTime = updated_break_time; // in minutes
                                            
                                            // Parse the time inputs
                                            const [updated_startHours, updated_startMinutes] = updated_startTime.split(":").map(Number);
                                            const [updated_endHours, updated_endMinutes] = updated_endTime.split(":").map(Number);
                                            
                                            // Calculate the time difference in minutes
                                            
                                            let updated_differenceMinutes = (updated_endHours * 60 + updated_endMinutes) - (updated_startHours * 60 + updated_startMinutes);
                                            
                                            // Ensure the differenceMinutes is positive
                                            if (updated_differenceMinutes < 0) {
                                                updated_differenceMinutes += 1440; // 24 hours in minutes
                                            }
                                            
                                            
                                            if($('#updated_unpaid').is(':checked')){
                                                // Subtract break time
                                                updated_differenceMinutes -= updated_breakTime;
                                            }
                                            
                                            // Ensure the result is positive
                                            if (updated_differenceMinutes < 0) {
                                                updated_differenceMinutes = 0;
                                            }
                                            
                                            // Calculate the hours and minutes for the result
                                            const updated_resultHours = Math.floor(updated_differenceMinutes / 60);
                                            const updated_resultMinutes = updated_differenceMinutes % 60;
                                            
                                            // Format the result as "HH:MM"
                                            const updated_formattedResult = `${String(updated_resultHours).padStart(2, '0')}:${String(updated_resultMinutes).padStart(2, '0')}`;
                                            // console.log(updated_formattedResult);
                                            var updated_fixedHour = document.getElementById('UpdateFixedWorkHour'+id);
                                            document.getElementById('fu_WorkHour'+id).value = `${String(updated_resultHours).padStart(2, '0')}`;
                                            document.getElementById('fu_WorkMin'+id).value =  `${String(updated_resultMinutes).padStart(2, '0')}`;
                                            updated_fixedHour.innerHTML = '';
                                            updated_fixedHour.innerHTML = `Total Work Hour: ${String(updated_resultHours).padStart(2, '0')} Hr ${String(updated_resultMinutes).padStart(2, '0')} Min`;
                                            console.log(`Result: ${updated_formattedResult}`);
                                            }
                                        </script>


                                    </div>
                                    <!-- table-responsive -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit" id="savechanges">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="fixDelete{{$fix->fixed_id}}">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-body text-center p-4">
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                        <i class="fe fe-warning fs-80 text-danger lh-1 mb-5 d-inline-block"></i>
                        <h4 class="text-danger">Delete Alert!</h4>
                        <p class="mg-b-20 mg-x-20">Are you sure want to delete it ?</p>
                        <form action="{{route('delete.shift',[$fix->fixed_id,'fixed'])}}" method="post">
                            @csrf
                            <button type="reset" aria-label="Close" class="btn btn-success pd-x-25"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" aria-label="Close" class="btn btn-danger pd-x-25">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach ($openShift as $open)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-xl-4 text-secondary my-auto">

                        <h5 class="my-auto">{{ $open->shift_name }}</h5>
                    </div>
                    <div class="col-5 col-xl-3 text-muted my-auto text-center">
                        <h6 class="my-auto text-primary">Open Shift</h6>
                        <span class="my-auto">Total Work: {{ $open->shift_hr }} hr {{ $open->shift_min }} min</span>
                    </div>
                    <div class="col-5 col-xl-3 text-muted my-auto">
                        <p class="my-auto">Assigned to 15 Employees</p>
                    </div>
                    <div class="col-2 col-xl-1 btn">
                        {{-- <form action="{{route('delete.shift',[$open->open_id,'open'])}}" method="post">
                        @csrf --}}
                        <div class="flex justify-content-between">
                            <button type="reset" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#openShiftEdit{{ $open->open_id }}"><i
                                    class="fe fe-edit fs-18"></i></button>
                            <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#openDelete{{$open->open_id}}"><i
                                    class="fe fe-trash fs-18"></i></button>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            {{-- create modal  --}}
            <div class="modal fade" id="openShiftEdit{{ $open->open_id }}">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">
                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Shift Policy</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('update.shift')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-header">
                                        <input type="text" name="openId" value="{{ $open->open_id }}" hidden>
                                        <h3 class="card-title">Updated Shift</h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="form-label">Shift Type</label>
                                            <select onchange="load(this.value)" name="shiftType"
                                                class="form-control custom-select select2"
                                                data-placeholder="Select Country" id="shifttype" disabled required>
                                                <option value="open">Open Shift</option>
                                                <option value="fixed">Fixed Shift</option>
                                                <option value="rotational">Rotational Shift</option>
                                            </select>
                                        </div>

                                        {{-- open shift  --}}
                                        <div class="form-group" id="openShiftEdit{{ $open->open_id }}">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">Shift Name</label>
                                                    <input class="form-control mb-4" value="{{ $open->shift_name }}"
                                                        placeholder="Enter Shift Name" type="text"
                                                        name="updatedOpenShiftName">

                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Hour</label>
                                                    <input class="form-control m-0" value="{{ $open->shift_hr }}"
                                                        placeholder="Set" type="number" name="updatedOpenHour">
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Minutes</label>
                                                    <input class="form-control" value="{{ $open->shift_min }}"
                                                        placeholder="Set" type="number" name="updatedOpenMin">
                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break(Min)</label>
                                                    <input class="form-control" value="{{ $open->break_min }}"
                                                        placeholder="Set" type="number" name="updatedOpenBreak">

                                                </div>
                                                <div class="col-xl-3">
                                                    <label class="form-label">Break is</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                @if ($open->is_paid==1)
                                                                @php
                                                                $check= 'checked';
                                                                $uncheck='';
                                                                @endphp
                                                                @else
                                                                @php
                                                                $check= '';
                                                                $uncheck='checked';
                                                                @endphp
                                                                @endif
                                                                <input type="radio" id="updatedOpenPaid"
                                                                    class="custom-control-input" name="updatedOpenPaid"
                                                                    value="1" {{$check}}>
                                                                <span class="custom-control-label">Paid</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="updatedOpenUnpaid"
                                                                    class="custom-control-input" name="updatedOpenPaid"
                                                                    value="0" {{$uncheck}}>
                                                                <span class="custom-control-label">Unpaid</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- table-responsive -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" type="submit" id="savechanges">Save changes</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="openDelete{{$open->open_id}}">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-body text-center p-4">
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                        <i class="fe fe-warning fs-80 text-danger lh-1 mb-5 d-inline-block"></i>
                        <h4 class="text-danger">Delete Alert!</h4>
                        <p class="mg-b-20 mg-x-20">Are you sure want to delete it ?</p>
                        <form action="{{route('delete.shift',[$open->open_id,'open'])}}" method="post">
                            @csrf
                            <button type="reset" aria-label="Close" class="btn btn-success pd-x-25"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" aria-label="Close" class="btn btn-danger pd-x-25">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach ($setShift as $set)
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-xl-4 text-secondary my-auto">
                        <h5 class="my-auto">{{ $set->set_name }}</h5>
                    </div>

                    <div class="col-5 col-xl-3 text-muted my-auto text-center">
                        <h6 class="my-auto text-primary">Rotational Shift</h6>
                        <?php
                        foreach ($rotationalShift->where('set_id',$set->set_id) as $key => $rotation) { ?>
                        <span class="text-dark">{{$rotation->shift_name}}</span>
                        <span class="my-auto">{{$rotation->shift_start}}-{{$rotation->shift_end}}</span><br>
                        <?php
                        }
                        ?>

                    </div>
                    <div class="col-5 col-xl-3 text-muted my-auto">
                        <p class="my-auto">Assigned to 15 Employees</p>
                    </div>
                    <div class="col-2 col-xl-1 btn">
                        {{-- <form action="{{route('delete.shift',[$set->set_id,'set'])}}" method="post">
                        @csrf --}}
                        <div class="flex justify-content-between">
                            <button type="reset" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#rotationalEdit{{$set->set_id}}"><i
                                    class="fe fe-edit fs-18"></i></button>
                            <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#rotateDelete{{$set->set_id}}"><i
                                    class="fe fe-trash fs-18"></i></button>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            {{-- create modal  --}}
            <div class="modal fade" id="rotationalEdit{{$set->set_id}}">

                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header p-5">
                            <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Update Shift
                                Policy</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('update.shift')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">


                                        <div class="form-group">
                                            <input type="text" name="setId" value="{{ $set->set_id }}" hidden>
                                            <label class="form-label">Shift Type</label>
                                            <select onchange="" name="shiftType"
                                                class="form-control custom-select select2"
                                                data-placeholder="Select Country" id="shifttype" disabled required>
                                                <option value="rotational">Rotational Shift</option>
                                                <option value="open">Open Shift</option>
                                                <option value="fixed">Fixed Shift</option>
                                            </select>
                                        </div>

                                        {{-- roatational shift  --}}
                                        <div class="form-group" id="UpdateRotationalShift">
                                            <div class="row">
                                                <div class="col-xl-11">
                                                    <label class="form-label"> Rotetional Shift Name</label>
                                                    <input class="form-control mb-4" value="{{ $set->set_name }}"
                                                        placeholder="Enter Shift Name" type="text"
                                                        name="updatedRotationalName">
                                                </div>
                                                <div class="col-xl-1 text-end mt-5">
                                                    <a class="btn btn-sm btn-success mt-2"
                                                        onclick="updateRotationalField()">Add New</a>
                                                </div>
                                            </div>


                                            <div id="updateAppendField{{$set->set_id}}">
                                                <?php
                                                $i = 0;
                                                foreach ($rotationalShift->where('set_id',$set->set_id) as $key => $rotation) { 
                                                    $i++;
                                                    ?>
                                                <div class="row" id="updateRotationalField{{$i}}" onload="updateRotateFunction({{$i}})">
                                                    <div class="col-xl-9">
                                                        <div class="row">
                                                            <div class="col-xl-3 mb-4">
                                                                <label class="form-label">Shift Name</label>
                                                                <input class="form-control" id="updateRotateName{{$i}}"
                                                                    onchange="updateRotateFunction({{$i}})"
                                                                    placeholder="Enter Shift Name"
                                                                    value="{{$rotation->shift_name}}" type="text"
                                                                    name="updatedRotationalShiftName[]">
                                                            </div>
                                                            <div class="col-xl-3 mb-4">
                                                                <label class="form-label">Start Time</label>
                                                                <input class="form-control" id="updateRotateStart{{$i}}"
                                                                    onchange="updateRotateFunction({{$i}})"
                                                                    placeholder="Set time"
                                                                    value="{{$rotation->shift_start}}" type="time"
                                                                    name="updatedRotationalShiftStart[]">
                                                            </div>
                                                            <div class="col-xl-3 mb-4">
                                                                <label class="form-label">End Time</label>
                                                                <input class="form-control" id="updateRotateEnd{{$i}}"
                                                                    onchange="updateRotateFunction({{$i}})"
                                                                    placeholder="Set time"
                                                                    value="{{$rotation->shift_end}}" type="time"
                                                                    name="updatedRotationalShiftEnd[]">
                                                            </div>
                                                            <div class="col-xl-3 mb-4">
                                                                <label class="form-label">Break(Min)</label>
                                                                <input class="form-control" id="updateRotateBreak{{$i}}"
                                                                    onchange="updateRotateFunction({{$i}})"
                                                                    placeholder="Set time"
                                                                    value="{{$rotation->break_min}}" type="number"
                                                                    name="updatedRotationalShiftBreak[]">
                                                            </div>
                                                            <input type="text" id="ru_WorkHour{{$i}}" name="ru_WorkHour[]" value="{{$rotation->work_hr}}" hidden>
                                                            <input type="text" id="ru_WorkMin{{$i}}" name="ru_WorkMin[]" value="{{$rotation->work_min}}" hidden>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3">
                                                        <label class="form-label">Break is</label>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <label class="custom-control custom-radio">
                                                                    @if ($rotation->is_paid==1)
                                                                    @php
                                                                    $check= 'checked';
                                                                    $uncheck='';
                                                                    @endphp
                                                                    @else
                                                                    @php
                                                                    $check= '';
                                                                    $uncheck='checked';
                                                                    @endphp
                                                                    @endif
                                                                    <input type="radio" class="custom-control-input"
                                                                        id="updateRotatePaid{{$i}}"
                                                                        onchange="updateRotateFunction({{$i}})"
                                                                        name="updatedRotationalpaid[]{{$i}}" value="1"
                                                                        {{$check}}>
                                                                    <span class="custom-control-label">Paid</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-5">
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" class="custom-control-input"
                                                                        id="updateRotateUnpaid{{$i}}"
                                                                        onchange="updateRotateFunction({{$i}})"
                                                                        name="updatedRotationalpaid[]{{$i}}" value="0"
                                                                        {{$uncheck}}>
                                                                    <span class="custom-control-label">Unpaid</span>
                                                                </label>
                                                            </div>
                                                            <div class="col-3">
                                                                <a class="btn btn-sm btn-danger" id="deleteElem0"
                                                                    onclick="removalUpdaedElement({{$i}})"><i
                                                                        class="fa fa-trash"></i></a>
                                                            </div>
                                                        </div>
                                                        <span id="updateRot_fixedWorkHour{{$i}}" class="mb-5 fs-12 text-muted">Total Work Hour: {{$rotation->work_hr}} Hr {{$rotation->work_min}} Min</span>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            </div>


                                            <?php $load=$i ?>
                                            <script>
                                                var id={{$i}};
                                                function updateRotationalField(){
                                                    // var id = '<?php echo $i++ ?>';
                                                    var setId = '<?php echo $set->set_id ?>';
                                                    var Id = ++id;
                                                    
                                                    console.log(Id);
                                                let updatedRotationalShift = '<div class="row" id="updateRotationalField'+ Id +'">' +
                                                    '<div class="col-xl-9">' +
                                                    '<div class="row">' +
                                                    '<div class="col-xl-3 mb-4">' +
                                                    '<label class="form-label">Shift Name</label>' +
                                                    '<input type="text" id="ru_WorkHour'+ Id +'" name="ru_WorkHour[]" value="" hidden>' +
                                                    '<input type="text" id="ru_WorkMin'+ Id +'" name="ru_WorkMin[]" value="" hidden>' +
                                                    '<input class="form-control" placeholder="Enter Shift Name" type="text" name="updatedRotationalShiftName[]">' +
                                                    '</div>' +
                                                    '<div class="col-xl-3 mb-4">' +
                                                    '<label class="form-label">Start Time</label>' +
                                                    '<input class="form-control" id="updateRotateStart'+ Id +'" onchange="updateRotateFunction('+ Id +')"  placeholder="Set time" type="time" name="updatedRotationalShiftStart[]">' +
                                                    '</div>' +
                                                    '<div class="col-xl-3 mb-4">' +
                                                    '<label class="form-label">End Time</label>' +
                                                    '<input class="form-control" id="updateRotateEnd'+ Id +'" onchange="updateRotateFunction('+ Id +')"  placeholder="Set time" type="time" name="updatedRotationalShiftEnd[]">' +
                                                    '</div>' +
                                                    '<div class="col-xl-3 mb-4">' +
                                                    '<label class="form-label">Break(Min)</label>' +
                                                    '<input class="form-control" id="updateRotateBreak'+ Id +'" onchange="updateRotateFunction('+ Id +')"  placeholder="Set time" type="number" name="updatedRotationalShiftBreak[]">' +
                                                    '</div>' +
                                                    '</div>' +
                                                    '</div>' +
                                                    '<div class="col-xl-3">' +
                                                    '<label class="form-label">Break is</label>' +
                                                    '<div class="row">' +
                                                    '<div class="col-4">' +
                                                    '<label class="custom-control custom-radio">' +
                                                    '<input type="radio" id="updateRotatePaid'+ Id +'" onchange="updateRotateFunction('+ Id +')" class="custom-control-input"  name="updatedRotationalpaid[]'+Id+'" value="1" checked>' +
                                                    '<span class="custom-control-label">Paid</span>' +
                                                    '</label>' +
                                                    '</div>' +
                                                    '<div class="col-5">' +
                                                    '<label class="custom-control custom-radio">' +
                                                    '<input type="radio" id="updateRotateUnpaid'+ Id +'" onchange="updateRotateFunction('+ Id +')" class="custom-control-input"  name="updatedRotationalpaid[]'+Id+'" value="0">' +
                                                    '<span class="custom-control-label">Unpaid</span>' +
                                                    '</label>' +
                                                    '</div>' +
                                                    '<div class="col-3">' +
                                                    '<a class="btn btn-sm btn-danger" id="deleteElem'+Id+'" onclick="removalUpdaedElement('+Id+')"><i class="fa fa-trash"></i></a>' +
                                                    '</div>' +
                                                    '</div>' +
                                                    '<span id="updateRot_fixedWorkHour'+Id+'" class="mb-5 fs-12 text-muted"></span>' +
                                                    '</div>' +
                                                    '</div>';
        
                                                let parent = document.getElementById('updateAppendField'+setId);
                                                parent.insertAdjacentHTML('beforeend', updatedRotationalShift);
                                            }

                                            function updateRotateFunction(rotId) {
                                                    console.log(rotId);
                                                    let updateRot_start_time = document.getElementById("updateRotateStart"+rotId).value;
                                                    let updateRot_end_time = document.getElementById("updateRotateEnd"+rotId).value;
                                                    let updateRot_break_time = document.getElementById("updateRotateBreak"+rotId).value;
                                                    // alert('abvc')
                                                    // Example time inputs
                                                    const updateRot_startTime = updateRot_start_time;
                                                    const updateRot_endTime = updateRot_end_time;
                                                    const updateRot_breakTime = updateRot_break_time; // in minutes
                    
                                                    // Parse the time inputs
                                                    const [updateRot_startHours, updateRot_startMinutes] = updateRot_startTime.split(":").map(Number);
                                                    const [updateRot_endHours, updateRot_endMinutes] = updateRot_endTime.split(":").map(Number);
                    
                                                    // Calculate the time difference in minutes
                                                    let updateRot_differenceMinutes = (updateRot_endHours * 60 + updateRot_endMinutes) - (updateRot_startHours * 60 + updateRot_startMinutes);
                    
                                                    // Ensure the differenceMinutes is positive
                                                    if (updateRot_differenceMinutes < 0) {
                                                        updateRot_differenceMinutes += 1440; // 24 hours in minutes
                                                    }
                    
                    
                                                    if($('#updateRotateUnpaid'+rotId).is(':checked')){
                                                        // Subtract break time
                                                        updateRot_differenceMinutes -= updateRot_breakTime;
                                                    }
                    
                                                    // Ensure the result is positive
                                                    if (updateRot_differenceMinutes < 0) {
                                                        updateRot_differenceMinutes = 0;
                                                    }
                    
                                                    // Calculate the hours and minutes for the result
                                                    const updateRot_resultHours = Math.floor(updateRot_differenceMinutes / 60);
                                                    const updateRot_resultMinutes = updateRot_differenceMinutes % 60;
                    
                                                    // Format the result as "HH:MM"
                                                    const updateRot_formattedResult = `${String(updateRot_resultHours).padStart(2, '0')}:${String(updateRot_resultMinutes).padStart(2, '0')}`;
                                                    var updateRot_fixedHour = document.getElementById('updateRot_fixedWorkHour'+rotId);
                                                     document.getElementById('ru_WorkHour'+rotId).value = `${String(updateRot_resultHours).padStart(2, '0')}`;
                                                     document.getElementById('ru_WorkMin'+rotId).value = `${String(updateRot_resultMinutes).padStart(2, '0')}`;
                                                    updateRot_fixedHour.innerHTML = `Total Work Hour: ${String(updateRot_resultHours).padStart(2, '0')} Hr ${String(updateRot_resultMinutes).padStart(2, '0')} Min`;
                                                    console.log(`Result: ${updateRot_formattedResult}`);
                                            }
        
                                            function removalUpdaedElement(id){
                                                // alert(id);
                                                // Get the element you want to remove by its ID
                                                var updatedElementToRemove = document.getElementById('updateRotationalField'+id);
        
                                                // Check if the element exists before attempting to remove it
                                                if (updatedElementToRemove) {
                                                    console.log(id);
                                                    // Remove the element
                                                    updatedElementToRemove.remove();
                                                } else {
                                                    console.log("Element with ID 'field' does not exist.");
                                                }
                                            }
        
                                            // function rotationaPaid(index) {
                                            //     document.getElementById('unpaid'+index).checked = false;
                                            //     document.getElementById('paid'+index).checked = true;
            
                                            // }
                                            // function rotationaUnpaid(index) {
                                            //     document.getElementById('unpaid'+index).checked = true;
                                            //     document.getElementById('paid'+index).checked = false;
                                            // }
                                            </script>
                                            <?php   ?>
                                        </div>

                                    </div>
                                    <!-- table-responsive -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit" id="savechanges">Save changes</button>
                            </div>
                        </form>
                        <script>
                            function load(value) {
                                    // alert(value);
                                    if (value == 'fixed') {
                                        $('#shiftname').removeClass('d-none');
                                        $('#shiftname2').addClass('d-none');
                                        $('#shifttime').removeClass('d-none');
                                        $('#unpaidbreaklabel').removeClass('d-none');
                                        $('#unpaidbreak').removeClass('d-none');
                                        $('#workhour').addClass('d-none');
                                        $('#additionaltbl').addClass('d-none');
                                    } else if (value == 'rotational') {
                                        $('#shiftname').addClass('d-none');
                                        $('#shiftname2').removeClass('d-none');
                                        $('#shifttime').addClass('d-none');
                                        $('#unpaidbreaklabel').addClass('d-none');
                                        $('#unpaidbreak').addClass('d-none');
                                        $('#workhour').addClass('d-none');
                                        $('#additionaltbl').removeClass('d-none');
                                    } else {
                                        $('#shiftname2').addClass('d-none');
                                        $('#shiftname').removeClass('d-none');
                                        $('#shifttime').addClass('d-none');
                                        $('#unpaidbreaklabel').addClass('d-none');
                                        $('#unpaidbreak').addClass('d-none');
                                        $('#workhour').removeClass('d-none');
                                        $('#additionaltbl').addClass('d-none');
                                    }
                                }
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="rotateDelete{{$set->set_id}}">
            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-body text-center p-4">
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                                aria-hidden="true">&times;</span></button>
                        <i class="fe fe-warning fs-80 text-danger lh-1 mb-5 d-inline-block"></i>
                        <h4 class="text-danger">Delete Alert!</h4>
                        <p class="mg-b-20 mg-x-20">Are you sure want to delete it ?</p>
                        <form action="{{route('delete.shift',[$set->set_id,'set'])}}" method="post">
                            @csrf
                            <button type="reset" aria-label="Close" class="btn btn-success pd-x-25"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" aria-label="Close" class="btn btn-danger pd-x-25">Continue</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- add new shift --}}
<div class="container">
    {{-- create modal  --}}
    <div class="modal fade" id="additionalModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Shift Policy</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-bs-dismiss="modal">&times;</span>
                    </button>
                </div>
                <form action="{{route('add.shift')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Add New Shift</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Shift Type</label>
                                    <select onchange="load(this.value)" name="shiftType"
                                        class="form-control custom-select select2" data-placeholder="Select Country"
                                        id="shifttype" required>
                                        <option label="Select Country"></option>
                                        <option value="fixed">Fixed Shift</option>
                                        <option value="rotational">Rotational Shift</option>
                                        <option value="open">Open Shift</option>
                                    </select>

                                    <input type="text" id="f_WorkHour" name="f_WorkHour" value="" hidden>
                                    <input type="text" id="f_WorkMin" name="f_WorkMin" value="" hidden>

                                    <input type="text" id="r_WorkHour0" name="r_WorkHour[]" value="" hidden>
                                    <input type="text" id="r_WorkMin0" name="r_WorkMin[]" value="" hidden>
                                </div>
                                {{-- fixed shift  --}}
                                <div class="form-group d-none" id="shifttime">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">Shift Name</label>
                                            <input class="form-control mb-4" placeholder="Enter Shift Name" type="text"
                                                name="fixedshiftName">

                                        </div>
                                        <div class="col-xl-3 mb-4">
                                            <label class="form-label">Start Time</label>
                                            <input class="form-control" id="start_time" onchange="myFunction()"
                                                placeholder="Set time" type="time" name="fixShiftStart">
                                        </div>
                                        <div class="col-xl-3 mb-4">
                                            <label class="form-label">End Time</label>
                                            <input class="form-control" id="end_time" onchange="myFunction()"
                                                placeholder="Set time" type="time" name="fixShiftEnd">
                                        </div>
                                        <div class="col-xl-3 mb-4">
                                            <label class="form-label">Break(Min)</label>
                                            <input class="form-control" id="break_time" onchange="myFunction()"
                                                placeholder="Set time" type="number" name="fixShiftBreak">
                                        </div>
                                        <div class="col-xl-3">
                                            <label class="form-label">Break is</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" id="paid" class="custom-control-input"
                                                            onchange="myFunction()" name="fixpaid" value="1" checked>
                                                        <span class="custom-control-label">Paid</span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" id="unpaid" class="custom-control-input"
                                                            onchange="myFunction()" name="fixpaid" value="0" checked>
                                                        <span class="custom-control-label">Unpaid</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <span id="fixedWorkHour" class="mb-5 fs-12 text-muted"></span>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function myFunction() {
                                    let start_time = document.getElementById("start_time").value;
                                    let end_time = document.getElementById("end_time").value;
                                    let break_time = document.getElementById("break_time").value;
                                    // alert('abvc')
                                    // Example time inputs
                                    const startTime = start_time;
                                    const endTime = end_time;
                                    const breakTime = break_time; // in minutes
    
                                    // Parse the time inputs
                                    const [startHours, startMinutes] = startTime.split(":").map(Number);
                                    const [endHours, endMinutes] = endTime.split(":").map(Number);
    
                                    // Calculate the time difference in minutes
                                    let differenceMinutes = (endHours * 60 + endMinutes) - (startHours * 60 + startMinutes);
    
                                    // Ensure the differenceMinutes is positive
                                    if (differenceMinutes < 0) {
                                    differenceMinutes += 1440; // 24 hours in minutes
                                    }
    
    
                                    if($('#unpaid').is(':checked')){
                                        // Subtract break time
                                    differenceMinutes -= breakTime;
                                    }
    
                                    // Ensure the result is positive
                                    if (differenceMinutes < 0) {
                                    differenceMinutes = 0;
                                    }
    
                                    // Calculate the hours and minutes for the result
                                    const resultHours = Math.floor(differenceMinutes / 60);
                                    const resultMinutes = differenceMinutes % 60;
    
                                    // Format the result as "HH:MM"
                                    const formattedResult = `${String(resultHours).padStart(2, '0')}:${String(resultMinutes).padStart(2, '0')}`;
                                    var fixedHour = document.getElementById('fixedWorkHour');
                                    document.getElementById('f_WorkHour').value = `${String(resultHours).padStart(2, '0')}`;
                                    document.getElementById('f_WorkMin').value =  `${String(resultMinutes).padStart(2, '0')}`;
                                    fixedHour.innerHTML = `Total Work Hour: ${String(resultHours).padStart(2, '0')} Hr ${String(resultMinutes).padStart(2, '0')} Min`;
                                    console.log(`Result: ${formattedResult}`);
                                    }
                                </script>

                                {{-- open shift  --}}
                                <div class="form-group d-none" id="workhour">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">Shift Name</label>
                                            <input class="form-control mb-4" placeholder="Enter Shift Name" type="text"
                                                name="openShiftName">

                                        </div>
                                        <div class="col-xl-3">
                                            <label class="form-label">Hour</label>
                                            <input class="form-control m-0" placeholder="Set" type="number"
                                                name="openHour">
                                        </div>
                                        <div class="col-xl-3">
                                            <label class="form-label">Minutes</label>
                                            <input class="form-control" placeholder="Set" type="number" name="openMin">
                                        </div>
                                        <div class="col-xl-3">
                                            <label class="form-label">Break(Min)</label>
                                            <input class="form-control" placeholder="Set" type="number"
                                                name="openBreak">
                                        </div>
                                        <div class="col-xl-3">
                                            <label class="form-label">Break is</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" onchange="openPaid()" id="openPaid"
                                                            class="custom-control-input" name="openPaid" value="1"
                                                            checked>
                                                        <span class="custom-control-label">Paid</span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" onchange="openUnpaid()" id="openUnpaid"
                                                            class="custom-control-input" name="openPaid" value="0"
                                                            checked>
                                                        <span class="custom-control-label">Unpaid</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <script>
                                                function openPaid() {
                                                    document.getElementById('openUnpaid').checked = false;
                                                    document.getElementById('openPaid').checked = true;
                
                                                }
                                                function openUnpaid() {
                                                    document.getElementById('openUnpaid').checked = true;
                                                    document.getElementById('openPaid').checked = false;
                                                }
                                            </script>
                                        </div>
                                    </div>
                                </div>

                                {{-- roatational shift  --}}
                                <div class="form-group d-none" id="shiftname2">
                                    <div class="row">
                                        <div class="col-11">
                                            <label class="form-label"> Rotetional Shift Name</label>
                                            <input class="form-control mb-4" placeholder="Enter Shift Name" type="text"
                                                name="rotationalName">
                                        </div>
                                        <div class="col-1 mt-5">
                                            <a class="btn btn-sm btn-success mt-2" onclick="addRotationalField()">Add
                                                New</a>
                                        </div>
                                    </div>

                                    <div class="row" id="newRotationalField0">
                                        <div class="col-xl-9">
                                            <div class="row">
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Shift Name</label>
                                                    <input class="form-control" placeholder="Enter Shift Name"
                                                        type="text" name="rotationalShiftName[]">

                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Start Time</label>
                                                    <input class="form-control" onchange="rotateFunction(0)"
                                                        id="start_time0" placeholder="Set time" type="time"
                                                        name="rotationalShiftStart[]">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">End Time</label>
                                                    <input class="form-control" onchange="rotateFunction(0)"
                                                        id="end_time0" placeholder="Set time" type="time"
                                                        name="rotationalShiftEnd[]">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Break(Min)</label>
                                                    <input class="form-control" onchange="rotateFunction(0)"
                                                        id="break_time0" placeholder="Set time" type="number"
                                                        name="rotationalShiftBreak[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <label class="form-label">Break is</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" id="rotatePaid0"
                                                            class="custom-control-input" onchange="rotateFunction(0)"
                                                            name="rotationalpaid[]" value="1" checked>
                                                        <span class="custom-control-label">Paid</span>
                                                    </label>
                                                </div>
                                                <div class="col-5">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" id="rotateUnpaid0"
                                                            class="custom-control-input" onchange="rotateFunction(0)"
                                                            name="rotationalpaid[]" value="0">
                                                        <span class="custom-control-label">Unpaid</span>
                                                    </label>
                                                </div>
                                                <div class="col-3">
                                                    <a class="btn btn-sm btn-danger" id="deleteElem0"
                                                        onclick="removalElement(0)"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                            <span id="rot_fixedWorkHour0" class="mb-5 fs-12 text-muted"></span>
                                        </div>
                                    </div>

                                    <script>
                                        let i = 0;
                                    function addRotationalField(){
                                        i++;
                                        let rotationalShift = '<div class="row" id="newRotationalField'+ i +'">' +
                                            '<div class="col-xl-9">' +
                                            '<div class="row">' +
                                            '<div class="col-xl-3 mb-4">' +
                                            '<label class="form-label">Shift Name</label>' +
                                            '<input type="text" id="r_WorkHour'+ i +'" name="r_WorkHour[]" value="" hidden>' +
                                            '<input type="text" id="r_WorkMin'+ i +'" name="r_WorkMin[]" value="" hidden>' +
                                            '<input class="form-control" placeholder="Enter Shift Name" type="text" name="rotationalShiftName[]">' +
                                            '</div>' +
                                            '<div class="col-xl-3 mb-4">' +
                                            '<label class="form-label">Start Time</label>' +
                                            '<input class="form-control" onchange="rotateFunction('+ i +')" id="start_time'+ i +'"  placeholder="Set time" type="time" name="rotationalShiftStart[]">' +
                                            '</div>' +
                                            '<div class="col-xl-3 mb-4">' +
                                            '<label class="form-label">End Time</label>' +
                                            '<input class="form-control" onchange="rotateFunction('+ i +')" id="end_time'+ i +'"  placeholder="Set time" type="time" name="rotationalShiftEnd[]">' +
                                            '</div>' +
                                            '<div class="col-xl-3 mb-4">' +
                                            '<label class="form-label">Break(Min)</label>' +
                                            '<input class="form-control" onchange="rotateFunction('+ i +')" id="break_time'+ i +'"  placeholder="Set time" type="number" name="rotationalShiftBreak[]">' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>' +
                                            '<div class="col-xl-3">' +
                                            '<label class="form-label">Break is</label>' +
                                            '<div class="row">' +
                                            '<div class="col-4">' +
                                            '<label class="custom-control custom-radio">' +
                                            '<input type="radio" id="rotatePaid'+i+'" onchange="rotateFunction('+ i +')" class="custom-control-input" onchange="rotationaPaid('+i+')" name="rotationalpaid[]'+i+'" value="1" checked>' +
                                            '<span class="custom-control-label">Paid</span>' +
                                            '</label>' +
                                            '</div>' +
                                            '<div class="col-5">' +
                                            '<label class="custom-control custom-radio">' +
                                            '<input type="radio" id="rotateUnpaid'+i+'" onchange="rotateFunction('+ i +')" class="custom-control-input" onchange="rotationaUnpaid('+i+')" name="rotationalpaid[]'+i+'" value="0">' +
                                            '<span class="custom-control-label">Unpaid</span>' +
                                            '</label>' +
                                            '</div>' +
                                            '<div class="col-3">' +
                                            '<a class="btn btn-sm btn-danger" id="deleteElem'+i+'" onclick="removalElement('+i+')"><i class="fa fa-trash"></i></a>' +
                                            '</div>' +
                                            '</div>' +
                                            '<span id="rot_fixedWorkHour'+i+'" class="mb-5 fs-12 text-muted"></span>' +
                                            '</div>' +
                                            '</div>';

                                        let parent = document.getElementById('shiftname2');
                                        parent.insertAdjacentHTML('beforeend', rotationalShift);
                                    }

                                    
                                    function rotateFunction(rotId) {
                                        let rot_start_time = document.getElementById("start_time"+rotId).value;
                                        let rot_end_time = document.getElementById("end_time"+rotId).value;
                                        let rot_break_time = document.getElementById("break_time"+rotId).value;
                                        // alert('abvc')
                                        // Example time inputs
                                        const rot_startTime = rot_start_time;
                                        const rot_endTime = rot_end_time;
                                        const rot_breakTime = rot_break_time; // in minutes
        
                                        // Parse the time inputs
                                        const [rot_startHours, rot_startMinutes] = rot_startTime.split(":").map(Number);
                                        const [rot_endHours, rot_endMinutes] = rot_endTime.split(":").map(Number);
        
                                        // Calculate the time difference in minutes
                                        let rot_differenceMinutes = (rot_endHours * 60 + rot_endMinutes) - (rot_startHours * 60 + rot_startMinutes);
        
                                        // Ensure the differenceMinutes is positive
                                        if (rot_differenceMinutes < 0) {
                                            rot_differenceMinutes += 1440; // 24 hours in minutes
                                        }
        
        
                                        if($('#rotateUnpaid'+rotId).is(':checked')){
                                            // Subtract break time
                                            rot_differenceMinutes -= rot_breakTime;
                                        }
        
                                        // Ensure the result is positive
                                        if (rot_differenceMinutes < 0) {
                                            rot_differenceMinutes = 0;
                                        }
        
                                        // Calculate the hours and minutes for the result
                                        const rot_resultHours = Math.floor(rot_differenceMinutes / 60);
                                        const rot_resultMinutes = rot_differenceMinutes % 60;
        
                                        // Format the result as "HH:MM"
                                        const rot_formattedResult = `${String(rot_resultHours).padStart(2, '0')}:${String(rot_resultMinutes).padStart(2, '0')}`;
                                        var rot_fixedHour = document.getElementById('rot_fixedWorkHour'+rotId);
                                        document.getElementById('r_WorkHour'+rotId).value = `${String(rot_resultHours).padStart(2, '0')}`;
                                        document.getElementById('r_WorkMin'+rotId).value = `${String(rot_resultMinutes).padStart(2, '0')}`;
                                        rot_fixedHour.innerHTML = `Total Work Hour: ${String(rot_resultHours).padStart(2, '0')} Hr ${String(rot_resultMinutes).padStart(2, '0')} Min`;
                                        console.log(`Result: ${rot_formattedResult}`);
                                    }
                          

                                    function removalElement(id){
                                        // alert(id);
                                        // Get the element you want to remove by its ID
                                        var elementToRemove = document.getElementById('newRotationalField'+id);

                                        // Check if the element exists before attempting to remove it
                                        if (elementToRemove) {
                                            // Remove the element
                                            elementToRemove.remove();
                                        } else {
                                            console.log("Element with ID 'field' does not exist.");
                                        }
                                    }

                                    // function rotationaPaid(index) {
                                    //     document.getElementById('unpaid'+index).checked = false;
                                    //     document.getElementById('paid'+index).checked = true;
    
                                    // }
                                    // function rotationaUnpaid(index) {
                                    //     document.getElementById('unpaid'+index).checked = true;
                                    //     document.getElementById('paid'+index).checked = false;
                                    // }
                                    </script>
                                </div>

                            </div>
                            <!-- table-responsive -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light" type="reset" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit" id="savechanges">Save changes</button>
                    </div>
                </form>
                <script>
                    function load(value) {
                            // alert(value);
                            if (value == 'fixed') {
                                $('#shiftname').removeClass('d-none');
                                $('#shiftname2').addClass('d-none');
                                $('#shifttime').removeClass('d-none');
                                $('#unpaidbreaklabel').removeClass('d-none');
                                $('#unpaidbreak').removeClass('d-none');
                                $('#workhour').addClass('d-none');
                                $('#additionaltbl').addClass('d-none');
                            } else if (value == 'rotational') {
                                $('#shiftname').addClass('d-none');
                                $('#shiftname2').removeClass('d-none');
                                $('#shifttime').addClass('d-none');
                                $('#unpaidbreaklabel').addClass('d-none');
                                $('#unpaidbreak').addClass('d-none');
                                $('#workhour').addClass('d-none');
                                $('#additionaltbl').removeClass('d-none');
                            } else {
                                $('#shiftname2').addClass('d-none');
                                $('#shiftname').removeClass('d-none');
                                $('#shifttime').addClass('d-none');
                                $('#unpaidbreaklabel').addClass('d-none');
                                $('#unpaidbreak').addClass('d-none');
                                $('#workhour').removeClass('d-none');
                                $('#additionaltbl').addClass('d-none');
                            }
                        }
                </script>
            </div>
        </div>
    </div>
</div>
@endsection