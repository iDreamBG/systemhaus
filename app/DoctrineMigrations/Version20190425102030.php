<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190425102030 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE telephone DROP FOREIGN KEY FK_450FF010A196F9FD');
        $this->addSql('DROP INDEX IDX_450FF010A196F9FD ON telephone');
        $this->addSql('ALTER TABLE telephone CHANGE authorid contactId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE telephone ADD CONSTRAINT FK_450FF010744BF426 FOREIGN KEY (contactId) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_450FF010744BF426 ON telephone (contactId)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE telephone DROP FOREIGN KEY FK_450FF010744BF426');
        $this->addSql('DROP INDEX IDX_450FF010744BF426 ON telephone');
        $this->addSql('ALTER TABLE telephone CHANGE contactid authorId INT DEFAULT NULL');
        $this->addSql('ALTER TABLE telephone ADD CONSTRAINT FK_450FF010A196F9FD FOREIGN KEY (authorId) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_450FF010A196F9FD ON telephone (authorId)');
    }
}
