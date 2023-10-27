<div>
    <!-- This is Readerstacks Hello World Component -->

    <div class="form-group form-row">
        <form action="{{ route('approval_submit') }}" method="POST">
            @csrf
            <div class="modal-body">

                <div class="row ">
                    <div class="col-xl-8">
                        <h4 class="card-title"><span>Attendance Approval </span></h4>
                    </div>

                    <div class="form-group row m-4">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Approval Cycle</label>
                        <div class="col-sm-5">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradiomonth"
                                    value="1" checked>
                                <label class="btn btn-outline-primary" for="btnradiomonth">Sequential
                                    {{-- (Chain) --}}
                                </label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradioyear"
                                    value="2">
                                <label class="btn btn-outline-primary" for="btnradioyear">
                                    Parallel {{-- Simultaneous  --}}
                                </label>
                            </div>
                        </div>
                    </div>

                </div>

                <hr style="background: black" />
                <h4 class="card-title"><span>Approval Category</span></h4>
                <div class="text-end">

                    <button type="button" class="btn btn-outline-primary add_item_btn"><i class="fe fe-plus bold"></i>
                    </button>
                </div>
                <div class="row ">
                    <span id="show_item">

                    </span>

                </div>

            </div>

            <div class="text-center">
                <button class="btn btn-success" type="submit">Apply</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <?php
    
    //    dd($BranchList);
    ?>
    <script>
        var leave_id = 1;
        $(document).ready(function() {
            $(".add_item_btn").click(function(e) {

                // e.preventDefault();
                // var categoryname = $('.btnradio').val();

                // console.log(categoryname);
                var selectInput =
                    '<select id="approval_select" name="approval_select[]" class="form-select">';
                <?php foreach ($adminRoleList as $loop) : ?>
                selectInput += `<option value="<?php echo $loop->id; ?>"><?php echo $loop->roles_name; ?></option>`;
                <?php endforeach; ?>
                selectInput += '</select>';

                // var branch_list =
                //     '<select id="approval_select" name="approval_select[]" class="form-select">';
                // <?php foreach ($BranchList as $loop) : ?>
                // branch_list += `<option value="<?php echo $loop->branch_id; ?>"><?php echo $loop->branch_name; ?></option>`;
                // <?php endforeach; ?>
                // branch_list += '</select>';
                //     <div class="card-body col-xl-8 pt-3" id=""> 
                // <label for="inputCity" class="form-label">Select Branch</label> 
                //     ${branch_list}
                // </div>
                $("#show_item").append(
                    `<div class="row">    
                <div class="card-body col-xl-8 pt-3" id=""> 
                    <label for="inputCity" class="form-label">Select Role</label> 
                    ${selectInput}
                </div>
                <div class="col-xl-2 pt-3"> 
                </div>
                <div class="col-xl-2 pt-3 text-end"> 
                    <label for="inputCity" class="form-label ">&nbsp;</label> 
                    <button type="button" class="btn btn-outline-danger remove_item_btn"><i class="feather feather-trash"></i></button>  
                </div> 
            </div>`
                );

                leave_id++;

            });

            $(document).on('click', '.remove_item_btn', function(e) {
                // e.preventDefault();
                let row_item = $(this).parent().parent();
                console.log(row_item);
                $(row_item).remove();
            })
            // $('#submit').click(function() {
            //     var isValid = true; // Flag to track if all fields are valid
            //     // Loop through each added item
            //     $('#show_item').each(function(index, element) {
            //         var categoryName = $(this).find('input[name="approval_select[]"]').val();

            //         // // Validate each field
            //         if (categoryName ?? false) {
            //             isValid = false; // Set the flag to false if any field is empty
            //             return false; // Exit the loop
            //         }
            //     });
            //     if (!isValid) {
            //         // Show an alert if any field is empty
            //         Swal.fire({
            //             title: 'Empty Fields',
            //             text: 'Please fill in all fields for each item before submitting.',
            //             icon: 'error',
            //         });
            //         return false; // Prevent form submission
            //     }

            //     // $.ajax({
            //     //     url: postURL,
            //     //     method: "POST",
            //     //     data: $('#add_item_btn').serialize(),
            //     //     type: 'json',
            //     //     // dd(data);
            //     //     success: function(data) {
            //     //         console.log(data);
            //     //         // if (data.error) {
            //     //         //     // Handle error if needed
            //     //         //     return Hello;
            //     //         // } else {
            //     //         //     // Handle success if needed
            //     //         //     i = 1;
            //     //         //     $('.dynamic-added').remove();
            //     //         //     $('#remove_item_btn')[0].reset();
            //     //         // }

            //     //     }
            //     // });
            // });
        });
    </script>
</div>
