<?php

namespace ApplicationMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140512210817 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE tblusers (
            userId integer auto_increment NOT NULL,
            firstName varchar(200) DEFAULT NULL,
            lastName varchar(200) DEFAULT NULL,
            username varchar(400) DEFAULT NULL,
            notes TEXT DEFAULT NULL,
            addressId integer NOT NULL,
            statusId integer NOT NULL,
            created timestamp,
            updated timestamp,
            PRIMARY KEY (userId)
        )');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tblusers');
    }
}
