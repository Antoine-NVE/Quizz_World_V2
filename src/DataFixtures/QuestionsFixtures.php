<?php

namespace App\DataFixtures;

use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionsFixtures extends Fixture implements DependentFixtureInterface
{
    private static $questionnaireCounter = 1;
    private static $questionCounter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->create(self::QUESTIONS_CATEGORY_1, self::ANSWERS_CATEGORY_1, self::ANECDOTES_CATEGORY_1, $manager);
        $this->create(self::QUESTIONS_CATEGORY_2, self::ANSWERS_CATEGORY_2, self::ANECDOTES_CATEGORY_2, $manager);
        $this->create(self::QUESTIONS_CATEGORY_3, self::ANSWERS_CATEGORY_3, self::ANECDOTES_CATEGORY_3, $manager);
        $this->create(self::QUESTIONS_CATEGORY_4, self::ANSWERS_CATEGORY_4, self::ANECDOTES_CATEGORY_4, $manager);
        $this->create(self::QUESTIONS_CATEGORY_5, self::ANSWERS_CATEGORY_5, self::ANECDOTES_CATEGORY_5, $manager);
        $this->create(self::QUESTIONS_CATEGORY_6, self::ANSWERS_CATEGORY_6, self::ANECDOTES_CATEGORY_6, $manager);
        $this->create(self::QUESTIONS_CATEGORY_7, self::ANSWERS_CATEGORY_7, self::ANECDOTES_CATEGORY_7, $manager);
        $this->create(self::QUESTIONS_CATEGORY_8, self::ANSWERS_CATEGORY_8, self::ANECDOTES_CATEGORY_8, $manager);
        $this->create(self::QUESTIONS_CATEGORY_9, self::ANSWERS_CATEGORY_9, self::ANECDOTES_CATEGORY_9, $manager);

        $manager->flush();
    }

    // Fonction qui crée les 30 questions d'une catégorie
    public function create(array $entryQuestions, array $entryAnswers, array $entryAnecdotes, ObjectManager $manager): void
    {
        // On divise le tableau en 3 parties qui correspondent chacune à un questionnaire
        foreach ($entryQuestions as $key => $questions) {
            // Pour chacune des 10 questions de la partie, on crée une instance
            for ($i = 0; $i < 10; $i++) {
                $question = new Questions();
                $question->setQuestion($questions[$i]);
                $question->setAnswer($entryAnswers[$key][$i]);
                $question->setAnecdote($entryAnecdotes[$key][$i]);
                $question->setQuestionnaire($this->getReference('questionnaire-' . self::$questionnaireCounter));

                $this->addReference('question-' . self::$questionCounter, $question);
                self::$questionCounter++;

                $manager->persist($question);
            }

            self::$questionnaireCounter++;
        }
    }

    public function getDependencies()
    {
        return [QuestionnairesFixtures::class];
    }

    private const QUESTIONS_CATEGORY_1 = [
        [
            "Quel logiciel de traitement de texte a été mis au point par Microsoft ?",
            "Le logiciel Excel extrait de la suite bureautique Microsoft Office est un...",
            "En informatique, comment appelle-t-on une erreur de programmation encore non localisée ?",
            "Quelle version de Windows Microsoft a-t-il lancé le vendredi 26 octobre 2012 ?",
            "Comment est communément abrégée la publication assistée par ordinateur ?",
            "Quelle application informatique de la société Apple permet de gérer facilement un iPod ?",
            "En informatique, quel logiciel permet de créer des calculs automatiques ?",
            "Quel pirate informatique casse les systèmes informatique et les logiciels protégés ?",
            "Quels logiciels installés sur PC, tablette ou smartphone, permettent de « surfer » sur Internet ?",
            "Quel outil développé par le géant Google permet de gérer son emploi du temps ?"
        ], [
            "Quelle grande société a reçu le feu vert en  2011 pour le rachat de 'Skype' ?",
            "Quel est probablement le plus connu des systèmes informatiques dits « libre » ?",
            "Quelle est le nom de la solution professionnelle de services Google ?",
            "Quel logiciel est mis gratuitement et librement à disposition par son créateur ?",
            "En avril 2012, quelle start-up Facebook a-t-il racheté pour un milliard de dollars ?",
            "Au Québec, quel mot est souvent utilisé pour désigner le courrier électronique ?",
            "Quel logiciel de Microsoft a remplacé 'Windows Live Messenger' en 2013 ?",
            "Quel nom portait le navigateur Internet de Microsoft, devenu aujourd'hui 'Microsoft Edge' ?",
            "Quel logiciel est indispensable pour protéger votre ordinateur sur Internet ?",
            "Qui est le tout premier pape à avoir envoyé un message sur 'Twitter' ?"
        ], [
            "Quel courrielleur créé par Mozilla est le compagnon idéal du navigateur 'Firefox' ?",
            "Quel nom porte la suite bureautique en ligne proposée par Microsoft ?",
            "Quel était le nom de code de la version 3.1 de Windows ?",
            "Quel nom porte le service de stockage en ligne de Windows Live ?",
            "Quel est le nouveau nom du logiciel gratuit de messagerie instantanée 'Gaim' ?",
            "Quelle suite logicielle équivaut à Microsoft Office chez le géant Google ?",
            "De quel pays la suite logicielle gratuite 'Opera' est-elle originaire ?",
            "Lequel de ces outils ne permet pas de visionner des pages web ?",
            "Combien de téléchargements dénombrait-on sur le célèbre 'App Store' fin 2012 ?",
            "Quelle est la date « officielle » de création de 'Wikipédia' en Français ?"
        ]
    ];
    private const ANSWERS_CATEGORY_1 = [
        [
            "Word",
            "Tableur",
            "Un bug",
            "Windows 8",
            "PAO",
            "iTunes",
            "Un tableur",
            "Un hacker",
            "Des navigateurs",
            "Google Agenda"
        ], [
            "Microsoft",
            "Linux",
            "Google Apps",
            "Un freeware",
            "Instagram",
            "Courriel",
            "Skype",
            "Internet Explorer",
            "Un antivirus",
            "Benoît XVI"
        ], [
            "Thunderbird",
            "Office 365",
            "Janus",
            "Onedrive",
            "Pidgin",
            "Google Documents",
            "Norvège",
            "Acrobat Reader",
            "35 milliards",
            "Le 23 mars 2001"
        ]
    ];
    private const ANECDOTES_CATEGORY_1 = [
        [
            "Microsoft publie plusieurs logiciels de traitement de texte, mais 'Word' en reste la « vedette ».",
            "Excel a été critiqué pour ses problèmes de précision sur calculs à virgule flottante.",
            "La gravité du dysfonctionnement informatique peut aller de bénigne à majeure.",
            "La version Windows 8.1 est une mise à jour gratuite de Windows 8 disponible depuis 2013.",
            "La PAO consiste à créer des documents imprimés en travaillant la composition et la typographie de documents.",
            "'iTunes' faisait partie de la suite logicielle d'Apple 'iLife' jusqu'à la version '06.",
            "Une feuille de calcul est une table d'informations la plupart du temps financières.",
            "Certains utilisent ce savoir-faire dans un cadre légal, d'autres étant hors-la-loi.",
            "Le premier navigateur stable et largement diffusé fut 'NCSA Mosaic', en 1993.",
            "'Google Agenda' permet de partager des événements et des agendas et de les publier sur internet ou sur un site Web."
        ], [
            "'Skype' est un logiciel gratuit qui permet de passer des appels téléphoniques et vidéo via Internet, ainsi que le partage d'écran.",
            "Linux est un système informatique qui fonctionne sur du matériel allant du téléphone portable au supercalculateur.",
            "Ce site Web au service des entreprises met en ligne de nombreuses applications.",
            "Il ne faut toutefois pas confondre freeware (gratuiciel) et shareware (partagiciel).",
            "'Instagram' est une application  cofondée et lancée par l'américain Kevin Systrom et le Brésilien Michel Mike Krieger en octobre 2010.",
            "Le courriel tend à être reconnu comme moyen valide de contacter une personne.",
            "'Skype' a été fondé en Estonie par Niklas Zennström et Janus Friis en 2003 et développé par 3 Estoniens à l'origine du logiciel 'KaZaA'.",
            "La version 11 du navigateur sera toujours présente dans Windows 10 avant le passage progressif à Microsoft Edge.",
            "Les antivirus peuvent balayer le contenu d'un disque dur, mais également la mémoire vive de l'ordinateur.",
            "Réputé conservateur, le cardinal Ratzinger a été élu le 19 avril 2005 pour succéder à Jean-Paul II."
        ], [
            "Tout comme 'Firefox', 'Thunderbird' et son interface en XUL est basé sur le moteur Gecko.",
            "Les abonnements 'Office 365' pour les particuliers permettent de bénéficier de la version complète de la suite Office que l'on connaît.",
            "La version 3 a été la première à connaître un large succès, permettant à Microsoft de rivaliser avec l'Apple Macintosh.",
            "Ce service en ligne de stockage et d'applications, créé en 2007, est une manifestation du concept de cloud computing.",
            "'Gaim' a été renommé en 'Pidgin' en 2007 en raison de plaintes de la société AOL et de sa marque AIM.",
            "'Google Documents' est une suite des évolutions de 'Google Spreadsheets' et de 'Writely', logiciel de traitement de texte.",
            "'Opera' est un navigateur Web développé par la société norvégienne Opera Software, qui propose plusieurs logiciels relatifs à Internet.",
            "Adobe change régulièrement le nom des produits de la famille Acrobat et cela en subdivisant ses produits.",
            "Depuis la mise à jour du système d'exploitation d'Apple iOS 7 en septembre 2013, l''App Store' possède un tout nouveau design.",
            "Plusieurs moyens de consulter l'encyclopédie existent, tels que des sites web miroirs ou des applications pour smartphone."
        ]
    ];

    private const QUESTIONS_CATEGORY_2 = [
        [
            "Comment supprimer les espaces en début et fin de la chaîne ch1 ?",
            "Pour tester de nombreuses conditions sur la même variable on utilise ?",
            "Quelle fonction est l'inverse de split() ?",
            "La valeur d'une date représente le nombre de millisecondes écoulées depuis le ?",
            "Que retourne typeof (1>2) ?",
            "Comment trouver la longueur de la variable Nom ?",
            "De quelle façon déclare-t-on un tableau T1 de 20 éléments ?",
            "Quelle fonction permet de temporiser l'exécution d'une commande ?",
            "Comment se rendre à l'url : 'http://www.quizz_world.com' ?",
            "Math.max(Math.SQRT2 , Math.PI , 4) retourne ?"
        ],
        [
            "Comment afficher la page précédente du navigateur ?",
            "De quelle façon peut-on récupérer le nombre d'éléments d'un tableau T1 ?",
            "Comment inverser un tableau T1 ?",
            "Avec l'événement 'onKeyPressed', quelle propriété stocke le code ASCII de la touche appuyée ?",
            "Avec quoi peut-on faire référence à l'objet courant ?",
            "Comment sortir d'une boucle for() ou while() ?",
            "Qu'affiche String.fromCharCode(65) ?",
            "Quel mot clé sert à ajouter des propriétés ou méthodes à un objet existant ?",
            "Quels sont les différents types de boutons possibles de la balise &lt;INPUT&gt; ?",
            "AJAX peut servir à "
        ],
        [
            "parseInt('101 dalmatiens'); renvoie",
            "Si ch1='WXYZ', que retourne ch1.CharAT(3)",
            "Quel est l'événement inverse de onFocus ?",
            "Quelle instruction ouvre une nouvelle fenêtre ?",
            "Comment télécharger et mettre une image en cache afin d'éviter les délais d'affichage ?",
            "alert(i++); et alert(++i); renvoient ",
            "Dans la hiérarchie des objets, quel est le parent direct de l'objet 'checkbox' ?",
            "Quel objet permet au JavaScript de dialoguer avec un serveur web ?",
            "Quelle méthode JavaScript est utilisée pour rattacher un gestionnaire d'évènements à un élément de la page ?",
            "Comment parcourir toutes les valeurs du tableau T1 ?"
        ]
    ];
    private const ANSWERS_CATEGORY_2 = [
        [
            "ch1.trim()",
            "switch()",
            "join()",
            "01 Janvier 1970",
            "boolean",
            "Nom.length",
            "T1=new Array(20)",
            "setTimeout()",
            "window.location.href",
            "4"
        ],
        [
            "history.back()",
            "T1.length",
            "T1.reverse()",
            "event.which",
            "this",
            "break",
            "A",
            "prototype",
            "SUBMIT, RESET et BUTTON",
            "interroger un serveur web"
        ],
        [
            "101",
            "une erreur",
            "onBlur",
            "window.open()",
            "new Image()",
            "i et i+1",
            "form",
            "XMLHttpRequest",
            "addEventListener()",
            "for(i in T1) { }"
        ]
    ];
    private const ANECDOTES_CATEGORY_2 = [
        [
            "La méthode trim() ne modifie pas la chaîne d'origine.",
            "L'expression switch est évaluée une fois.",
            "La méthode join() renvoie un tableau sous forme de chaîne. N'importe quel séparateur peut être spécifié. La valeur par défaut est la virgule (,).",
            "C'est le Timestamp Unix",
            "L'opérateur typeof renvoie une chaîne qui indique le type de son opérande.",
            "La propriété 'length' représente la longueur d'une chaîne de caractères. C'est une propriété accessible en lecture seule.",
            "T1[0] est le premier élément, T1[19] est le dernier élément.",
            "La méthode 'setTimeout()' appelle une fonction après un certain nombre de millisecondes : setTimeout(function, milliseconds);",
            "'window.location.href' peut être utilisé pour obtenir l'adresse de la page actuelle (URL) et pour rediriger le navigateur vers une nouvelle page",
            "La méthode 'Math.max()' renvoie le nombre avec la valeur la plus élevée."
        ],
        [
            "La méthode 'history.back()' ne fonctionne que si une page précédente existe.",
            "'T1.length' est toujours supérieure au plus grand indice du tableau.",
            "La méthode 'T1.reverse()' modifie le tableau courant et renvoie une référence à ce tableau.",
            "la dernière spécification des événements DOM recommande d'utiliser la propriété 'key' à la place",
            "'this' n'est pas une variable. C'est un mot clé. Vous ne pouvez pas modifier la valeur de 'this'.",
            "L'instruction 'continue' « saute » une itération dans la boucle.",
            "La méthode 'String.fromCharCode()' convertit les valeurs Unicode en caractères.",
            "Conseil : Ne modifiez que vos propres prototypes. Ne modifiez jamais les prototypes d'objets JavaScript standards.",
            "",
            "AJAX permet de mettre à jour une page Web sans recharger la page, mais aussi d'envoyer des données à un serveur web en arrière plan"
        ],
        [
            "La méthode 'parseInt' analyse une valeur sous forme de chaîne et renvoie le premier entier.",
            "Attention au camelCase en JavaScript !!!",
            "L'événement 'onblur' se produit lorsqu'un objet perd le focus.",
            "La méthode 'open()' ouvre une nouvelle fenêtre de navigateur ou un nouvel onglet, selon les paramètres de votre navigateur et les valeurs des paramètres.",
            "Le constructeur 'Image()' crée une nouvelle instance HTMLImageElement, équivalent à 'document.createElement('img')'",
            "i++ incrémente la valeur et renvoie la valeur avant incrément, ++i renvoie la valeur après incrément",
            "L'interface 'HTMLFormElement' représente un élément &lt;form&gt; dans le DOM",
            "Tous les navigateurs modernes prennent en charge l'objet 'XMLHttpRequest', aujourd'hui on utilisera plutôt l'API Fetch() de JavaScript.",
            "La méthode 'removeEventListener()' permet de supprimer un gestionnaire d'évènements sur un élément",
            "L'instruction 'for...in' permet d'itérer sur les propriétés énumérables d'un objet"
        ]
    ];

    private const QUESTIONS_CATEGORY_3 = [
        [
            "En France, de quand datent les congés payés ainsi que la semaine de quarante heures ?",
            "Quand a débuté la Cinquième République en France, succédant à la Quatrième République ?",
            "Quelle est l'année du début de la Seconde Guerre mondiale, conflit armé à l'échelle planétaire ?",
            "En quelle année a eu lieu la Bataille de Verdun du 21 février au 19 décembre ?",
            "En quelle année a eu lieu la première Bataille de la Marne, mettant en échec le plan Schlieffen ?",
            "En quelle année Kennedy, souvent désigné par ses initiales JFK, a-t-il été assassiné ?",
            "En quelle année est mort Charles de Gaulle, grand homme dÉtat français ?",
            "En quelle année les Accords de Genève ont-ils marqué la fin de la guerre d'Indochine ?",
            "En quelle année Charles De Gaulle a-t-il été élu au suffrage universel ?",
            "En quelle année une crise économique mondiale sans précédent s'est-elle déclenchée aux États-Unis ?"
        ],
        [
            "En quelle année s'est déroulée la Conférence de Brazzaville avec le général de Gaulle ?",
            "En quelle année le Plan Marshall a-t-il permis de redresser l'économie européenne ?",
            "Jusque quand Franco a-t-il gouverné l'Espagne, avant l'arrivée au pouvoir de Juan Carlos ?",
            "La Guerre d'Algérie a pris fin avec les Accords d'Évian qui furent signés en quelle année ?",
            "En quelle année fut signé à  Rome le traité sur le fonctionnement de l'Union européenne ?",
            "En France, de quand date la victoire du Front Populaire, coalition de partis de gauche ?",
            "Quelle est l'année du torpillage du paquebot Lusitania et des premières attaques au gaz ?",
            "En quelle année la France est-elle entrée dans la CEE pour mener une intégration économique ?",
            "En quelle année Salvador Allende a-t-il trouvé la mort durant le coup d'État du général Pinochet ?",
            "A partir de quelle année Fidel Catro a-t-il dirigé Cuba en renversant le régime de Batista ?"
        ],
        [
            "Quelle est l'année de la nomination d'Hitler comme chancelier du Reich ?",
            "En quelle année le Japon a-t-il battu l'Empire russe durant la bataille de Tsushima ?",
            "En quelle année la visite de Nixon à Pékin a-t-elle marqué la fin de l'isolement diplomatique chinois ?",
            "En quelle année l'Irlande du Sud, anciennement britannique, est-il devenu indépendant ?",
            "En quelle année a eu lieu la Conférence de Bandung sur la décolonisation ?",
            "Quelle est l'année de l'abdication de Guillaume II et de l'exécution du tsar Nicolas II ?",
            "Quelle est l'année du putsch manqué d'Hitler et de la faillite de l'économie allemande ?",
            "En quelle année les Britanniques ont-ils quitté l'Inde, ancienne colonie d'Asie ?",
            "La République Populaire de Chine fut proclamée en quelle année ?",
            "Quand Churchill a-t-il déclaré : « Nous sommes en face d'une catastrophe de première grandeur » ?"
        ]
    ];
    private const ANSWERS_CATEGORY_3 = [
        [
            "1936",
            "1958",
            "1939",
            "1916",
            "1914",
            "1963",
            "1970",
            "1954",
            "1965",
            "1929"
        ],
        [
            "1944",
            "1947",
            "1975",
            "1962",
            "1957",
            "1936",
            "1915",
            "1957",
            "1973",
            "1958"
        ],
        [
            "1933",
            "1905",
            "1972",
            "1921",
            "1955",
            "1918",
            "1923",
            "1947",
            "1949",
            "1938"
        ]
    ];
    private const ANECDOTES_CATEGORY_3 = [
        [
            "Les congés payés sont une innovation sociale majeure dont certaines prémices étaient apparues en Allemagne.",
            "Elle marque une rupture par rapport à la tradition parlementaire de la République française.",
            "Ce conflit planétaire opposa schématiquement deux camps : les Alliés et l'Axe.",
            "Cette bataille a vu une moyenne de 70 000 victimes pour chacun des dix mois du conflit.",
            "Cette bataille doit être distinguée de la seconde bataille de la Marne, qui se déroula en juillet 1918.",
            "Son assassinat reste à ce jour, pour beaucoup, non résolu, alimentant les rumeurs et les hypothèses les plus folles.",
            "Charles de Gaulle est le premier à occuper la magistrature suprême sous la Cinquième République.",
            "Depuis 1946, la guerre d'Indochine opposait principalement la France au Viet Minh dirigé par Ho Chi Minh.",
            "Sa vision du pouvoir l'oppose aux partis communiste, socialiste, centristes pro-européens et d'extrême droite.",
            "La Grande Dépression va du krach de 1929 aux États-Unis jusqu'à la Seconde Guerre mondiale."
        ],
        [
            "À l'issue de cette conférence, l'abolition du code de l'indigénat est décidée ainsi qu'une politique d'assimilation en faveur des colonies.",
            "Les milliards débloqués ne furent pas un don mais un prêt accordé par des banques américaines.",
            "Selon l'historien franquiste Ricardo de la Cierva, il s'agissait pour Franco de sauver l'Espagne du chaos.",
            "Après l'indépendance, ce fut le tour d'une guerre civile algérienne qui se termina en septembre 1963.",
            "Le Traité de Maastricht a renommé la Communauté économique européenne en Communauté européenne.",
            "Il réunissait les trois principaux partis de la gauche, la SFIO, le Parti radical-socialiste et le Parti communiste.",
            "Son torpillage, avec plus de 1 200 passagers, joua un rôle important dans l'hostilité des États-Unis envers l'Allemagne.",
            "Charles de Gaulle utilisa son droit de veto à l'entrée du Royaume-Uni dans les communautés.",
            "Salvador Allende se suicida dans le palais de la Moneda, sous les bombes putschistes.",
            "Ses détracteurs et des organisations de défense des droits de l'Homme dénoncent son gouvernement comme une dictature."
        ],
        [
            "L'année suivante, il se fait aussitôt plébisciter en août 1934 comme chef de l'État, portant le titre de Führer.",
            "Il s'agit du principal affrontement naval de la guerre russo-japonaise (février 1904 - septembre 1905).",
            "Cette visite est devenue une métaphore en anglais pour parler d'une action inhabituelle d'un politicien.",
            "Le Parlement de l'Irlande du Sud de l'Irlande ne s'est réuni qu'une seule fois avec seulement quatre membres présents.",
            "La conférence à réuni pour la première fois les représentants de vingt-neuf pays africains et asiatiques.",
            "Sans descendance, Guillaume II eut pour héritier son lointain cousin catholique Albert de Wurtemberg.",
            "Le putsch de Munich se déroula principalement à la Bürgerbräukeller, une brasserie de Munich.",
            "L'Inde devient indépendante en 1947 après une lutte marquée par la résistance non-violente du Mahatma Gandhi.",
            "Avec plus de 1,3 milliard d'habitants, la Chine est le pays le plus peuplé du monde.",
            "Les accords de Munich sont considérés comme ayant mis un terme à la première République tchécoslovaque."
        ]
    ];

    private const QUESTIONS_CATEGORY_4 = [
        [
            "Quel plombier de jeu vidéo, vêtu de rouge, est également la mascotte de Nintendo ?",
            "Sur quelle console de chez Nintendo sont sortis les deux premiers jeux 'Pokémon' ?",
            "Lequel de ces personnages de jeu ne fait pas partie de l'univers de Mario ?",
            "Quel jeu vidéo de sport développé et édité par Nintendo était offert pour l'achat d'une Wii ?",
            "Quel personnage fictif de jeu vidéo représente la fidèle monture de Mario ?",
            "Quel gorille costaud fut un des premiers personnages célèbres de la marque Nintendo ?",
            "Que signifie le sigle « DS » de la Nintendo DS, console portable sortie en 2005 en Europe ?",
            "Parmi ces « catégories » de Game Boy, laquelle ne pourrez-vous jamais trouver en magasin ?",
            "Quel accessoire prévu pour être connecté à la console Wii est associé au jeu 'Wii Fit' ?",
            "Dans l'univers Nintendo, quel habitant de Dream Land est représenté par une petite boule rose ?"
        ],
        [
            "Quelle arme est utilisée par Luigi dans 'Luigi's Mansion' sous la dénomination « Ectoblast 3000 » ?",
            "Quel a été le tout premier nom de Mario, apparu en 1981 dans le jeu 'Donkey Kong' ?",
            "Quel était le nom de prototype de la Wii depuis la conférence de presse précédant l'E3 de 2004 ?",
            "Quelle ville de la région de Kanto est la ville natale de Sacha dans 'Pokémon' ?",
            "Quel accessoire transforme la wiimote et le nunchuk de la Wii en un simulateur de mitraillette ?",
            "Créée en 1983, quelle fut la première console de salon de chez Nintendo ?",
            "À quelle console au design très similaire la Nintendo DSi a-t-elle succédé ?",
            "Laquelle de ces consoles révolutionnaire de Nintendo peut fonctionner avec un stylet ?",
            "Quel message apparaît fréquemment derrière l'héroïne du jeu 'Donkey Kong' ?",
            "Laquelle de ces consoles fut considérée comme un échec commercial par Nintendo ?"
        ],
        [
            "Quel petit astronaute est un personnage imaginaire et emblématique de Nintendo ?",
            "Quel était le tout premier métier de Mario avant de devenir plombier dans 'Mario Bros.' ?",
            "Quel était le nom de prototype de la  console de jeux vidéo de salon GameCube ?",
            "Dans 'Super Mario Kart', chaque coupe est composée de 5 courses comptant chacune combien de tours ?",
            "Dans quelle ville se trouve le siège de la société Nintendo fondée en 1889 par Fusajiro Yamauchi ?",
            "Quelle déesse a créé la vie dans le jeu vidéo phare 'Zelda : Ocarina of time' ?",
            "Que faisait la société Nintendo avant de produire des jeux vidéo ?",
            "Quelle est le nom de la deuxième génération de console Nintendo DS ?",
            "En quelle année la société Nintendo est-elle entrée en bourse ?",
            "Comment se prénommait la petite amie de Jumpman dans 'Donkey Kong' ?"
        ]
    ];
    private const ANSWERS_CATEGORY_4 = [
        [
            "Mario",
            "Game Boy",
            "Mylord",
            "Wii Sports",
            "Yoshi",
            "Donkey Kong",
            "Dual Screen",
            "Printer",
            "Wii Balance Board",
            "Kirby"
        ],
        [
            "Un aspirateur",
            "Jumpman",
            "Revolution",
            "Bourg Palette",
            "Wii Zapper",
            "Famicom",
            "DS Lite",
            "DS",
            "HELP !",
            "Virtual Boy"
        ],
        [
            "Olimar",
            "Charpentier",
            "Dolphin",
            "5",
            "Kyoto",
            "Farore",
            "Des cartes à jouer",
            "DS Lite",
            "1962",
            "Lady"
        ]
    ];
    private const ANECDOTES_CATEGORY_4 = [
        [
            "Mario est facilement reconnaissable à sa moustache, sa salopette, ses gants blancs et sa casquette rouge marquée d'un M.",
            "Le joueur contrôle le personnage principal via une vue aérienne et le dirige dans l'ensemble de la région fictive de Kanto.",
            "La série 'Mario' est la plus vendue de l'histoire du jeu vidéo, avec plus de 195 millions d'exemplaires écoulés.",
            "Le jeu a été inclus dans un paquetage promotionnel avec la Wii sur tous les territoires, excepté au Japon et en Corée du Sud.",
            "Yoshi a fait sa première apparition (dans un jeu) dans le niveau 1-2 de 'Super Mario World' sur Super Nintendo, sorti en 1990 au Japon.",
            "Créé par Shigeru Miyamoto, ce gorille est à l'origine l'ennemi de Jumpman, son maître, dont il a enlevé la fiancée.",
            "La Nintendo DS est devenue la console la plus vendue de tous les temps au cours du mois de décembre 2012.",
            "Malgré la sortie de consoles portables technologiquement plus avancées, la Game Boy a véritablement connu un franc succès.",
            "La Wii Balance Board est un accessoire en forme de pèse-personne électronique conçu pour les consoles de jeu Wii et Wii U.",
            "La particularité de Kirby est qu'il peut aspirer tout ce qu'il voit, que ce soit des objets ou des ennemis."
        ],
        [
            "Le jeu retrace les aventures de Luigi dans un manoir qu'il a gagné lors d'un concours auquel il n'a jamais participé.",
            "Les jeux de la série 'Super Mario' ont joué un rôle important dans l'évolution du jeu de plates-formes.",
            "La Wii était jusqu'alors évoquée sous les noms de « GCNext » et « N5 » (N5 signifiant cinquième génération de consoles Nintendo).",
            "Kanto est la région utilisée dans les versions Vert (Japon uniquement), Rouge, Bleu, Jaune, Or, Argent et Rouge Feu.",
            "Le Wii Zapper, vendu avec 'Link's Crossbow Training', a reçu ce nom en référence au pistolet optique du NES, le NES Zapper.",
            "Nintendo a élargi sa clientèle en exportant en 1985 aux États-Unis la console rebaptisée Nintendo Entertainment System.",
            "La DSi est équipée de deux caméras, un lecteur de cartes SD, un navigateur web Opera intégré et un lecteur audio.",
            "Son jeu phare, 'New Super Mario Bros.', reste quant à lui l'un des jeux les plus vendus du monde.",
            "Malgré les doutes initiaux de l'équipe américaine, 'Donkey Kong' fut un succès énorme au Japon et en Amérique du Nord.",
            "Le Virtual Boy est la console la moins vendue dans l'histoire des consoles de jeu vidéo de Nintendo, avec 770 000 unités vendues."
        ],
        [
            "Olimar est équipé d'un scaphandre qu'il met toujours sur la Planète Lointaine car, pour lui, l'oxygène est toxique.",
            "Le nom de Mario aurait été choisi en l'honneur du propriétaire des locaux de la société Nintendo of America de l'époque, Mario Segali.",
            "C'est le 24 août 2000 que la machine est officiellement présentée avec son nouveau nom, la GameCube.",
            "Dans 'Super Mario Kart', le joueur contrôle l'un des huit personnages issus de l'univers 'Super Mario'.",
            "Nintendo est l'une des rares entreprises de jeu vidéo à avoir su faire rentrer certaines de ses licences, en particulier 'Mario' ou 'Pokémon'.",
            "Les trois Déesses d'Hyrule sont Din, déesse de la Force, Nayru, déesse de la Sagesse et du Temps et Farore, déesse du Courage.",
            "Cest à partir des années 1970 que la société Nintendo a diversifié ses activités en produisant des jouets et des bornes darcade.",
            " La Nintendo DS Lite, avec ses 93 millions de ventes, est aujourd'hui la console portable la mieux vendue de tous les temps.",
            "Cest grâce à un contrat signé avec Disney en 1959 que la société prend une envergure internationale et entre en bourse en 1962.",
            "Maltraité par le charpentier, Donkey Kong s'échappe et kidnappe la petite amie de Jumpman, connue sous le nom de Lady."
        ]
    ];

    private const QUESTIONS_CATEGORY_5 = [
        [
            "Combien de travaux Hercule dut-il exécuter pour Eurysthée, roi de Tirynthe ?",
            "À quel âge Nadia Comaneci a-t-elle obtenu la note parfaite de 10 aux Jeux olympiques ?",
            "Quelle est la différence chiffrée entre le carré de 87 et le carré de 86 ?",
            "Combien de milliers de passagers le Titanic pouvait-il contenir à son bord ?",
            "En quelle année Charlemagne a-t-il été couronné empereur à Rome ?",
            "En mesure, quelle est la valeur en millimètres d'un pouce anglais ?",
            "Quel âge avait Mozart lorsque son premier opéra fut joué en public ?",
            "Dans la mythologie grecque, combien d'Argonautes ont accompagné Jason ?",
            "En quelle année a eu lieu le tout premier Festival de Cannes ?",
            "Combien d'années Robinson Crusoé a-t-il passé sur son île ?"
        ],
        [
            "En informatique, combien y a-t-il d'octets dans un kilooctet ?",
            "En quelle année Michel Preud'homme a-t-il décroché le Prix Lev Yachine ?",
            "Combien le site de Carnac compte-t-il de menhirs dans ses alignements ?",
            "Combien dénombre-t-on à ce jour de satellites naturels connus autour de Jupiter ?",
            "Quelle distance sépare la ligne de départ de la première haie au 400 m haies ?",
            "Combien de matchs l'équipe nationale de foot belge a-t-elle disputés avec Guy Thys ?",
            "Quel est le pourcentage de silicium entrant dans la composition de l'écorce terrestre ?",
            "Combien d'années Ferdinand Marcos a-t-il été président des Philippines ?",
            "Combien de spectateurs peuvent aujourd'hui accueillir les arènes de Vérone ?",
            "Combien de pièces contenait le palais impérial dans la Cité interdite ?"
        ],
        [
            "Quelle est la longueur totale du pont du Golden Gate de San Francisco ?",
            "Combien de chansons d'Elvis Presley ont été numéro un au hit-parade américain ?",
            "Dans la mythologie grecque, combien le géant Argos avait-il d'yeux ?",
            "De combien de fois la superficie de la Chine est-elle plus grande que celle du Japon ?",
            "Quelle est la longueur de la cordillère des Andes culminant à 6 962 mètres ?",
            "Quelle est la longueur du tunnel ferroviaire japonais du Seikan ?",
            "Combien de confettis ont été lancés sur John Glenn après son célèbre voyage spatial ?",
            "Combien de soldats environ compte l'armée enterrée de l'empereur Qin ?",
            "En quelle année Nicolas Appert a-t-il découvert la boîte de conserve ?",
            "Quel est le nombre d'îles présentes sur l'ensemble du territoire finlandais ?"
        ]
    ];
    private const ANSWERS_CATEGORY_5 = [
        [
            "12",
            "14 ans",
            "173",
            "Trois",
            "800",
            "25 mm",
            "13 ans",
            "50",
            "1946",
            "28"
        ],
        [
            "1 024",
            "1994",
            "2 934",
            "69",
            "45 m",
            "100",
            "25 %",
            "21",
            "22 000",
            "9 999"
        ],
        [
            "1 280 m",
            "18",
            "100",
            "39",
            "7 100 km",
            "53 km",
            "3 474 tonnes",
            "8 000",
            "1795",
            "180 000"
        ]
    ];
    private const ANECDOTES_CATEGORY_5 = [
        [
            "Héraclès correspond à l'Hercule romain, au Melqart phénicien, à l'Hercle étrusque et au Kakasbos en Asie Mineure.",
            "Nadia Comaneci a été naturalisée américaine après sa carrière sportive, n'ayant donc jamais représenté ce pays en compétition.",
            "Tout nombre réel strictement positif est le carré d'exactement deux nombres, l'un strictement positif, l'autre strictement négatif.",
            "La coque du Titanic était pourvue de seize compartiments étanches servant à protéger le navire en cas de voies d'eau.",
            "Souverain réformateur, soucieux de culture, il protège les arts et lettres et est à l'origine de la renaissance carolingienne.",
            "Le pouce est une unité de longueur datant du Moyen Âge, aujourd'hui utilisée pour les tailles des pneus ou des écrans d'ordinateur.",
            "Mort à 35 ans, Mozart laisse derrière lui 626 oeuvres répertoriées qui embrassent tous les genres musicaux de son époque.",
            "Le périple des Argonautes a donné lieu à plusieurs péplums qui s'inspirent assez librement des différentes sources du mythe.",
            "Le Festival fut fondé en 1946 sur un projet de Jean Zay, ministre de l'Éducation nationale et des Beaux-arts du Front populaire.",
            "'Robinson Crusoé' est un roman anglais écrit par Daniel Defoe dont l'histoire s'inspire très librement de la vie d'Alexandre Selkirk."
        ],
        [
            "Le terme est utilisé comme unité de mesure en informatique pour indiquer la capacité de mémorisation des mémoires.",
            "Michel Preud'homme a occupé le poste d'entraîneur au Standard de Liège, après avoir été le directeur sportif du même club.",
            "Le site de Carnac est situé sur la limite nord de Mor braz, entre le golfe du Morbihan à l'est et la presqu'île de Quiberon à l'ouest.",
            "Jupiter est la deuxième planète du Système solaire, après Saturne, avec le plus grand nombre de satellites naturels observés.",
            "La première haie (sur les dix au total) se trouve à 45 m de la ligne de départ et les suivantes à 35 m les unes des autres.",
            "Né à Anvers et fils de Ivan Thys, Guy Thys a été l'entraîneur de l'équipe nationale belge de football le plus couronné de succès.",
            "Le silicium n'est comparativement présent qu'en relativement faible quantité dans la matière constituant le vivant.",
            "Marcos peut être considéré comme un expert du détournement de fonds : il aurait détourné des milliards de dollars du Trésor philippin.",
            "Presque tous les soirs de mars à septembre environ, des spectacles ont lieu et ont pour thème les anciens combats de gladiateurs.",
            "Le chiffre de 9 999 s'explique par le fait que seules leurs divinités avaient le droit de construire un palais comprenant 10 000 pièces."
        ],
        [
            "Le pont du Golden Gate fut, jusqu'en 1964, le pont suspendu le plus long du monde et reste un célèbre monument de San Francisco.",
            "Elvis a contribué à populariser le genre naissant du rockabilly, un mélange énergique de musique country et de rhythm and blues.",
            "Il y en a en permanence cinquante qui dorment et cinquante qui veillent, de sorte qu'il soit impossible de tromper sa vigilance.",
            "Le Japon forme, depuis 1945, un archipel de 6 852 îles dont les quatre plus grandes sont Hokkaido, Honshu, Shikoku, et Kyushu.",
            "La cordillère des Andes débute au Venezuela puis traverse la Colombie, l'Équateur, le Pérou, la Bolivie, le Chili et l'Argentine.",
            "Le tunnel du Seikan est légèrement plus long que le tunnel sous la Manche et comporte un tronçon de 23.3 km sous le fond marin.",
            "Après avoir quitté la NASA en 1963, il entame une carrière politique infructueuse qui l'oblige à se tourner vers le monde des affaires.",
            "Des couleurs minérales étaient appliquées après cuisson sur les statues, permettant ainsi de distinguer les différentes unités.",
            "L'appertisation peut être définie comme un procédé de conservation qui consiste à stériliser par la chaleur des denrées périssables.",
            "La plupart des îles sont dans le Sud-Ouest, dans l'archipel d'Aland, et le long de la côte méridionale du golfe de Finlande."
        ]
    ];

    private const QUESTIONS_CATEGORY_6 = [
        [
            "Dans quelle ville se situait en 2018 le siège social de Microsoft ?",
            "Quel nom porte la console de jeux vidéo conçue par Microsoft ?",
            "Qui est, avec Bill Gates, le cofondateur de la société Microsoft ?",
            "Quel célèbre simulateur de vol pour PC a été conçu par Microsoft ?",
            "Quel nom a été choisi par Microsoft pour la commercialisation de son smartphone ?",
            "Quel système d'exploitation fut commercialisé entre Windows 98 et Windows XP ?",
            "Quel service de stockage en ligne a été inventé par la société Microsoft ?",
            "Quel est le nom de la tablette conçue par les designers de chez Microsoft ?",
            "En quelle année la multinationale Microsoft Corporation a-t-elle été fondée ?",
            "Quel mot se cache derrière la lettre O du système d'exploitation MS-DOS ?"
        ],
        [
            "Qui a remplacé Bill Gates comme Chief Executive Officer en janvier 2000 ?",
            "Quel est le prénom de la femme de Bill Gates, née à Dallas en 1964 ?",
            "Quelle somme Bill Gates va-t-il dépenser pour combattre le réchauffement climatique ?",
            "De combien le nombre d'employés de Microsoft a-t-il évolué de 2005 à 2014 ?",
            "En quelle année la société Microsoft a-t-elle acheté le logiciel Skype ?",
            "Quelle est la signification des lettres RT du nom de produit Windows RT ?",
            "Quel matériel peut contrôler une interface sans utiliser de manette ?",
            "Après combien d'années le successeur de Windows XP a-t-il été commercialisé ?",
            "Quelle interface graphique a remplacé le thème Luna de Windows XP ?",
            "En 2019, combien de fois Microsoft a-t-il adapté son logo depuis sa création ?"
        ],
        [
            "Quelle est la forme du logo aux teintes bleutées de Cortana ?",
            "Quel budget de communication fut associé au lancement du moteur de recherche Bing ?",
            "Quel projet de réalité augmentée a été présenté par Microsoft ?",
            "De combien de branches techniques la gamme Windows est-elle composée ?",
            "Quel concurrent Microsoft a-t-il condamné lors de la sortie de Internet Explorer 3.0 ?",
            "Quelle entreprise, connue pour son jeu Minecraft, a été rachetée par Microsoft ?",
            "Quel est le nom de code du projet associé au navigateur internet Microsoft Edge ?",
            "Quelle section du magasin en ligne de Microsoft a été supprimée en juillet 2019 ?",
            "Quel est le petit nom donné au bracelet de sport commercialisé par Microsoft ?",
            "Quelle est la surface approximative du Microsoft Redmond Campus ?"
        ]
    ];
    private const ANSWERS_CATEGORY_6 = [
        [
            "Redmond",
            "Xbox",
            "Paul Allen",
            "Flight Simulator",
            "Lumia",
            "Windows ME",
            "OneDrive",
            "Surface",
            "1975",
            "Operating"
        ],
        [
            "Steve Ballmer",
            "Melinda",
            "2 milliards de dollars",
            "Doublé",
            "2011",
            "Officiellement aucune",
            "Kinect",
            "5 ans",
            "Aero",
            "4 fois"
        ],
        [
            "Ronde",
            "90 millions",
            "Skinput",
            "Cinq",
            "Netscape",
            "Mojang",
            "Spartan",
            "Ebooks",
            "Microsoft Band",
            "80 km²"
        ]
    ];
    private const ANECDOTES_CATEGORY_6 = [
        [
            "Cette ville de l'État de Washington abrite le siège social de l'éditeur de logiciels Microsoft et de la branche américaine de Nintendo.",
            "Une Xbox ne pouvait à l'origine exécuter que des programmes Xbox provenant d'un média au format propriétaire Microsoft sur DVD.",
            "Paul Allen est aussi patron actionnaire d'un empire financier de multiples sociétés dans les domaines des hautes technologies.",
            "Bill Gates est fasciné par le roman 'Vol de nuit' d'Antoine de Saint-Exupéry qui raconte en détail la sensation de voler dans un petit avion.",
            "Cette série de smartphones et d'une tablette tactile est le résultat d'une coopération avec Nokia, constructeur des téléphones.",
            "Entièrement basé sur Windows 98, lui-même basé sur Windows 95, Windows ME était le pendant familial et multimédia de Windows.",
            "Le service peut s'utiliser de deux manières : à travers un navigateur web ou à travers le logiciel OneDrive qui permet une synchronisation.",
            "La première génération de tablette a été introduite en 2012 où deux versions de Surface sont présentées : Surface RT et Surface Pro.",
            "Son activité principale consiste à développer et vendre des systèmes d'exploitation, des logiciels et des produits matériels dérivés.",
            "Ce système fonctionnant en mode réel, mono-tâche et mono-utilisateur, était équipé par défaut d'une interface en ligne de commande."
        ],
        [
            "Depuis 2014, Steve Ballmer est le nouveau propriétaire des Clippers, une franchise de basket-ball de la NBA basée à Los Angeles.",
            "Pour la fondation qu'elle copréside depuis 1999, Melinda Gates effectue plusieurs voyages par an dans des pays d'Afrique et d'Asie.",
            "Bill Gates est devenu, en grande partie grâce au succès commercial de Microsoft, l'homme le plus riche du monde de 1996 à 2007.",
            "L'introduction en bourse de Microsoft a fait quatre milliardaires et environ 12 000 millionnaires parmi les employés de Microsoft.",
            "Skype est un logiciel qui permet aux utilisateurs de passer des appels téléphoniques ou vidéo via Internet, ainsi que le partage d'écran.",
            "Système d'exploitation dérivé de Windows 8, le sigle RT n'a pas de signification officielle mais fait généralement référence à Runtime.",
            "Initialement connu sous le nom Project Natal, le mot-valise Kinect est issu des mots anglais kinetic (cinétique) et connect (connecter).",
            "Remplacé par Windows Vista, Windows XP (en version Familiale et Professionnelle) a été vendu à près de 400 millions de copies.",
            "L'interface Aero a été conçue pour être plus puissante, plus efficace et plus plaisante esthétiquement que l'ancien thème Luna.",
            "Les produits du dernier logo sont Office pour le carré rouge, Xbox pour le carré vert, Windows pour le carré bleu et Bing pour le carré jaune."
        ],
        [
            "Cortana est l'assistant personnel intelligent développé par Microsoft pour sa plateforme Windows Phone à partir de la version 8.1.",
            "Bing, anciennement Live Search, Windows Live Search et MSN Search, est un moteur de recherche rendu public le 3 juin 2009.",
            "En février 2011, Microsoft Research a présenté sa prospective en réalité augmentée, notamment avec les projets Skinput et Light Space.",
            "Les cinq branches techniques de Windows sont la branche 16 bits, la branche Windows 9x, la branche NT, la branche CE et la branche NT.",
            "Le support de Netscape Navigator a cessé en 2008, mais il est à l'origine du navigateur Mozilla Firefox, toujours en développement.",
            "En 2011, le fondateur de Napster et l'ancien président de Facebook Solidarité, Sean Parker, proposèrent d'investir dans Mojang.",
            "Depuis le mois de février 2018, Edge n'est plus une exclusivité de Windows 10 : Microsoft a porté le navigateur sur iOS et Android.",
            "Les livres numériques (gratuits ou achetés sur la plateforme) ne seront plus lisibles suite à l'arrêt des serveurs de DRM.",
            "Commercialisé en 2014, il s'agit du premier appareil propulsé par Microsoft Health, le nouveau service de santé de Microsoft.",
            "Les campus historiques de l'Est et de l'Ouest comptent plus de 120 bâtiments de près de 700 000 m² sur plus de 200 hectares."
        ]
    ];

    private const QUESTIONS_CATEGORY_7 = [
        [
            "Comment obtenir l'identifiant unique d'une session ?",
            "Quel est le format par défaut de l'en-tête HTML ?",
            "Comment se nomme le fichier de session qui contient toutes les variables de session ?",
            "Quelle directive de httpd.conf interdit de lister un dossier ?",
            "Comment afficher la valeur du cookie 'ck1' ?",
            "Comment ouvrir un fichier en lecture / écriture, et y placer le pointeur à la fin ?",
            "Comment trouver une valeur dans un tableau ?",
            "floor(-3,56) affiche ?",
            "Comment trier un tableau ?",
            "Comment instancier un objet à partir d'une classe ?"
        ],
        [
            "Lequel de ces 'content-type' n'existe pas dans un header ?",
            "reset()",
            "round(4,6) affiche ?",
            "Que faut-il utiliser pour modifier l'en-tête d'une réponse HTTP ?",
            "Comment appelle-t-on le fait d'utiliser une 'classe' pour créer un 'objet' ?",
            "Quelle est l'utilité de throw() en PHP Orienté Objet ?",
            "Quel est l'inventeur du PHP ?",
            "A quoi sert la fonction copy() ?",
            "Les fonctions MySQL améliorées 'mysqli' existent depuis ?",
            "Quelle fonction permet d'écrire dans un fichier ?"
        ],
        [
            "Comment supprimer l'ensemble des variables d'une session ?",
            "session_start() crée un cookie nommé ?",
            "Comment récupérer la variable 'nom' transmise par un formulaire ?",
            "Que retourne urlencode(\$chaine) ?",
            "Quelle est la taille maximale d'un cookie ?",
            "Quelle méthode est utilisée par défaut pour envoyer les données d'un formulaire ?",
            "Quelle fonction crée un cookie ?",
            "\$a === \$b signifie ?",
            "preg_match('/^a/', 'abcdef') renvoie ?",
            "Qu'est-ce que GD ?"
        ]
    ];
    private const ANSWERS_CATEGORY_7 = [
        [
            "session_id()",
            "text/html",
            "'sess_' suivi de l'id",
            "Options -indexes",
            "print(\$_COOKIE['ck1'])",
            "fopen('fichier.txt','a')",
            "in_array()",
            "-4",
            "sort()",
            "new"
        ],
        [
            "html/xml",
            "place le pointeur au début du tableau",
            "5",
            "header()",
            "instanciation",
            "à émettre une exception",
            "Rasmus Lerdorf",
            "copier un fichier",
            "PHP 5 et MySQL 4.1",
            "fwrite()"
        ],
        [
            "session_destroy()",
            "PHPSESSID",
            "\$_POST['nom']",
            "encode \$chaine comme GET",
            "4 Ko",
            "GET",
            "setcookie()",
            "vrai si \$a = \$b et si de même type",
            "1",
            "une bibliothèque graphique pour PHP"
        ]
    ];
    private const ANECDOTES_CATEGORY_7 = [
        [
            "session_id() retourne l'identifiant de session pour la session courante ou une chaîne vide, s'il n'y a pas de session courante (aucun identifiant de session n'existe). En cas d'échec, false est retourné.",
            "",
            "Ce fichier de session se trouve par défaut sur 'C:\\WINDOWS\\Temp'",
            "Apache utilise le fichier 'httpd.conf' pour les paramètres globaux et le fichier '.htaccess' pour les paramètres d'accès par répertoire.",
            "'\$_COOKIE' est la variable superglobale de PHP",
            "La fonction 'fopen()' ouvre un fichier ou une URL.",
            "Syntaxe : in_array(search, array, type), si type est à TRUE la recherche est sensible à la casse.",
            "La fonction 'floor()' arrondie les nombres à l'entier inférieur le plus proche",
            "La fonction 'sort()' trie un tableau indexé par ordre croissant",
            "Le mot clé 'new' est utilisé pour créer un objet à partir d'une classe."
        ],
        [
            "https://developer.mozilla.org/fr/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types",
            "Pour en savoir plus sur la fonction 'reset()' : https://www.w3schools.com/php/func_array_reset.asp",
            "Pour en savoir plus sur la fonction 'round()' : https://www.w3schools.com/php/func_math_round.asp",
            "Il est important de noter que la fonction 'header()' doit être appelée avant que toute sortie réelle ne soit envoyée !",
            "",
            "Les exceptions sont un moyen de modifier le déroulement du programme en cas de situation inattendue, telle que des données non valides.",
            "Rasmus Lerdorf est né en 1968 et il est Canadien",
            "La fonction 'copy()' s'utilise de cette façon : copy('source.txt','target.txt');",
            "Ces fonctions sont maintenant dépréciées au profit de PDO",
            "La fonction 'fwrite()' écrit dans un fichier ouvert."
        ],
        [
            "Si vous souhaitez supprimer une seule variable de session, vous pouvez utiliser la fonction 'unset()' .",
            "PHP transmet automatiquement cet ID de page en page, en utilisant généralement un cookie.",
            "Il faut impérativement qu'il y ait une balise HTML qui possède l'attribut name='nom' dans le formulaire.",
            "La fonction 'urlencode()' est utile lors de l'encodage d'une chaîne de caractères à utiliser dans la partie d'une URL, comme façon simple de passer des variables vers la page suivante.",
            "Ne dépassez pas 50 cookies par nom de domaine",
            "Avec cette méthode, les données du formulaire seront encodées dans une URL.",
            "La fonction setcookie() définit un cookie à envoyer avec le reste des en-têtes HTTP.",
            "Cet opérateur permet une comparaison beaucoup plus stricte entre les variables.",
            "Pour en savoir plus sur la fonction 'preg_match()' : https://www.php.net/manual/fr/function.preg-match.php",
            "La librairie GD est une extension open source du langage PHP. Tout comme PDO pour les Bdd."
        ]
    ];

    private const QUESTIONS_CATEGORY_8 = [
        [
            "Comment appelle-t-on une personne qui utilise Internet pour visiter des sites web ?",
            "Sur Internet, 'Google', 'Bing' et 'Yahoo' sont des exemples de moteurs de...",
            "Quel symbole typographique est toujours représenté dans les adresses e-mails ?",
            "Quelle encyclopédie collaborative est actuellement la plus utilisée sur Internet ?",
            "Que sont 'Google Chrome', 'Internet Explorer' et 'Mozilla Firefox' ?",
            "Quel logiciel est indispensable pour protéger votre ordinateur sur Internet ?",
            "Comment désigne-t-on un passionné d'Internet et des nouvelles technologies ?",
            "Quels outils permettent de « mettre en mémoire » une adresse web pour y revenir ultérieurement ?",
            "Comment appelle-t-on généralement une discussion instantanée passée sur Internet ?",
            "Quelle connexion sans fil pouvez-vous utiliser pour surfer plus facilement sur Internet ?"
        ],
        [
            "Quelle « box » est reliée à votre ordinateur pour vous connecter à Internet ?",
            "Quel mot français est désormais utilisé pour traduire le mot « e-mail » ?",
            "Sur quel média sont enregistrés les sites web que vous visitez depuis votre ordinateur ?",
            "Que signifie le deuxième « w » du « www » utilisé dans la plupart des adresses de sites internet ?",
            "De combien de mégaoctets avez-vous besoin pour obtenir un gigaoctet ?",
            "Quel nom portait le précédent navigateur Internet de Microsoft, devenu aujourd'hui 'Microsoft Edge' ?",
            "Sur Internet, que signifie l'extension « .com » que l'on peut retrouver dans une adresse web ?",
            "Lequel de ces outils ne permet pas de visionner des pages web ?",
            "Comment appelle-t-on un e-mail non sollicité reçu depuis Internet ?",
            "Quel spécialiste de l'informatique est capable de pirater presque n'importe quel site Internet ?"
        ],
        [
            "Grâce à quoi tous les ordinateurs sur Internet sont-ils plus ou moins facilement repérables ?",
            "Quelle extension ajoutée à votre navigateur Internet préféré accentue ses possibilités ?",
            "Comment appelle-t-on les canulars transmis par messagerie électronique ou via Internet ?",
            "De plus en plus de sites enregistrent sur votre ordinateur un témoin de passage appelé...",
            "En quelle année a été envoyé le tout premier courriel ou courrier électronique ?",
            "Quelle opération informatique illicite consiste à copier l'intégralité d'un site Internet sur son ordinateur ?",
            "Quelle abréviation est utilisée pour désigner une adresse de site Internet ?",
            "Quel anniversaire le World Wide Web a-t-il fêté en 2014 ?",
            "Quel protocole est dédié à la transmission de fichiers sur Internet ?",
            "Quel terme désigne le code de bonne conduite sur Internet ?"
        ]
    ];
    private const ANSWERS_CATEGORY_8 = [
        [
            "Internaute",
            "Recherche",
            "Arobase",
            "Wikipédia",
            "Navigateurs",
            "Antivirus",
            "Geek",
            "Favoris",
            "Chat",
            "Wi-Fi"
        ],
        [
            "Modem",
            "Courriel",
            "Serveur",
            "Wide",
            "1 024",
            "Internet Explorer",
            "Commercial",
            "Acrobat Reader",
            "Spam",
            "Hacker"
        ],
        [
            "Adresse IP",
            "Plug-in",
            "Hoax",
            "Cookie",
            "1971",
            "Aspiration",
            "URL",
            "Ses 25 ans",
            "FTP",
            "Nétiquette"
        ]
    ];
    private const ANECDOTES_CATEGORY_8 = [
        [
            "Il est considéré que le pourcentage d'internautes par rapport à la population est un indice de développement économique.",
            "Certains sites offrent un moteur comme principale fonctionnalité, on appelle alors « moteur de recherche » le site lui-même.",
            "Une opinion commune voudrait que le mot « arobase » provienne de la contraction du terme typographique « a rond bas ».",
            "Sur Wikipédia, n'importe qui pouvant accéder au site peut modifier la quasi-totalité de ses articles, sous réserve de modération.",
            "Le terme « navigateur » est inspiré de Netscape Navigator, le navigateur phare principalement utilisé en 1995 et 1996.",
            "Les antivirus peuvent balayer le contenu d'un disque dur, mais également la mémoire vive de l'ordinateur.",
            "Du fait de ses passions diverses et de ses connaissances pointues, le geek est parfois perçu comme trop cérébral.",
            "On retrouve principalement les favoris dans les logiciels de traitement de texte ou pour la navigation internet.",
            "Contrairement au courrier électronique, ce moyen de communication permet de conduire un dialogue interactif.",
            "La portée du Wi-Fi atteint plusieurs dizaines de mètres en intérieur (généralement entre une vingtaine et une cinquantaine de mètres)."
        ],
        [
            "Techniquement, l'appareil sert à convertir les données numériques de l'ordinateur en signal modulé, dit « analogique ».",
            "Les règles de bon usage du courrier électronique sont décrites dans un document de référence appelé nétiquette.",
            "Le nombre de sites sur Internet a augmenté rapidement en 2005 et en 2006 grâce à la popularité croissante des blogs.",
            "Le Web n'est qu'une des applications d'Internet, distincte du courriel, de la messagerie instantanée ou du partage de fichiers.",
            "Les préfixes binaires sont souvent utilisés lorsque l'on doit traiter de grandes quantités d'octets.",
            "La version 11 du navigateur 'Internet Explorer' sera toujours présente dans Windows 10 avant le passage progressif à 'Microsoft Edge'.",
            "Initialement administré par le ministère de la Défense américain, le domaine .com est aujourd'hui exploité par la société Verisign.",
            "Adobe change régulièrement le nom des produits de la famille Acrobat et cela en subdivisant sa gamme.",
            "Le spam désigne en général des envois en grande quantité effectués à des fins publicitaires.",
            "Les hackers sont classés en plusieurs catégories en fonction de leurs objectifs, de leur compétence et de la légalité de leurs actes."
        ],
        [
            "L'adresse IP est à la base du système d'acheminement (le routage) des messages sur Internet.",
            "Certains plug-ins peuvent aussi être utilisés comme logiciel à part entière, on dit alors qu'ils sont « standalone ».",
            "Conçus pour apparaître crédibles et véritables, ces canulars peuvent parfois avoir un but malveillant.",
            "Existant depuis plus de 20 ans, les cookies permettent aux développeurs de sites internet de conserver des données utilisateur.",
            "Il faut disposer d'une adresse électronique et d'un client de messagerie permettant l'accès aux messages via un navigateur.",
            "Un site web est un ensemble de pages qui peuvent être consultées en suivant des hyperliens à l'intérieur du site lui-même.",
            "En France, d'après le Journal officiel du 16 mars 1999, « URL » peut être traduit par adresse réticulaire ou adresse universelle.",
            "En septembre 2014, Internet dépassait un milliard de sites en ligne pour près de trois milliards d'internautes.",
            "Ce mécanisme de copie est souvent utilisé pour alimenter un site web hébergé chez un tiers.",
            "La « nétiquette » rassemble des tentatives de formalisation d'un certain contrat social pour l'Internet."
        ]
    ];

    private const QUESTIONS_CATEGORY_9 = [
        [
            "Qui est le padawan du chevalier et maître Jedi Obi-Wan Kenobi ?",
            "Quel petit bonhomme vert a enseigné à Luke comment utiliser la Force ?",
            "Dans la saga « Star Wars », quels chevaliers se battent avec des sabres lasers ?",
            "De quelle station spatiale ennemie la princesse Leia apprend-elle les plans de construction ?",
            "Personnage central de la saga « Star Wars », avec qui Anakin Skywalker se marie-t-il ?",
            "Pour aider les Jedi a réparer leur vaisseau, Anakin doit gagner une course...",
            "Que contrôlent les Jedi qui les rendent très différents des simples humains ?",
            "Quels puissants ennemis et « seigneurs » les Jedi pensent-ils avoir vaincu ?",
            "De qui la princesse Leia tombe-t-elle amoureuse dans la saga « Star Wars » ?",
            "Quelle armée aidera les Jedi pour ensuite se retourner contre eux et les forces du mal ?"
        ],
        [
            "Quel chancelier suprême est seigneur noir des Sith dans la série « Star Wars » ?",
            "De qui Chewbacca, le plus célèbre des guerriers Wookie, est-il le co-pilote ?",
            "Que se passe-t-il lorsqu'Anakin Skywalker affronte le compte Dooku la première fois ?",
            "Parmi ces personnages de « Star Wars », qui dirige le conseil des Jedi avec Yoda ?",
            "Quel maître Jedi d'Obi-Wan Kenobi sera finalement tué par Dark Maul ?",
            "Quel apprenti Sith Obi-Wan va-t-il tuer en vengeant la mort de son maître ?",
            "Quel nom porte le vaisseau spatial du contrebandier Han Solo ?",
            "Qui tue Boba Fett, chasseur de primes connu pour son adresse à traquer sa proie ?",
            "Sur quelle planète vit Anakin avant de partir rejoindre les Jedi ?",
            "Quel célèbre chasseur de primes a été engagé par Dark Vador pour traquer Han Solo ?"
        ],
        [
            "Une fois mesurée, quelle molécule permet de savoir si un individu peut être un Jedi ?",
            "Quel taux de cette molécule Anakin possède-t-il lorsque Qui-Gon l'analyse la première fois ?",
            "Quel mystique de la connaissance est le maître de Dark Sidious ?",
            "Lesquels de ces épisodes de « Star Wars » n'ont pas été réalisés par George Lucas ?",
            "À partir de quelle bataille peut-on mesurer la chronologie dans « Star Wars » ?",
            "Que signifie la dernière phrase de Dark Vador avant de mourir : « Tu l'as déjà fait Luke » ?",
            "Contre qui Han Solo remporte-t-il le Faucon Millénium lors d'une partie de sabacc ?",
            "Sur quelle planète Luke est-il parti pour apprendre à devenir un véritable Jedi ?",
            "Dans « Star Wars », de George Lucas, qui tue le chancelier Palpatine alias Dark Sidious ?",
            "Combien d'années séparent le premier épisode sorti en salle de l'épisode 3 ?"
        ]
    ];
    private const ANSWERS_CATEGORY_9 = [
        [
            "Anakin Skywalker",
            "Yoda",
            "Jedi",
            "L'Étoile Noire",
            "Sénatrice Padme",
            "De module",
            "La Force",
            "Les siths",
            "Han Solo",
            "L'armée des clones"
        ],
        [
            "Palpatine",
            "Han Solo",
            "Il perd une main",
            "Mace Windu",
            "Qui-Gon Jinn",
            "Dark Maul",
            "Faucon Millénium",
            "Han Solo",
            "Tatooine",
            "Boba Fett"
        ],
        [
            "Midi-chloriens",
            "Plus de 20 000",
            "Dark Plagueis",
            "5 et 6",
            "Bataille de Yavin",
            "L'avoir sauvé",
            "Lando Calrissian",
            "Dagobah",
            "Dark Vador",
            "28 ans"
        ]
    ];
    private const ANECDOTES_CATEGORY_9 = [
        [
            "Obi-Wan Kenobi est tout d'abord le padawan de Qui-Gon Jinn avant de devenir lui-même l'instructeur d'Anakin Skywalker.",
            "Yoda est présent dans cinq épisodes sur ceux que compte actuellement la saga (I, II, III, V, VI).",
            "L'Ordre Jedi est dirigé par le Conseil Jedi, qui se réunit sur la planète Coruscant.",
            "L'Étoile noire et l'Étoile de la mort sont deux stations spatiales sidérales mobiles de la taille d'une lune.",
            "Padmé Amidala Skywalker est née en 46 av. BY sur Naboo et morte en 19 av. BY sur Polis Massa.",
            "Après une course acharnée et très disputée, Anakin parviendra finalement à remporter la victoire.",
            "Les chevaliers Jedi forment un ordre d'individus qui sont aptes à maîtriser la Force et qui l'utilisent uniquement pour faire le bien.",
            "Les siths sont les ennemis jurés des Jedi dont ils constituent une menace pour la République Galactique.",
            "Han Solo est un contrebandier, pilote et ancien élève officier impérial qui a dû déserter pour sauver Chewbacca.",
            "« L'Attaque des clones » est l'un des premiers films à être tourné entièrement en numérique."
        ],
        [
            "Originaire de Naboo, Palpatine a été formé au côté obscur de la Force dès le plus jeune âge par son maître, Dark Plagueis.",
            "Chewbacca fait partie du noyau de rebelles qui ont restauré la liberté dans la galaxie.",
            "Dooku fut l'héritier d'une famille d'aristocrates et diplomates de Serenno à la fortune colossale.",
            "En plus de sa réputation de sage, Windu est considéré comme l'un des meilleurs combattants au sabre laser de l'Ordre Jedi.",
            "Le personnage est interprété par Liam Neeson et doublé par Samuel Labarthe en France.",
            "Le personnage de Dark Maul fut créé par l'illustrateur Iain Mccaig pour Industrial Light et Magic.",
            "Le Faucon Millénium fut appelé « Millenium Condor » dans la version française du premier épisode produit.",
            "On apprendra plus tard qu'il échappe à la digestion du Gerand Sarlacc et qu'il reviendra dans l'histoire.",
            "Située dans la Bordure extérieure, cette planète désertique est le refuge des plus vils brigands de la galaxie.",
            "L'origine de Boba Fett est donnée dans « L'Attaque des clones » : il est le « fils » du légendaire chasseur de primes Jango Fett."
        ],
        [
            "Dans la saga « Star Wars », Anakin Skywalker se fait remarquer par son fort taux de midi-chloriens.",
            "Ce taux de midi-­chloriens est de plus supérieur à celui de Yoda, pourtant reconnu comme Grand Maître des Jedi.",
            "Seigneur Noir des Sith, il possédait un pouvoir inimaginable qui lui permettait de garder les gens en vie avec la Force.",
            "Même s'il ne les a pas réalisés, George Luas a donné de très nombreuses directives à Irvin Kerschner et Richard Marquand.",
            "La bataille de Yavin oppose l'Empire galactique aux Rebelles autour de la planète gazeuse Yavin.",
            "Le fait que Dark Vador soit le père des jumeaux Luke Skywalker et Leia Organa constitue l'intrigue principale de la saga.",
            "Lando Calrissian est devenu par la suite administrateur de la cité des Nuages, une colonie minière.",
            "Dagobah, dans le secteur Sluis, est un monde de sombres marais, de bayous putrides et de forêts d'arbres tortueux.",
            "Le règne de Palpatine s'achève dans l'épisode VI, à la fin duquel il est tué par Anakin Skywalker en l'an 4 ap. BY.",
            "À l'origine nommée « La Guerre des étoiles », « Star Wars » est un univers de science-fiction créé par George Lucas en 1977."
        ]
    ];
}
