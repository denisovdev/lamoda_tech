<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504143659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {   
        $this->addSql('CREATE TABLE storage (id SERIAL PRIMARY KEY);');
        $this->addSql('ALTER TABLE storage ADD name VARCHAR(50) NOT NULL;');
        $this->addSql('ALTER TABLE storage ADD availability BOOLEAN NOT NULL;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS storage');
    }
}
