<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Service\Client\ContactService;
use App\Http\Requests\StoreCustomerMessageRequest;

class ContactController extends Controller
{
    private $contactService;

    public function __construct()
    {
        $this->contactService = app(contactService::class);
    }

    public function index()
    {
        $contactUs = $this->contactService->getAll();
        return view('client.contact.index', compact('contactUs'));
    }

    public function store(StoreCustomerMessageRequest $request)
    {
        $data = $this->contactService->prepare($request);
        $this->contactService->storeCustomerRequest($data);
        return redirect()->back();
    }
}
