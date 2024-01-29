<?php

namespace App\Http\Controllers\admin\Report;

use Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\BioMetricImport;
use Illuminate\Support\Facades\Validator;
use Alert;

class ImportReportController extends Controller
{
    public function ImportBioMetric(Request $request)
    {
        // dd($request->all());
        $month = $request->month;
        $year = $request->year;
        $validator = Validator::make($request->all(), [
            'bioExcelSheet' => 'required|file|mimes:xlsx',
        ]);

        if ($validator->fails()) {
            Alert::error('Validation Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('bioExcelSheet');

        try {
            $import = Excel::import(new BioMetricImport($month, $year), $file);
            if ($import) {
                Alert::success('Success');
            } else {
                Alert::error('Failed');
            }
            Alert::success('Successfully Inserted all Data');
            return back();
        } catch (\Exception $e) {
            Alert::error('Failed due to - '.$e);
            return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function downloadBiometricSample(Request $request)
    {
        dd($request->all());
        return Excel::download(new BioMetricImport('01', '2024'), 'BiometricUploadFixHR.xlsx');
    }

}
