<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506191839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO storage (name, availability) VALUES ('Долгопрудный', true), ('Балашиха', false), ('Химки', true);");
        
        $this->addSql("INSERT INTO item (id, name, size) VALUES ('uid-1', 'Кроссовки', '41'), ('uid-2', 'Футболка', 'M'), ('uid-3', 'Куртка', '44'), ('uid-4', 'Туфли', '39'), ('uid-5', 'Кофта', 'L'), ('uid-6', 'Шапка', '19');");

        $this->addSql("INSERT INTO storage_item (storage_id, item_id, amount) VALUES (1, 'uid-1', 20), (1, 'uid-2', 10), (1, 'uid-3', 15), (1, 'uid-6', 2), (1, 'uid-4', 10), (1, 'uid-5', 91), (2, 'uid-2', 70), (2, 'uid-3', 1), (2, 'uid-4', 5), (2, 'uid-5', 8), (3, 'uid-6', 6), (3, 'uid-4', 19)");
        
    }

    public function down(Schema $schema): void
    {
        //
    }
}
