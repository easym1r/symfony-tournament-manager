<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version1_BasicTables extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Создание базовых таблиц для приложения: Список турниров, список команд, список команд по турнирам';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY(id), UNIQUE(name)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tournaments (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id), UNIQUE(name)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tournament_teams (tournament_id INT NOT NULL, team_id INT NOT NULL, INDEX team_id (team_id), INDEX IDX_5794B24133D1A3E7 (tournament_id), PRIMARY KEY(tournament_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tournament_teams ADD CONSTRAINT tournament_teams_ibfk_1 FOREIGN KEY (tournament_id) REFERENCES tournaments (id) ON UPDATE NO ACTION ON DELETE CASCADE ');
        $this->addSql('ALTER TABLE tournament_teams ADD CONSTRAINT tournament_teams_ibfk_2 FOREIGN KEY (team_id) REFERENCES teams (id) ON UPDATE NO ACTION ON DELETE CASCADE ');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournament_teams DROP FOREIGN KEY tournament_teams_ibfk_1');
        $this->addSql('ALTER TABLE tournament_teams DROP FOREIGN KEY tournament_teams_ibfk_2');
        $this->addSql('DROP TABLE tournament_teams');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE tournaments');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
