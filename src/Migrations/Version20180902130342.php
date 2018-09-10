<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180902130342 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_919694F97294869C');
        $this->addSql('DROP INDEX IDX_919694F9BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article_tag AS SELECT article_id, tag_id FROM article_tag');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('CREATE TABLE article_tag (article_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(article_id, tag_id), CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article_tag (article_id, tag_id) SELECT article_id, tag_id FROM __temp__article_tag');
        $this->addSql('DROP TABLE __temp__article_tag');
        $this->addSql('CREATE INDEX IDX_919694F97294869C ON article_tag (article_id)');
        $this->addSql('CREATE INDEX IDX_919694F9BAD26311 ON article_tag (tag_id)');
        $this->addSql('DROP INDEX IDX_9474526CE2904019');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, thread_id, body, ancestors, depth, created_at, state FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thread_id VARCHAR(255) DEFAULT NULL COLLATE BINARY, author_id INTEGER DEFAULT NULL, body CLOB NOT NULL COLLATE BINARY, ancestors VARCHAR(1024) NOT NULL COLLATE BINARY, depth INTEGER NOT NULL, created_at DATETIME NOT NULL, state INTEGER NOT NULL, CONSTRAINT FK_9474526CE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, thread_id, body, ancestors, depth, created_at, state) SELECT id, thread_id, body, ancestors, depth, created_at, state FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CE2904019 ON comment (thread_id)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_919694F97294869C');
        $this->addSql('DROP INDEX IDX_919694F9BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article_tag AS SELECT article_id, tag_id FROM article_tag');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('CREATE TABLE article_tag (article_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(article_id, tag_id))');
        $this->addSql('INSERT INTO article_tag (article_id, tag_id) SELECT article_id, tag_id FROM __temp__article_tag');
        $this->addSql('DROP TABLE __temp__article_tag');
        $this->addSql('CREATE INDEX IDX_919694F97294869C ON article_tag (article_id)');
        $this->addSql('CREATE INDEX IDX_919694F9BAD26311 ON article_tag (tag_id)');
        $this->addSql('DROP INDEX IDX_9474526CE2904019');
        $this->addSql('DROP INDEX IDX_9474526CF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, thread_id, body, ancestors, depth, created_at, state FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thread_id VARCHAR(255) DEFAULT NULL, body CLOB NOT NULL, ancestors VARCHAR(1024) NOT NULL, depth INTEGER NOT NULL, created_at DATETIME NOT NULL, state INTEGER NOT NULL)');
        $this->addSql('INSERT INTO comment (id, thread_id, body, ancestors, depth, created_at, state) SELECT id, thread_id, body, ancestors, depth, created_at, state FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CE2904019 ON comment (thread_id)');
    }
}
