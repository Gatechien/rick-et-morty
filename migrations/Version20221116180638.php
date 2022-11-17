<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116180638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, air_date VARCHAR(255) NOT NULL, episode VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, dimension VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, origin_id INT DEFAULT NULL, location_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT NULL, species VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, origin_name VARCHAR(255) DEFAULT NULL, location_name VARCHAR(255) DEFAULT NULL, INDEX IDX_34DCD17656A273CC (origin_id), INDEX IDX_34DCD17664D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_episode (person_id INT NOT NULL, episode_id INT NOT NULL, INDEX IDX_FF34AF53217BBB47 (person_id), INDEX IDX_FF34AF53362B62A0 (episode_id), PRIMARY KEY(person_id, episode_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17656A273CC FOREIGN KEY (origin_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17664D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE person_episode ADD CONSTRAINT FK_FF34AF53217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person_episode ADD CONSTRAINT FK_FF34AF53362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17656A273CC');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17664D218E');
        $this->addSql('ALTER TABLE person_episode DROP FOREIGN KEY FK_FF34AF53217BBB47');
        $this->addSql('ALTER TABLE person_episode DROP FOREIGN KEY FK_FF34AF53362B62A0');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE person_episode');
    }
}
