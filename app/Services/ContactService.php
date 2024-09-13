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
  
            $contact = Contact::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
            ]);

  
            if (isset($data['phones'])) {
                foreach ($data['phones'] as $phoneNumber) {
                    Phone::create([
                        'contact_id' => $contact->id,
                        'phone_number' => $phoneNumber,
                    ]);
                }
            }


            if (isset($data['emails'])) {
                foreach ($data['emails'] as $emailAddress) {
                    Email::create([
                        'contact_id' => $contact->id,
                        'email_address' => $emailAddress,
                    ]);
                }
            }

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

    public function updateContact($id, $data)
    {
        $contact = Contact::findOrFail($id);

        $contact->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name']
        ]);

        $this->syncPhones($contact, $data['phones'] ?? []);
        $this->syncEmails($contact, $data['emails'] ?? []);
        $this->syncAddresses($contact, $data['addresses'] ?? []);

        return $contact;
    }


    private function syncPhones(Contact $contact, array $phones)
    {
        $contact->phones()->delete();
        foreach ($phones as $phone) {
            $contact->phones()->create(['phone_number' => $phone]);
        }
    }

    private function syncEmails(Contact $contact, array $emails)
    {
        $contact->emails()->delete();
        foreach ($emails as $email) {
            $contact->emails()->create(['email_address' => $email]);
        }
    }
    private function syncAddresses(Contact $contact, array $addresses)
    {
        $contact->addresses()->delete(); 
        foreach ($addresses as $address) {
            $contact->addresses()->create([
                'street' => $address['street'],
                'city' => $address['city'],
                'state' => $address['state'],
                'postal_code' => $address['postal_code']
            ]);
        }
    }

    public function deleteContact($id)
    {

        $contact = Contact::findOrFail($id);
        $contact->phones()->delete();
        $contact->emails()->delete();
        $contact->addresses()->delete();
        $contact->delete();
    }
}
