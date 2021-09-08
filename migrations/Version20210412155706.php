<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210412155706 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
CREATE TABLE category (
    id SERIAL NOT NULL PRIMARY KEY,
    name VARCHAR(50) NOT NULL
)
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
ALTER TABLE category
ADD CONSTRAINT CHECK_category_name_length_min CHECK (length(name) >= 5)
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
CREATE UNIQUE INDEX UNIQ_category_name ON category (name)
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
CREATE TABLE product (
    id SERIAL NOT NULL PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(20) NOT NULL,
    symbol VARCHAR(4) DEFAULT NULL
)
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
ALTER TABLE product
ADD CONSTRAINT CHECK_product_name_length_min CHECK (length(name) >= 5)
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
CREATE UNIQUE INDEX UNIQ_product_category_id ON product (category_id)
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
CREATE UNIQUE INDEX UNIQ_product_symbol ON product (symbol)
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
CREATE UNIQUE INDEX UNIQ_product_name ON product (name)
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
ALTER TABLE product ADD CONSTRAINT FK_product_category_category_id_id FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
ALTER TABLE product
    ADD CONSTRAINT CHECK_product_symbol CHECK (symbol ~* '^[A-J]{1}[0-9]{3}$')
SQL
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
DROP INDEX UNIQ_product_category_id
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
DROP INDEX UNIQ_category_name;
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
ALTER TABLE product DROP CONSTRAINT CHECK_product_name_length_min;
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
DROP INDEX UNIQ_product_name
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
ALTER TABLE category DROP CONSTRAINT CHECK_category_name_length_min
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
ALTER TABLE product DROP CONSTRAINT fk_product_category_category_id_id
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
ALTER TABLE product DROP CONSTRAINT CHECK_product_symbol
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
DROP TABLE category
SQL
        );

        $this->addSql(
        /** @lang PostgreSQL */ <<< SQL
DROP TABLE product
SQL
        );
    }
}
