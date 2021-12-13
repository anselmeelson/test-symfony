<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211208205601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D190BE4C5');
        $this->addSql('DROP INDEX IDX_1981A66D190BE4C5 ON operation');
        $this->addSql('ALTER TABLE operation DROP user_client_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation ADD user_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D190BE4C5 FOREIGN KEY (user_client_id) REFERENCES user_client (id)');
        $this->addSql('CREATE INDEX IDX_1981A66D190BE4C5 ON operation (user_client_id)');
    }
}
