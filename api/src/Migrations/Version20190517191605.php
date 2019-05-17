<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190517191605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE slot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE food_truck_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE booking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE slot (id INT NOT NULL, location_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC0E206764D218E ON slot (location_id)');
        $this->addSql('CREATE TABLE food_truck (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, name VARCHAR(255) NOT NULL, latitude NUMERIC(8, 6) NOT NULL, longitude NUMERIC(9, 6) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE booking (id INT NOT NULL, location_id INT DEFAULT NULL, food_truck_id INT DEFAULT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E00CEDDE64D218E ON booking (location_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEEED85B8C ON booking (food_truck_id)');
        $this->addSql('ALTER TABLE slot ADD CONSTRAINT FK_AC0E206764D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE64D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEEED85B8C FOREIGN KEY (food_truck_id) REFERENCES food_truck (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDEEED85B8C');
        $this->addSql('ALTER TABLE slot DROP CONSTRAINT FK_AC0E206764D218E');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE64D218E');
        $this->addSql('DROP SEQUENCE slot_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE food_truck_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE location_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE booking_id_seq CASCADE');
        $this->addSql('DROP TABLE slot');
        $this->addSql('DROP TABLE food_truck');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE booking');
    }
}
