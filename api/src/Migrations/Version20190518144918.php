<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190518144918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds a table for mapping lunch trains to lunch train riders';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE lunch_train_riders (lunch_train_id INT NOT NULL, customer_id INT NOT NULL, PRIMARY KEY(lunch_train_id, customer_id))');
        $this->addSql('CREATE INDEX IDX_7443B241F15826E1 ON lunch_train_riders (lunch_train_id)');
        $this->addSql('CREATE INDEX IDX_7443B2419395C3F3 ON lunch_train_riders (customer_id)');
        $this->addSql('ALTER TABLE lunch_train_riders ADD CONSTRAINT FK_7443B241F15826E1 FOREIGN KEY (lunch_train_id) REFERENCES lunch_train (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lunch_train_riders ADD CONSTRAINT FK_7443B2419395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE lunch_train_riders');
    }
}
