<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261019142553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Logos et photos : stockage du nom de fichier uploadé (back-office).';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__sponsor AS SELECT id, name, tier, website_url, description, logo_path, position FROM sponsor');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('CREATE TABLE sponsor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tier VARCHAR(255) NOT NULL, website_url VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, position INTEGER NOT NULL)');
        $this->addSql('INSERT INTO sponsor (id, name, tier, website_url, description, logo, position) SELECT id, name, tier, website_url, description, logo_path, position FROM __temp__sponsor');
        $this->addSql('DROP TABLE __temp__sponsor');
        $this->addSql('CREATE TEMPORARY TABLE __temp__team_member AS SELECT id, name, role, bio, photo_path, linkedin_url, github_url, speaker, position FROM team_member');
        $this->addSql('DROP TABLE team_member');
        $this->addSql('CREATE TABLE team_member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, bio CLOB NOT NULL, photo VARCHAR(255) DEFAULT NULL, linkedin_url VARCHAR(255) DEFAULT NULL, github_url VARCHAR(255) DEFAULT NULL, speaker BOOLEAN NOT NULL, position INTEGER NOT NULL)');
        $this->addSql('INSERT INTO team_member (id, name, role, bio, photo, linkedin_url, github_url, speaker, position) SELECT id, name, role, bio, photo_path, linkedin_url, github_url, speaker, position FROM __temp__team_member');
        $this->addSql('DROP TABLE __temp__team_member');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__sponsor AS SELECT id, name, tier, website_url, description, logo, position FROM sponsor');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('CREATE TABLE sponsor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tier VARCHAR(255) NOT NULL, website_url VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, logo_path VARCHAR(255) DEFAULT NULL, position INTEGER NOT NULL)');
        $this->addSql('INSERT INTO sponsor (id, name, tier, website_url, description, logo_path, position) SELECT id, name, tier, website_url, description, logo, position FROM __temp__sponsor');
        $this->addSql('DROP TABLE __temp__sponsor');
        $this->addSql('CREATE TEMPORARY TABLE __temp__team_member AS SELECT id, name, role, bio, photo, linkedin_url, github_url, speaker, position FROM team_member');
        $this->addSql('DROP TABLE team_member');
        $this->addSql('CREATE TABLE team_member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, bio CLOB NOT NULL, photo_path VARCHAR(255) DEFAULT NULL, linkedin_url VARCHAR(255) DEFAULT NULL, github_url VARCHAR(255) DEFAULT NULL, speaker BOOLEAN NOT NULL, position INTEGER NOT NULL)');
        $this->addSql('INSERT INTO team_member (id, name, role, bio, photo_path, linkedin_url, github_url, speaker, position) SELECT id, name, role, bio, photo, linkedin_url, github_url, speaker, position FROM __temp__team_member');
        $this->addSql('DROP TABLE __temp__team_member');
    }
}
