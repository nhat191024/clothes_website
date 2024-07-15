<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Service\Client\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contactService;

    public function __construct(ContactService $contactService) {
        $this->contactService = $contactService;
    }
    public function index(){
        $contactUs = $this->contactService->getAll();
        return view('client.contact.index', compact('contactUs'));
    }
}
