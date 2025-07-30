<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Helpers\AuthHelper;
use App\Traits\ApiResponse;
use App\Jobs\Contact\SendContactEmail;
use App\Jobs\Contact\ProcessContactData;
use App\Http\Requests\ContactFormRequest;
use App\Repositories\ContactRepositoryInterface;

class ContactController extends Controller
{
    use ApiResponse;
    protected $contacts;
    public function __construct(ContactRepositoryInterface $contacts)
    {
        $this->contacts = $contacts;
    }
    public function index()
    {
        AuthHelper::checkAdmin();
        $contacts = $this->contacts->all();
        ProcessContactData::dispatch($contacts);
        return $this->successResponse('Contacts fetched successfully!', ['data' => $contacts]);
    }
    public function store(ContactFormRequest $request)
    {
        $contact = $this->contacts->create($request->validated());
        SendContactEmail::dispatch($contact);
        return response()->json(['message' => 'Contact form submitted successfully!', 'data' => $contact]);
    }

    public function show($id)
    {
        AuthHelper::checkAdmin();
        $contact = $this->contacts->find($id);
        if ($contact) {
            $contact->is_read = 1;
            $contact->save();
        }
        return $this->successResponse('Contact details fetched successfully!', ['data' => $contact]);
    }
}
