<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240205094137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE juego (id INT AUTO_INCREMENT NOT NULL, categoria_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, imagen VARCHAR(255) NOT NULL, num_downloads INT NOT NULL, rating DOUBLE PRECISION NOT NULL, INDEX IDX_F0EC403D3397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, id_creador_id INT DEFAULT NULL, id_juego_id INT DEFAULT NULL, titulo VARCHAR(100) NOT NULL, descripcion VARCHAR(100) NOT NULL, imagen VARCHAR(100) NOT NULL, fecha DATETIME NOT NULL, num_likes INT NOT NULL, INDEX IDX_5A8A6C8DC77E8CEA (id_creador_id), INDEX IDX_5A8A6C8D43ECBEC0 (id_juego_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(30) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(30) NOT NULL, profile_image VARCHAR(100) NOT NULL, num_posts INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE juego ADD CONSTRAINT FK_F0EC403D3397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DC77E8CEA FOREIGN KEY (id_creador_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D43ECBEC0 FOREIGN KEY (id_juego_id) REFERENCES juego (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE juego DROP FOREIGN KEY FK_F0EC403D3397707A');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DC77E8CEA');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D43ECBEC0');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE juego');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE usuario');
    }
}
