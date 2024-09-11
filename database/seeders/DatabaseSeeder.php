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
            'format' => 'Mek povez',
            'cover_image_path' => 'images/pokretni_praznik_vv.jpg',
            'page_count' => 235,
            'description' => '"Pokretni praznik” jedna je od poslednjih knjiga američkog nobelovca Ernesta Hemingveja, puna slika iz piščevog života u Parizu u periodu između 1921. i 1926. godine. Ovo je autobiografsko delo “fluidnog žanra”, koje je Meri Hemingvej, piščeva četvrta žena, objavila tri godine po njegovoj smrti, uz napomenu da ju je on s prekidima pisao od 1957. do 1960. godine. Podeljen na dvadeset pojedinačnih poglavlja, “Pokretni praznik” se sastoji od svojevrsnih skica o Parizu s početka XX veka, o mnogim tadašnjim piscima i umetnicima, Hemingvejevom svakodnevnom životu (navike, život sa prvom ženom i sinom, nedostatak novca, druženje i razgovori po kafeima i knjižarama), njegovim poetičkim stavovima i, možda najvažnije, njegovoj posvećenosti pisanju.'
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
            'format' => 'Mek povez',
            'cover_image_path' => 'images/niko_i_nista_u_parizu_i_londonu_vv.jpg',
            'page_count' => 219,
            'description' => 'Niko i ništa u Parizu i Londonu (1933.) prva je objavljena knjiga Džordža Orvela. Sadrži tužne i savremenom čitaocu jezivo bliske životne ispovesti o ekstremnoj bedi londonskih skitnica i modernom ropstvu pomoćnih kuhinjskih radnika u hotelima Pariza. Ove priče-reportaže o pukom preživljavanju u tadašnjim najluksuznijim evropskim prestonicama su proistekle iz neobičnih društvenih eksperimenata u kojima se autor lično okušao kako bi preispitao predrasude i zablude o siromaštvu i teškom radu.

„Masu bogatih i siromašnih razdvajaju njihovi prihodi i ništa drugo, a prosečni milioner je samo prosečni perač sudova odeven u novo odelo.“

Orvel je smatrao da je veliki problem to što se inteligentni, kultivisani ljudi, baš oni ljudi od kojih bi se moglo očekivati da imaju liberalne stavove, nikada ne druže sa siromašnima. Upravo taj jaz je pokušao da premosti ovom, a i svojim kasnijim knjigama: Burmanski dani, Sveštenikova kći, Samo nek aspidistre lete, U borbi za vazduh...'
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
            'format' => 'Mek povez',
            'cover_image_path' => 'images/gospodar_prstenova_-_druzina_prstena_mek_povez_vv.jpg',
            'page_count' => 484,
            'description' => 'Kada ekscentrični Hobit Bilbo Bagins na oproštajnoj zabavi povodom svog 111. rođendana iznenada i naočigled zaprepašćenih gostiju volšebno nestane, u idiličnom Okrugu pokrenuće se lanac događaja koji će uzdrmati čitav Srednji svet i odrediti njegovu sudbinu. Bilbo je, naime, odlučio da ostatak života provede u vilovnjačkom carstvu Rivendal, i svu svoju imovinu ostavio je mladom rođaku Frodu Baginsu, uključujući i tajanstveni prsten koji njegovog nosioca čini nevidljivim. Ali dok se oprašta sa starim prijateljem Gandalfom, moćni čarobnjak shvata da je Bilbov prsten mnogo više od rekvizita za hobitske trikove...

Tri prstena za prste kraljeva vilin-vrste pod nebesima što sjaju, Sedam za vladare Patuljaka u dvoru njihovom kamnom, Devet za Smrtne Ljude koje smrt čeka na kraju, Jedan za Mračnog Gospodara na njegovom prestolu tamnom U Zemlji Mordor gde Senke traju. Jedan Prsten da svima gospodari, jedan za svima seže, Jedan Prsten da sve okupi i u tami ih sveže U Zemlji Mordor gde Senke traju.

