<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190518122821 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE booking_rating_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE booking_rating (id INT NOT NULL, booking_id INT DEFAULT NULL, food_truck_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, stars SMALLINT NOT NULL, comment TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_63131DDC3301C60 ON booking_rating (booking_id)');
        $this->addSql('CREATE INDEX IDX_63131DDCEED85B8C ON booking_rating (food_truck_id)');
        $this->addSql('CREATE INDEX IDX_63131DDC9395C3F3 ON booking_rating (customer_id)');
        $this->addSql('COMMENT ON COLUMN booking_rating.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE booking_rating ADD CONSTRAINT FK_63131DDC3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_rating ADD CONSTRAINT FK_63131DDCEED85B8C FOREIGN KEY (food_truck_id) REFERENCES food_truck (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_rating ADD CONSTRAINT FK_63131DDC9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE booking_rating_id_seq CASCADE');
        $this->addSql('DROP TABLE booking_rating');
    }
}
