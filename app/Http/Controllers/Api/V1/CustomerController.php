<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $customers = Customer::orderBy('id', 'desc')->paginate(10);
            return CustomerResource::collection($customers)->additional(['status' => 1, 'message' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something wrong'
            ]);
        }
    }

    public function store(CustomerRequest $request)
    {
        try {
            $inputs = $request->only(['name', 'email', 'address']);
            $save = Customer::create($inputs);
            $data = new CustomerResource($save);
            return response()->json([
                'status' => 1,
                'message' => 'Successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Fail'
            ]);
        }
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $inputs = $request->only(['name', 'email', 'address']);
            $customer->update($inputs);
            $data = new CustomerResource($customer);
            return response()->json([
                'status' => 1,
                'message' => 'Successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Fail'
            ]);
        }
    }

    public function customerData(Customer $customer)
    {
        try {
            $data = new CustomerResource($customer);
            return response()->json([
                'status' => 1,
                'message' => 'Success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Fail'
            ]);
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return response()->json([
                'status' => 1,
                'message' => 'Successfully Deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Fail'
            ]);
        }
    }
}
