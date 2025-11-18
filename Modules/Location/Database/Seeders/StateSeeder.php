<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Location\Http\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = 1;
        $data = [
            ["id" => $id++, "name" => "Nilphamari", "abbreviation" => "NIL", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Dinajpur", "abbreviation" => "DIN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Brahmanbaria", "abbreviation" => "BRA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Rangamati", "abbreviation" => "RAN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Noakhali", "abbreviation" => "NOA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Chandpur", "abbreviation" => "CHA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Lakshmipur", "abbreviation" => "LAK", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Chattogram", "abbreviation" => "CHA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Coxsbazar", "abbreviation" => "COX", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Khagrachhari", "abbreviation" => "KHA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Bandarban", "abbreviation" => "BAN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Sirajganj", "abbreviation" => "SIR", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Pabna", "abbreviation" => "PAB", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Bogura", "abbreviation" => "BOG", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Rajshahi", "abbreviation" => "RAJ", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Natore", "abbreviation" => "NAT", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Joypurhat", "abbreviation" => "JOY", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Chapainawabganj", "abbreviation" => "CHA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Naogaon", "abbreviation" => "NAO", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Jashore", "abbreviation" => "JAS", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Satkhira", "abbreviation" => "SAT", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Meherpur", "abbreviation" => "MEH", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Narail", "abbreviation" => "NAR", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Chuadanga", "abbreviation" => "CHU", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Kushtia", "abbreviation" => "KUS", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Magura", "abbreviation" => "MAG", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Khulna", "abbreviation" => "KHU", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Bagerhat", "abbreviation" => "BAG", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Jhenaidah", "abbreviation" => "JHE", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Jhalakathi", "abbreviation" => "JHA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Patuakhali", "abbreviation" => "PAT", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Pirojpur", "abbreviation" => "PIR", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Barisal", "abbreviation" => "BAR", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Bhola", "abbreviation" => "BHO", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Barguna", "abbreviation" => "BAR", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Sylhet", "abbreviation" => "SYL", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Moulvibazar", "abbreviation" => "MOU", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Habiganj", "abbreviation" => "HAB", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Sunamganj", "abbreviation" => "SUN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Narsingdi", "abbreviation" => "NAR", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Gazipur", "abbreviation" => "GAZ", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Shariatpur", "abbreviation" => "SHA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Narayanganj", "abbreviation" => "NAR", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Tangail", "abbreviation" => "TAN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Kishoreganj", "abbreviation" => "KIS", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Manikganj", "abbreviation" => "MAN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Dhaka", "abbreviation" => "DHA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Munshiganj", "abbreviation" => "MUN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Rajbari", "abbreviation" => "RAJ", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Madaripur", "abbreviation" => "MAD", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Gopalganj", "abbreviation" => "GOP", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Faridpur", "abbreviation" => "FAR", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Panchagarh", "abbreviation" => "PAN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],

            ["id" => $id++, "name" => "Feni", "abbreviation" => "FEN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Lalmonirhat", "abbreviation" => "LAL", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Comilla", "abbreviation" => "COM", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Gaibandha", "abbreviation" => "GAI", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Thakurgaon", "abbreviation" => "THA", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Rangpur", "abbreviation" => "RAN", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Kurigram", "abbreviation" => "KUR", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Sherpur", "abbreviation" => "SHE", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Mymensingh", "abbreviation" => "MYM", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Jamalpur", "abbreviation" => "JAM", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
            ["id" => $id++, "name" => "Netrokona", "abbreviation" => "NET", "country_id" => 1, "order" => $id, "is_default" => 0, "status" => 1],
        ];
        State::upsert($data, ['name']);
    }
}
