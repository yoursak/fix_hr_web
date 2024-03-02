@php
    $Central = new App\Helpers\Central_unit();
@endphp
<div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap  border-bottom " id="basic-datatable">
                <thead>
                    <tr>
                        <th class="border-bottom-0 w-10">S.No.</th>
                        <th class="border-bottom-0">Policy Name</th>
                        <th class="border-bottom-0">Policy Cycle</th>
                        <th class="border-bottom-0">Leave | Applied To</th>
                        <th class="border-bottom-0"></th>
                        <th class="border-bottom-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $j = 1;
                    @endphp
                    @foreach ($leavePolicy as $item)
                    <tr>
                        <td class="font-weight-semibold">{{ $j++ }}.</td>
                        <td class="font-weight-semibold">{{ $item->policy_name }}</td>
                        <td class="font-weight-semibold">
                            @foreach ($Central->LeavePolicyCategory($item->id) as $check)
                            <div class="row">
                                <div class="tags">
                                    <span class="tag tag-rounded">
                                        {{ $check->leave_cycle_monthly_yearly == 1 ? 'Monthly' : 'Yearly' }}
                                        &nbsp;
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </td>
                        <td class="font-weight-semibold">
                            @foreach ($Central->LeavePolicyCategory($item->id) as $check)
                            <div class="row">
                                <div class="tags">
                                    <span class="tag tag-rounded"> {{ $check->static_category_name }} &nbsp;
                                    </span>
                                    <span class="tag tag-rounded">
                                        {{ $check->static_leave_category_applicable_name }}
                                    </span>

                                </div>
                            </div>
                            @endforeach
                        </td>
                        <td><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($item->updated_at))}}</span></td>
                        @php
                        $masterendgame = 0;
                        @endphp
                        <td>

                            @foreach ($getleavepolicy as $dataaa)
                            @if ($item->id == $dataaa->leave_policy_ids_list)
                            @php
                            $masterendgame = 1;
                            break; // Break out of the loop once a match is found
                            @endphp
                            @endif
                            @endforeach

                            <button class="btn action-btns  btn-primary btn-icon btn-sm" href="javascript:void(0);" {{ $masterendgame == 1 ? 'disabled' : '' }} onclick="openEditModel(this)" data-id='<?= $item->id ?>' data-policy_name='<?= $item->policy_name ?>' data-sandwich_leaves_count='<?= $item->sandwich_leaves_count ?>' data-sandwich_leaves_ignore='<?= $item->sandwich_leaves_ignore ?>' data-leave_policy_cycle_monthly='<?= $item->leave_policy_cycle_monthly ?>' data-leave_policy_cycle_yearly='<?= $item->leave_policy_cycle_yearly ?>' data-leave_period_from='<?= $item->leave_period_from ?>' data-leave_period_to='<?= $item->leave_period_to ?>' data-bs-toggle="modal" data-bs-target="#showmodal">
                                <i class="feather feather-edit" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                            </button>
                            <a class="btn action-btns  btn-primary btn-icon btn-sm" href="javascript:void(0);" onclick="openViewModel(this)" data-id='<?= $item->id ?>' data-policy_name='<?= $item->policy_name ?>' data-sandwich_leaves_count='<?= $item->sandwich_leaves_count ?>' data-sandwich_leaves_ignore='<?= $item->sandwich_leaves_ignore ?>' data-leave_policy_cycle_monthly='<?= $item->leave_policy_cycle_monthly ?>' data-leave_policy_cycle_yearly='<?= $item->leave_policy_cycle_yearly ?>' data-leave_period_from='<?= $item->leave_period_from ?>' data-leave_period_to='<?= $item->leave_period_to ?>' data-bs-toggle="modal" data-bs-target="#viewshowmodal">
                                <i class="feather feather-eye" data-bs-toggle="tooltip" data-original-title="View/Edit"></i>
                            </a>
                            <button id="deleteButton" class="btn action-btns  btn-danger btn-icon btn-sm" data-toggle="modal" onclick="ItemDeleteModel(this)" data-id='<?= $item->id ?>' data-policy_name='<?= $item->policy_name ?>' data-target="#deleteModal" data-id="1"><i class="feather feather-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between">
            <div>
                <label for="perPage">Per Page:</label>

                <div class="form-group mb-3" x-data="{ isOpen: false }" x-on:click.away="isOpen = false">
                    <div class="input-group">
                        <select wire:model.debounce.350ms="perPage" class="form-control"
                            x-on:focus="isOpen = true" x-on:blur="isOpen = false">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i x-show="isOpen" class="fa fa-caret-up"></i>
                                <i x-show="!isOpen" class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>

                {!! $leavePolicy->links() !!}
            </div>
        </div>
    </div>
</div>
