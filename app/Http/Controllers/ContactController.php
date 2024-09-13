<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Illuminate\Http\Request;

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
        // Obtener los datos validados
        $validatedData = $request->validated();

        // Llamar al servicio para actualizar el contacto
        $contact = $this->contactService->updateContact($id, $validatedData);

        // Retornar la respuesta
        return response()->json([
            'message' => 'Contact updated successfully',
            'contact' => $contact
        ], 200);
    }
}
