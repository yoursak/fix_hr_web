<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Personal Details</title>
    <style>
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

        */ .custom-table {
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
    <div class="container photo">
        <img src="business_logo/{{ $OtherData[0]->business_logo }}" alt="" srcset="" width="90px" height="70px">
    </div>
    <div class="content">
        <h4>{{ $OtherData[0]->business_name }}</h4>
        <small>Date: {{ date('d-m-Y') }}</small>
        <br>
        <small>Employee Details</small>
        <br>
        <small>Branch:
            <?= $OtherData[4] != null ? $OtherData[4] : 'All' ?>
        </small>
    </div>

    <br>

    <div class="table-container">
        <table id="myTable" class="table">
            <thead>

                <tr>
                    <th class="border-bottom-0">S. No.</th>
                    <th class="border-bottom-0">Employee Name</th>
                    <th class="border-bottom-0"> Employee ID</th>
                    <th class="border-bottom-0">Branch</th>
                    <th class="border-bottom-0">Department</th>
                    <th class="border-bottom-0">DOJ</th>
                    <th class="border-bottom-0">Mobile No.</th>
                    <th class="border-bottom-0">Active/In-Active</th>


                </tr>
            </thead>
            @php
            $count = 1;
            @endphp
            <tbody class="my_body">
                {{-- {{ dd($data) }} --}}
                @foreach ($data as $item)
                <tr>
                    <td>{{ $count++ }}
                    </td>
                    <td>
                        {{ $item->first_name . ' ' . $item->middle_name . ' ' . $item->last_name }} <br>
                        <p style="font-size: 10px;"> {{ $item->desig_name }}</p>
                    </td>
                    <td>{{ $item->emp_id }}
                    </td>

                    <td>{{ $item->branch_name }}</td>
                    <td>{{ $item->depart_name }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($item->doj)->format('d-m-Y') }}</td>

                    <td>{{ $item->mobile_no }}
                    </td>
                    <td>{{ $item->active }}
                    </td>



                </tr>
                @endforeach
                <tr>
                    <td colspan="8">Total No. of Employee :
                        <?= $OtherData[1] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Active :
                        <?= $OtherData[2] ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In-Active :
                        <?= $OtherData[3] ?>

                    </td>
                </tr>
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