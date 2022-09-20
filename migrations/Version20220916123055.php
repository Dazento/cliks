<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916123055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD delivery_adress_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398C0E3B53E FOREIGN KEY (delivery_adress_id) REFERENCES user_adress (id)');
        $this->addSql('CREATE INDEX IDX_F5299398C0E3B53E ON `order` (delivery_adress_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398C0E3B53E');
        $this->addSql('DROP INDEX IDX_F5299398C0E3B53E ON `order`');
        $this->addSql('ALTER TABLE `order` DROP delivery_adress_id');
    }
}
