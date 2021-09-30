<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

use App\Imports\CompanyImport;
use PDF;
use Excel;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->company = new Company;
    }

    public function index()
    {
        return view('company');
    }

    public function add(Request $request)
    {
        return $this->company->createCompany($request);
    }

    public function get()
    {
        $companies = $this->company->getCompanies();

        return response()->json([
            'status' => 'success',
            'results' => $companies
        ], 200);
    }

    public function getOne($param)
    {
        $company = $this->company->getOneCompany($param);

        return response()->json([
            'status' => 'success',
            'results' => $company
        ], 200);
    }

    public function update($id)
    {
        return $this->company->updateCompany($id);
    }

    public function delete($id)
    {
        return $this->company->deleteCompany($id);
    }

    public function exportPdf()
    {
        $pdf = PDF::loadview('exports.company', [
            'companies' => Company::all(),
        ]);

        return $pdf->download('companies.pdf');
    }

    public function importExcel(Request $request)
    {
        ini_set('memory_limit', -1);

        $this->validate($request, [
            'importExcel' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('importExcel');

        try {
            Excel::import(new CompanyImport, $file);

            return response()->json([
                'status' => 'imported',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'errorInfo' => $e
            ], 200);
        }
    }
}
