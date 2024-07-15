<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Service\Client\CustomerRequestService;
use Illuminate\Http\Request;

class CustomerRequestController extends Controller
{
    protected $customerRequestService;
    public function __construct(CustomerRequestService $customerRequestService) {
        $this->customerRequestService = $customerRequestService;
    }

    public function store(Request $request){

        $request -> validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,

        ];

        $this->customerRequestService->storeCustomerRequest($data);
        return redirect()->back();
    }
}
