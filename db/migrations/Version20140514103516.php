<?php

namespace ApplicationMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140514103516 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql(
            "CREATE TABLE IF NOT EXISTS tblstatus (
            statusId integer auto_increment NOT NULL,
            status VARCHAR(20) NOT NULL,
            created timestamp,
            updated timestamp,
            PRIMARY KEY (statusId))"
        );

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            "CREATE TABLE IF NOT EXISTS tbladdresses (
            addressId integer auto_increment NOT NULL,
            addressTypeId integer NOT NULL,
            addressOne VARCHAR(100) NOT NULL,
            addressTwo VARCHAR(100) NULL,
            city VARCHAR(10) NULL,
            state VARCHAR(10) NULL,
            postcode VARCHAR(30) NOT NULL,
            countryId integer NOT NULL,
            created timestamp,
            updated timestamp,
            PRIMARY KEY (addressId))"
        );

        $this->addSql(
            "CREATE TABLE IF NOT EXISTS tbladdresstype (
            addressTypeId integer auto_increment NOT NULL,
            addressType VARCHAR(100) NOT NULL,
            notes VARCHAR(200) NULL,
            created timestamp,
            updated timestamp,
            PRIMARY KEY (addressTypeId))"
        );

        $this->addSql(
            "CREATE TABLE IF NOT EXISTS tblcountry (
            countryId integer auto_increment NOT NULL,
            countryName VARCHAR(100) NOT NULL,
            countryCode VARCHAR(3) NOT NULL,
            created timestamp,
            updated timestamp,
            PRIMARY KEY (countryId))"
        );
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("drop table tblstatus");
        $this->addSql("drop table tbladdresses");
        $this->addSql("drop table tbladdresstype");
        $this->addSql("drop table tblcountry");
    }
}
