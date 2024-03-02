<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\admin\BusinessDetailsList;
use App\Models\PolicySalaryDeductionSetup;
use App\Models\PolicysalarySetting;
use App\Models\PolicySalarySetup;
use App\Models\PolicySalaryStaticEarningComponent;
use App\Models\PolicySalaryProtaxStore;
use App\Models\SalaryProfessionalTax;
use App\Models\PolicySalaryTdsStore;
use App\Models\PolicySalaryStaticDeductionComponent;
use App\Models\PolicySalaryStaticIndirectAllowance;
use App\Models\StaticSalaryEarningType;
use Session;
use DB;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('PayrollItems.salarysetting');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function salaryTemplateIndex()
    {
        return view('PayrollItems.salaryTemplate.salary-template');
    }

    public function salaryTemplateCreate()
    {
        return view('PayrollItems.salaryTemplate.create-salary-template');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function indirect_allowance(Request $request)
    {
        //    dd($request->all());
        $data = PolicySalaryStaticIndirectAllowance::select('*')->get();
        return view('PayrollItems.indirect_alllowance', compact('data'));
    }

    public function indirectAllowanceAdd(Request $request)
    {
        $data = PolicySalaryStaticIndirectAllowance::select('*')->get();
        return view('PayrollItems.indirect_alllowance', compact('data'));

        dd($request->all());
    }

    public function salarysetting()
    {
        // $newdata=SalaryProfessionalTax::select('*')->get();
        $saradata = PolicysalarySetting::select('*')->where('business_id', Session::get('business_id'))->first();
        //dd('new',$saradata);
        $data = PolicySalaryProtaxStore::select('*')->get();
        // dd($data);
        $newdata = PolicySalaryTdsStore::select('*')->get();
        //  dd($newdata->isNotEmpty());
        //  dd($newdata->tdsffromsalary[0]);
        return view('PayrollItems.salaryset', compact('saradata', 'data', 'newdata'));
    }
    public function Earnsetting()
    {
        $data = PolicySalaryStaticEarningComponent::select('*')->get();
        $earn_type = StaticSalaryEarningType::select('*')->get(); // Changed variable name to $earn_types
        $newData = PolicySalarySetup::select('*')->with('policy_salary_static_earning_component', 'static_salary_earning_type')->get(); // Changed variable name to $policies
        // dd($newData);StaticSalaryEarningType

        return view('PayrollItems.earnset', compact('data', 'newData', 'earn_type')); // Changed variable name to $earn_types
    }

    public function addEarning(Request $request)
    {
        // dd($request->all()); // Uncomment this line for debugging if needed


        $salary_id = $request->salary_id;
        $business_id = Session::get('business_id');
        $branch_id = Session::get('branch_id');

        // Create PolicySalarySetup record
        $data = PolicySalarySetup::create([
            'business_id' => $business_id,
            'branch_id' => $branch_id,
            'others' => $request->others,
            'salary_id' => $request->salary_id,
            'earning_type_id' => $request->earning_component,
        ]);
        //    dd($data);
        // Redirect to the specified URL
        return redirect('admin/settings/payroll/earnings');
    }

    public function Deductionsetting()
    {
        $data = PolicySalaryStaticDeductionComponent::select('*')->get();
        //dd($data);
        $newData = PolicySalaryDeductionSetup::select('*')->get();
        return view('PayrollItems.deductionset', compact('data', 'newData'));
    }
    // public function Overtimesetting()
    // {

    // }

    // for deduction
    public function add_deduction(Request $request)
    {
        //dd($request->all());OtherTaxes
        $business_id = Session::get('business_id');
        $branch_id = Session::get('branch_id');
        // if ($request->deduction_component === 'OtherTaxes') {
        //     $salaryId = $request->deduction;
        // } else {
        //     $salaryId = $request->deduction_component;
        // }

        $data = PolicySalaryDeductionSetup::create([
            'business_id' => $business_id,
            'branch_id' => $branch_id,
            'business_id' => $business_id,
            'branch_id' => $branch_id,
            'deduct_name' => $salaryId,
        ]);
        // dd($data);
        return redirect('admin/settings/payroll/deductions');
    }

    // for update earning
    public function updateEarning(Request $request)
    {
        // dd($request->all()); // Uncomment for debugging if needed

        $findid = $request->input('edit');

        $business_id = Session::get('business_id');
        $branch_id = Session::get('branch_id');

        $data = PolicySalarySetup::where('id', $findid) // Corrected 'findid' to 'id'
            ->where('branch_id', $branch_id)
            ->update([
                'business_id' => $business_id,
                'branch_id' => $branch_id,
                'others' => $request->earnOther,
                'salary_id' => $request->earnType,
                'earning_type_id' => $request->earnName,
                'custom_earning_compo' => $request->custom_name,
                'earning_amount_percent' => $request->custom_earn
            ]);
        // dd($data);
        return redirect('admin/settings/payroll/earnings');
    }

    // for delete earning
    public function deleteEarn(Request $request)
    {
        // dd($request->all());

        $deleteId = $request->input('deleteId');

        // Delete the item from the database based on its ID
        $data = PolicySalarySetup::select('*')->where('id', $deleteId)->delete();

        return redirect('admin/settings/payroll/earnings');
    }




    public function salarysettingvalues(Request $request)
    {
        $business_id = Session::get('business_id');
        $dahra = $request->da != null ? ($request->da == 'on' ? '1' : '0') : '0';
        $pfset = $request->pf != null ? ($request->pf == 'on' ? '1' : '0') : '0';
        $esiset = $request->esi != null ? ($request->esi == 'on' ? '1' : '0') : '0';
        $epsset = $request->eps != null ? ($request->eps == 'on' ? '1' : '0') : '0';
        $lwfset = $request->lwf != null ? ($request->lwf == 'on' ? '1' : '0') : '0';
        $protset = $request->prof_tax != null ? ($request->prof_tax == 'on' ? '1' : '0') : '0';
        $tdsset = $request->tds_tx != null ? ($request->tds_tx == 'on' ? '1' : '0') : '0';
        //    dd('$dahra',$dahra,'$pfset',$pfset,' $esiset', $esiset,'$epsset',$epsset,'$lwfset',$lwfset,' $protset', $protset,'$tdsset',$tdsset);

        if ($request->filled('salset_id_')) {
            $data = PolicysalarySetting::select('*')->where('id', $request->salset_id_)->first();
            // dd($request->all(),'data',$data);
            $data->update([
                'business_id' => $business_id,
                'da_hra' => $dahra,
                'pfset' => $pfset,
                'esi_set' => $esiset,
                'eps_set' => $epsset,
                'lwf_set' => $lwfset,
                'Protax_set' => $protset,
                'TDS_set' => $tdsset,
                'da_value' => $request->da_value,
                'hra_value' => $request->hra_value,
                'pf_employee_value' => $request->pf_employee_value,
                'pf_organization_value' => $request->pf_organization_value,
                'esi_employee_value' => $request->esi_employee_value,
                'esi_organization_value' => $request->esi_organization_value,
                'eps_value' => $request->eps_value,
                'lwf_employee_value' => $request->lwf_employee_value,
                'lwf_organization_value' => $request->lwf_organization_value
            ]);
            //  dd('$data',$data);

            // $air_mode = ProtaxSalaryStore::delete();
            $air_mode = PolicySalaryProtaxStore::truncate();
            if ($request->protax_from_salry != '' || $request->protax_from_salry != null) {
                $salset_id = ($data->id);
                foreach ($request->protax_from_salry as $key => $value) {
                    $protaxData = new PolicySalaryProtaxStore();
                    $protaxData->business_id = $business_id;
                    $protaxData->salset_id = $salset_id; // Assuming $salset_id is defined somewhere
                    $protaxData->proffromsalary = $request->protax_from_salry[$key];
                    $protaxData->protosalary = $request->protax_to_salary[$key];
                    $protaxData->proamountstore = $request->amount[$key];
                    $protaxData->save();
                }
            }
            $air_mode_second = PolicySalaryTdsStore::truncate();
            // Insert data for PolicySalaryTdsStore model
            if ($request->tdsffromsalary != '' || $request->tdsffromsalary != null) {
                foreach ($request->tdsffromsalary as $key => $value) {
                    $tdsData = new PolicySalaryTdsStore();
                    $tdsData->business_id = $business_id;
                    $tdsData->salset_id = $salset_id;
                    $tdsData->tdsffromsalary = $request->tdsffromsalary[$key];
                    $tdsData->tdstosalary = $request->tdstosalary[$key];
                    $tdsData->tdsamountstore = $request->tdsamountstore[$key];
                    $tdsData->save();
                }
            }
            // dd($request->filled('salset_id_'), $request->all(),$request->salset_id_,'$air_mode',$air_mode,'salset_id',$salset_id,'$protaxData',$protaxData,'air_mode_second',$air_mode_second,' $tdsData', $tdsData);
            // dd($request->all());
            // dd($data);
            return redirect('admin/settings/payroll/salaryset');
        } else {
            // dd('aaya data');
            $business_id = Session::get('business_id');
            $data = PolicysalarySetting::create([
                'business_id' => $business_id,
                'da_hra' => $request->dahra,
                'pfset' => $request->pfset,
                'esi_set' => $request->esiset,
                'eps_set' => $request->epsset,
                'lwf_set' => $request->lwfset,
                'Protax_set' => $request->protset,
                'TDS_set' => $request->tdsset,
                'da_value' => $request->da_value,
                'hra_value' => $request->hra_value,
                'pf_employee_value' => $request->pf_employee_value,
                'pf_organization_value' => $request->pf_organization_value,
                'esi_employee_value' => $request->esi_employee_value,
                'esi_organization_value' => $request->esi_organization_value,
                'eps_value' => $request->eps_value,
                'lwf_employee_value' => $request->lwf_employee_value,
                'lwf_organization_value' => $request->lwf_organization_value
            ]);

            $salset_id = ($data->id);
            /// Insert data for ProtaxSalaryStore model
            if ($request->protax_from_salry != '' || $request->protax_from_salry != null) {
                foreach ($request->protax_from_salry as $key => $value) {
                    $protaxData = new PolicySalaryProtaxStore();
                    $protaxData->business_id = $business_id;
                    $protaxData->salset_id = $salset_id; // Assuming $salset_id is defined somewhere
                    $protaxData->proffromsalary = $request->protax_from_salry[$key];
                    $protaxData->protosalary = $request->protax_to_salary[$key];
                    $protaxData->proamountstore = $request->amount[$key];
                    $protaxData->save();
                }
            }
            if ($request->tdsffromsalary != '' || $request->tdsffromsalary != null) {
                // Insert data for PolicySalaryTdsStore model
                foreach ($request->tdsffromsalary as $key => $value) {
                    $tdsData = new PolicySalaryTdsStore();
                    $tdsData->business_id = $business_id;
                    $tdsData->salset_id = $salset_id;
                    $tdsData->tdsffromsalary = $request->tdsffromsalary[$key];
                    $tdsData->tdstosalary = $request->tdstosalary[$key];
                    $tdsData->tdsamountstore = $request->tdsamountstore[$key];
                    $tdsData->save();
                }
            }
            return redirect('admin/settings/payroll/salaryset');
        }
    }
}
