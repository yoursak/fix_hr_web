<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Personal Details</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        /* Apply styles for the table */
        .table-container {
            margin: 0 auto;
            font-size: 12px;
            /* Center the table horizontally */
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            /* Ensure table fills its container */
            /* Collapse the borders */
        }

        /* Example border styles for table headers and data cells */
        .table th,
        .table td {
            border: 1px solid #000;
            /* Set border for cells */
            padding: 5px;
            /* Add padding to cells */
            text-align: center;
            /* Align text in cells */
        }

        /* Example style for removing bottom border from table header */
        .table th.border-bottom-0 {
            border-bottom: 0;
        }

        .row {
            display: flex;
        }

        .container.photo {
            flex: 0 0 auto;
            /* Prevent photo from growing */
            width: 50px;
            /* Adjust width as needed */
            /* Additional photo styles */
        }

        .d-flex {
            display: flex;
            align-items: center;
            /* Align items vertically */
            justify-content: flex-start;
            /* Align content to the start (left side) */
        }


        /* .content {
            margin-left: 80px;
        }
        /* Adjust margin as needed for spacing */

        .custom-table {
            border-collapse: collapse;
            /* Merge table borders */
        }

        .custom-table th,
        .custom-table td {
            text-align: left;
            border: none;
            /* Remove borders from table cells */
        }
    </style>
</head>

<body>
    <?php $rulemode = new App\Helpers\MasterRulesManagement\RulesManagement(); ?>
    <br>

    <div class="table-container">

        @foreach ($category as $modelBG)
            <table id="myTable" class="table">
                <thead>
                    <th colspan="7">{{ $modelBG->name }} {{ $date }}</th>
                </thead>

                <thead>
                    <tr>
                        <th class="border-bottom-0">Employee Name</th>
                        <th class="border-bottom-0"> Employee ID</th>
                        <th class="border-bottom-0"> Employee DOJ</th>
                        <th class="border-bottom-0">Leave Opening</th>
                        <th class="border-bottom-0">Leave Allotted</th>
                        <th class="border-bottom-0">Leave Taken</th>
                        <th class="border-bottom-0">Leave Remaining</th>
                        {{-- <th class="border-bottom-0">Year</th> --}}
                    </tr>
                </thead>

                <tbody class="my_body">
                    @foreach ($Emp as $item)
                        @php

                            $mode = $rulemode->LeaveManagementProviderDynamicTable($modelBG->id, $item->business_id, $item->emp_id, 0);
                        @endphp
                        <tr>
                            <td> {{ $item->emp_name . ' ' . $item->emp_mname . ' ' . $item->emp_lname }} <br>
                            </td>
                            <td>{{ $item->emp_id }}
                            </td>
                            <td> {{ \Carbon\Carbon::parse($item->emp_date_of_joining)->format('d-m-Y') }} </td>
                            <td>
                                <?= $mode[0] ?>
                            </td>
                            <td>
                                <?= $mode[1] ?>
                            </td>
                            <td>
                                <?= $mode[2] ?>
                            </td>
                            <td>
                                <?= $mode[3] ?>
                            </td>
                            {{-- 
                        <td>
                            {{ \Carbon\Carbon::parse($mode[4])->format('Y-m') }}
                            {{ \Carbon\Carbon::parse($mode[5])->format('Y-m') }}
                        </td> --}}

                        </tr>
                    @endforeach


                </tbody>
            </table>
            <div class="page-break"></div>
        @endforeach
        <table id="myTable" class="table">
            <thead>
                <th colspan="7">{{ 'LWP' }} {{ $date }}</th>
            </thead>

            <thead>
                <tr>
                    <th class="border-bottom-0">Employee Name</th>
                    <th class="border-bottom-0"> Employee ID</th>
                    <th class="border-bottom-0"> Employee DOJ</th>
                    <th class="border-bottom-0">Leave Opening</th>
                    <th class="border-bottom-0">Leave Allotted</th>
                    <th class="border-bottom-0">Leave Taken</th>
                    <th class="border-bottom-0">Leave Remaining</th>
                    {{-- <th class="border-bottom-0">Year</th> --}}
                </tr>
            </thead>

            <tbody class="my_body">
                @foreach ($Emp as $item)
                    @php

                        $mode = $rulemode->LeaveManagementProviderDynamicTable(8, $item->business_id, $item->emp_id, 0);
                    @endphp
                    <tr>
                        <td> {{ $item->emp_name . ' ' . $item->emp_mname . ' ' . $item->emp_lname }} <br>
                        </td>
                        <td>{{ $item->emp_id }}
                        </td>
                        <td> {{ \Carbon\Carbon::parse($item->emp_date_of_joining)->format('d-m-Y') }} </td>
                        <td>
                            <?= $mode[0] ?>
                        </td>
                        <td>
                            <?= $mode[1] ?>
                        </td>
                        <td>
                            <?= $mode[2] ?>
                        </td>
                        <td>
                            <?= $mode[3] ?>
                        </td>
                        {{-- 
                    <td>
                        {{ \Carbon\Carbon::parse($mode[4])->format('Y-m') }}
                        {{ \Carbon\Carbon::parse($mode[5])->format('Y-m') }}
                    </td> --}}

                    </tr>
                @endforeach


            </tbody>
        </table>
        <div class="page-break"></div>
        <table id="myTable" class="table">
            <thead>
                <th colspan="7">{{ 'Comp-Off' }} {{ $date }}</th>
            </thead>

            <thead>
                <tr>
                    <th class="border-bottom-0">Employee Name</th>
                    <th class="border-bottom-0"> Employee ID</th>
                    <th class="border-bottom-0"> Employee DOJ</th>
                    <th class="border-bottom-0">Leave Opening</th>
                    <th class="border-bottom-0">Leave Allotted</th>
                    <th class="border-bottom-0">Leave Taken</th>
                    <th class="border-bottom-0">Leave Remaining</th>
                    {{-- <th class="border-bottom-0">Year</th> --}}
                </tr>
            </thead>

            <tbody class="my_body">
                @foreach ($Emp as $item)
                    @php

                        $mode = $rulemode->LeaveManagementProviderDynamicTable(9, $item->business_id, $item->emp_id, 0);
                    @endphp
                    <tr>
                        <td> {{ $item->emp_name . ' ' . $item->emp_mname . ' ' . $item->emp_lname }} <br>
                        </td>
                        <td>{{ $item->emp_id }}
                        </td>
                        <td> {{ \Carbon\Carbon::parse($item->emp_date_of_joining)->format('d-m-Y') }} </td>
                        <td>
                            <?= $mode[0] ?>
                        </td>
                        <td>
                            <?= $mode[1] ?>
                        </td>
                        <td>
                            <?= $mode[2] ?>
                        </td>
                        <td>
                            <?= $mode[3] ?>
                        </td>
                        {{-- 
                    <td>
                        {{ \Carbon\Carbon::parse($mode[4])->format('Y-m') }}
                        {{ \Carbon\Carbon::parse($mode[5])->format('Y-m') }}
                    </td> --}}

                    </tr>
                @endforeach


            </tbody>
        </table>

    </div>

    <div class="footer margin-top">
        <br>
        <div>Thank you</div>
        <div>&copy;<b>FixHR</b> </div>
    </div>
</body>

</html>
