<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240902070030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE user_licence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_licence (id INT NOT NULL, user_id VARCHAR(255) NOT NULL, licence VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_45A7F842A76ED395 ON user_licence (user_id)');
        $this->addSql('ALTER TABLE user_licence ADD CONSTRAINT FK_45A7F842A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE user_licence_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_licence DROP CONSTRAINT FK_45A7F842A76ED395');
        $this->addSql('DROP TABLE user_licence');
    }
}
