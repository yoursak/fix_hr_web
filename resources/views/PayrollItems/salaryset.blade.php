{{-- <?php dd(isset($newdata)); ?> --}}
{{-- <?php dd($newdata != null); ?> --}}
{{-- <?php dd(!empty($newdata)); ?> --}}
@extends('admin.pagelayout.master')

@section('title')
    Setup Activation | Salary Settings
@endsection

@section('css')
    @parent
    <style>
        .small-text {
            font-size: smaller;
        }
    </style>
@endsection


@section('content')
    <div class=" p-0 mt-3">
        <ol class="breadcrumb breadcrumb-arrow m-0 p-0" style="background: none;">
            <li><a href="{{ url('/admin') }}">Dashboard</a></li>
            <li><a href="{{ url('/admin/settings/payroll') }}">Payroll Setup</a></li>
            <li class="active"><span><b>Salary Settings</b></span></li>
        </ol>
    </div>
    <div class="page-header d-md-flex d-block">
        <div class="page-leftheader">
            <div class="page-title">Salary Settings</div>
        </div>
    </div>

    <form action="{{ url('admin/settings/payroll/salarysetvalues') }}" method="POST">
        @csrf
        <input type="hidden" name="main_form" id="">
        <div class="card ">
            <div class="card-body">
                {{-- For DA and HRA section --}}
                <div class="settings-widget d-flex justify-content-between align-items-center">
                    <h3 class="card-title">DA and HRA</h3>
                    <label class="custom-switch d-inline-block align-middle">
                        <input type="checkbox" name="da"  id="offandon" onclick="toggle_mode(this)"
                            {{ $saradata != null ? ($saradata->da_hra == 1 ? 'checked' : '') : '' }}
                            class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                    </label>
                    <input type="hidden" name="dahra" value="0" id="offda">
                    <input type="hidden" name="salset_id_" value="{{ $saradata->id ?? '' }}">
                </div>
                 <div id="contentband">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="form-label">DA (%)</label>
                                <input type="text" class="form-control" name="da_value"
                                    value="{{ $saradata->da_value ?? '' }}" id="daone">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="form-label">HRA (%)</label>
                                <input class="form-control" type="text" name="hra_value"
                                    value="{{ $saradata->hra_value ?? '' }}" id="hraone">
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Provident Fund Settings --}}
                <div class="settings-widget mt-1 mb-1">
                    <div class="d-flex justify-content-between mb-3">
                       {{-- <div class="">
                        <p class="card-title">Provident Fund Settings <span>(Basic DA)</span></p>
                       </div> --}}
                       <div class="d-flex justify-content-between ">
                            <div>
                                <h3 class="card-title">Provident Fund Settings </h3>
                            </div>
                            <div>
                                    <small class="text-muted">(Basic+da)</small>
                            </div>
                        </div>
                       <div>
                          <label class="custom-switch d-inline-block align-middle">
                            <input type="checkbox" name="pf" id="pfindicateband" onchange="toggle_mode_pf(this)"
                                   {{ $saradata != null ? ($saradata->pfset == 1 ? 'checked' : '') : '' }}
                                   class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                          </label>
                        </div>
                    </div>
                        <div>
                            <p class="text-muted text-small"><small>A Provident Fund (PF) is a retirement savings scheme where employees and employers contribute for future benefits</small></p>
                        </div>
                    <input type="hidden" name="pfset" value="0" id="pfoff">
                </div>


                <div class="row" id="pfwaladivband">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="form-label">Employee Share (%)</label>
                                <input class="form-control" id="esone" name="pf_employee_value"
                                    value="{{ $saradata->pf_employee_value ?? '' }}" type="text" placeholder="12%">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="form-label">Organization Share(%)</label>
                                <input class="form-control" id=ostwo type="text" name="pf_organization_value"
                                    value="{{ $saradata->pf_organization_value ?? '' }}" placeholder="12%">
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ESI Settings --}}
                <div class="settings-widget  mt-4">
                    <div class="d-flex justify-content-between mb-3">
                        {{-- <div>
                            <h3 class="card-title"> <span class="text-muted"></span></h3>
                        </div> --}}
                        <div class="d-flex justify-content-between ">
                            <div>
                                <h3 class="card-title">ESI Settings </h3>
                            </div>
                            <div>
                                    <small class="text-muted">(Monthly Ctc excluding conveyance and LTA)</small>
                            </div>
                        </div>
                        <div>
                            <label class="custom-switch d-inline-block align-middle">
                                <input type="checkbox" name="esi" id="esidicateband" onchange="toggle_mode_esi(this)"
                                    {{ $saradata->esi_set == 1 ? 'checked' : '' }} {{-- {{ $saradata != null ? ($saradata->esi_set == 1 ? 'checked' : '') : '' }} --}}
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>
                       <div>
                        <p class="text-muted text-small"><small>Employee's State Insurance Corporation, offers social security benefits, including medical care, to employees in India through joint contributions</small></p>
                       </div>
                        <input type="hidden" name="esiset" value="0" id="esioff">
                </div>
                <div class="row" id="esiwaladiv">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="form-label">Employee Share (%)</label>
                                <input class="form-control" id="esione" name="esi_employee_value"
                                    value="{{ $saradata->esi_employee_value ?? '' }}" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="form-label">Organization Share (%)</label>
                                <input class="form-control" id="esitwo" name="esi_organization_value"
                                    value="{{ $saradata->esi_organization_value ?? '' }}" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Eps setting --}}
                <div class="settings-widget  mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <h3 class="card-title">EPS SETTINGS</h3>
                        </div>
                        <div>
                            <label class="custom-switch d-inline-block align-middle">
                                <input type="checkbox" name="eps" id="epsdicateband" onchange="toggle_mode_eps(this)"
                                    {{-- {{ $saradata->eps_set == 1 ? 'checked' : '' }} --}} {{ $saradata != null ? ($saradata->eps_set == 1 ? 'checked' : '') : '' }}
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>
                            <p class="text-muted text-small pt-2"><small>Employee Pension Scheme, is a social security initiative in India that provides pension benefits to employees upon retirement, managed by the  EPFO.</small></p>
                    <input type="hidden" name="epsset" value="0" id="epsoff">
                </div>
                <div id=epswaladiv>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="form-label ">EPS (%)</label>
                                <input type="text" id="epsone" name="eps_value"
                                    value="{{ $saradata->eps_value ?? '' }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="settings-widget  mt-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex justify-content-between ">
                            <div>
                                <h3 class="card-title">Labour Welfare Fund  </h3>
                            </div>
                            <div>
                                    <small class="text-muted">(Monthly Ctc)</small>
                            </div>
                        </div>
                        <div>
                            <label class="custom-switch d-inline-block align-middle">
                                <input type="checkbox" name="lwf" id="labourdicateband" onchange="toggle_mode_labour(this)"
                                    {{-- {{ $saradata->lwf_set == 1 ? 'checked' : '' }} --}}
                                    {{ $saradata != null ? ($saradata->lwf_set == 1 ? 'checked' : '') : '' }}
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>
                            <p class="text-muted text-small "><small>The LWF is a fund established by governments to support the welfare of laborers through various benefits and services, such as healthcare, education, and housing.</small></p>
                           {{-- Professional tax is a tax levied by state governments in India on salaried individuals and professionals based on their income or profession. --}}

                    <input type="hidden" name="lwfset" value="0" id="lwfoff">
                </div>

                <div id=labourdiv>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="form-label">Employee Share (%)</label>
                                <input class="form-control" name="lwf_employee_value" id="labourone"
                                    value="{{ $saradata->lwf_employee_value ?? '' }}" type="text"
                                    placeholder="Amount">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-block mb-3">
                                <label class="form-label">Organization Share(%)</label>
                                <input class="form-control" name="lwf_organization_value" id="labourtwo"
                                    value="{{ $saradata->lwf_organization_value ?? '' }}" type="text"
                                    placeholder="Amount">
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Professional Taxes --}}
                <div class="settings-widget mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        {{-- <div>
                            <h3 class="card-title"><span class="text-muted"></span></h3>
                        </div> --}}
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <h3 class="card-title">Professional Taxes </h3>
                            </div>
                            <div>
                                    <small class="text-muted">(Monthly Salary)</small>
                            </div>
                        </div>
                        <div>
                            <label class="custom-switch ">
                                <input type="checkbox" name="prof_tax" id="Professionaldicateband"
                                    onchange="toggle_mode_Professional(this)" {{-- {{ $saradata->Protax_set == 1 ? 'checked' : '' }} --}}
                                    {{ $saradata != null ? ($saradata->Protax_set == 1 ? 'checked' : '') : '' }}
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        {{-- <div class="d-flex justify-content-between"> --}}
                            <div>
                            <p class="text-muted text-small m-0 pt-2"><small>Professional tax is a tax levied by state governments in India on salaried individuals and professionals based on their income or profession.</small></p>
                            </div>
                             <input type="hidden" name="protset" value="0" id="protaxoff">
                             <div class="col-md-1  p-0 text-end flex-grow-1  ">
                                 <div class="">
                                     <button type="button" class="btn btn-sm btn-primary" onclick="addprotax()"><i class="fe fe-plus bold"></i></button>
                                 </div>
                             </div>
                        {{-- </div>
                        <div>
                        </div> --}}
                    </div>
                </div>

                <div id="protax">
                    <div class="row align-items-center " >
                        <?php $i_num = 0; ?>
                        @if ($data->isNotEmpty())
                            @foreach ($data as $item)
                                {{-- <input type="text" name="protset" value="{{$item->protaxstore_id ?? '' }}" id="protaxoff"> --}}
                                <?php $i_num++; ?>
                                <div class="col-md-3">
                                    <div class="input- mb-3" id="pro_one_{{ $i_num }}">
                                        <label class="form-label">Salary From</label>
                                        <input class="form-control" name="protax_from_salry[]" id="Professionalone"
                                            data="new_{{ $i_num }}" value="{{ $item->proffromsalary ?? '' }}"
                                            type="text">
                                        {{-- <input type="text" name="protaxstore_id[]" id="protaxstore_id " value="{{ $item->protaxstore_id}}"> --}}
                                        {{-- <input type="text" name="protset" value="{{$item->protaxstore_id ?? '' }}" id="protaxoff"> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-block mb-3" id="pro_two_{{ $i_num }}">
                                        <label class="form-label">Salary To</label>
                                        <input class="form-control" name="protax_to_salary[]" id="Professionaltwo"
                                            data="new_{{ $i_num }}" value="{{ $item->protosalary ?? '' }}"
                                            type="text">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-block mb-3" id="pro_three_{{ $i_num }}">
                                        <label class="form-label">amount</label>
                                        <input class="form-control" name="amount[]"
                                            value="{{ $item->proamountstore ?? '' }}" id="Professionalthree"
                                            data="new_{{ $i_num }}" type="text">
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <div class="input-block mb-3" id="delete_pro_{{ $i_num }}">
                                        <label class="d-none d-sm-block">&nbsp;</label>
                                        <button class="btn btn-sm btn-danger" type="button"
                                            onclick="deleteprotax({{ $i_num }})"><i class="feather feather-trash"
                                                aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row row-sm">
                                <div class="col-md-3">
                                    <div class="input-block mb-3">
                                        <label class="form-label">Salary From</label>
                                        <input class="form-control" required name="protax_from_salry[]" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-block mb-3">
                                        <label class="form-label">Salary To</label>
                                        <input class="form-control" required name="protax_to_salary[]" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-block mb-3">
                                        <label class="form-label">Amount</label>
                                        <input class="form-control" required name="amount[]" type="text">
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
                {{-- TDS Annual Salary --}}
                <div class="settings-widget mt-4">
                    <div class="d-flex justify-content-between mb-2">

                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="card-title">Tax Deducted at Source</h3>
                            </div>
                            <div>
                                    <small class="text-muted">(Yearly Ctc)</small>
                            </div>
                        </div>
                        <div>
                            <label class="custom-switch">
                                <input type="checkbox" name="tds_tx" id="tdsdicateband" onchange="toggle_tds(this)"
                                    {{-- {{ $saradata->TDS_set == 1 ? 'checked' : '' }} --}}
                                    {{ $saradata != null ? ($saradata->TDS_set == 1 ? 'checked' : '') : '' }}
                                    class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                            </label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                         <p class="text-muted  text-small m-0 pt-2"><small>TDS, is a system in India where tax is deducted from the income at the time of payment itself, ensuring collection of taxes at the source.</small></p>
                        </div>
                         <input type="hidden" name="tdsset" value="0" id="tdsoff">
                         <div class="col-md-1 p-0 text-end flex-grow-1 ">
                             <div class="text-end">
                                 <button type="button" class="btn btn-sm btn-primary" onclick="addtdstax()"><i class="fe fe-plus bold"></i></button>
                             </div>
                         </div>
                    </div>
                    </div>
                {{-- <div class="row  d-flex align-items-center"  id="tdstax"> --}}
                {{-- <div  id="td_stax_second"></div> --}}
                <div id="tdstax">
                    <div class="row row-sm">
                        @if ($newdata->isNotEmpty())
                            @foreach ($newdata as $item)
                                <?php $i_num++; ?>
                                <div class="col-md-3" id="tdsone_{{ $i_num }}">
                                    <div class="input-block mb-3">
                                        <label class="form-label">Salary From</label>
                                        <input class="form-control" name="tdsffromsalary[]" id="tdsone"
                                            data="new_{{ $i_num }}" value="{{ $item->tdsffromsalary ?? '' }}"
                                            type="text">
                                    </div>
                                </div>
                                <div class="col-md-4" id="tdstwo_{{ $i_num }}">
                                    <div class="input-block mb-3">
                                        <label class="form-label">Salary To</label>
                                        <input class="form-control" name="tdstosalary[]" id="tdstwo"
                                            data="new_{{ $i_num }}" value="{{ $item->tdstosalary ?? '' }}"
                                            required type="text">
                                    </div>
                                </div>
                                <div class="col-md-4" id="tdsthree_{{ $i_num }}">
                                    <div class="input-block mb-3">
                                        <label class="form-label">%</label>
                                        <input class="form-control" name="tdsamountstore[]" id="tdsthree"
                                            data="new_{{ $i_num }}" value="{{ $item->tdsamountstore ?? '' }}"
                                            required type="text">
                                    </div>
                                </div>
                                <div class="col-md-1 text-end" id="delete_{{ $i_num }}">
                                    <div class="input-block mb-3">
                                        <label class="d-none d-sm-block">&nbsp;</label>
                                        <button class="btn btn-sm btn-danger" type="button"
                                            onclick="deletetds({{ $i_num }})"><i class="feather feather-trash"
                                                data="new_{{ $i_num }}" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row row-sm">
                                <div class="col-md-3">
                                    <div class="input-block mb-3">
                                        <label class="form-label">Salary From</label>
                                        <input class="form-control" required name="tdsffromsalary[]" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-block mb-3">
                                        <label class="form-label">Salary To</label>
                                        <input class="form-control" required name="tdstosalary[]" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-block mb-3">
                                        <label class="form-label">%</label>
                                        <input class="form-control" required name="tdsamountstore[]" type="text">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="submit-section text-end mt-4">
            <button class="btn btn-primary submit-btn float-end" type="submit">Save</button>
        </div>
    </form>
@endsection
@section('js')
    <script>
        function addprotax() {
            var newhtml = `
    <div class="row row-sm">
        <div class="col-md-3  mb-3">
            <div class="input-block">
                <label class="form-label">Salary From</label>
                <input class="form-control" required name="protax_from_salry[]" type="text">
            </div>
        </div>
        <div class="col-md-4  mb-3">
            <div class="input-block">
                <label class="form-label">Salary To</label>
                <input class="form-control" required name="protax_to_salary[]" type="text">
            </div>
        </div>
        <div class="col-md-4  mb-3">
            <div class="input-block">
                <label class="form-label">Amount</label>
                <input class="form-control" required name="amount[]" type="text">
            </div>
        </div>
        <div class="col-md-1  mb-3">
            <div class="input-block ">
                <label class="d-none d-sm-block">&nbsp;</label>
                <button class="btn btn-sm btn-danger" type="button"><i class="feather feather-trash" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
    `;
            $("#protax").append(newhtml);
        };

        // function add tds
        function addtdstax() {
            var newhtml = `
            <div class="row row-sm">
                <div class="col-md-3">
                    <div class="input-block mb-3">
                        <label class="form-label">Salary From</label>
                        <input class="form-control" required name="tdsffromsalary[]" type="text">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-block mb-3">
                        <label class="form-label">Salary To</label>
                        <input class="form-control" required name="tdstosalary[]"  type="text">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-block mb-3">
                        <label class="form-label">%</label>
                        <input class="form-control" required name="tdsamountstore[]"  type="text">
                    </div>
                </div>
                <div class="col-md-1 ">
                    <div class="input-block mb-3">
                        <label class="d-none d-sm-block">&nbsp;</label>
                        <button class="btn btn-sm btn-danger" remove_item_btn_edit type="button"><i class="feather feather-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            `;
            $("#tdstax").append(newhtml);
        };

        function toggle_mode(section) {
            console.log('section', section);
            var offandon = document.getElementById('offandon'); //offda
            console.log('offandon', offandon.value);
            var divid = document.getElementById('contentband');
            var offda = document.getElementById('offda');
            var hraone = document.getElementById('hraone');
            if (offandon.checked) {
                divid.style.display = 'block';
                daone.disabled = false;
                hraone.disabled = false;
                document.getElementById('offda').value = 1;

            } else {
                divid.style.display = 'none';
                daone.disabled = true;
                hraone.disabled = true;
                document.getElementById('offda').value = 0;
            }
        }

        // for toggle in pf
        function toggle_mode_pf() {
            var pfindicateband = document.getElementById('pfindicateband');
            var pfwaladivband = document.getElementById('pfwaladivband');
            var esone = document.getElementById('esone');
            var ostwo = document.getElementById('ostwo');
            if (pfindicateband.checked) {
                pfwaladivband.style.display = 'block';
                esone.disabled = false;
                ostwo.disabled = false;
                document.getElementById('pfoff').value = 1;
            } else {
                pfwaladivband.style.display = 'none';
                esone.disabled = true;
                ostwo.disabled = true;
                document.getElementById('pfoff').value = 0;
            }
        }

        // for toggle in esi
        function toggle_mode_esi() {
            var esidicateband = document.getElementById('esidicateband');
            var esiwaladiv = document.getElementById('esiwaladiv');
            var esione = document.getElementById('esione');
            var esitwo = document.getElementById('esitwo');
            if (esidicateband.checked) {
                esiwaladiv.style.display = 'block';
                esione.disabled = false;
                esitwo.disabled = false;
                document.getElementById('esioff').value = 1;
            } else {
                esiwaladiv.style.display = 'none';
                esione.disabled = true;
                esitwo.disabled = true;
                document.getElementById('esioff').value = 0;
            }
        }
        // eps walatoggle_mode_labour
        function toggle_mode_eps() {
            var epsdicateband = document.getElementById('epsdicateband');
            var epswaladiv = document.getElementById('epswaladiv');
            var epsone = document.getElementById('epsone');
            //   var esitwo = document.getElementById('esitwo');
            if (epsdicateband.checked) {
                epswaladiv.style.display = 'block';
                epsone.disabled = false;
                // esitwo.disabled = false;
                document.getElementById('epsoff').value = 1;
            } else {
                epswaladiv.style.display = 'none';
                epsone.disabled = true;
                // esitwo.disabled = true;
                document.getElementById('epsoff').value = 0;
            }
        }

        // labour wala
        function toggle_mode_labour() {
            var labourdicateband = document.getElementById('labourdicateband');
            var labourdiv = document.getElementById('labourdiv');
            var labourone = document.getElementById('labourone');
            var labourtwo = document.getElementById('labourtwo');
            if (labourdicateband.checked) {
                labourdiv.style.display = 'block';
                labourone.disabled = false;
                labourtwo.disabled = false;
                document.getElementById('lwfoff').value = 1;
            } else {
                labourdiv.style.display = 'none';
                labourone.disabled = true;
                labourtwo.disabled = true;
                document.getElementById('lwfoff').value = 0;
            }
        }

        // Professional wala
        function toggle_mode_Professional() {
            var Professionaldicateband = document.getElementById('Professionaldicateband');
            var protax = document.getElementById('protax');
            var Professionalone = document.getElementById('Professionalone');
            var Professionaltwo = document.getElementById('Professionaltwo');
            var Professionalthree = document.getElementById('Professionalthree');
            if (Professionaldicateband.checked) {
                protax.style.display = 'block';
                Professionalone.disabled = false;
                Professionaltwo.disabled = false;
                Professionalthree.disabled = false;
                document.getElementById('protaxoff').value = 1;
            } else {
                protax.style.display = 'none';
                Professionalone.disabled = true;
                Professionaltwo.disabled = true;
                Professionalthree.disabled = true;
                document.getElementById('protaxoff').value = 0;
            }
        }
        // tds tax
        function toggle_tds() {
            var tdsdicateband = document.getElementById('tdsdicateband');
            var tdstax = document.getElementById('tdstax');
            var tdsone = document.getElementById('tdsone');
            var tdstwo = document.getElementById('tdstwo');
            var tdsthree = document.getElementById('tdsthree');
            let data_toggol = document.getElementById('tdsoff').value;
            console.log('data_toggol', data_toggol);
            let isAppended = false;

            // console.log('tdstax',tdstax);

            if (tdsdicateband.checked) {
                tdstax.style.display = 'block';
                tdsone.disabled = false;
                tdstwo.disabled = false;
                tdsthree.disabled = false;

                document.getElementById('tdsoff').value = 1;
            } else {
                tdstax.style.display = 'none';
                tdsone.disabled = true;
                tdstwo.disabled = true;
                tdsthree.disabled = true;

                document.getElementById('tdsoff').value = 0;
            }
        }

        // FOR DELTE in pro tax
        function deleteprotax(button) {
            document.getElementById('delete_pro_' + button).remove();
            document.getElementById('pro_three_' + button).remove();
            document.getElementById('pro_two_' + button).remove();
            document.getElementById('pro_one_' + button).remove();

        }
        // for deleete tds
        function deletetds(button) {
            // console.log(button);
            document.getElementById('delete_' + button).remove();
            document.getElementById('tdsthree_' + button).remove();
            document.getElementById('tdstwo_' + button).remove();
            document.getElementById('tdsone_' + button).remove();

        }
    </script>
@endsection
