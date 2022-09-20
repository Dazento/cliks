<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220916135548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, orderid_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_ED896F464584665A (product_id), UNIQUE INDEX UNIQ_ED896F466F90D45B (orderid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F464584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F466F90D45B FOREIGN KEY (orderid_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE ordered_product DROP FOREIGN KEY FK_E6F097B64584665A');
        $this->addSql('ALTER TABLE ordered_product DROP FOREIGN KEY FK_E6F097B66F90D45B');
        $this->addSql('DROP TABLE ordered_product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ordered_product (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, orderid_id INT DEFAULT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_E6F097B66F90D45B (orderid_id), INDEX IDX_E6F097B64584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ordered_product ADD CONSTRAINT FK_E6F097B64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE ordered_product ADD CONSTRAINT FK_E6F097B66F90D45B FOREIGN KEY (orderid_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F464584665A');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F466F90D45B');
        $this->addSql('DROP TABLE order_detail');
    }
}
