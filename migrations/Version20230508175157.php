<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508175157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_blocked (id INT AUTO_INCREMENT NOT NULL, user_blocked_id INT NOT NULL, blocked_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_blocked_users (users_blocked_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_AA27EC18F694FEA2 (users_blocked_id), INDEX IDX_AA27EC1867B3B43D (users_id), PRIMARY KEY(users_blocked_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_blocked_users ADD CONSTRAINT FK_AA27EC18F694FEA2 FOREIGN KEY (users_blocked_id) REFERENCES users_blocked (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_blocked_users ADD CONSTRAINT FK_AA27EC1867B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_blocked_users DROP FOREIGN KEY FK_AA27EC18F694FEA2');
        $this->addSql('ALTER TABLE users_blocked_users DROP FOREIGN KEY FK_AA27EC1867B3B43D');
        $this->addSql('DROP TABLE users_blocked');
        $this->addSql('DROP TABLE users_blocked_users');
    }
}
