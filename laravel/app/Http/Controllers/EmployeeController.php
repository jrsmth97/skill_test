<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;

use App\Imports\EmployeeImport;
use Excel;
use PDF;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->employee = new Employee;
        $this->companies = Company::all();
    }

    public function index()
    {
        return view('employee', ['companies' => $this->companies]);
    }

    public function add(Request $request)
    {
        return $this->employee->createEmployee($request);
    }

    public function get()
    {
        $employees = $this->employee->getEmployees();

        return response()->json([
            'status' => 'success',
            'results' => $employees
        ], 200);
    }

    public function getOne($param)
    {
        $employee = $this->employee->getOneEmployee($param);

        return response()->json([
            'status' => 'success',
            'results' => $employee
        ], 200);
    }

    public function update($id)
    {
        return $this->employee->updateEmployee($id);
    }

    public function delete($id)
    {
        return $this->employee->deleteEmployee($id);
    }

    public function exportPdf()
    {
        $pdf = PDF::loadview('exports.employee', [
            'employees' => Employee::all(),
        ]);

        return $pdf->download('employees.pdf');
    }

    public function importExcel(Request $request)
    {
        ini_set('memory_limit', -1);

        $this->validate($request, [
            'importExcel' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('importExcel');

        try {
            Excel::import(new EmployeeImport, $file);

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
