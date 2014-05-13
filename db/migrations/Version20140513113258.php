<?php

namespace ApplicationMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140513113258 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tblfeeds (
            feedId integer auto_increment NOT NULL,
            feedDateTime DATETIME NULL,
            feedAmount int NOT NULL,
            feedNotes TEXT NULL,
            feedTemperature FLOAT (5,2) NULL,
            userId integer NOT NULL,
            created timestamp,
            updated timestamp,
            PRIMARY KEY (feedId)
        )');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tblfeeds');
    }
}
