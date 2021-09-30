<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'company_id', 'company', 'email'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getEmployees()
    {
        return parent::paginate(5);
    }

    public function getOneEmployee($param)
    {
        $result = parent::where('id', $param)->orWhere('name', 'LIKE', '%' . $param . '%')->first();
        return $result;
    }

    public function createEmployee(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id' => 'nullable',
            'name' => 'required',
            'company' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errorInfo' => $validator->errors()
            ]);
        }

        $companyId = DB::table('companies')->where('name', 'LIKE', '%' . $data['company'] . '%')->first()->id;
        $data['company_id'] = $companyId;

        try {
            $saveEmployee = parent::updateOrCreate(['id' => $data['id']], $data);

            if ($saveEmployee) {
                return response()->json([
                    'status' => 'updated'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'error' => $e
            ], 500);
        }
    }

    public function deleteEmployee($id)
    {
        $deleted = parent::where('id', $id)->delete();

        if ($deleted) {
            return response()->json([
                'status' => 'deleted'
            ], 200);
        }
    }
}
