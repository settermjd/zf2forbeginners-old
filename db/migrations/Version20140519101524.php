<?php

namespace ApplicationMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140519101524 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("alter table tblfeeds drop column feedDateTime");
        $this->addSql("alter table tblfeeds add column feedDate date not null");
        $this->addSql("alter table tblfeeds add column feedTime time not null");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("alter table tblfeeds add column feedDateTime datetime not null");
    }
}
