<?php

namespace App\Service\Client;
use App\Models\CustomerRequest;
class CustomerRequestService {
    public function storeCustomerRequest($data){
        return CustomerRequest::create($data);
    }
}