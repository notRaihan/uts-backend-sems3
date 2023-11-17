<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\employees_contactModel;
use App\Models\employees_addressModel;
use Illuminate\Support\Arr;

class employeesModel extends Model
{
    use HasFactory;

    // call table employees
    protected $table = 'employees';

    // call fillable column
    protected $fillable = [
        'name',
        'gender',
        'status',
        'hired_on'
    ];

    // get all employees with contact and address
    public function getAll()
    {
        return $this->with('contact', 'address')->get();
    }

    // create new employees also create contact and address
    public function createNew($data)
    {
        $employee = $this->create($data);

        // create contact and address
        $employee->contact()->create(['phone' => $data['phone'], 'email' => $data['email']]);
        $employee->address()->create(['address' => $data['address']]);

        return $employee;
    }

    // get employees by id with contact and address
    public function getById($id)
    {
        return $this->with('contact', 'address')->where('id', $id)->first();
    }

    // update employees by id also update contact and address
    public function updateById($id, $data)
    {
        $employee = $this->find($id);

        if (!$employee) {
            return false;
        } // return false if employee not found


        $employee->update($data);

        if (isset($data['phone']) || isset($data['email'])) {
            $contactData = Arr::only($data, ['phone', 'email']);
            $employee->contact()->update($contactData);
        } // update contact if phone or email is set

        if (isset($data['address'])) {
            $employee->address()->update(['address' => $data['address']]);
        } // update address if address is set

        return $employee;
    }

    // delete employees by id also delete contact and address
    public function deleteById($id)
    {
        $employee = $this->find($id);

        if (!$employee) {
            return false;
        } // return false if employee not found

        $employee->contact()->delete();
        $employee->address()->delete();
        $employee->delete();

        return true;
    }

    //search employees by name
    public function searchByName($name)
    {
        return $this->where('name', 'like', '%' . $name . '%')->with('contact', 'address')->get();
    }



    // get all active employees status
    public function active()
    {
        return $this->where('status', 'active')->get();
    }

    //get all inactive employees status
    public function inactive()
    {
        return $this->where('status', 'inactive')->get();
    }

    //get all terminated employees status
    public function terminated()
    {
        return $this->where('status', 'terminated')->get();
    }



    // call relationship
    public function contact()
    {
        return $this->hasOne(employees_contactModel::class, 'employees_id');
    }

    public function address()
    {
        return $this->hasOne(employees_addressModel::class, 'employees_id');
    }
}
