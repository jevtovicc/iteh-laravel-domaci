<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate();
        Publisher::truncate();
        Author::truncate();
        Store::truncate();
        Genre::truncate();
        Book::truncate();

        User::factory(10)->create();

        $laguna = Publisher::create(['name' => 'Laguna']);
        $prosveta = Publisher::create(['name' => 'Prosveta']);
        $otvorenaKnjiga = Publisher::create(['name' => 'Otvorena knjiga']);
        $kontrastIzdavastvo = Publisher::create(['name' => 'Kontrast izdavastvo']);
        $publikPraktikum = Publisher::create(['name' => 'Publik Praktikum']);

        $hemingway = Author::create([
            'name' => 'Ernest Hemingvej',
            'bio' => 'Ernest Hemingvej (1899–1961) bio je američki pisac i novinar, jedan od najuticajnijih književnika 20. veka. Poznat po svom sažetom stilu pisanja i temama koje istražuju hrabrost, gubitak i rat, Hemingvej je osvojio Nobelovu nagradu za književnost 1954. godine. Neka od njegovih najpoznatijih dela uključuju romane "Starac i more", "Zbogom oružje" i "Za kim zvono zvoni". Hemingvej je takođe bio poznat po svom avanturističkom životnom stilu, često inspirisan boravkom u ratnim zonama i egzotičnim lokacijama.'
        ]);

        $orvel = Author::create([
            'name' => 'Džordž Orvel',
            'bio' => 'Džordž Orvel (1903–1950) bio je britanski pisac, novinar i esejista, poznat po svojim delima koja kritikuju totalitarizam, socijalnu nepravdu i zloupotrebu moći. Njegova najpoznatija dela su "1984", distopijski roman o autoritarnom društvu pod stalnim nadzorom, i "Životinjska farma", alegorijska priča o Sovjetskoj revoluciji. Orvelov stil je jasan i direktan, a njegova dela često istražuju teme slobode, kontrole i istine. Smatra se jednim od najuticajnijih pisaca 20. veka.'
        ]);

        $bukovski = Author::create([
            'name' => 'Čarls Bukovski',
            'bio' => 'Čarls Bukovski (1920–1994) bio je američki pesnik, romanopisac i pisac kratkih priča, poznat po svom sirovom i iskrenom stilu pisanja. Njegova dela često prikazuju svakodnevni život marginalizovanih ljudi, koristeći autobiografske elemente i istražujući teme alkohola, siromaštva, neuspelih veza i borbe sa sistemom. Bukovski je bio glas tzv. "underground" kulture, a njegova najpoznatija dela su romani "Pošta", "Bludni sin" i zbirke poezije poput "Ljubav je pas iz pakla". Njegov stil karakterišu direktnost, humor i brutalna iskrenost.'
        ]);

        $tolkin = Author::create([
            'name' => 'Dž. R. R. Tolkin',
            'bio' => 'Dž. R. R. Tolkin (1892–1973) bio je britanski pisac, pesnik, filolog i profesor, najpoznatiji po stvaranju epskih fantastičnih dela. Njegovo najčuvenije delo je trilogija "Gospodar prstenova", zajedno sa romanom "Hobit" i posthumno objavljenim "Silmarilionom", koji su postavili temelje moderne epske fantastike. Tolkin je stvorio čitav svet – Srednju Zemlju – s detaljnim jezicima, kulturama i mitologijama. Njegov stil je bogat i slojevit, a on se smatra jednim od najuticajnijih pisaca u žanru fantastike.'
        ]);

        $store1 = Store::create([
            'name' => 'Knjižara SKC',
            'location' => 'Kralja Milana 48'
        ]);

        $store2 = Store::create([
            'name' => 'Knjižara „Jovan Jovanović Zmaj“',
            'location' => 'Zmaj Jovina 12'
        ]);

        $store3 = Store::create([
            'name' => 'Knjižara "Borislav Pekic"',
            'location' => 'Knez Mihailova 48'
        ]);

        Genre::create(['name' => 'Epska fantastika']);
        Genre::create(['name' => 'Fantastika']);
        Genre::create(['name' => 'Drama']);
        Genre::create(['name' => 'Klasična književnost']);

        Book::create([
            'title' => 'Pokretni praznik',
            'author_id' => $hemingway->id,
            'publisher_id' => $laguna->id,
            'store_id' => $store1->id,
            'price' => 1099.00,
            'stock' => 6,
        ]);

        Book::create([
            'title' => 'Niko i nista u Parizu i Londonu',
            'author_id' => $orvel->id,
            'publisher_id' => $laguna->id,
            'store_id' => $store2->id,
            'price' => 1099.00,
            'stock' => 3,
        ]);

        Book::create([
            'title' => 'Gospodar Prstenova: Druzina prstena',
            'author_id' => $tolkin->id,
            'publisher_id' => $publikPraktikum->id,
            'store_id' => $store2->id,
            'price' => 1099.00,
            'stock' => 5,
        ]);

        Book::create([
            'title' => 'Gospodar Prstenova: Dve kule',
            'author_id' => $tolkin->id,
            'publisher_id' => $publikPraktikum->id,
            'store_id' => $store2->id,
            'price' => 1099.00,
            'stock' => 5,
        ]);

        Book::create([
            'title' => 'Gospodar Prstenova: Povratak kralja',
            'author_id' => $tolkin->id,
            'publisher_id' => $publikPraktikum->id,
            'store_id' => $store2->id,
            'price' => 1099.00,
            'stock' => 5,
        ]);
    }
}
