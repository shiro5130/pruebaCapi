<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Address;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Crear 5000 contactos
        for ($i = 0; $i < 5000; $i++) {
            // Crear un contacto
            $contact = Contact::create([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
            ]);

            // Crear entre 1 y 3 teléfonos para cada contacto
            for ($j = 0; $j < rand(1, 3); $j++) {
                Phone::create([
                    'contact_id' => $contact->id,
                    'phone_number' => $faker->phoneNumber,
                ]);
            }

            // Crear entre 1 y 2 emails para cada contacto
            for ($k = 0; $k < rand(1, 2); $k++) {
                Email::create([
                    'contact_id' => $contact->id,
                    'email_address' => $faker->safeEmail,
                ]);
            }

            // Crear entre 1 y 2 direcciones para cada contacto
            for ($l = 0; $l < rand(1, 2); $l++) {
                Address::create([
                    'contact_id' => $contact->id,
                    'street' => $faker->streetAddress,
                    'city' => $faker->city,
                    'state' => $faker->state,
                    'postal_code' => $faker->postcode,
                ]);
            }
        }
    }
}
