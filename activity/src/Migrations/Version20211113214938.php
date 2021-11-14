<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211113214938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE view CHANGE last_view date DATETIME NOT NULL, ADD id INT AUTO_INCREMENT NOT NULL, DROP views_count, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE view CHANGE date last_view DATETIME NOT NULL');
        $this->addSql('ALTER TABLE view MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE view DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE view ADD views_count INT NOT NULL, DROP id');
        $this->addSql('ALTER TABLE view ADD PRIMARY KEY (url)');
    }
}
