@extends('admin.pagelayout.master')

@section('title')
    Weekly Holiday
@endsection

@section('css')
@endsection
@section('content')
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            {{-- <li><a href="{{ url('admin/settings/business')}}">Settings</a></li> --}}
            <li><a href="{{ url('admin/settings/business') }}">Business Settings</a></li>
            <li class="active"><span><b>Weekly Holiday</b></span></li>
        </ol>
    </div>
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Weekly Holiday</div>
            <p class="text-muted m-0">Assign weekly off days of your business to automatically mark attendance for those
                days.
            </p>
        </div>
        <div class="page-rightheader ms-md-auto">
            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                <div class="d-lg-flex d-block ms-auto">
                    <div class="btn-list">
                        {{-- <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-bs-target="#modaldemo3"   data-target="#modaldemo3">
                        Create Templates
                    </button> --}}
                        <a class="btn btn-primary" data-bs-target="#modaldemo3" data-bs-toggle="modal" href="#">Create
                            Week Off</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="text-center py-4 bg-light border">
    <a class="btn btn-primary" data-bs-target="#modaldemo3" data-bs-toggle="modal" href="#">View Live Demo</a>
</div><!-- pd-y-30 --> --}}
    <!-- LARGE MODAL -->
    <div class="modal fade" id="modaldemo3">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Weekoff/Weekly Holiday</h6>
                    <button aria-label="Close" class="btn-close" type="reset" onclick="SelectWeekOff(this)" value="0"
                        data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" action="{{ route('create.CreateWeeklyPolicy') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="weekname" class="col-sm-3 col-form-label fs-14">Weekly off template name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="templatename" id="weekname"
                                    placeholder="Enter Week Off Policy Name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="weekname" class="col-sm-3 col-form-label fs-14">Select Week Off Type</label>

                            <div class="col-sm-9">
                                <select name="selectWeekOffPolicy" id="selectBox" class="form-control"
                                    onchange="SelectWeekOff(this)" required>
                                    <option value="">Select Week Off Policy</option>
                                    @foreach ($staticweekoffType as $staticweekoffitem)
                                        <option value="{{ $staticweekoffitem->id }}">
                                            {{ $staticweekoffitem->week_off_type_name }}</option>
                                    @endforeach
                                    {{-- <option value="1">5-Day Week-> Saturday & Sunday are off</option>
                                    <option value="2">6-Day Week-> Only Sunday is off</option>
                                    <option value="3">2nd & 4th Saturday off-> Apart from sunday</option>
                                    <option value="4">Other</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="row d-none" id="firstWeekOff">
                            <div class="col-xl-12">
                                <div class="form-group m-0">
                                    <div class="fs-14 mb-4">Weekly Holiday Days</div>
                                    <div class="custom-controls-stacked">

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input first second" name="days[]"
                                                value="Monday">
                                            <span class="custom-control-label">Monday</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input first second" name="days[]"
                                                value="Tuesday">
                                            <span class="custom-control-label">Tuesday</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input first second" name="days[]"
                                                value="Wednesday">
                                            <span class="custom-control-label">Wednesday</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input first second" name="days[]"
                                                value="Thursday">
                                            <span class="custom-control-label">Thursday</span>
                                        </label>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input first second" name="days[]"
                                                value="Friday">
                                            <span class="custom-control-label">Friday</span>
                                        </label>

                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input second onecreate"
                                                name="days[]" value="Saturday">
                                            <span class="custom-control-label ">Saturday
                                        </label>
                                        <label class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input onecreate twocreate"
                                                name="days[]" value="Sunday">
                                            <span class="custom-control-label ">Sunday</span>
                                        </label>
                                        <span id="SaturdayDescription" class="d-none fs-12" style="color: red">Note:-
                                            Alternate Saturday off (1st, 3rd, and 5th Saturdays are working in a month).
                                        </span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="reset" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary me-0" id="sumbit" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Weekly Holiday List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table  table-vcenter text-nowrap  border-bottom " id="file-datatable">
                    <thead>
                        <tr>
                            <th class="border-bottom-0 w-10">S.No.</th>
                            <th class="border-bottom-0">Policy Name</th>

                            <th class="border-bottom-0">Week off Type</th>
                            <th class="border-bottom-0">Weekly</th>

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
                                <td>
                                    <a class="btn action-btns  btn-primary btn-icon btn-sm" href="javascript:void(0);"
                                        onclick="openEditModel(this)" data-id='<?= $item->id ?>' data-bs-toggle="modal"
                                        data-bs-target="#editBranchName">
                                        <i class="feather feather-edit" data-bs-toggle="tooltip"
                                            data-original-title="View/Edit"></i>
                                    </a>

                                    <a class="btn action-btns  btn-danger btn-icon btn-sm" href="javascript:void(0);"
                                        onclick="ItemDeleteModel(this)" data-id='<?= $item->id ?>'
                                        data-weekly_name='<?= $item->name ?>' data-bs-toggle="modal"
                                        data-bs-target="#editDeleteModel"><i class="feather feather-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="row">


        <!-- LARGE MODAL -->
        <div class="modal fade" id="editBranchName">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">Weekoff/Weekly Holiday</h6><button aria-label="Close" class="btn-close"
                            data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('update.WeeklyPolicy') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group row  ">
                                <input type="text" name="id" id="weekly_id" hidden>
                                <label for="weekname" class="col-sm-3 col-form-label fs-14">Weekly off template
                                    name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="edit_weekname" id="edit_weekname"
                                        placeholder="name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="weekname" class="col-sm-3 col-form-label fs-14">Select Week Off Type</label>

                                <div class="col-sm-9">
                                    <select name="selectWeekOffPolicyUpdate" id="edit_selectBox" class="form-control"
                                        onchange="SelectWeekOffUpdate(this)" required>
                                        <option value="">Select Week Off Policy</option>
                                        @foreach ($staticweekoffType as $staticweekoffitem)
                                            <option value="{{ $staticweekoffitem->id }}">
                                                {{ $staticweekoffitem->week_off_type_name }}</option>
                                        @endforeach
                                        {{-- <option value="1">5-Day Week-> Saturday & Sunday are off</option>
                                        <option value="2">6-Day Week-> Only Sunday is off</option>
                                        <option value="3">2nd & 4th Saturday off-> Apart from sunday</option>
                                        <option value="4">Other</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group m-0">
                                        <div class="fs-14 mb-4">Weekly Holiday Days</div>
                                        <div class="custom-controls-stacked">
                                            {{-- 
                                                    {{ in_array('Monday', $days) ? 'checked' : 'null' }} --}}
                                            <label>
                                                <input type="checkbox" class="updateUncheck   three" name="holidays[]"
                                                    value="Monday">
                                                Monday

                                            </label><br>
                                            <label>
                                                <input type="checkbox" class="updateUncheck   three" name="holidays[]"
                                                    value="Tuesday">
                                                Tuesday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" class="updateUncheck   three" name="holidays[]"
                                                    value="Wednesday">
                                                Wednesday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" class="updateUncheck three" name="holidays[]"
                                                    value="Thursday">
                                                Thursday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" class="updateUncheck three" name="holidays[]"
                                                    value="Friday">
                                                Friday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" class="updateUncheck one  three" name="holidays[]"
                                                    value="Saturday">
                                                Saturday
                                            </label><br>

                                            <label>
                                                <input type="checkbox" class="updateUncheck one two three"
                                                    name="holidays[]" value="Sunday">
                                                Sunday
                                            </label>
                                            <br>
                                            <span id="updateSaturdayDescription" class="d-none fs-12"
                                                style="color: red">Note:- Alternate Saturday off (1st, 3rd, and 5th
                                                Saturdays are working in a month).</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" data-bs-dismiss="modal">Cancel</button> <button
                                class="btn btn-primary me-0" id=type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editDeleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <form action="{{ route('delete.DeleteWeeklyPolicy') }}" method="POST">
                        @csrf
                        <input type="text" id="weekly_policy_id" name="weekly_policy_id" hidden>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">

                            <h4 class="mt-5">Are you sure you want to delete this weekoff policy ?</h4><b>
                                {{-- <span id="assign_emp"></span> --}}
                        </div>
                        <div class="modal-footer">

                            <a class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                            <button type="submit" class="btn btn-danger" id="">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#submit').on('click', function(e) {
                // e.preventDefault(); // This prevents the default form submission behavior
                return false;
                // Your additional logic can go here
            });
        });
    </script>

    <script>
        function SelectWeekOffUpdate(context) {
            $('.updateUncheck').prop('checked', false);
            console.log(context.value);
            if (context.value == 1) {
                $('#updateSaturdayDescription').addClass('d-none');
                $('.updateUncheck').prop('disabled', true);
                $('.one').prop('disabled', false);
                $('.custom-control-input').prop('checked', false);
                $('.one').prop('required', true);

            } else if (context.value == 2) {
                $('#updateSaturdayDescription').addClass('d-none');

                $('.updateUncheck').prop('disabled', true);
                $('.two').prop('disabled', false);
                $('.two').prop('required', true);


            } else if (context.value == 3) {
                $('#updateSaturdayDescription').removeClass('d-none');

                $('.updateUncheck').prop('disabled', true);
                $('.one').prop('disabled', false);
                $('.one').prop('required', true);

            } else if (context.value == 4) {
                $('#updateSaturdayDescription').addClass('d-none');
                $('.two').prop('required', false);
                $('.one').prop('required', false);
                $('.updateUncheck').prop('disabled', false);
            }
        }

        function SelectWeekOff(context) {
            console.log(context.value);
            if (context.value == 1) {
                $('#SaturdayDescription').addClass('d-none');
                $('#firstWeekOff').removeClass('d-none');
                // $('.second').prop('disabled', false);

                $('.custom-control-input').prop('disabled', true);
                $('.onecreate').prop('disabled', false);
                $('.custom-control-input').prop('checked', false);
                $('.onecreate').prop('checked', true);
                $('.onecreate').prop('required', true);


            } else if (context.value == 2) {
                // Disable the checkbox
                $('#SaturdayDescription').addClass('d-none');
                $('#firstWeekOff').addClass('d-none');
                $('#firstWeekOff').removeClass('d-none');
                $('.second').prop('disabled', true);
                $('.custom-control-input').prop('checked', false);
                $('.twocreate').prop('checked', true);
                $('.twocreate').prop('required', true);
                $('.twocreate').prop('disabled', false);

            } else if (context.value == 3) {
                $('#SaturdayDescription').removeClass('d-none');
                $('#firstWeekOff').removeClass('d-none');
                $('.second').prop('disabled', false);
                $('.custom-control-input').prop('disabled', true);
                $('.custom-control-input').prop('checked', false);
                $('.onecreate').prop('checked', true);
                $('.onecreate').prop('required', true);
                $('.onecreate').prop('disabled', false);


            } else if (context.value == 4) {
                $('#SaturdayDescription').addClass('d-none');
                $('#firstWeekOff').removeClass('d-none');
                $('.second').prop('disabled', false);
                $('.first').prop('disabled', false);
                $('.twocreate').prop('disabled', false);
                $('.custom-control-input').prop('checked', false);
                $('.onecreate').prop('required', false);

            } else if (context.value == 0) {
                $('#SaturdayDescription').addClass('d-none');
                $('#firstWeekOff').addClass('d-none');
                $('#selectBox').prop('selectedIndex', 0);

            }
        }

        function openEditModel(context) {
            var id = $(context).data('id');
            $('#weekly_id').val(id);
            $.ajax({
                url: "{{ url('/admin/settings/business/all_weekly_holiday') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    holiday_weekly_id: id
                },
                dataType: 'json',
                success: function(result) {
                    if (result.get[0].days && result.get[0].name) {
                        $('#edit_weekname').val(result.get[0].name);
                        $('#edit_selectBox').val(result.get[0].weekend_policy);
                        if (result.get[0].weekend_policy == 1) {
                            $('#updateSaturdayDescription').addClass('d-none');
                            $('.updateUncheck').prop('disabled', true);
                            $('.one').prop('required', true);

                            // $('.one').prop('disabled', false);
                        } else if (result.get[0].weekend_policy == 2) {
                            $('#updateSaturdayDescription').addClass('d-none');
                            $('.updateUncheck').prop('disabled', true);
                            $('.two').prop('disabled', false);
                            $('.two').prop('required', true);

                        } else if (result.get[0].weekend_policy == 3) {
                            $('#updateSaturdayDescription').removeClass('d-none');
                            $('.updateUncheck').prop('disabled', true);
                            $('.one').prop('required', true);

                            $('.one').prop('disabled', false);
                        } else if (result.get[0].weekend_policy == 4) {
                            $('#updateSaturdayDescription').addClass('d-none');
                            $('.updateUncheck').prop('disabled', false);
                        }
                        var daysArray = JSON.parse(result.get[0].days);
                        console.log("Parsed daysArray:", daysArray); // Debugging statement
                        $('input[name="holidays[]"]').each(function() {
                            var checkboxValue = $(this).val();
                            if (daysArray.indexOf(checkboxValue) !== -1) {
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });
                    } else {
                        console.error("Invalid data structure in the response.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request error:", error);
                }

            });
        }

        function ItemDeleteModel(context) {
            var id = $(context).data('id');
            var name = $(context).data('weekly_name')
            $('#weekly_policy_id').val(id);
            $('#assign_emp').text(name);

        }
    </script>
@endsection
<!-- END Business Lavel MODAL  -->
