<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use GeneralTrait;

    //add employee function
    public function addEmployee(Request $request){
        try{
        // validation
            $rules = [
                "first_name" => "required|regex:/^[\pL\s\-]+$/u|max:20",
                'last_name'=> "required|regex:/^[\pL\s\-]+$/u|max:20",
                'hiringDate'=>"required|date",

            ];
            $messages = [
                "first_name.required"=>"the first name is required",
                "last_name.required"=>"the last name is required",
                "regex"=>"this filed must be letters",
                "hiringDate.required"=>"the hiring date is required",
                "date"=>"invalid value, try to enter a suitable date",

            ];

            $validator = Validator::make($request->all(), $rules , $messages);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //add new employee
            $employee = Employee::create([
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'hiringDate'=>$request->hiringDate,
            ]);
            //return success message
            $msg = "employee information has been added successfully";
            return $this->returnSuccessMessage($msg);
            }catch(Exception $ex){
                //this exception is returned if error occure in try code
                return $this->returnError($ex->getCode(), $ex->getMessage());
            }
    }
    //update employee information function
    public function updateEmployee(Request $request){
        try {
            // validation
            $rules = [
                "first_name" => "required|regex:/^[\pL\s\-]+$/u|max:20",
                'last_name'=> "required|regex:/^[\pL\s\-]+$/u|max:20",
                'hiringDate'=>"required|date",

            ];
            $messages = [
                "first_name.required"=>"the first name is required",
                "last_name.required"=>"the last name is required",
                "regex"=>"this filed must be letters",
                "hiringDate.required"=>"the hiring date is required",
                "date"=>"invalid value, try to enter a suitable date",

            ];
            $validator = Validator::make($request->all(), $rules , $messages);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////get employee from database
            $employee = Employee::find($request->id);
            // check if employee is exists in database or not
            if(!$employee){
                return $this->returnError('' , 'this employee doesn`t exists');
            }
            // update employee information
            $employee->update([
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'hiringDate'=>$request->hiringDate,
            ]);
            //return success message
            $msg = "employee information has been updated successfully";
            return $this->returnSuccessMessage($msg);
        } catch (Exception $ex) {
            //this exception is returned if error occure in try code
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    //delete employee from database
    public function deleteEmployee(Request $request){
                try{
                    //get id from request to employeeId variable
                    $employeeId = $request->id;
                    //check if the id input is null or not
                    if($employeeId != null){
                        //get employee from database
                        $employee = Employee::find($employeeId);
                        //check if employee is exists in database or not
                        if(!$employee){
                           return $this->returnError('' , 'this employee doesn`t exists');
                        }
                        // for delete employee
                        $employee->delete();
                        //return success message
                       return $this->returnSuccessMessage('employee removed successfuly');
                    }else{
                        //return error message
                       return $this->returnError('' , 'something went wrongs');
                    }

                }catch (Exception $ex) {
                    //this exception is returned if error occure in try code
                    return $this->returnError($ex->getCode(), $ex->getMessage());
                }

    }
    // this function for export the excel file
    public function get_employee_data()
    {
        return Excel::download(new EmployeeExport, 'Employees.xlsx');
    }
}
