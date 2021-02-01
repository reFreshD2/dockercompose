<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200627053948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auction (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(50) NOT NULL, date DATE NOT NULL, time TIME NOT NULL, discription VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bue (id INT AUTO_INCREMENT NOT NULL, lot_id INT NOT NULL, buyer_id INT NOT NULL, UNIQUE INDEX UNIQ_DB82DE38A8CBA5F7 (lot_id), INDEX IDX_DB82DE386C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(40) NOT NULL, discription VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club_user (club_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E95B1CA961190A32 (club_id), INDEX IDX_E95B1CA9A76ED395 (user_id), PRIMARY KEY(club_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lot (id INT AUTO_INCREMENT NOT NULL, auction_id INT NOT NULL, seller_id INT NOT NULL, name VARCHAR(50) NOT NULL, price INT NOT NULL, INDEX IDX_B81291B57B8F0DE (auction_id), INDEX IDX_B81291B8DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(40) NOT NULL, password VARCHAR(40) NOT NULL, phone VARCHAR(12) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bue ADD CONSTRAINT FK_DB82DE38A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lot (id)');
        $this->addSql('ALTER TABLE bue ADD CONSTRAINT FK_DB82DE386C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE club_user ADD CONSTRAINT FK_E95B1CA961190A32 FOREIGN KEY (club_id) REFERENCES club (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE club_user ADD CONSTRAINT FK_E95B1CA9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B57B8F0DE FOREIGN KEY (auction_id) REFERENCES auction (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291B8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B57B8F0DE');
        $this->addSql('ALTER TABLE club_user DROP FOREIGN KEY FK_E95B1CA961190A32');
        $this->addSql('ALTER TABLE bue DROP FOREIGN KEY FK_DB82DE38A8CBA5F7');
        $this->addSql('ALTER TABLE bue DROP FOREIGN KEY FK_DB82DE386C755722');
        $this->addSql('ALTER TABLE club_user DROP FOREIGN KEY FK_E95B1CA9A76ED395');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291B8DE820D9');
        $this->addSql('DROP TABLE auction');
        $this->addSql('DROP TABLE bue');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE club_user');
        $this->addSql('DROP TABLE lot');
        $this->addSql('DROP TABLE user');
    }
}
