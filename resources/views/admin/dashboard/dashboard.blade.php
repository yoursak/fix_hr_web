@extends('admin.layout.master')
@section('title')
Dashboard
@endsection
@section('contents')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="page-header d-md-flex d-block">
                        <div class="page-leftheader">
                            <div class="page-title">Attendance</div>
                        </div>
                        <div class="page-rightheader ms-md-auto">
                            <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                                <div class="d-flex">
                                    <div class="header-datepicker me-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend ">
                                                <div class="input-group-text d-none d-xl-block">
                                                    <i class="feather feather-calendar"></i>
                                                </div>
                                            </div><input class="form-control fc-datepicker" placeholder="19 Feb 2020"
                                                type="text">
                                        </div>
                                    </div>
                                    <div class="header-datepicker me-3 d-none d-md-block">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text d-none d-xl-block">
                                                    <i class="feather feather-clock"></i>
                                                </div>
                                            </div><!-- input-group-prepend -->
                                            <input id="tpBasic" type="text" placeholder="09:30am"
                                                class="form-control input-small">
                                        </div>
                                    </div><!-- wd-150 -->
                                </div>
                                <div class="d-lg-flex d-block">
                                    <div class="btn-list">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#clockinmodal">Attendance Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="card att">
                                    <div class="card-body">
                                        <div class="mt-0 text-center"> <span
                                                class="fs-18 font-weight-semibold">Present</span>
                                            <h5 class="mb-0 mt-1 mb-2">78</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="card att">
                                    <div class="card-body">
                                        <div class="mt-0 text-center"> <span
                                                class="fs-18 font-weight-semibold">Absent</span>
                                            <h5 class="mb-0 mt-1 mb-2">4</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="card att">
                                    <div class="card-body">
                                        <div class="mt-0 text-center"> <span class="fs-18 font-weight-semibold">Half
                                                Day</span>
                                            <h5 class="mb-0 mt-1  mb-2">2</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="card att">
                                    <div class="card-body">
                                        <div class="mt-0 text-center"> <span class="fs-18 font-weight-semibold">Weekly
                                                Off</span>
                                            <h5 class="mb-0 mt-1 mb-2">8</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="card att">
                                    <div class="card-body">
                                        <div class="mt-0 text-center"> <span
                                                class="fs-18 font-weight-semibold">Leaves</span>
                                            <h5 class="mb-0 mt-1 mb-2">6</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="card att">
                                    <div class="card-body">
                                        <div class="mt-0 text-center"> <span
                                                class="fs-18 font-weight-semibold">Holiday</span>
                                            <h5 class="mb-0 mt-1 mb-2">4</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="card att">
                                    <div class="card-body">
                                        <div class="mt-0 text-center"> <span
                                                class="fs-18 font-weight-semibold">Overtime</span>
                                            <h5 class="mb-0 mt-1  mb-2">53</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="card att">
                                    <div class="card-body">
                                        <div class="mt-0 text-center"> <span class="fs-18 font-weight-semibold">Miss
                                                Punch</span>
                                            <h5 class="mb-0 mt-1 mb-2">8</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="row">
                <div class="col-xl-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom-0">
                            <div class="card-title">
                                Thinks To Do
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-transparent mb-0 mail-inbox">
                                <a  href="#" class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                    <div class="spinner1">
                                        <div class="double-bounce1 bg-danger"></div>
                                        <div class="double-bounce2 bg-danger"></div>
                                    </div>
                                      <b>Manage Attendance</b>
                                      <span class="ms-auto badge bg-primary">12</span>
                                </a>
                                <a  href="#" class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                    <div class="spinner1">
                                        <div class="double-bounce1 bg-success"></div>
                                        <div class="double-bounce2 bg-success"></div>
                                    </div>
                                    </span> <b>Manage Miss Punch</b> <span class="ms-auto badge bg-success">12</span>
                                </a>
                                <a  href="#" class="list-group-item list-group-item-action d-flex align-items-center px-0 py-2">
                                    <div class="spinner1">
                                        <div class="double-bounce1 bg-success"></div>
                                        <div class="double-bounce2 bg-success"></div>
                                    </div>
                                    </span> <b>Manage Leaves</b> <span class="ms-auto badge bg-secondary">2</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-md-6 col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="card-header border-bottom-0">
                            <h3 class="card-title">Wish Birthday</h3>
                            <div class="card-options">
                                <a  href="javascript:void(0);" class="card-options-collapse me-2" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a  href="javascript:void(0);" class="card-options-remove" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
                            </div>
                        </div>
                        <div class="card-body ">
                            <p>Today is <b>User's</b> Birthday.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header border-bottom-0">
                <div class="card-title">
                    Employee Summary
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table  table-vcenter text-nowrap table-bordered border-bottom table-striped"
                        id="hr-attendance1">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center border-bottom-0">Action</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Emp ID</th>
                                <th rowspan="2" class="border-bottom-0 ">Employee</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Present</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Absent</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Half Days</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Paid Leave</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Miss Punch</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Overtime</th>
                                <th rowspan="2" class="text-center border-bottom-0 ">Total Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <div class="btn btn-light btn-icon btn-sm" id="calenderbtn"
                                        data-bs-toggle="tooltip" data-original-title="View">
                                        <i class="feather feather-eye"></i>
                                    </div>
                                </td>
                                <td>FD22311</td>
                                <td>
                                    <div class="d-flex">
                                        <span class="avatar avatar brround me-3"
                                            style="background-image: url(imgs/user.png)"></span>
                                        <div class="me-3 mt-0 mt-sm-2 d-block">
                                            <h6 class="mb-1 fs-14">Aman Sahu</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">5</td>
                                <td class="text-center">2</td>
                                <td class="text-center">1</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">5</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive hr-attlist d-none" id="calendertbl">
                    <table class="table  table-vcenter text-nowrap table-bordered border-bottom" id="hr-attendance">
                        <thead>
                            <tr>
                                <div class="text-center d-flex justify-content-around">
                                    <span><b><</b></span>
                                    <span><b>July 2023</b></span>
                                    <span><b>></b></span>
                                </div>
                            </tr>
                            <tr>
                                <th class="text-DARK">DAYS</th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>1</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>2</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>M</p>
                                        <p class='fs-12'>3</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>T</p>
                                        <p class='fs-12'>4</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>W</p>
                                        <p class='fs-12'>5</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>T</p>
                                        <p class='fs-12'>6</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>F</p>
                                        <p class='fs-12'>7</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>8</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>9</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>M</p>
                                        <p class='fs-12'>10</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>T</p>
                                        <p class='fs-12'>11</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>W</p>
                                        <p class='fs-12'>12</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>T</p>
                                        <p class='fs-12'>13</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>F</p>
                                        <p class='fs-12'>14</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>15</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>16</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>M</p>
                                        <p class='fs-12'>17</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>T</p>
                                        <p class='fs-12'>18</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>W</p>
                                        <p class='fs-12'>19</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>T</p>
                                        <p class='fs-12'>20</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>F</p>
                                        <p class='fs-12'>21</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>22</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>23</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>M</p>
                                        <p class='fs-12'>24</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>T</p>
                                        <p class='fs-12'>25</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>W</p>
                                        <p class='fs-12'>26</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>T</p>
                                        <p class='fs-12'>27</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>F</p>
                                        <p class='fs-12'>28</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>29</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>S</p>
                                        <p class='fs-12'>30</p>
                                    </div>
                                </th>
                                <th class="text-muted font-weight-normal">
                                    <div>
                                        <p class='fs-12'>M</p>
                                        <p class='fs-12'>31</p>
                                    </div>
                                </th>
                                <th class="text-dark">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span></span></td>
                                <td>
                                    <p class="fs-12 font-weight-bold">P</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">WO</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">P</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">P</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">A</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">A</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">A</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">P</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                                <td>
                                    <p class="fs-12 font-weight-bold">-</p>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-DARK">WH</th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">08:49</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">08:39</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">09:19</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">10:00</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">10:19</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-muted font-weight-light">
                                    <p class="fs-12">-</p>
                                </th>
                                <th class="text-dark">
                                    <b>45:50</b>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">Staff Payment Summary</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable" class="table key-buttons">
                            <tbody>
                                <tr class="d-flex justify-content-between">
                                    <td>Actual Salary</td>
                                    <td>$125,250</td>
                                </tr>
                                <tr class="d-flex justify-content-between">
                                    <td>Adjustments</td>
                                    <td>$125,250</td>
                                </tr>
                                <tr class="d-flex justify-content-between">
                                    <td>Net Pay</td>
                                    <td>$125,250</td>
                                </tr>
                                <tr class="d-flex justify-content-between">
                                    <td>Gross Salary</td>
                                    <td>$125,250</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-bottom-0">
                    <h3 class="card-title">Statutory Expenses</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="file-datatable" class="table text-nowrap key-buttons">
                            <thead>
                                <tr>
                                    <th class="border-bottom-1">Type</th>
                                    <th class="border-bottom-1">Employee</th>
                                    <th class="border-bottom-1">Employer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>PF</td>
                                    <td>Zenaida Frank</td>
                                    <td>Fixing Dots</td>
                                </tr>
                                <tr>
                                    <td>ESIC</td>
                                    <td>Zenaida Frank</td>
                                    <td>Fixing Dots</td>
                                </tr>
                                <tr>
                                    <td>LWF</td>
                                    <td>Zenaida Frank</td>
                                    <td>Fixing Dots</td>
                                </tr>
                                <tr>
                                    <td>Professional Taxes</td>
                                    <td>Zenaida Frank</td>
                                    <td>Fixing Dots</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
