<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class ContactService
{
    public function getAllContacts()
    {
        
        return Contact::with(['phones', 'emails', 'addresses'])
            ->paginate(50); 
    }

    public function createContact(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Crear el contacto
            $contact = Contact::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
            ]);

            // Crear teléfonos
            if (isset($data['phones'])) {
                foreach ($data['phones'] as $phoneNumber) {
                    Phone::create([
                        'contact_id' => $contact->id,
                        'phone_number' => $phoneNumber,
                    ]);
                }
            }

            // Crear correos electrónicos
            if (isset($data['emails'])) {
                foreach ($data['emails'] as $emailAddress) {
                    Email::create([
                        'contact_id' => $contact->id,
                        'email_address' => $emailAddress,
                    ]);
                }
            }

            // Crear direcciones
            if (isset($data['addresses'])) {
                foreach ($data['addresses'] as $addressData) {
                    Address::create([
                        'contact_id' => $contact->id,
                        'street' => $addressData['street'],
                        'city' => $addressData['city'],
                        'state' => $addressData['state'],
                        'postal_code' => $addressData['postal_code'],
                    ]);
                }
            }

            return $contact;
        });
    }
}
