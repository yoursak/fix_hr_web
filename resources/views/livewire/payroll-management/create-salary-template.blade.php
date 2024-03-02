<div>
    @php
        $centralUnit = new App\Helpers\Central_unit();
        $LOADED = new App\Helpers\MasterRulesManagement\RulesManagement();
        $Department = $centralUnit->DepartmentList();
        $Branch = $centralUnit->BranchList();
        $Employee = $centralUnit->EmployeeDetails();
        $nss = new App\Helpers\Central_unit();
        $EmpID = $nss->EmpPlaceHolder();
        $ITEM = $LOADED->SectionEmployeeCounters();
        //dd($ITEM);
        $Designation = $centralUnit->DesignationList();
    @endphp
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('admin/settings/payroll/salary_template') }}">Salary Template</a></li>
            <li class="active"><span><b>Create Salary Template</b></span></li>
        </ol>
    </div>

    <div class="row p-2">
        <div class="card ">
            <div class="card-body">
                <h4 class="card-title">Salary Structure Template</h4>
                <div class="row">
                    <div class="col-md-3">
                        {!! Form::label('tn', 'Template Name', ['class' => 'awesome']) !!}
                        {!! Form::text('tn', '', [
                            'class' => 'form-control ',
                            'placeholder' => 'Enter Template Name',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {!! Form::label('salary_type', 'Employee Details', ['class' => 'awesome']) !!}
                        {!! Form::select(
                            'salary_type',
                            $SalaryType,
                            null, // Selected option (in this case, null for no preselection)
                            ['class' => 'form-control form-select'],
                        ) !!}
                    </div>
                    <div class="col-md-3">
                        {{ Form::label('salary_calculate_type', 'Salary Calculate Type') }}
                        {!! Form::select('salary_calculate_type', $SalaryCalculateType, null, [
                            'class' => 'form-control form-select',
                        ]) !!}
                    </div>
                    <div class="col-md-3">
                        {{ Form::label('add', 'Added ') }}

                        <button class="btn btn-primary" wire:click="clickToAppended">Get</button>
                    </div>
                </div>

                <div class="row">
                    Earnings

                    {{-- @if ($InterationCountMode > 0)
                        <div class="row">
                            <input type="text" class="form-control" value="{{ $InterationCountMode }}">
                        </div>
                    @endif --}}
                    @foreach ($cloneArray as $item)
                        <input type="text" class="form-control" value="{{ $item }}">
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