Epska priča o zaboravljenim i ponovo izmišljenim vremenima u kojima su zemljom hodali Ljudi, Čarobnjaci, Vilovnjaci, Patuljci i Hobiti. Dok se senka moćnog gospodara zla Saurona nadvija nad svetom, a potmuli bat njegovih hordi preti poslednjim ratom, Družina Prstena kreće na dugo i opasno putovanje: čarobnjak Gandalf, vilovnjak Legolas, patuljak Gimli, zapovednik ljudske vojske Boromir, potomak kralja od davnina Aragorn i četiri mala „polušana” – Pipin, Veseli, Sem i Frodo. Udružuju se u pohodu na Mordor, da bi tamo, na Planini Usuda, uništili Jedinstveni Prsten, jedino što Sauronu nedostaje da postane nepobediv.'
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
            'format' => 'Mek povez',
            'cover_image_path' => 'images/gospodar_prstenova_-_dve_kule_mek_povez_vv.jpg',
            'page_count' => 407,
            'description' => 'Družina Prstena je na svom pohodu prošla razna iskušenja i na kraju se raspala - Gandalf je u borbi s demonom Balrogom nestao u utrobi zemlje, Boromir je najpre podlegao mračnoj moći Prstena a zatim poginuo u napadu Orka, dok su Pipin i Veseli oteti. Frodo, nakon što se uverio koliko mračna moć Prstena utiče na svakoga ko dođe u dodir s njim, odlučuje da put u Mordor nastavi sâm. Ipak, verni Sem ga ne napušta.

Dok putuju ka Planini Usuda, teret koji Frodo nosi sve je teži... U stopu ih prati Golum - upropašćeni stvor ide za Prekrasnim, koji je nekad posedovao, a koji mu je Bilbo Bagins odneo. Ako misle da nađu put do Mordora, Frodo i Sem moraju da prihvate Golumovo nepouzdano savezništvo. 

Daleko odatle, prateći trag otetih Hobita Pipina i Veselog, Aragorn, Legolas i Gimli shvataju da je Sauronova vojska Orka sve brojnija, i da je početak Rata sve bliži. Saruman, Sauronov sluga, u Izengardu stvara čudovišnu rasu Orka i kreće na zemlju Rohan. Preživeli članovi Družine okupljaju saveznike i spremaju se za odsudnu bitku, znajući da će njihova pobeda biti uzaludna ako Frodo ne stigne na cilj...'
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
            'format' => 'Mek povez',
            'page_count' => 467,
            'cover_image_path' => 'images/gospodar_prstenova_-_povratak_kralja_mek_povez_vv.jpg',
            'description' => 'Iako poražene u prvoj velikoj bici Rata za Prsten, armije Mračnog Gospodara sve su moćnije i spremaju se na pohod na Minas Tirit, prestonicu Gondora, najmoćnijeg kraljevstva Ljudi. Pad Gondora značio bi i trijumf Zla i kraj Srednjeg sveta. Dok Ljudi, Patuljci i Vilovnjaci ujedinjuju snage u odbrani „belog grada” Minis Tirita, Frodo i Sem nastavljaju svoj tegoban put u Mordor.

Rat se rasplamsava, ali njegov konačni ishod odlučiće nemogući poduhvat dva mala Hobita da unište Jedinstveni Prsten tamo gde ga je Mračni Gospodar i napravio: u vatrenoj utrobi Planine Usuda.

Epilog epske priče o poslednjem zajedničkom pohodu Hobita, Ljudi, Vilovnjaka, Patuljaka, Enta i Čarobnjaka na srce zla, Mordor, da bi se sprečila propast. Najteži zadatak poveren je najslabijoj i najmanjoj među svim rasama koje su naseljavale Tolkinov svet. Hoće li uspeti, hoće li Frodo stići na odredište - i po koju cenu...'
        ]);
        $book5->stores()->attach([
            $store1->id => ['stock' => 6],
            $store2->id => ['stock' => 10],
        ]);
        $book5->genres()->sync([$genre2->id]);
    }
}
