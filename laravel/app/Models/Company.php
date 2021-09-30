<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'logo', 'website'
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public function getCompanies()
    {
        return parent::paginate(5);
    }

    public function getOneCompany($param)
    {
        $result = parent::where('id', $param)->orWhere('name', 'LIKE', '%' . $param . '%')->first();

        return $result;
    }

    public function createCompany(Request $request)
    {
        $data = $request->all();

        if ($data['id'] != null && $data['logo'] == 'undefined') unset($data['logo']);

        $validator = Validator::make($data, [
            'id' => 'nullable',
            'name' => 'required',
            'email' => 'required',
            'logo' => $data['id'] == null ? 'required|max:2048|mimes:jpg,png' : 'max:2048|mimes:jpg,png',
            'website' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errorInfo' => $validator->errors()
            ]);
        }

        if ($request->has('logo') && isset($data['logo'])) {
            $fileName = $this->_uploadImage($data['logo']);
            $data['logo'] = $fileName;
        } else {
            unset($data['logo']);
        }

        try {
            $saveCompany = parent::updateOrCreate(['id' => $data['id']], $data);

            if ($saveCompany) {
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

    public function deleteCompany($id)
    {
        $deleted = parent::where('id', $id)->delete();

        if ($deleted) {
            return response()->json([
                'status' => 'deleted'
            ], 200);
        }
    }

    private function _uploadImage($image)
    {
        $name = rand();
        $fileName = $name . '.' . $image->getClientOriginalExtension();

        $folder = 'public/app/company';
        $saveFile = $image->storeAs($folder, $fileName);

        if ($saveFile) return 'storage/app/company/' . $fileName;
    }
}
