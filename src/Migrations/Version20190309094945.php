<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190309094945 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492CCB2688 FOREIGN KEY (access_token_id) REFERENCES token (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6492CCB2688 ON user (access_token_id)');
        $this->addSql('DROP INDEX UNIQ_5F37A13BB6A2DD68 ON token');
        $this->addSql('ALTER TABLE token ADD date_token DATETIME NOT NULL, DROP token_date');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE token ADD token_date DATE NOT NULL, DROP date_token');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F37A13BB6A2DD68 ON token (access_token)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492CCB2688');
        $this->addSql('DROP INDEX UNIQ_8D93D6492CCB2688 ON user');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
