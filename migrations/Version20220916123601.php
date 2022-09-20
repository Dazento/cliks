<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916123601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD billing_adress_id INT NOT NULL, ADD amount INT NOT NULL, ADD paid TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939830959BF2 FOREIGN KEY (billing_adress_id) REFERENCES user_adress (id)');
        $this->addSql('CREATE INDEX IDX_F529939830959BF2 ON `order` (billing_adress_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939830959BF2');
        $this->addSql('DROP INDEX IDX_F529939830959BF2 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP billing_adress_id, DROP amount, DROP paid');
    }
}
