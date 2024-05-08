<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507065727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE reservation (id SERIAL PRIMARY KEY)');
        $this->addSql('ALTER TABLE reservation ADD uid VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD storage_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD item_id VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD amount INT NOT NULL');
        $this->addSql("ALTER TABLE reservation ADD status VARCHAR(10) DEFAULT 'created'");


        $this->addSql('ALTER TABLE reservation ADD FOREIGN KEY (storage_id) REFERENCES storage(id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD FOREIGN KEY (item_id) REFERENCES item(id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS reservation');
    }
}
