<?php

namespace App\Service\Client;
use App\Models\ContactUs;
class ContactService {
    public function getAll(){
        return ContactUs::first();
    }
}