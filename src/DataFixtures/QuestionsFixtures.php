<?php

namespace App\DataFixtures;

use App\Entity\Questions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionsFixtures extends Fixture implements DependentFixtureInterface
{

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

    private static $questionnaireCounter = 1;
    private static $questionCounter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->create(self::QUESTIONS_CATEGORY_1, self::ANSWERS_CATEGORY_1, self::ANECDOTES_CATEGORY_1, $manager);

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
}
