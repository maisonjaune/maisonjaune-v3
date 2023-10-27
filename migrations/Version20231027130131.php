<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231027130131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE node (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, published_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', actif TINYINT(1) NOT NULL, draft TINYINT(1) NOT NULL, sticky TINYINT(1) NOT NULL, commentable TINYINT(1) NOT NULL, node_type VARCHAR(255) NOT NULL, INDEX IDX_857FE845F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE node_brief (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_category (brief_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_E0A4AB57757FABFF (brief_id), INDEX IDX_E0A4AB5712469DE2 (category_id), PRIMARY KEY(brief_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE node_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, shortname VARCHAR(10) NOT NULL, slug VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE node_page (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE node_post (id INT NOT NULL, excerpt LONGTEXT DEFAULT NULL, reviewed TINYINT(1) NOT NULL, decorated TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_category (post_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B9A190604B89032C (post_id), INDEX IDX_B9A1906012469DE2 (category_id), PRIMARY KEY(post_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE845F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE node_brief ADD CONSTRAINT FK_61082FBBF396750 FOREIGN KEY (id) REFERENCES node (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_category ADD CONSTRAINT FK_E0A4AB57757FABFF FOREIGN KEY (brief_id) REFERENCES node_brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_category ADD CONSTRAINT FK_E0A4AB5712469DE2 FOREIGN KEY (category_id) REFERENCES node_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE node_page ADD CONSTRAINT FK_D3AE3BB6BF396750 FOREIGN KEY (id) REFERENCES node (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE node_post ADD CONSTRAINT FK_9D2EE11BBF396750 FOREIGN KEY (id) REFERENCES node (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A190604B89032C FOREIGN KEY (post_id) REFERENCES node_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A1906012469DE2 FOREIGN KEY (category_id) REFERENCES node_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE node DROP FOREIGN KEY FK_857FE845F675F31B');
        $this->addSql('ALTER TABLE node_brief DROP FOREIGN KEY FK_61082FBBF396750');
        $this->addSql('ALTER TABLE brief_category DROP FOREIGN KEY FK_E0A4AB57757FABFF');
        $this->addSql('ALTER TABLE brief_category DROP FOREIGN KEY FK_E0A4AB5712469DE2');
        $this->addSql('ALTER TABLE node_page DROP FOREIGN KEY FK_D3AE3BB6BF396750');
        $this->addSql('ALTER TABLE node_post DROP FOREIGN KEY FK_9D2EE11BBF396750');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A190604B89032C');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A1906012469DE2');
        $this->addSql('DROP TABLE node');
        $this->addSql('DROP TABLE node_brief');
        $this->addSql('DROP TABLE brief_category');
        $this->addSql('DROP TABLE node_category');
        $this->addSql('DROP TABLE node_page');
        $this->addSql('DROP TABLE node_post');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
