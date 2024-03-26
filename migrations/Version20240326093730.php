<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326093730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_3AF346682B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE propositions (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, proposition VARCHAR(63) NOT NULL, INDEX IDX_E9AB02861E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaires (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, difficulty VARCHAR(63) NOT NULL, INDEX IDX_5D60D73F12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT NOT NULL, question VARCHAR(255) NOT NULL, answer VARCHAR(63) NOT NULL, anecdote VARCHAR(255) DEFAULT NULL, INDEX IDX_8ADC54D5CE07E8FF (questionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scores (questionnaire_id INT NOT NULL, user_id INT NOT NULL, score INT NOT NULL, INDEX IDX_750375ECE07E8FF (questionnaire_id), INDEX IDX_750375EA76ED395 (user_id), PRIMARY KEY(questionnaire_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(63) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE propositions ADD CONSTRAINT FK_E9AB02861E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE questionnaires ADD CONSTRAINT FK_5D60D73F12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaires (id)');
        $this->addSql('ALTER TABLE scores ADD CONSTRAINT FK_750375ECE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaires (id)');
        $this->addSql('ALTER TABLE scores ADD CONSTRAINT FK_750375EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE propositions DROP FOREIGN KEY FK_E9AB02861E27F6BF');
        $this->addSql('ALTER TABLE questionnaires DROP FOREIGN KEY FK_5D60D73F12469DE2');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5CE07E8FF');
        $this->addSql('ALTER TABLE scores DROP FOREIGN KEY FK_750375ECE07E8FF');
        $this->addSql('ALTER TABLE scores DROP FOREIGN KEY FK_750375EA76ED395');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE propositions');
        $this->addSql('DROP TABLE questionnaires');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE scores');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
