<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employeesModel;
use Illuminate\Support\Facades\Validator;

class employeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statusCode = 200;

        // Get all employees
        $employees = new employeesModel();
        $employees = $employees->getAll(); // call getAll() function from employeesModel

        $data = [
            "status" => "success",
            "message" => "All employees",
            "data" => $employees
        ];

        if (count($employees) == 0) {
            $data = [
                "status" => "error",
                "message" => "No employees found"
            ];
            $statusCode = 404;
        }

        // Return a collection of $employees all employees
        return response()->json($data, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $statusCode = 201;

        // Validate request
        $input = [
            'name' => $request->name,
            'gender' => $request->gender,
            'status' => 'active', // default status is 'active
            'hired_on' => $request->hired_on,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email
        ];
        
        // create rules for validation
        $rules = [
            'name' =>  'required',
            'gender' => 'required',
            'status' => 'required',
            'hired_on' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ]; 

        // create validator
        $validator = Validator::make($input, $rules);

        // check if validation fails
        if ($validator->fails()) {
            $data = [
                "status" => "error",
                "message" => "Validation Error",
                "errors" => $validator->errors()
            ];

            $statusCode = 400;
        } else {
            // create employee
            $employee = new employeesModel();
            $employee = $employee->createNew($request->all()); // call createNew() function from employeesModel

            $employee = $employee->getById($employee->id); // call getById() function from employeesModel

            $data = [
                "status" => "success",
                "message" => "Employee created successfully",
                "data" => $employee
            ];
        }

        // Return a collection of $employee
        return response()->json($data, $statusCode);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $statusCode = 200;

        // Get employee by id
        $employee = new employeesModel();
        $employee = $employee->getById($id); // call getById() function from employeesModel

        $data = [
            "status" => "success",
            "message" => "Employee",
            "data" => $employee
        ];

        if (!$employee) {
            $data = [
                "status" => "error",
                "message" => "Employee not found"
            ];
            $statusCode = 404;
        }

        // Return a collection of $employee
        return response()->json($data, $statusCode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $statusCode = 200;

        $employee = new employeesModel();
        $employee = $employee->updateById($id, $request->all()); // call updateById() function from employeesModel

        $employee = $employee->getById($id); // call getById() function from employeesModel

        $data = [
            "status" => "success",
            "message" => "Employee updated successfully",
            "data" => $employee
        ];

        if (!$employee) {
            $data = [
                "status" => "error",
                "message" => "Employee not found"
            ];
            $statusCode = 404;
        }

        // Return a collection of $employee
        return response()->json($data, $statusCode);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $statusCode = 200;

        // Get employee by id
        $employee = new employeesModel();
        $employee = $employee->deleteById($id); // call deleteById() function from employeesModel

        $data = [
            "status" => "success",
            "message" => "Employee deleted successfully"
        ];

        if (!$employee) {
            $data = [
                "status" => "error",
                "message" => "Employee not found"
            ];
            $statusCode = 404;
        }

        // Return a collection of $employee
        return response()->json($data, $statusCode);

    }


    /**
     * Search for a name
     */
    public function search(string $name) {
        $statusCode = 200;

        // Get employee by name
        $employee = new employeesModel();
        $employee = $employee->searchByName($name); // call searchByName() function from employeesModel

        $data = [
            "status" => "success",
            "message" => "Employee",
            "data" => $employee
        ];

        if (!$employee) {
            $data = [
                "status" => "error",
                "message" => "Employee not found"
            ];
            $statusCode = 404;
        }

        // Return a collection of $employee
        return response()->json($data, $statusCode);
    }

    /**
     * get all active employees status
    */
    public function active() {
        $statusCode = 200;

        // Get all active employees
        $employees = new employeesModel();
        $employees = $employees->active(); // call getActiveEmployees() function from employeesModel

        $data = [
            "status" => "success",
            "message" => "All active employees",
            "data" => $employees
        ];

        if (count($employees) == 0) {
            $data = [
                "status" => "error",
                "message" => "No active employees found"
            ];
            $statusCode = 404;
        }

        // Return a collection of $employees all employees
        return response()->json($data, $statusCode);
    }

    /**
     * get all inactive employees status
    */
    public function inactive() {
        $statusCode = 200;

        // Get all inactive employees
        $employees = new employeesModel();
        $employees = $employees->inactive(); // call getInactiveEmployees() function from employeesModel

        $data = [
            "status" => "success",
            "message" => "All inactive employees",
            "data" => $employees
        ];

        if (count($employees) == 0) {
            $data = [
                "status" => "error",
                "message" => "No inactive employees found"
            ];
            $statusCode = 404;
        }

        // Return a collection of $employees all employees
        return response()->json($data, $statusCode);
    }

    /**
     * get terminated employees status
    */
    public function terminated() {
        $statusCode = 200;

        // Get all terminated employees
        $employees = new employeesModel();
        $employees = $employees->terminated(); // call getTerminatedEmployees() function from employeesModel

        $data = [
            "status" => "success",
            "message" => "All terminated employees",
            "data" => $employees
        ];

        if (count($employees) == 0) {
            $data = [
                "status" => "error",
                "message" => "No terminated employees found"
            ];
            $statusCode = 404;
        }

        // Return a collection of $employees all employees
        return response()->json($data, $statusCode);
    }
}
