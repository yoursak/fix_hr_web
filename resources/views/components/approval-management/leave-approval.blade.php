<div class="row">
    <!-- This is Readerstacks Hello World Component -->
    <div id="p2" class="form-row form-group">
        <form action="{{ route('approval_submit') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row ">
                    <div class="col-xl-8">
                        <input type="text" name="load" value="2" hidden>
                    </div>
                    @php
                        $assignPermsisionOrNotValue = 0;
                    @endphp
                    @if (in_array('Approval Setup.Update', $permissions) && in_array('Approval Setup.Create', $permissions))
                        @php
                            $assignPermsisionOrNotValue = 1;
                        @endphp
                    @endif

                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-7 col-form-label"><b>Leave Approval Cycle
                                &nbsp;</b></label>
                        <div class="col-sm-5">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradiomonthl1"
                                    {{ $assignPermsisionOrNotValue == 1 ? '' : 'disabled' }} value="1" checked>
                                <label class="btn btn-outline-primary" for="btnradiomonthl1">Sequential
                                    {{-- (Chain) --}}
                                </label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradioyearl1"
                                    {{ $assignPermsisionOrNotValue == 1 ? '' : 'disabled' }} value="2">
                                <label class="btn btn-outline-primary" for="btnradioyearl1">
                                    Parallel {{-- Simultaneous --}}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="background: black" />
                <div class="row d-flex">
                    <div class="col-sm-10">

                        <h4 class="card-title"><span>Approval Category</span></h4>
                    </div>
                    <div class="col-sm-2 text-end">
                        @if (in_array('Approval Setup.Create', $permissions) && in_array('Approval Setup.Update', $permissions))
                            <button type="button" class="btn btn-sm btn-primary add_item_btnl1"><i
                                    class="fe fe-plus bold"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="row ">
                    <span id="show_item_l1">
                    </span>
                </div>
                <div>
                    <span class="text-danger d-none" id="DuplicateLeaveRoleCheck">Duplicate selections found.
                        Please remove duplicates.</span>
                </div>
            </div>
            @if (in_array('Approval Setup.Create', $permissions) && in_array('Approval Setup.Update', $permissions))
                <div class="text-center">
                    <button class="btn btn-primary" id="leaveApplyButton" type="submit">Apply</button>
                </div>
            @endif
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        var leave_id = 1;
        $(document).ready(function() {
            $(".add_item_btnl1").click(function(e) {
                // e.preventDefault();
                var selectInput =
                    '<select id="approval_select" name="approval_select[]" onchange="checkForLeaveDuplicates()" class="leave_duplicate_check form-select" required><option class="text-muted" value="" disabled selected required>Select Role</option>';
                <?php foreach ($adminRoleList as $loop) : ?>
                selectInput += `<option value="<?php echo $loop->id; ?>"><?php echo $loop->roles_name; ?></option>`;
                <?php endforeach; ?>
                selectInput += '</select>';
                $("#show_item_l1").append(
                    `<div class="row mt-2">    
                    <div class="col-xl-3 d-flex align-items-center" id=""> 
                        <label for="inputCity" class="form-label">Select Role</label> 
                    </div>
                    <div class="col-xl-7">    
                        ${selectInput}
                    </div>
                    <?php if(in_array('Approval Setup.All', $permissions) && in_array('Approval Setup.All', $permissions) ){ ?>                
                        <div class="mt-xl-0 mt-2 col-xl-2 text-end"> 
                        <button type="button" class="btn btn-sm btn-danger remove_item_btnl1"><i class="feather feather-trash"></i></button>  
                    </div> 
                    <?php  } ?>

                </div>`
                );

                leave_id++;

            });

            $(document).on('click', '.remove_item_btnl1', function(e) {
                // e.preventDefault();
                let row_item = $(this).parent().parent();
                console.log(row_item);
                $(row_item).remove();
            });
            $('#leaveApplyButton').click(function() {
                // Get all selected values from the select boxes
                var selectedValues = $('.leave_duplicate_check').map(function() {
                    return $(this).val();
                }).get();
                // Check for duplicates
                var hasDuplicates = new Set(selectedValues).size !== selectedValues.length;

                if (hasDuplicates) {
                    $('#DuplicateLeaveRoleCheck').removeClass('d-none');
                    alert('Duplicate selections found. Please remove duplicates.');
                    return false; // Prevent the form from submitting
                } else {
                    $('#DuplicateLeaveRoleCheck').addClass('d-none');
                }
            });

            // Function to check for duplicates
            function checkForLeaveDuplicates() {
                var selectedValues = $('.leave_duplicate_check').map(function() {
                    return $(this).val();
                }).get();

                // Check for duplicates
                var hasDuplicates = new Set(selectedValues).size !== selectedValues.length;

                if (hasDuplicates) {
                    $('#DuplicateLeaveRoleCheck').removeClass('d-none');
                } else {
                    $('#DuplicateLeaveRoleCheck').addClass('d-none');
                }
            }

            // Initial check for duplicates
            checkForLeaveDuplicates();
        });

        $(document).ready(function() {

            $.ajax({
                url: '{{ url('/Role-permission/approval_get_set/2') }}', // Replace with your API endpoint URL
                method: 'GET',
                dataType: 'json',
                success: function(get) {
                    var cycleType = get.data.cycle_type; // Get the value from your data

                    // Check the radio button based on the cycleType value
                    if (cycleType === 1) {
                        $('#btnradiomonthl1').prop('checked', true);
                    } else if (cycleType === 2) {
                        $('#btnradioyearl1').prop('checked', true);
                    }

                    // Attach a change event to handle radio button changes
                    $('.btn-check').change(function() {
                        var selectedValue = $('input[name="btnradio"]:checked').val();
                        console.log("Selected Value: " + selectedValue);
                        // You can perform actions based on the selected radio button value here
                    });
                    if (get.data.approval_type_id == 2) {
                        var roleIds = JSON.parse(get.data.role_id);

                        // Loop through the roleIds
                        roleIds.forEach(function(roleId) {
                            var container = $('<div class="">');

                            // Create a select input element
                            var selectInput =
                                '<select id="approval_select" name="approval_select[]" onchange="checkForLeaveDuplicates()" class="leave_duplicate_check form-select" required  <?php echo $assignPermsisionOrNotValue == 1 ? '' : 'disabled'; ?> ><option value="" disabled selected>Select Role</option>';
                            // Loop through the adminRoleList and add options based on a condition
                            <?php foreach ($adminRoleList as $loop) : ?>
                            if (<?php echo $loop->id; ?> == roleId) {
                                selectInput +=
                                    `<option value="<?php echo $loop->id; ?>" selected><?php echo $loop->roles_name; ?></option>`;
                            } else {
                                selectInput +=
                                    `<option value="<?php echo $loop->id; ?>"><?php echo $loop->roles_name; ?></option>`;
                            }
                            <?php endforeach; ?>

                            selectInput += '</select>';
                            container.append(
                                `<div class="row mt-2">    
                        <div class="col-xl-3 d-flex align-items-center" id=""> 
                            <label for="inputCity" class="form-label">Select Role</label> 
                        </div>
                        <div class="col-xl-7">
                            ${selectInput}
                        </div>
                        <?php if(in_array('Approval Setup.Delete', $permissions) || in_array('Approval Setup.All', $permissions)){ ?>                
                        <div class="mt-xl-0 mt-2 col-xl-2 text-end"> 
                            <button type="button" class="btn btn-sm btn-danger remove_item_btnl1"><i class="feather feather-trash"></i></button>  
                        </div> 
                        <?php  } ?>
                    </div>`
                            );

                            // Append the container to the desired element
                            $("#show_item_l1").append(container);
                        });
                    }

                },
                error: function(error) {
                    // Handle the error, e.g., display an error message
                }
            });
        });
    </script>
    <script>
        function checkForLeaveDuplicates() {
            var selectedValues = $('.leave_duplicate_check').map(function() {
                return $(this).val();
            }).get();

            // Check for duplicates
            var hasDuplicates = new Set(selectedValues).size !== selectedValues.length;

            if (hasDuplicates) {
                $('#DuplicateLeaveRoleCheck').removeClass('d-none');
                $('#leaveApplyButton').prop('disabled', true);
            } else {
                $('#DuplicateLeaveRoleCheck').addClass('d-none');
                $('#leaveApplyButton').prop('disabled', false);
            }
        }
    </script>
</div>
