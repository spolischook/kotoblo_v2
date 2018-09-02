<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180902163703 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_919694F9BAD26311');
        $this->addSql('DROP INDEX IDX_919694F97294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article_tag AS SELECT article_id, tag_id FROM article_tag');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('CREATE TABLE article_tag (article_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(article_id, tag_id), CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article_tag (article_id, tag_id) SELECT article_id, tag_id FROM __temp__article_tag');
        $this->addSql('DROP TABLE __temp__article_tag');
        $this->addSql('CREATE INDEX IDX_919694F9BAD26311 ON article_tag (tag_id)');
        $this->addSql('CREATE INDEX IDX_919694F97294869C ON article_tag (article_id)');
        $this->addSql('DROP INDEX IDX_9474526CF675F31B');
        $this->addSql('DROP INDEX IDX_9474526CE2904019');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, thread_id, author_id, body, ancestors, depth, created_at, state FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thread_id VARCHAR(255) DEFAULT NULL COLLATE BINARY, author_id INTEGER DEFAULT NULL, body CLOB NOT NULL COLLATE BINARY, ancestors VARCHAR(1024) NOT NULL COLLATE BINARY, depth INTEGER NOT NULL, created_at DATETIME NOT NULL, state INTEGER NOT NULL, CONSTRAINT FK_9474526CE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, thread_id, author_id, body, ancestors, depth, created_at, state) SELECT id, thread_id, author_id, body, ancestors, depth, created_at, state FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('CREATE INDEX IDX_9474526CE2904019 ON comment (thread_id)');
        $this->addSql('ALTER TABLE fos_user ADD COLUMN avatar_url CLOB DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_9407E54977FA751A');
        $this->addSql('DROP INDEX UNIQ_9407E5494B12AD6EA000B10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__acl_object_identities AS SELECT id, parent_object_identity_id, class_id, object_identifier, entries_inheriting FROM acl_object_identities');
        $this->addSql('DROP TABLE acl_object_identities');
        $this->addSql('CREATE TABLE acl_object_identities (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_object_identity_id INTEGER UNSIGNED DEFAULT NULL, class_id INTEGER UNSIGNED NOT NULL, object_identifier VARCHAR(100) NOT NULL COLLATE BINARY, entries_inheriting BOOLEAN NOT NULL, CONSTRAINT FK_9407E54977FA751A FOREIGN KEY (parent_object_identity_id) REFERENCES acl_object_identities (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO acl_object_identities (id, parent_object_identity_id, class_id, object_identifier, entries_inheriting) SELECT id, parent_object_identity_id, class_id, object_identifier, entries_inheriting FROM __temp__acl_object_identities');
        $this->addSql('DROP TABLE __temp__acl_object_identities');
        $this->addSql('CREATE INDEX IDX_9407E54977FA751A ON acl_object_identities (parent_object_identity_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9407E5494B12AD6EA000B10 ON acl_object_identities (object_identifier, class_id)');
        $this->addSql('DROP INDEX IDX_825DE299C671CEA1');
        $this->addSql('DROP INDEX IDX_825DE2993D9AB4A6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__acl_object_identity_ancestors AS SELECT object_identity_id, ancestor_id FROM acl_object_identity_ancestors');
        $this->addSql('DROP TABLE acl_object_identity_ancestors');
        $this->addSql('CREATE TABLE acl_object_identity_ancestors (object_identity_id INTEGER UNSIGNED NOT NULL, ancestor_id INTEGER UNSIGNED NOT NULL, PRIMARY KEY(object_identity_id, ancestor_id), CONSTRAINT FK_825DE2993D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_825DE299C671CEA1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO acl_object_identity_ancestors (object_identity_id, ancestor_id) SELECT object_identity_id, ancestor_id FROM __temp__acl_object_identity_ancestors');
        $this->addSql('DROP TABLE __temp__acl_object_identity_ancestors');
        $this->addSql('CREATE INDEX IDX_825DE299C671CEA1 ON acl_object_identity_ancestors (ancestor_id)');
        $this->addSql('CREATE INDEX IDX_825DE2993D9AB4A6 ON acl_object_identity_ancestors (object_identity_id)');
        $this->addSql('DROP INDEX IDX_46C8B806DF9183C9');
        $this->addSql('DROP INDEX IDX_46C8B8063D9AB4A6');
        $this->addSql('DROP INDEX IDX_46C8B806EA000B10');
        $this->addSql('DROP INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9');
        $this->addSql('DROP INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__acl_entries AS SELECT id, class_id, object_identity_id, security_identity_id, field_name, ace_order, mask, granting, granting_strategy, audit_success, audit_failure FROM acl_entries');
        $this->addSql('DROP TABLE acl_entries');
        $this->addSql('CREATE TABLE acl_entries (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER UNSIGNED NOT NULL, object_identity_id INTEGER UNSIGNED DEFAULT NULL, security_identity_id INTEGER UNSIGNED NOT NULL, field_name VARCHAR(50) DEFAULT NULL COLLATE BINARY, ace_order SMALLINT UNSIGNED NOT NULL, mask INTEGER NOT NULL, granting BOOLEAN NOT NULL, granting_strategy VARCHAR(30) NOT NULL COLLATE BINARY, audit_success BOOLEAN NOT NULL, audit_failure BOOLEAN NOT NULL, CONSTRAINT FK_46C8B806EA000B10 FOREIGN KEY (class_id) REFERENCES acl_classes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_46C8B8063D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_46C8B806DF9183C9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO acl_entries (id, class_id, object_identity_id, security_identity_id, field_name, ace_order, mask, granting, granting_strategy, audit_success, audit_failure) SELECT id, class_id, object_identity_id, security_identity_id, field_name, ace_order, mask, granting, granting_strategy, audit_success, audit_failure FROM __temp__acl_entries');
        $this->addSql('DROP TABLE __temp__acl_entries');
        $this->addSql('CREATE INDEX IDX_46C8B806DF9183C9 ON acl_entries (security_identity_id)');
        $this->addSql('CREATE INDEX IDX_46C8B8063D9AB4A6 ON acl_entries (object_identity_id)');
        $this->addSql('CREATE INDEX IDX_46C8B806EA000B10 ON acl_entries (class_id)');
        $this->addSql('CREATE INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9 ON acl_entries (class_id, object_identity_id, security_identity_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4 ON acl_entries (class_id, object_identity_id, field_name, ace_order)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4');
        $this->addSql('DROP INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9');
        $this->addSql('DROP INDEX IDX_46C8B806EA000B10');
        $this->addSql('DROP INDEX IDX_46C8B8063D9AB4A6');
        $this->addSql('DROP INDEX IDX_46C8B806DF9183C9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__acl_entries AS SELECT id, class_id, object_identity_id, security_identity_id, field_name, ace_order, mask, granting, granting_strategy, audit_success, audit_failure FROM acl_entries');
        $this->addSql('DROP TABLE acl_entries');
        $this->addSql('CREATE TABLE acl_entries (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, class_id INTEGER UNSIGNED NOT NULL, object_identity_id INTEGER UNSIGNED DEFAULT NULL, security_identity_id INTEGER UNSIGNED NOT NULL, field_name VARCHAR(50) DEFAULT NULL, ace_order SMALLINT UNSIGNED NOT NULL, mask INTEGER NOT NULL, granting BOOLEAN NOT NULL, granting_strategy VARCHAR(30) NOT NULL, audit_success BOOLEAN NOT NULL, audit_failure BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO acl_entries (id, class_id, object_identity_id, security_identity_id, field_name, ace_order, mask, granting, granting_strategy, audit_success, audit_failure) SELECT id, class_id, object_identity_id, security_identity_id, field_name, ace_order, mask, granting, granting_strategy, audit_success, audit_failure FROM __temp__acl_entries');
        $this->addSql('DROP TABLE __temp__acl_entries');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4 ON acl_entries (class_id, object_identity_id, field_name, ace_order)');
        $this->addSql('CREATE INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9 ON acl_entries (class_id, object_identity_id, security_identity_id)');
        $this->addSql('CREATE INDEX IDX_46C8B806EA000B10 ON acl_entries (class_id)');
        $this->addSql('CREATE INDEX IDX_46C8B8063D9AB4A6 ON acl_entries (object_identity_id)');
        $this->addSql('CREATE INDEX IDX_46C8B806DF9183C9 ON acl_entries (security_identity_id)');
        $this->addSql('DROP INDEX UNIQ_9407E5494B12AD6EA000B10');
        $this->addSql('DROP INDEX IDX_9407E54977FA751A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__acl_object_identities AS SELECT id, parent_object_identity_id, class_id, object_identifier, entries_inheriting FROM acl_object_identities');
        $this->addSql('DROP TABLE acl_object_identities');
        $this->addSql('CREATE TABLE acl_object_identities (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_object_identity_id INTEGER UNSIGNED DEFAULT NULL, class_id INTEGER UNSIGNED NOT NULL, object_identifier VARCHAR(100) NOT NULL, entries_inheriting BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO acl_object_identities (id, parent_object_identity_id, class_id, object_identifier, entries_inheriting) SELECT id, parent_object_identity_id, class_id, object_identifier, entries_inheriting FROM __temp__acl_object_identities');
        $this->addSql('DROP TABLE __temp__acl_object_identities');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9407E5494B12AD6EA000B10 ON acl_object_identities (object_identifier, class_id)');
        $this->addSql('CREATE INDEX IDX_9407E54977FA751A ON acl_object_identities (parent_object_identity_id)');
        $this->addSql('DROP INDEX IDX_825DE2993D9AB4A6');
        $this->addSql('DROP INDEX IDX_825DE299C671CEA1');
        $this->addSql('CREATE TEMPORARY TABLE __temp__acl_object_identity_ancestors AS SELECT object_identity_id, ancestor_id FROM acl_object_identity_ancestors');
        $this->addSql('DROP TABLE acl_object_identity_ancestors');
        $this->addSql('CREATE TABLE acl_object_identity_ancestors (object_identity_id INTEGER UNSIGNED NOT NULL, ancestor_id INTEGER UNSIGNED NOT NULL, PRIMARY KEY(object_identity_id, ancestor_id))');
        $this->addSql('INSERT INTO acl_object_identity_ancestors (object_identity_id, ancestor_id) SELECT object_identity_id, ancestor_id FROM __temp__acl_object_identity_ancestors');
        $this->addSql('DROP TABLE __temp__acl_object_identity_ancestors');
        $this->addSql('CREATE INDEX IDX_825DE2993D9AB4A6 ON acl_object_identity_ancestors (object_identity_id)');
        $this->addSql('CREATE INDEX IDX_825DE299C671CEA1 ON acl_object_identity_ancestors (ancestor_id)');
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
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, thread_id, author_id, body, ancestors, depth, created_at, state FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thread_id VARCHAR(255) DEFAULT NULL, author_id INTEGER DEFAULT NULL, body CLOB NOT NULL, ancestors VARCHAR(1024) NOT NULL, depth INTEGER NOT NULL, created_at DATETIME NOT NULL, state INTEGER NOT NULL)');
        $this->addSql('INSERT INTO comment (id, thread_id, author_id, body, ancestors, depth, created_at, state) SELECT id, thread_id, author_id, body, ancestors, depth, created_at, state FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CE2904019 ON comment (thread_id)');
        $this->addSql('CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)');
        $this->addSql('DROP INDEX UNIQ_957A647992FC23A8');
        $this->addSql('DROP INDEX UNIQ_957A6479A0D96FBF');
        $this->addSql('DROP INDEX UNIQ_957A6479C05FB297');
        $this->addSql('CREATE TEMPORARY TABLE __temp__fos_user AS SELECT id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, github_id FROM fos_user');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('CREATE TABLE fos_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:array)
        , github_id VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO fos_user (id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, github_id) SELECT id, username, username_canonical, email, email_canonical, enabled, salt, password, last_login, confirmation_token, password_requested_at, roles, github_id FROM __temp__fos_user');
        $this->addSql('DROP TABLE __temp__fos_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479C05FB297 ON fos_user (confirmation_token)');
    }
}
