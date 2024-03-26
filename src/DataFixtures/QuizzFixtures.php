<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Propositions;
use App\Entity\Questionnaires;
use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\String\Slugger\SluggerInterface;

class QuizzFixtures extends Fixture
{
    public function __construct(
        private SluggerInterface $slugger,
        private array $questions1 = [
            "Quel logiciel de traitement de texte a été mis au point par Microsoft ?",
            "Le logiciel Excel extrait de la suite bureautique Microsoft Office est un...",
            "En informatique, comment appelle-t-on une erreur de programmation encore non localisée ?",
            "Quelle version de Windows Microsoft a-t-il lancé le vendredi 26 octobre 2012 ?",
            "Comment est communément abrégée la publication assistée par ordinateur ?",
            "Quelle application informatique de la société Apple permet de gérer facilement un iPod ?",
            "En informatique, quel logiciel permet de créer des calculs automatiques ?",
            "Quel pirate informatique casse les systèmes informatique et les logiciels protégés ?",
            "Quels logiciels installés sur PC, tablette ou smartphone, permettent de « surfer » sur Internet ?",
            "Quel outil développé par le géant Google permet de gérer son emploi du temps ?",
            "Quelle grande société a reçu le feu vert en  2011 pour le rachat de 'Skype' ?",
            "Quel est probablement le plus connu des systèmes informatiques dits « libre » ?",
            "Quelle est le nom de la solution professionnelle de services Google ?",
            "Quel logiciel est mis gratuitement et librement à disposition par son créateur ?",
            "En avril 2012, quelle start-up Facebook a-t-il racheté pour un milliard de dollars ?",
            "Au Québec, quel mot est souvent utilisé pour désigner le courrier électronique ?",
            "Quel logiciel de Microsoft a remplacé 'Windows Live Messenger' en 2013 ?",
            "Quel nom portait le navigateur Internet de Microsoft, devenu aujourd'hui 'Microsoft Edge' ?",
            "Quel logiciel est indispensable pour protéger votre ordinateur sur Internet ?",
            "Qui est le tout premier pape à avoir envoyé un message sur 'Twitter' ?",
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
        ],
        private array $answers1 = [
            "Word",
            "Tableur",
            "Un bug",
            "Windows 8",
            "PAO",
            "iTunes",
            "Un tableur",
            "Un hacker",
            "Des navigateurs",
            "Google Agenda",
            "Microsoft",
            "Linux",
            "Google Apps",
            "Un freeware",
            "Instagram",
            "Courriel",
            "Skype",
            "Internet Explorer",
            "Un antivirus",
            "Benoît XVI",
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
        ],
        private array $anecdotes1 = [
            "Microsoft publie plusieurs logiciels de traitement de texte, mais 'Word' en reste la « vedette ».",
            "Excel a été critiqué pour ses problèmes de précision sur calculs à virgule flottante.",
            "La gravité du dysfonctionnement informatique peut aller de bénigne à majeure.",
            "La version Windows 8.1 est une mise à jour gratuite de Windows 8 disponible depuis 2013.",
            "La PAO consiste à créer des documents imprimés en travaillant la composition et la typographie de documents.",
            "'iTunes' faisait partie de la suite logicielle d'Apple 'iLife' jusqu'à la version '06.",
            "Une feuille de calcul est une table d'informations la plupart du temps financières.",
            "Certains utilisent ce savoir-faire dans un cadre légal, d'autres étant hors-la-loi.",
            "Le premier navigateur stable et largement diffusé fut 'NCSA Mosaic', en 1993.",
            "'Google Agenda' permet de partager des événements et des agendas et de les publier sur internet ou sur un site Web.",
            "'Skype' est un logiciel gratuit qui permet de passer des appels téléphoniques et vidéo via Internet, ainsi que le partage d'écran.",
            "Linux est un système informatique qui fonctionne sur du matériel allant du téléphone portable au supercalculateur.",
            "Ce site Web au service des entreprises met en ligne de nombreuses applications.",
            "Il ne faut toutefois pas confondre freeware (gratuiciel) et shareware (partagiciel).",
            "'Instagram' est une application  cofondée et lancée par l'américain Kevin Systrom et le Brésilien Michel Mike Krieger en octobre 2010.",
            "Le courriel tend à être reconnu comme moyen valide de contacter une personne.",
            "'Skype' a été fondé en Estonie par Niklas Zennström et Janus Friis en 2003 et développé par 3 Estoniens à l'origine du logiciel 'KaZaA'.",
            "La version 11 du navigateur sera toujours présente dans Windows 10 avant le passage progressif à Microsoft Edge.",
            "Les antivirus peuvent balayer le contenu d'un disque dur, mais également la mémoire vive de l'ordinateur.",
            "Réputé conservateur, le cardinal Ratzinger a été élu le 19 avril 2005 pour succéder à Jean-Paul II.",
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
        ],
        private array $propositions1 = [
            ["Word", "PowerPoint", "Excel", "Access"],
            ["Traitement de texte", "Client de messagerie", "Tableur", "Navigateur internet"],
            ["Un spam", "Un virus", "Un crack", "Un bug"],
            ["Windows CE", "Windows 8", "Windows 7", "Windows Mobile"],
            ["USB", "PAO", "VGA", "CIO"],
            ["iTunes", "FileMaker", "QuickTime", "HyperCard"],
            ["Un tableur", "Un navigateur", "Un explorateur", "Un débogueur"],
            ["Un blagueur", "Un pirateur", "Un forceur", "Un hacker"],
            ["Des navigateurs", "Des éditeurs", "Des tableurs", "Des émulateurs"],
            ["Google Mobile", "Google TimeLine", "Google Agenda", "Google Tempo"],
            ["Facebook", "Microsoft", "Apple", "Google"],
            ["Linux", "MS-DOS", "Mac OS", "Windows"],
            ["Google Apps", "Google Mac", "Google Pro", "Google Serve"],
            ["Un adware", "Un software", "Un malware", "Un freeware"],
            ["Backelite", "Valve", "Instagram", "Globalnet"],
            ["Lettrinter", "Copitel", "Courriel", "Emel"],
            ["QuickTime", "Skype", "Pidgin", "Instagram"],
            ["Safari", "Firefox", "Chrome", "Internet Explorer"],
            ["Un antivirus", "Un navigateur", "Une messagerie", "Un chat"],
            ["Jean-Paul II", "François", "Benoît XVI", "Paul VI"],
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
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $category = $this->createCategory('Applications web', '.jpg', $manager);
        $questionnaires = $this->createQuestionnaires($category, $manager);
        $questions = $this->createQuestions($questionnaires, $manager, $this->questions1, $this->answers1, $this->anecdotes1);
        $this->createPropositions($questions, $manager, $this->propositions1);

        $manager->flush();
    }

    public function createCategory(string $name, string $extension, ObjectManager $manager): Categories
    {
        $category = new Categories();
        $category->setTitle($name);
        $category->setSlug($this->slugger->slug($category->getTitle())->lower());
        $category->setImage($category->getSlug() . $extension);

        $manager->persist($category);

        return $category;
    }

    public function createQuestionnaires(Categories $category, ObjectManager $manager, array $difficulties = ['facile', 'moyen', 'difficile']): array
    {
        foreach ($difficulties as $key => $difficulty) {
            $questionnaire = new Questionnaires();
            $questionnaire->setDifficulty($difficulty);
            $questionnaire->setCategory($category);

            $questionnaires[] = $questionnaire;

            $manager->persist($questionnaire);
        }

        return $questionnaires;
    }

    public function createQuestions(array $questionnaires, ObjectManager $manager, array $entryQuestions, array $entryAnswers, array $entryAnecdotes): array
    {
        for ($i = 0; $i < 10; $i++) {
            $question = new Questions();
            $question->setQuestion($entryQuestions[$i]);
            $question->setAnswer($entryAnswers[$i]);
            $question->setAnecdote($entryAnecdotes[$i]);
            $question->setQuestionnaire($questionnaires[0]);

            $questions[] = $question;

            $manager->persist($question);
        }
        for ($i = 10; $i < 20; $i++) {
            $question = new Questions();
            $question->setQuestion($entryQuestions[$i]);
            $question->setAnswer($entryAnswers[$i]);
            $question->setAnecdote($entryAnecdotes[$i]);
            $question->setQuestionnaire($questionnaires[1]);

            $questions[] = $question;

            $manager->persist($question);
        }
        for ($i = 20; $i < 30; $i++) {
            $question = new Questions();
            $question->setQuestion($entryQuestions[$i]);
            $question->setAnswer($entryAnswers[$i]);
            $question->setAnecdote($entryAnecdotes[$i]);
            $question->setQuestionnaire($questionnaires[2]);

            $questions[] = $question;

            $manager->persist($question);
        }

        return $questions;
    }

    public function createPropositions(array $questions, ObjectManager $manager, array $entryPropositions)
    {
        for ($i = 0; $i < 30; $i++) {
            foreach ($entryPropositions[$i] as $entryProposition) {
                $proposition = new Propositions();
                $proposition->setProposition($entryProposition);
                $proposition->setQuestion($questions[$i]);

                $manager->persist($proposition);
            }
        }
    }
}
