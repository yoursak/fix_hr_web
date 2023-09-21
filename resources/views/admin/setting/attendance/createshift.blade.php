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

            {{-- <div class="card-body">
                @foreach ($Shifts as $shift)
                <div class="row">
                    <div class="col-12 col-xl-4 text-secondary my-auto">
                        <h5>{{ $shift->shift_name }}</h5>
                    </div>
                    <div class="col-5 col-xl-3 text-muted my-auto">
                        <p>{{ $shift->shift_from }} - {{ $shift->shift_to }}</p>
                    </div>
                    <div class="col-5 col-xl-3 text-muted my-auto">
                        <p>Assigned to 15 Employees</p>
                    </div>
                    <div class="col-2 col-xl-1 btn">
                        <div class="dropdown header-message" id="moredrop">
                            <div class="nav-link icon" data-bs-toggle="dropdown">
                                <i class="fe fe-more-vertical fs-22"></i>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end animated">
                                <div class="header-dropdown-list message-menu" id="message-menu">
                                    <div class=" dropdown-item d-flex align-items-center justify-content-around">
                                        <i class="fe fe-edit fs-18"></i>
                                        <i class="fe fe-trash-2 fs-18"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div> --}}
        </div>
    </div>
</div>

{{-- add new shift --}}





<div class="container">
    {{-- create modal  --}}
    <div class="modal fade" id="additionalModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size:18px;">Leave Policy</h5>
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
                                                            onchange="myFunction()" name="fixpaid"
                                                            value="1" checked>
                                                        <span class="custom-control-label">Paid</span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" id="unpaid" class="custom-control-input"
                                                            onchange="myFunction()" name="fixpaid"
                                                            value="0" checked>
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
                                                        <input type="radio" onchange="openPaid()" id="openPaid" class="custom-control-input"
                                                            name="openPaid"
                                                            value="1" checked>
                                                        <span class="custom-control-label">Paid</span>
                                                    </label>
                                                </div>
                                                <div class="col-6">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" onchange="openUnpaid()" id="openUnpaid" class="custom-control-input"
                                                             name="openPaid"
                                                            value="0" checked>
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
                                                    <input class="form-control" id="start_time" placeholder="Set time"
                                                        type="time" name="rotationalShiftStart[]">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">End Time</label>
                                                    <input class="form-control" id="end_time" placeholder="Set time"
                                                        type="time" name="rotationalShiftEnd[]">
                                                </div>
                                                <div class="col-xl-3 mb-4">
                                                    <label class="form-label">Break(Min)</label>
                                                    <input class="form-control" id="break_time" placeholder="Set time"
                                                        type="number" name="rotationalShiftBreak[]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <label class="form-label">Break is</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" id="paid0" class="custom-control-input"
                                                            onchange="rotationaPaid(0)" name="rotationalpaid[]" value="1" checked>
                                                        <span class="custom-control-label">Paid</span>
                                                    </label>
                                                </div>
                                                <div class="col-5">
                                                    <label class="custom-control custom-radio">
                                                        <input type="radio" id="unpaid0" class="custom-control-input"
                                                            onchange="rotationaUnpaid(0)" name="rotationalpaid[]" value="0">
                                                        <span class="custom-control-label">Unpaid</span>
                                                    </label>
                                                </div>
                                                <div class="col-3">
                                                    <a class="btn btn-sm btn-danger" id="deleteElem0"
                                                        onclick="removalElement(0)"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </div>
                                            <span id="fixedWorkHour" class="mb-5 fs-12 text-muted"></span>
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
                                            '<input class="form-control" placeholder="Enter Shift Name" type="text" name="rotationalShiftName[]">' +
                                            '</div>' +
                                            '<div class="col-xl-3 mb-4">' +
                                            '<label class="form-label">Start Time</label>' +
                                            '<input class="form-control" id="start_time"  placeholder="Set time" type="time" name="rotationalShiftStart[]">' +
                                            '</div>' +
                                            '<div class="col-xl-3 mb-4">' +
                                            '<label class="form-label">End Time</label>' +
                                            '<input class="form-control" id="end_time"  placeholder="Set time" type="time" name="rotationalShiftEnd[]">' +
                                            '</div>' +
                                            '<div class="col-xl-3 mb-4">' +
                                            '<label class="form-label">Break(Min)</label>' +
                                            '<input class="form-control" id="break_time"  placeholder="Set time" type="number" name="rotationalShiftBreak[]">' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>' +
                                            '<div class="col-xl-3">' +
                                            '<label class="form-label">Break is</label>' +
                                            '<div class="row">' +
                                            '<div class="col-4">' +
                                            '<label class="custom-control custom-radio">' +
                                            '<input type="radio" id="paid'+i+'" class="custom-control-input" onchange="rotationaPaid('+i+')" name="rotationalpaid[]'+i+'" value="1" checked>' +
                                            '<span class="custom-control-label">Paid</span>' +
                                            '</label>' +
                                            '</div>' +
                                            '<div class="col-5">' +
                                            '<label class="custom-control custom-radio">' +
                                            '<input type="radio" id="unpaid'+i+'" class="custom-control-input" onchange="rotationaUnpaid('+i+')" name="rotationalpaid[]'+i+'" value="0">' +
                                            '<span class="custom-control-label">Unpaid</span>' +
                                            '</label>' +
                                            '</div>' +
                                            '<div class="col-3">' +
                                            '<a class="btn btn-sm btn-danger" id="deleteElem'+i+'" onclick="removalElement('+i+')"><i class="fa fa-trash"></i></a>' +
                                            '</div>' +
                                            '</div>' +
                                            '<span id="fixedWorkHour" class="mb-5 fs-12 text-muted"></span>' +
                                            '</div>' +
                                            '</div>';

                                        let parent = document.getElementById('shiftname2');
                                        parent.insertAdjacentHTML('beforeend', rotationalShift);
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

                                    function rotationaPaid(index) {
                                        document.getElementById('unpaid'+index).checked = false;
                                        document.getElementById('paid'+index).checked = true;
    
                                    }
                                    function rotationaUnpaid(index) {
                                        document.getElementById('unpaid'+index).checked = true;
                                        document.getElementById('paid'+index).checked = false;
                                    }
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