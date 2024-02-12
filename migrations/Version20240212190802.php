<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212190802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP role');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DF85E0677 ON usuario (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_2265B05DF85E0677 ON usuario');
        $this->addSql('ALTER TABLE usuario ADD role VARCHAR(30) NOT NULL, DROP roles');
    }
}
