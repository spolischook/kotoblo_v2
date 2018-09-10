<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180902105409 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thread_id VARCHAR(255) DEFAULT NULL, body CLOB NOT NULL, ancestors VARCHAR(1024) NOT NULL, depth INTEGER NOT NULL, created_at DATETIME NOT NULL, state INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9474526CE2904019 ON comment (thread_id)');
        $this->addSql('CREATE TABLE fos_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:array)
        , github_id VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479C05FB297 ON fos_user (confirmation_token)');
        $this->addSql('CREATE TABLE thread (id VARCHAR(255) NOT NULL, permalink VARCHAR(255) NOT NULL, is_commentable BOOLEAN NOT NULL, num_comments INTEGER NOT NULL, last_comment_at DATETIME DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP INDEX IDX_919694F9BAD26311');
        $this->addSql('DROP INDEX IDX_919694F97294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article_tag AS SELECT article_id, tag_id FROM article_tag');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('CREATE TABLE article_tag (article_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(article_id, tag_id), CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article_tag (article_id, tag_id) SELECT article_id, tag_id FROM __temp__article_tag');
        $this->addSql('DROP TABLE __temp__article_tag');
        $this->addSql('CREATE INDEX IDX_919694F9BAD26311 ON article_tag (tag_id)');
        $this->addSql('CREATE INDEX IDX_919694F97294869C ON article_tag (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE thread');
        $this->addSql('DROP INDEX IDX_919694F97294869C');
        $this->addSql('DROP INDEX IDX_919694F9BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article_tag AS SELECT article_id, tag_id FROM article_tag');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('CREATE TABLE article_tag (article_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(article_id, tag_id))');
        $this->addSql('INSERT INTO article_tag (article_id, tag_id) SELECT article_id, tag_id FROM __temp__article_tag');
        $this->addSql('DROP TABLE __temp__article_tag');
        $this->addSql('CREATE INDEX IDX_919694F97294869C ON article_tag (article_id)');
        $this->addSql('CREATE INDEX IDX_919694F9BAD26311 ON article_tag (tag_id)');
    }
}
