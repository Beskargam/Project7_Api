<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190318102311 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE manufacturer (id INT AUTO_INCREMENT NOT NULL, manufacturer_name VARCHAR(190) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, access_token VARCHAR(190) NOT NULL, date_token DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendor (id INT AUTO_INCREMENT NOT NULL, vendor_name VARCHAR(190) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD manufacturer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A23B42D FOREIGN KEY (manufacturer_id) REFERENCES manufacturer (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A23B42D ON article (manufacturer_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649B6A2DD68 ON user');
        $this->addSql('ALTER TABLE user ADD access_token_id INT NOT NULL, ADD vendor_id INT NOT NULL, DROP access_token');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492CCB2688 FOREIGN KEY (access_token_id) REFERENCES token (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6492CCB2688 ON user (access_token_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F603EE73 ON user (vendor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A23B42D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492CCB2688');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F603EE73');
        $this->addSql('DROP TABLE manufacturer');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('DROP INDEX IDX_23A0E66A23B42D ON article');
        $this->addSql('ALTER TABLE article DROP manufacturer_id');
        $this->addSql('DROP INDEX UNIQ_8D93D6492CCB2688 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649F603EE73 ON user');
        $this->addSql('ALTER TABLE user ADD access_token VARCHAR(190) NOT NULL COLLATE utf8mb4_unicode_ci, DROP access_token_id, DROP vendor_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649B6A2DD68 ON user (access_token)');
    }
}
