<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250609123543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_E19D9AD277153098 ON service (code)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD status VARCHAR(100) DEFAULT NULL, ADD category VARCHAR(1) DEFAULT NULL, ADD position VARCHAR(255) DEFAULT NULL, ADD position_occupied TINYINT(1) DEFAULT NULL, ADD location VARCHAR(100) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_E19D9AD277153098 ON service
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP status, DROP category, DROP position, DROP position_occupied, DROP location
        SQL);
    }
}
