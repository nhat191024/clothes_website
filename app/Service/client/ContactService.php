<?php

namespace App\Service\Client;
use App\Models\ContactUs;

class contactService{
    public function getAll(){
        return ContactUs::first();
    }
}