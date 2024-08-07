<?php

namespace App\Service\client;
use App\Models\ContactUs;
use App\Models\CustomerRequest;

class ContactService {
    public function getAll(){
        return ContactUs::first();
    }
    public function storeCustomerRequest($data){
        return CustomerRequest::create($data);
    }
    public function prepare($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
        ];
    }
}
