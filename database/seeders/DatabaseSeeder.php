<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Publisher::factory(5)->create();
        
        // $authors = Author::factory(10)->create();
    
        // Book::factory(20)->create()->each(function ($book) use ($authors) {
        //     $book->authors()->attach(
        //         $authors->random(rand(1, 3))->pluck("id")
        //     );
        // });

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $publishers = collect([
            ['name' => 'Porto Editora',      'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/Porto_Editora_logo.svg/1200px-Porto_Editora_logo.svg.png'],
            ['name' => 'Leya',               'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Leya_logo.svg/1200px-Leya_logo.svg.png'],
            ['name' => 'Bertrand Editora',   'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Bertrand_logo.svg/1200px-Bertrand_logo.svg.png'],
            ['name' => 'Relógio d\'Água',    'logo' => 'https://relogiodagua.pt/wp-content/uploads/2020/01/logo.png'],
            ['name' => 'Dom Quixote',        'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Dom_Quixote_logo.svg/1200px-Dom_Quixote_logo.svg.png'],
        ])->map(fn($p) => Publisher::create($p));

        $authors = collect([
            ['name' => 'José Saramago',            'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5b/Jos%C3%A9_Saramago_%281%29.jpg/440px-Jos%C3%A9_Saramago_%281%29.jpg'],
            ['name' => 'Fernando Pessoa',          'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a8/Fernando_Pessoa_1914.jpg/440px-Fernando_Pessoa_1914.jpg'],
            ['name' => 'Eça de Queirós',           'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/E%C3%A7a_de_Queiroz.jpg/440px-E%C3%A7a_de_Queiroz.jpg'],
            ['name' => 'Luís de Camões',           'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/ninb/Cam%C3%B5es.jpg/440px-Cam%C3%B5es.jpg'],
            ['name' => 'Sophia de Mello',          'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/Sophia_de_Mello_Breyner_Andresen.jpg/440px-Sophia_de_Mello_Breyner_Andresen.jpg'],
            ['name' => 'António Lobo Antunes',     'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3b/Ant%C3%B3nio_Lobo_Antunes_2010.jpg/440px-Ant%C3%B3nio_Lobo_Antunes_2010.jpg'],
            ['name' => 'Miguel Torga',             'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Miguel_Torga.jpg/440px-Miguel_Torga.jpg'],
            ['name' => 'Agustina Bessa-Luís',      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Agustina_Bessa_Luis.jpg/440px-Agustina_Bessa_Luis.jpg'],
            ['name' => 'Vergílio Ferreira',        'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Verg%C3%ADlio_Ferreira.jpg/440px-Verg%C3%ADlio_Ferreira.jpg'],
            ['name' => 'José Rodrigues dos Santos','photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8e/Jos%C3%A9_Rodrigues_dos_Santos.jpg/440px-Jos%C3%A9_Rodrigues_dos_Santos.jpg'],
        ])->map(fn($a) => Author::create($a));

        $books = [
            [
                'title'        => 'O Memorial do Convento',
                'isbn'         => '9789722006095',
                'publisher'    => 'Leya',
                'bibliography' => 'Romance histórico passado no século XVIII, durante a construção do Convento de Mafra. Publicado em 1982, é considerado uma das obras maiores de Saramago.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722006095-L.jpg',
                'price'        => 14.90,
                'author'       => 'José Saramago',
            ],
            [
                'title'        => 'Ensaio sobre a Cegueira',
                'isbn'         => '9789722021095',
                'publisher'    => 'Leya',
                'bibliography' => 'Uma cidade é subitamente atingida por uma epidemia de cegueira branca. Obra distópica publicada em 1995, vencedora do Prémio Nobel.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722021095-L.jpg',
                'price'        => 13.50,
                'author'       => 'José Saramago',
            ],
            [
                'title'        => 'O Evangelho segundo Jesus Cristo',
                'isbn'         => '9789722013504',
                'publisher'    => 'Leya',
                'bibliography' => 'Reinterpretação da vida de Jesus Cristo sob um olhar humanista e crítico. Publicado em 1991, gerou grande polémica em Portugal.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722013504-L.jpg',
                'price'        => 15.00,
                'author'       => 'José Saramago',
            ],
            [
                'title'        => 'Mensagem',
                'isbn'         => '9789722501736',
                'publisher'    => 'Bertrand Editora',
                'bibliography' => 'Único livro publicado em vida por Fernando Pessoa em português. Colectânea de poemas sobre a história e o destino de Portugal, publicada em 1934.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722501736-L.jpg',
                'price'        => 9.90,
                'author'       => 'Fernando Pessoa',
            ],
            [
                'title'        => 'Livro do Desassossego',
                'isbn'         => '9789727082872',
                'publisher'    => 'Relógio d\'Água',
                'bibliography' => 'Obra fragmentária atribuída ao semi-heterónimo Bernardo Soares. Diário filosófico e poético publicado postumamente em 1982.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789727082872-L.jpg',
                'price'        => 16.50,
                'author'       => 'Fernando Pessoa',
            ],
            [
                'title'        => 'O Crime do Padre Amaro',
                'isbn'         => '9789722501583',
                'publisher'    => 'Bertrand Editora',
                'bibliography' => 'Primeiro romance de Eça de Queirós, publicado em 1875. Crítica feroz à hipocrisia clerical na sociedade portuguesa do século XIX.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722501583-L.jpg',
                'price'        => 11.90,
                'author'       => 'Eça de Queirós',
            ],
            [
                'title'        => 'Os Maias',
                'isbn'         => '9789722501750',
                'publisher'    => 'Bertrand Editora',
                'bibliography' => 'Considerado a obra-prima de Eça de Queirós. Crónica da decadência de uma família aristocrática portuguesa, publicada em 1888.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722501750-L.jpg',
                'price'        => 12.50,
                'author'       => 'Eça de Queirós',
            ],
            [
                'title'        => 'Os Lusíadas',
                'isbn'         => '9789720006994',
                'publisher'    => 'Porto Editora',
                'bibliography' => 'Epopeia de Luís de Camões publicada em 1572. Narra as viagens marítimas de Vasco da Gama e exalta os feitos dos portugueses.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789720006994-L.jpg',
                'price'        => 8.90,
                'author'       => 'Luís de Camões',
            ],
            [
                'title'        => 'Os Cus de Judas',
                'isbn'         => '9789722011037',
                'publisher'    => 'Dom Quixote',
                'bibliography' => 'Romance autobiográfico de Lobo Antunes sobre a guerra colonial em Angola. Publicado em 1979, é uma das obras mais marcantes da literatura portuguesa contemporânea.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722011037-L.jpg',
                'price'        => 13.90,
                'author'       => 'António Lobo Antunes',
            ],
            [
                'title'        => 'Fado Alexandrino',
                'isbn'         => '9789722013191',
                'publisher'    => 'Dom Quixote',
                'bibliography' => 'Romance coral sobre o regresso de soldados da guerra colonial. Publicado em 1983, retrata a sociedade portuguesa pós-25 de Abril.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722013191-L.jpg',
                'price'        => 14.50,
                'author'       => 'António Lobo Antunes',
            ],
            [
                'title'        => 'A Sibila',
                'isbn'         => '9789727082414',
                'publisher'    => 'Relógio d\'Água',
                'bibliography' => 'Obra de estreia de Agustina Bessa-Luís, publicada em 1954. Retrata duas gerações de mulheres transmontanas numa narrativa densa e poética.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789727082414-L.jpg',
                'price'        => 12.90,
                'author'       => 'Agustina Bessa-Luís',
            ],
            [
                'title'        => 'Bichos',
                'isbn'         => '9789722011976',
                'publisher'    => 'Dom Quixote',
                'bibliography' => 'Colectânea de contos de Miguel Torga publicada em 1940. Cada conto tem um animal como protagonista, numa visão trágica e telúrica do mundo.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722011976-L.jpg',
                'price'        => 11.00,
                'author'       => 'Miguel Torga',
            ],
            [
                'title'        => 'Aparição',
                'isbn'         => '9789722501903',
                'publisher'    => 'Bertrand Editora',
                'bibliography' => 'Romance existencialista de Vergílio Ferreira publicado em 1959. Considerado um marco do romance filosófico português do século XX.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722501903-L.jpg',
                'price'        => 12.00,
                'author'       => 'Vergílio Ferreira',
            ],
            [
                'title'        => 'Manhã Submersa',
                'isbn'         => '9789722501897',
                'publisher'    => 'Bertrand Editora',
                'bibliography' => 'Romance autobiográfico de Vergílio Ferreira sobre a infância num seminário. Publicado em 1954, retrata o conflito entre fé e razão.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789722501897-L.jpg',
                'price'        => 11.50,
                'author'       => 'Vergílio Ferreira',
            ],
            [
                'title'        => 'A Glória de Ser Português',
                'isbn'         => '9789897415784',
                'publisher'    => 'Leya',
                'bibliography' => 'Ensaio de José Rodrigues dos Santos publicado em 2021 sobre a identidade e história de Portugal numa perspectiva contemporânea.',
                'cover'        => 'https://covers.openlibrary.org/b/isbn/9789897415784-L.jpg',
                'price'        => 17.90,
                'author'       => 'José Rodrigues dos Santos',
            ],
        ];

        foreach ($books as $bookData) {
            $author    = $authors->firstWhere('name', $bookData['author']);
            $publisher = $publishers->firstWhere('name', $bookData['publisher']);

            $book = Book::create([
                'title'        => $bookData['title'],
                'isbn'         => $bookData['isbn'],
                'publisher_id' => $publisher->id,
                'bibliography' => $bookData['bibliography'],
                'cover'        => $bookData['cover'],
                'price'        => $bookData['price'],
            ]);

            $book->authors()->attach($author->id);
        }
    }
}
