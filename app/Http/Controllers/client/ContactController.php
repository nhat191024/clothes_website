<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Service\Client\ContactService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerMessageRequest;

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
    public function store(StoreCustomerMessageRequest $request){
        $data = $this->contactService->prepare($request);
        $this->contactService->storeCustomerRequest($data);
        return redirect()->back();
    }
}
