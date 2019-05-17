<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190517231316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE customer_location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE customer_location (id INT NOT NULL, customer_id INT DEFAULT NULL, location_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_725BCAE49395C3F3 ON customer_location (customer_id)');
        $this->addSql('CREATE INDEX IDX_725BCAE464D218E ON customer_location (location_id)');
        $this->addSql('ALTER TABLE customer_location ADD CONSTRAINT FK_725BCAE49395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customer_location ADD CONSTRAINT FK_725BCAE464D218E FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT fk_68c58ed964d218e');
        $this->addSql('DROP INDEX idx_68c58ed964d218e');
        $this->addSql('ALTER TABLE favorite RENAME COLUMN location_id TO food_truck_id');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9EED85B8C FOREIGN KEY (food_truck_id) REFERENCES food_truck (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_68C58ED9EED85B8C ON favorite (food_truck_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE customer_location_id_seq CASCADE');
        $this->addSql('DROP TABLE customer_location');
        $this->addSql('ALTER TABLE favorite DROP CONSTRAINT FK_68C58ED9EED85B8C');
        $this->addSql('DROP INDEX IDX_68C58ED9EED85B8C');
        $this->addSql('ALTER TABLE favorite RENAME COLUMN food_truck_id TO location_id');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT fk_68c58ed964d218e FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_68c58ed964d218e ON favorite (location_id)');
    }
}
