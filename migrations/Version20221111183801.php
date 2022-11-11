<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221111183801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, species VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE character_episode (character_id INT NOT NULL, episode_id INT NOT NULL, INDEX IDX_B40F9CE71136BE75 (character_id), INDEX IDX_B40F9CE7362B62A0 (episode_id), PRIMARY KEY(character_id, episode_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, air_date VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, origin_character_id INT DEFAULT NULL, location_character_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, dimension VARCHAR(255) DEFAULT NULL, INDEX IDX_5E9E89CBDF5F8E0C (origin_character_id), INDEX IDX_5E9E89CB6091EE1B (location_character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE character_episode ADD CONSTRAINT FK_B40F9CE71136BE75 FOREIGN KEY (character_id) REFERENCES `character` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_episode ADD CONSTRAINT FK_B40F9CE7362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBDF5F8E0C FOREIGN KEY (origin_character_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB6091EE1B FOREIGN KEY (location_character_id) REFERENCES `character` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character_episode DROP FOREIGN KEY FK_B40F9CE71136BE75');
        $this->addSql('ALTER TABLE character_episode DROP FOREIGN KEY FK_B40F9CE7362B62A0');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBDF5F8E0C');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB6091EE1B');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE character_episode');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE location');
    }
}
