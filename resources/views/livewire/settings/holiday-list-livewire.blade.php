<div>
    @php
        $centralUnit = new App\Helpers\Central_unit();
    @endphp
    <div class="card-body">
        <div class="table-responsive">
            <table class="table  table-vcenter text-nowrap  tabel-border-bottom " id="basic-datatable">
                <thead>
                    <tr>
                        <th class="border-bottom-0 w-10">S.No.</th>
                        <th class="border-bottom-0">Holiday Policy Name</th>
                        <th class="border-bottom-0">Numbers of Holiday</th>
                        <th class="border-bottom-0"></th>
                        <th class="border-bottom-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $j = 1;
                    @endphp
                    @foreach ($HolidayTemplate as $item)
                        <tr>
                            <td class="font-weight-semibold">{{ $j++ }}.</td>
                            <td class="font-weight-semibold">{{ $item->temp_name }}</td>
                            <td class="font-weight-semibold"><?php
                            $load = $centralUnit->GetPolicysCount($item->temp_id);
                            $ll = $load[0];
                            echo $ll;
                            ?>
                                <span>Days</span>
                            </td>
                            <td class="font-weight-semibold"><span class="fs-11 fw-bold">W.E.F. </span><span class="with-effect-from-badge">{{date('d-M-Y h:i A',strtotime($item->updated_at))}}</span></td>
                            <td>
                                @php
                                    $masterendgame = 0;
                                @endphp
                                @foreach ($masterEndAssignCheck as $checkmaster)
                                    @if ($checkmaster->holiday_policy_ids_list == $item->temp_id)
                                        @php
                                            $masterendgame = 1;
                                            break;
                                        @endphp
                                    @endif
                                @endforeach
                                @if (in_array('Holiday Settings.Update', $permissions))
                                    <button class="btn action-btns  btn-primary btn-icon btn-sm"
                                        href="javascript:void(0);" {{ $masterendgame == 1 ? 'disabled' : '' }}
                                        onclick="openEditModel(this)" data-temp_id='<?= $item->temp_id ?>'
                                        data-temp_name='<?= $item->temp_name ?>'
                                        data-temp_from='<?= $item->temp_from ?>'
                                        data-temp_to='<?= $item->temp_to ?>'
                                        data-business_id='<?= $item->business_id ?>'>
                                        <i class="feather feather-edit" data-bs-toggle="tooltip"
                                            data-original-title="View/Edit"></i>
                                    </button>
                                @endif
                                @if (in_array('Holiday Settings.View', $permissions))
                                    <a class="btn action-btns  btn-primary btn-icon btn-sm"
                                        href="javascript:void(0);" onclick="openViewModel(this)"
                                        data-temp_id='<?= $item->temp_id ?>'
                                        data-temp_name='<?= $item->temp_name ?>'
                                        data-temp_from='<?= $item->temp_from ?>'
                                        data-temp_to='<?= $item->temp_to ?>'
                                        data-business_id='<?= $item->business_id ?>'>
                                        <i class="feather feather-eye" data-bs-toggle="tooltip"
                                            data-original-title="View/Edit"></i>
                                    </a>
                                @endif
                                @if (in_array('Holiday Settings.Delete', $permissions))
                                    <a class="btn action-btns  btn-danger btn-icon btn-sm"
                                        href="javascript:void(0);" onclick="ItemDeleteModel(this)"
                                        data-id='<?= $item->temp_id ?>' data-temp_name='<?= $item->temp_name ?>'
                                        data-bs-toggle="modal" data-bs-target="#editDeleteModel"><i
                                            class="feather feather-trash"></i>
                                    </a>
                                @endif
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

                {!! $HolidayTemplate->links() !!}
            </div>
        </div>
    </div>
</div>
