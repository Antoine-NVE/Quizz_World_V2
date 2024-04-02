<?php

namespace App\DataFixtures;

use App\Entity\Propositions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PropositionsFixtures extends Fixture implements DependentFixtureInterface
{
    private static $questionCounter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->create(self::PROPOSITIONS_CATEGORY_1, $manager);
        $this->create(self::PROPOSITIONS_CATEGORY_2, $manager);
        $this->create(self::PROPOSITIONS_CATEGORY_3, $manager);
        $this->create(self::PROPOSITIONS_CATEGORY_4, $manager);
        $this->create(self::PROPOSITIONS_CATEGORY_5, $manager);
        $this->create(self::PROPOSITIONS_CATEGORY_6, $manager);
        $this->create(self::PROPOSITIONS_CATEGORY_7, $manager);
        $this->create(self::PROPOSITIONS_CATEGORY_8, $manager);
        $this->create(self::PROPOSITIONS_CATEGORY_9, $manager);

        $manager->flush();
    }

    // Fonction qui crée les 120 propositions d'une catégorie
    public function create(array $entryPropositions, ObjectManager $manager)
    {
        // On divise le tableau en 3 parties
        foreach ($entryPropositions as $propositionsQuestion) {
            // On redivise chaque partie en 10 parties
            for ($i = 0; $i < 10; $i++) {
                // On redivise ces dernières en 4 propositions et on crée une instance pour chacune
                foreach ($propositionsQuestion[$i] as $propositionChoice) {
                    $proposition = new Propositions();
                    $proposition->setProposition($propositionChoice);
                    $proposition->setQuestion($this->getReference('question-' . self::$questionCounter));

                    $manager->persist($proposition);
                }

                self::$questionCounter++;
            }
        }
    }

    public function getDependencies()
    {
        return [QuestionsFixtures::class];
    }

    private const PROPOSITIONS_CATEGORY_1 = [
        [
            ["Word", "PowerPoint", "Excel", "Access"],
            ["Traitement de texte", "Client de messagerie", "Tableur", "Navigateur internet"],
            ["Un spam", "Un virus", "Un crack", "Un bug"],
            ["Windows CE", "Windows 8", "Windows 7", "Windows Mobile"],
            ["USB", "PAO", "VGA", "CIO"],
            ["iTunes", "FileMaker", "QuickTime", "HyperCard"],
            ["Un tableur", "Un navigateur", "Un explorateur", "Un débogueur"],
            ["Un blagueur", "Un pirateur", "Un forceur", "Un hacker"],
            ["Des navigateurs", "Des éditeurs", "Des tableurs", "Des émulateurs"],
            ["Google Mobile", "Google TimeLine", "Google Agenda", "Google Tempo"]
        ], [
            ["Facebook", "Microsoft", "Apple", "Google"],
            ["Linux", "MS-DOS", "Mac OS", "Windows"],
            ["Google Apps", "Google Mac", "Google Pro", "Google Serve"],
            ["Un adware", "Un software", "Un malware", "Un freeware"],
            ["Backelite", "Valve", "Instagram", "Globalnet"],
            ["Lettrinter", "Copitel", "Courriel", "Emel"],
            ["QuickTime", "Skype", "Pidgin", "Instagram"],
            ["Safari", "Firefox", "Chrome", "Internet Explorer"],
            ["Un antivirus", "Un navigateur", "Une messagerie", "Un chat"],
            ["Jean-Paul II", "François", "Benoît XVI", "Paul VI"]
        ], [
            ["Thunderbird", "Foxmail", "Incredimail", "Sylpheed"],
            ["Office 365", "KOffice", "OpenOffice", "StarOffice"],
            ["Uranus", "Janus", "Opus", "Startus"],
            ["MediaFire", "Dropbox", "RapidShare", "Onedrive"],
            ["Komunnity", "Connect", "Pidgin", "iShare"],
            ["Google Sites", "Google Documents", "OpenOffice", "Works"],
            ["Norvège", "France", "Autriche", "Italie"],
            ["Mozilla Firefox", "Google Chrome", "Internet Explorer", "Acrobat Reader"],
            ["35 milliards", "15 milliards", "5 milliards", "25 milliards"],
            ["Le 2 janvier 1999", "Le 15 janvier 2002", "Le 8 décembre 2000", "Le 23 mars 2001"]
        ]
    ];
    private const PROPOSITIONS_CATEGORY_2 = [
        [
            ["supprespaces(ch1)", "ch1.trim()", "trim(ch1)", "ch1.supprespaces()"],
            ["for()", "switch()", "if()", "while()"],
            ["append()", "unite()", "join()", "concat()"],
            ["01 Janvier 1900", "01 Janvier de l'an 0", "01 Janvier 1850", "01 Janvier 1970"],
            ["boolean", "false", "true", "integer"],
            ["length(Nom)", "Nom.width", "width(Nom)", "Nom.length"],
            ["var T1=array(20)", "var T1(20)", "T1=new Array(20)", "var T1[20]"],
            ["setTimeout()", "wait()", "SetTimer()", "sleep()"],
            ["location()", "window.location.href", "url()", "window.location.url"],
            ["4", "PI", "la racine carrée de 2", "une erreur"]
        ],
        [
            ["c'est impossible", "rollback()", "history.back()", "previous()"],
            ["T1.count()", "T1.length", "length(T1)", "T1.last()"],
            ["T1.inverse()", "T1.rollout", "T1.reverse()", "T1.transpose()"],
            ["event.which", "KeyAscii", "fromCharCode", "event.CharCode"],
            ["&", "le point", "this", "->"],
            ["end", "break", "exit", "continue"],
            ["A", "une erreur", "true", "1"],
            ["this", "create", "prototype", "new"],
            ["SUBMIT, RESET et BUTTON", "SUBMIT et RESET", "SUBMIT", "SUBMIT et BUTTON"],
            ["nettoyer la salle de bain", "interroger un serveur web", "exécuter JavaScript sur un serveur", "exécuter des contrôles ActiveX"]
        ],
        [
            ["NaN (Not a Number)", "101", "une erreur", "18"],
            ["true", "une erreur", "Y", "Z"],
            ["onFocusDown", "onFocusOff", "onBlur", "onDeselect"],
            ["open.url()", "open.html()", "window.open()", "url.open()"],
            ["preload()", "load Image()", "new Image()", "cache()"],
            ["deux erreurs", "i et i+1", "i+1 et i+1", "i+1 et une erreur"],
            ["document", "window", "body", "form"],
            ["mysql_db_query", "http_get_request", "XMLparseRequest", "XMLHttpRequest"],
            ["addEventListener()", "XMLHttpRequest()", "on()", "event()"],
            ["for(T1[]<>NULL) { }", "for(each(T1[]) { }", "for(i in T1) { }", "for(T1[i]) { }"]
        ]
    ];
    private const PROPOSITIONS_CATEGORY_3 = [
        [
            ["1936", "1956", "1946", "1926"],
            ["1968", "1938", "1948", "1958"],
            ["1939", "1914", "1940", "1938"],
            ["1926", "1936", "1946", "1916"],
            ["1942", "1914", "1916", "1940"],
            ["1963", "1953", "1973", "1983"],
            ["1950", "1960", "1980", "1970"],
            ["1954", "1964", "1944", "1974"],
            ["1945", "1975", "1955", "1965"],
            ["1929", "1939", "1919", "1949"]
        ],
        [
            ["1964", "1944", "1954", "1974"],
            ["1957", "1947", "1967", "1977"],
            ["1965", "1975", "1985", "1995"],
            ["1962", "1952", "1972", "1982"],
            ["1947", "1977", "1967", "1957"],
            ["1956", "1946", "1936", "1926"],
            ["1935", "1925", "1915", "1905"],
            ["1947", "1967", "1977", "1957"],
            ["1953", "1963", "1973", "1943"],
            ["1978", "1948", "1958", "1968"]
        ],
        [
            ["1913", "1933", "1943", "1923"],
            ["1915", "1905", "1935", "1925"],
            ["1972", "1982", "1962", "1952"],
            ["1911", "1901", "1921", "1931"],
            ["1955", "1975", "1965", "1945"],
            ["1928", "1918", "1908", "1938"],
            ["1933", "1943", "1913", "1923"],
            ["1967", "1937", "1947", "1957"],
            ["1929", "1919", "1949", "1939"],
            ["1968", "1948", "1958", "1938"]
        ]
    ];
    private const PROPOSITIONS_CATEGORY_4 = [
        [
            ["Luigi", "Wario", "Peach", "Mario"],
            ["Game Boy", "Nintendo DS", "Super Nintendo", "Game Cube"],
            ["Luigi", "Mylord", "Wario", "Peach"],
            ["Wii Play", "Wii Sports", "Wii Games", "Wii Mix"],
            ["Birbo", "Peach", "Yoshi", "Kirby"],
            ["King Kong", "Mookie", "Donkey Kong", "Abu"],
            ["Direct Shot", "Dual Screen", "Detect System", "Data Super"],
            ["Printer", "Advance", "Pocket", "Color"],
            ["Wii Balance Board", "Wii Zapper", "Wii Gun", "Wii Shot"],
            ["Pinky", "Kirby", "Yoshi", "Dadidou"]
        ],
        [
            ["Un aspirateur", "Un lance-flammes", "Une raquette", "Un marteau"],
            ["Jumpman", "Link", "Yoshi", "Zelda"],
            ["Revolution", "Nintendo 64", "Super GameCube", "Wiitendo"],
            ["SachaLand", "Kong City", "Dream Land", "Bourg Palette"],
            ["Wii Wiz", "Wii Shot", "Wii Gun", "Wii Zapper"],
            ["GameCube", "Nintendo 64", "Wii", "Famicom"],
            ["Game Boy", "Advance", "DS", "DS Lite"],
            ["DS", "Famicom", "Nintendo 64", "GameCube"],
            ["BONUS", "HELP !", "SMILE", "PUSH"],
            ["Virtual Boy", "Wii", "Game Cube", "3DS"]
        ],
        [
            ["Louie", "Pikmin", "Olimar", "Kirby"],
            ["Charpentier", "Boulanger", "Pizzaïolo", "Magicien"],
            ["Revolution", "Dolphin", "Game 128", "Famicom"],
            ["3", "5", "2", "4"],
            ["Kyoto", "Tokyo", "Shanghai", "Pékin"],
            ["Eikichi", "Din", "Nayru", "Farore"],
            ["Des dés à jouer", "Des montres", "Des livres", "Des cartes à jouer"],
            ["DS3D", "DSi", "Advance", "DS Lite"],
            ["1972", "1982", "1962", "1992"],
            ["Zelda", "Daisy", "Pauline", "Lady"]
        ]
    ];
    private const PROPOSITIONS_CATEGORY_5 = [
        [
            ["40", "12", "100", "10"],
            ["15 ans", "14 ans", "16 ans", "13 ans"],
            ["173", "86", "1", "87"],
            ["Trois", "Un", "Quatre", "Deux"],
            ["800", "600", "900", "700"],
            ["32 mm", "25 mm", "45 mm", "16 mm"],
            ["11 ans", "17 ans", "15 ans", "13 ans"],
            ["100", "500", "50", "40"],
            ["1946", "1956", "1966", "1976"],
            ["24", "20", "16", "28"]
        ],
        [
            ["512", "32", "256", "1 024"],
            ["1992", "1990", "1988", "1994"],
            ["2 934", "1 394", "2 394", "1 934"],
            ["39", "69", "49", "59"],
            ["18 m", "29 m", "37 m", "45 m"],
            ["120", "80", "100", "140"],
            ["8 %", "32 %", "19 %", "25 %"],
            ["17", "21", "19", "25"],
            ["19 000", "22 000", "13 000", "16 000"],
            ["6 666", "9 999", "7 777", "8 888"]
        ],
        [
            ["1 073 m", "1 146 m", "1 280 m", "996 m"],
            ["14", "16", "12", "18"],
            ["80", "40", "60", "100"],
            ["29", "9", "39", "19"],
            ["7 100 km", "8 300 km", "6 700 km", "9 700 km"],
            ["37 km", "53 km", "29 km", "42 km"],
            ["1 732 tonnes", "4 437 tonnes", "2 828 tonnes", "3 474 tonnes"],
            ["6 000", "4 000", "10 000", "8 000"],
            ["1795", "1902", "1847", "1829"],
            ["140 000", "120 000", "180 000", "160 000"]
        ]
    ];
    private const PROPOSITIONS_CATEGORY_6 = [
        [
            ["Redmond", "Londres", "New-York", "Paris"],
            ["Xbox", "Wii", "PlayStation", "Game Gear"],
            ["Paul Allen", "Elon Musk", "Alex Spanos", "Larry Ellison"],
            ["Freight Simulator", "Fight Simulator", "Fog Simulator", "Flight Simulator"],
            ["Lumia", "Loumnia", "Lomna", "Loubna"],
            ["Windows VE", "Windows RE", "Windows TE", "Windows ME"],
            ["FourDrive", "TwoDrive", "ThreeDrive", "OneDrive"],
            ["Tabsoft", "Hurricane", "Storm", "Surface"],
            ["1975", "1985", "1995", "2005"],
            ["Opale", "Operating", "Operator", "Opera"]
        ],
        [
            ["Steve Stones", "Satya Nadella", "Steve Ballmer", "Steve Jobs"],
            ["Melissa", "Melanie", "Melinda", "Mandy"],
            ["2 milliards de dollars", "500 millions de dollars", "1 milliard de dollars", "150 millions de dollars"],
            ["Triplé", "Doublé", "Quintuplé", "Quadruplé"],
            ["2011", "2009", "2008", "2001"],
            ["RunTime", "RandTime", "RogueTime", "Officiellement aucune"],
            ["Xbox Gun", "Konect", "Kinect", "PowerShot"],
            ["6 ans", "4 ans", "5 ans", "3 ans"],
            ["Rollo", "Doro", "Aero", "Zorro"],
            ["1 fois", "4 fois", "2 fois", "3 fois"]
        ],
        [
            ["Rectangulaire", "Ovale", "Ronde", "Carrée"],
            ["65 millions", "30 millions", "15 millions", "90 millions"],
            ["Skinproject", "Skinput", "Tinyput", "Skinfall"],
            ["Deux", "Cinq", "Quatre", "Trois"],
            ["Netscape", "NetView", "NetPlan", "NetBrowser"],
            ["Motang", "Mojing", "Mojang", "Mojung"],
            ["Ben", "John", "Runny", "Spartan"],
            ["ChromeBooks", "Tbooks", "WinBooks", "Ebooks"],
            ["Microsoft Lace", "Microsoft Pace", "Microsoft Bracelet", "Microsoft Band"],
            ["100 000 m²", "8 km²", "900 000 m²", "80 km²"]
        ]
    ];
    private const PROPOSITIONS_CATEGORY_7 = [
        [
            ["get_session()", "session_id()", "\$_SESSION['ID']", "\$_SESSION['ID_PHP']"],
            ["W3C/html", "text/html", "html", "html 4.01"],
            ["PHPSESSID suivi de l'id", "'sess_' suivi de l'id", "'tmp_sess_' suivi de l'id", "le nom correspond à l'id"],
            ["Directory -denied0", "Options -indexes", "Options none", "Diretory disable"],
            ["print(COOKIE['ck1'])", "print(\$_COOKIE['ck1'])", "print(POST['ck1'])", "print(\$_POST['ck1'])"],
            ["fopen('fichier.txt','w+')", "write('fichier.txt','a')", "write('fichier.txt','w+')", "fopen('fichier.txt','a')"],
            ["instr()", "faire une boucle", "in_array()", "find()"],
            ["4", "-4", "-3", "3"],
            ["orderby()", "ascending()", "asc()", "sort()"],
            ["construct()", "implement()", "new", "->"]
        ],
        [
            ["image/png", "html/xml", "text/csv", "application/pdf"],
            ["n'existe pas en php", "sert à vider un tableau", "libère les octets occupés par un tableau", "place le pointeur au début du tableau"],
            ["4", "Une erreur", "4,7", "5"],
            ["header()", "des balises <head> </head>", "ce n'est pas possible", "write_header()"],
            ["surcharge", "implémentation", "instanciation", "construction"],
            ["à interdire d'étendre la classe", "à libérer de l'espace mémoire", "à émettre une exception", "sert de destructeur"],
            ["Michael Widenius", "Steve Wozniak", "Rasmus Lerdorf", "Linus Torvalds"],
            ["copier une variable", "copier un fichier", "copier un tableau", "copier une chaine"],
            ["PHP 6 et MySQL 5.1", "PHP 4.2 et MySQL 4.1", "PHP 5 et MySQL 5", "PHP 5 et MySQL 4.1"],
            ["write_file()", "fwrite()", "write()", "put()"]
        ],
        [
            ["session_stop()", "session_unset()", "unset(\$_SESSION[])", "session_destroy()"],
            ["SESSION_PHP", "PHPSESSID", "SESSIONID", "SESSION_INIT"],
            ["\$GET['nom']", "\$_POST['nom']", "\$POST['nom']", "GET['nom']"],
            ["encode \$chaine comme POST", "'http://' suivi de \$chaine", "crypte \$chaine", "encode \$chaine comme GET"],
            ["512 Ko", "4 Ko", "2 Ko", "1 Ko"],
            ["SEND", "SUBMIT", "GET", "POST"],
            ["set()", "set_cookie()", "setcookie()", "cookie()"],
            ["ce test n'existe pas", "vrai si \$a et \$b sont de même type", "est toujours vrai", "vrai si \$a = \$b et si de même type"],
            ["bcdef", "1", "0", "une erreur"],
            ["un ensemble de commandes SQLite", "une bibliothèque graphique pour PHP", "un compilateur PHP", "une distribution PHP libre de droits"]
        ]
    ];
    private const PROPOSITIONS_CATEGORY_8 = [
        [
            ["Butineur", "Internaute", "Navigateur", "Webmaster"],
            ["Sauvegarde", "Courrier", "Navigation", "Recherche"],
            ["Esperluette", "Croisillon", "Astérisque", "Arobase"],
            ["Pandocréon", "Wikipédia", "Framasoft", "Netalya"],
            ["Encyclopédies", "Routeurs", "Moteurs", "Navigateurs"],
            ["Messagerie", "Navigateur", "Chat", "Antivirus"],
            ["Butineur", "Geek", "Hacker", "No life"],
            ["Adresses", "Favoris", "Extensions", "Onglets"],
            ["Spam", "Cookie", "Chat", "Hoax"],
            ["Fibre", "RNIS", "Wi-Fi", "ADSL"]
        ],
        [
            ["Modem", "Serveur", "Wi-Fi", "Routeur"],
            ["Courriel", "Enveloppe", "Progiciel", "Navigateur"],
            ["Serveur", "Modem", "CD-ROM", "Wi-Fi"],
            ["Worse", "Wide", "World", "Web"],
            ["49", "1 024", "100", "10 000"],
            ["Safari", "Firefox", "Chrome", "Internet Explorer"],
            ["Commercial", "Communautaire", "Communication", "Commémoration"],
            ["Mozilla Firefox", "Acrobat Reader", "Google Chrome", "Internet Explorer"],
            ["Hoax", "Spam", "Bug", "Cookie"],
            ["Hacker", "Driver", "Surfeur", "Cracker"]
        ],
        [
            ["Adresse IP", "Antivirus", "Écran", "Bornage"],
            ["Backup", "Plug-in", "Spool", "Byte"],
            ["Bug", "Virus", "Hoax", "Cookie"],
            ["Cupcake", "Spam", "Modem", "Cookie"],
            ["1991", "1981", "1971", "1961"],
            ["Gravure", "Sauvegarde", "Aspiration", "Copie"],
            ["KBD", "TCP", "URL", "MP3"],
            ["Ses 45 ans", "Ses 35 ans", "Ses 25 ans", "Ses 15 ans"],
            ["HTTP", "IPX/SPX", "FTP", "TCP/IP"],
            ["Reboot", "Nétiquette", "Phishing", "Hameçonnage "]
        ]
    ];
    private const PROPOSITIONS_CATEGORY_9 = [
        [
            ["Yoda", "Anakin Skywalker", "Leia", "Mace Windu"],
            ["Anakin Skywalker", "Yado", "Yoda", "Jabba"],
            ["Zodiak", "Jedi", "Table ronde", "Samourai"],
            ["La Lune obscure", "L'Étoile qui tue", "Le côté obscur", "L'Étoile Noire"],
            ["Obiwana", "Madpe", "Leia Organa", "Sénatrice Padme"],
            ["De nexu", "De acklay", "De module", "De nodule"],
            ["La Force", "Le langage droïde", "La lumière", "L'immortalité"],
            ["Les siths", "Les Ch'tis", "Les Vicks", "Les friths"],
            ["Chewbacca", "Obi-Wan Kenobi", "Luke Skywalker", "Han Solo"],
            ["L'armée des clones", "Les Gungans", "Les Bantha", "Les faucons"]
        ],
        [
            ["Palpatine", "Valorum", "Yoda", "Padme Amidala"],
            ["Luke Skywalker", "Obi-Wan Kenobi", "Han Solo", "Anakin Skywalker"],
            ["Yoda tue Dooku", "Il gagne le duel", "Il perd une main", "Dooku le tue"],
            ["Anakin Skywalker", "Qui Go Jin", "Obiwan Kenobi", "Mace Windu"],
            ["Adi Gallia", "Ki-Adi-Mundi", "Qui-Gon Jinn", "Plo Koon"],
            ["Dark Maul", "Dark Leouf", "Dark Sidious", "Dark Pantouf"],
            ["Intergalactique", "Faucon Millénium", "Anneau Solaire", "Enterprise"],
            ["Han Solo", "Luke Skywalker", "Obi-Wan Kenobi", "Dark Vador"],
            ["Dagobah", "Tatooine", "Naboo", "Mustafar"],
            ["Jabba le Hutt", "Han Solo", "Zam Wesell", "Boba Fett"]
        ],
        [
            ["Midi-chloriens", "Meti-chlorien", "Chlorydrate", "Chlori-Metica"],
            ["Plus de 20 000", "Plus de 5 000", "Plus de 1 000", "Plus de 10 000"],
            ["Dark Bane", "Dark Tyranus", "Dark Vador", "Dark Plagueis"],
            ["3 et 4", "5 et 6", "1 à 3", "2 et 3"],
            ["Bataille de Jaku", "Bataille de Coruscant", "Bataille de Naboo", "Bataille de Yavin"],
            ["L'avoir retrouvé", "L'avoir sauvé", "L'avoir aimé", "L'avoir trahi"],
            ["Lando Calrissian", "Watto", "Boba Fett", "Jabba le Hutt"],
            ["Dagobah", "Utapau", "Naboo", "Malastare"],
            ["Han Solo", "Dark Vador", "Luke Skywalker", "La princesse Leia"],
            ["28 ans", "24 ans", "26 ans", "30 ans"]
        ]
    ];
}
