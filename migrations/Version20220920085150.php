<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920085150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP INDEX UNIQ_ED896F466F90D45B, ADD INDEX IDX_ED896F466F90D45B (orderid_id)');
        $this->addSql('ALTER TABLE order_detail CHANGE orderid_id orderid_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP INDEX IDX_ED896F466F90D45B, ADD UNIQUE INDEX UNIQ_ED896F466F90D45B (orderid_id)');
        $this->addSql('ALTER TABLE order_detail CHANGE orderid_id orderid_id INT DEFAULT NULL');
    }
}
