<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190518134235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds a table for lunch trains';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE lunch_train_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE lunch_train (id INT NOT NULL, operator_id INT DEFAULT NULL, booking_id INT DEFAULT NULL, leaves_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3429ADBF584598A3 ON lunch_train (operator_id)');
        $this->addSql('CREATE INDEX IDX_3429ADBF3301C60 ON lunch_train (booking_id)');
        $this->addSql('COMMENT ON COLUMN lunch_train.leaves_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN lunch_train.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE lunch_train ADD CONSTRAINT FK_3429ADBF584598A3 FOREIGN KEY (operator_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lunch_train ADD CONSTRAINT FK_3429ADBF3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE lunch_train_id_seq CASCADE');
        $this->addSql('DROP TABLE lunch_train');
    }
}
