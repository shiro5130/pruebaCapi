<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    protected $contactService;

    
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function store(StoreContactRequest $request) 
    {
        $validatedData = $request->validated();
        $contact = $this->contactService->createContact($validatedData);
        return response()->json([
            'message' => 'Contact created successfully',
            'contact' => $contact
        ], 201);
    }

    public function index(Request $request)
    {
    
        $contacts = $this->contactService->getAllContacts();

     
        return response()->json([
            'contacts' => $contacts
        ], 200);
    }
    public function update(UpdateContactRequest $request, $id)
    {
        $validatedData = $request->validated();

        $contact = $this->contactService->updateContact($id, $validatedData);

        return response()->json([
            'message' => 'Contact updated successfully',
            'contact' => $contact
        ], 200);
    }

    public function destroy($id)
    {
    
        try {
            $this->contactService->deleteContact($id);
            return response()->json([
                'message' => 'Contacto eliminado correctamente'
            ], Response::HTTP_NO_CONTENT); 
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'El contacno no fue encontrado',
            ], Response::HTTP_NOT_FOUND); 
        }
    
    }
}
