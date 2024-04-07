<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * TODO Временное решение посева данных
 *
 * FIXME Необходимо заменить на doctrine:fixtures (composer require --dev doctrine/data-fixtures)
 *
 * Использовать на чистые таблицы с помощью команды: php bin/console doctrine:migrations:execute DoctrineMigrations\\Version1_BasicSeeder --up
 */
class Version1_BasicSeeder extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Заполнение базовых таблиц данными, созданных с помощью миграции';
    }

    public function up(Schema $schema): void
    {
        /**
         * Table - tournaments
         */

        $this->addSql("INSERT INTO tournaments (id, name) VALUES (1, 'Football'),
                                                                     (2, 'Basketball'),
                                                                     (3, 'Sprint 100m')");

        /**
         * Table - teams
         */

        $this->addSql("INSERT INTO teams (id, name) VALUES (1, 'Russia'),
                                                               (2, 'USA'),
                                                               (3, 'China'),
                                                               (4, 'Germany'),
                                                               (5, 'Cuba'),
                                                               (6, 'Japan'),
                                                               (7, 'Kenya'),
                                                               (8, 'Mexico'),
                                                               (9, 'Niger'),
                                                               (10, 'Italy')");

        /**
         * Table - tournament_teams
         */
        $this->addSql('INSERT INTO tournament_teams (tournament_id, team_id) VALUES (1, 1),
                                                                                        (1, 4),
                                                                                        (1, 7),
                                                                                        (1, 10),
                                                                                        (2, 2),
                                                                                        (2, 5),
                                                                                        (2, 8),
                                                                                        (3, 3),
                                                                                        (3, 6),
                                                                                        (3, 9)');
    }

    public function down(Schema $schema): void
    {
        // TODO: Implement up() method.
    }
}