<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Truncate tables
        User::truncate();
        Publisher::truncate();
        Author::truncate();
        Store::truncate();
        Genre::truncate();
        Book::truncate();

        // Create users
        User::factory(10)->create();

        $user1 = User::create([
            'email' => 'fj20180381@gmail.com',
            'name' => 'Filip',
            'password' => Hash::make('sifra12345') // Hash passwords
        ]);
        $user1->assignRole('customer');

        $user2 = User::create([
            'email' => 'vanja@gmail.com',
            'name' => 'Vanja',
            'password' => Hash::make('sifra12345') // Hash passwords
        ]);
        $user2->assignRole('customer');

        $user3 = User::create([
            'email' => 'admin@admin.com',
            'name' => 'Admin1',
            'password' => Hash::make('sifra12345') // Hash passwords
        ]);
        $user3->assignRole('admin');

        // Create publishers
        $laguna = Publisher::create(['name' => 'Laguna']);
        $prosveta = Publisher::create(['name' => 'Prosveta']);
        $otvorenaKnjiga = Publisher::create(['name' => 'Otvorena knjiga']);
        $kontrastIzdavastvo = Publisher::create(['name' => 'Kontrast izdavastvo']);
        $publikPraktikum = Publisher::create(['name' => 'Publik Praktikum']);

        // Create authors
        $hemingway = Author::create([
            'name' => 'Ernest Hemingvej',
            'bio' => 'Ernest Hemingvej (1899–1961) bio je američki pisac i novinar, jedan od najuticajnijih književnika 20. veka...'
        ]);
        $orvel = Author::create([
            'name' => 'Džordž Orvel',
            'bio' => 'Džordž Orvel (1903–1950) bio je britanski pisac, novinar i esejista...'
        ]);
        $bukovski = Author::create([
            'name' => 'Čarls Bukovski',
            'bio' => 'Čarls Bukovski (1920–1994) bio je američki pesnik, romanopisac i pisac kratkih priča...'
        ]);
        $tolkin = Author::create([
            'name' => 'Dž. R. R. Tolkin',
            'bio' => 'Dž. R. R. Tolkin (1892–1973) bio je britanski pisac, pesnik, filolog i profesor...'
        ]);

        // Create stores
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

        // Create genres
        $genre2 = Genre::create(['name' => 'Fantastika']);
        $genre3 = Genre::create(['name' => 'Drama']);
        $genre4 = Genre::create(['name' => 'Klasična književnost']);

        // Create books
        $book1 = Book::create([
            'title' => 'Pokretni praznik',
            'author_id' => $hemingway->id,
            'publisher_id' => $laguna->id,
            'price' => 1099.00,
        ]);
        $book1->stores()->attach([
            $store1->id => ['stock' => 6],
            $store2->id => ['stock' => 10],
        ]);
        $book1->genres()->sync([$genre4->id]);

        $book2 = Book::create([
            'title' => 'Niko i nista u Parizu i Londonu',
            'author_id' => $orvel->id,
            'publisher_id' => $laguna->id,
            'price' => 1099.00,
        ]);
        $book2->stores()->attach([
            $store1->id => ['stock' => 6],
            $store2->id => ['stock' => 10],
        ]);
        $book2->genres()->sync([$genre4->id, $genre3->id]);

        $book3 = Book::create([
            'title' => 'Gospodar Prstenova: Druzina prstena',
            'author_id' => $tolkin->id,
            'publisher_id' => $publikPraktikum->id,
            'price' => 1099.00,
        ]);
        $book3->stores()->attach([
            $store1->id => ['stock' => 6],
            $store2->id => ['stock' => 10],
        ]);
        $book3->genres()->sync([$genre2->id]);

        $book4 = Book::create([
            'title' => 'Gospodar Prstenova: Dve kule',
            'author_id' => $tolkin->id,
            'publisher_id' => $publikPraktikum->id,
            'price' => 1099.00,
        ]);
        $book4->stores()->attach([
            $store1->id => ['stock' => 6],
            $store2->id => ['stock' => 10],
        ]);
        $book4->genres()->sync([$genre2->id]);

        $book5 = Book::create([
            'title' => 'Gospodar Prstenova: Povratak kralja',
            'author_id' => $tolkin->id,
            'publisher_id' => $publikPraktikum->id,
            'price' => 1099.00,
        ]);
        $book5->stores()->attach([
            $store1->id => ['stock' => 6],
            $store2->id => ['stock' => 10],
        ]);
        $book5->genres()->sync([$genre2->id]);
    }
}
