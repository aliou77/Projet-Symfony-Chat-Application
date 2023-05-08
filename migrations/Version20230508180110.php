<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508180110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_deleted (id INT AUTO_INCREMENT NOT NULL, user_deleted_id INT NOT NULL, deleted_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_deleted TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_deleted_users (users_deleted_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_70EE92B248F6BA29 (users_deleted_id), INDEX IDX_70EE92B267B3B43D (users_id), PRIMARY KEY(users_deleted_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_deleted_users ADD CONSTRAINT FK_70EE92B248F6BA29 FOREIGN KEY (users_deleted_id) REFERENCES users_deleted (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_deleted_users ADD CONSTRAINT FK_70EE92B267B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_blocked ADD is_blocked TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_deleted_users DROP FOREIGN KEY FK_70EE92B248F6BA29');
        $this->addSql('ALTER TABLE users_deleted_users DROP FOREIGN KEY FK_70EE92B267B3B43D');
        $this->addSql('DROP TABLE users_deleted');
        $this->addSql('DROP TABLE users_deleted_users');
        $this->addSql('ALTER TABLE users_blocked DROP is_blocked');
    }
}
