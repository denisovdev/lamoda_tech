<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505063004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE item (id VARCHAR(50) PRIMARY KEY);');
        $this->addSql('ALTER TABLE item ADD name VARCHAR(50) NOT NULL;');
        $this->addSql('ALTER TABLE item ADD size VARCHAR(50) DEFAULT NULL;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS item');
    }
}
