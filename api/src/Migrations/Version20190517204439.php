<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190517204439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE booking DROP CONSTRAINT fk_e00cedde64d218e');
        $this->addSql('DROP INDEX idx_e00cedde64d218e');
        $this->addSql('ALTER TABLE booking RENAME COLUMN location_id TO slot_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE59E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E00CEDDE59E5119C ON booking (slot_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE59E5119C');
        $this->addSql('DROP INDEX IDX_E00CEDDE59E5119C');
        $this->addSql('ALTER TABLE booking RENAME COLUMN slot_id TO location_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT fk_e00cedde64d218e FOREIGN KEY (location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e00cedde64d218e ON booking (location_id)');
    }
}
