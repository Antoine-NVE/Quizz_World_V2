<?php

namespace App\DataFixtures;

use App\Entity\Propositions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PropositionsFixtures extends Fixture implements DependentFixtureInterface
{
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

    private static $questionCounter = 1;

    public function load(ObjectManager $manager): void
    {
        $this->create(self::PROPOSITIONS_CATEGORY_1, $manager);

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
}
