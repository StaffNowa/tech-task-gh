<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240511123206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, valid_from DATE NOT NULL, valid_until DATE NOT NULL, expired TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flight (id INT AUTO_INCREMENT NOT NULL, flight_number VARCHAR(10) NOT NULL, flight_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flight_ground_crew_member (flight_id INT NOT NULL, ground_crew_member_id INT NOT NULL, INDEX IDX_E774349391F478C5 (flight_id), INDEX IDX_E7743493D89A93E4 (ground_crew_member_id), PRIMARY KEY(flight_id, ground_crew_member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ground_crew_member (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ground_crew_member_skill (ground_crew_member_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_A3656437D89A93E4 (ground_crew_member_id), INDEX IDX_A36564375585C142 (skill_id), PRIMARY KEY(ground_crew_member_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ground_crew_member_certification (ground_crew_member_id INT NOT NULL, certification_id INT NOT NULL, INDEX IDX_9DCE5B1CD89A93E4 (ground_crew_member_id), INDEX IDX_9DCE5B1CCB47068A (certification_id), PRIMARY KEY(ground_crew_member_id, certification_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, flight_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_527EDB2591F478C5 (flight_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE flight_ground_crew_member ADD CONSTRAINT FK_E774349391F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flight_ground_crew_member ADD CONSTRAINT FK_E7743493D89A93E4 FOREIGN KEY (ground_crew_member_id) REFERENCES ground_crew_member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ground_crew_member_skill ADD CONSTRAINT FK_A3656437D89A93E4 FOREIGN KEY (ground_crew_member_id) REFERENCES ground_crew_member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ground_crew_member_skill ADD CONSTRAINT FK_A36564375585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ground_crew_member_certification ADD CONSTRAINT FK_9DCE5B1CD89A93E4 FOREIGN KEY (ground_crew_member_id) REFERENCES ground_crew_member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ground_crew_member_certification ADD CONSTRAINT FK_9DCE5B1CCB47068A FOREIGN KEY (certification_id) REFERENCES certification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2591F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flight_ground_crew_member DROP FOREIGN KEY FK_E774349391F478C5');
        $this->addSql('ALTER TABLE flight_ground_crew_member DROP FOREIGN KEY FK_E7743493D89A93E4');
        $this->addSql('ALTER TABLE ground_crew_member_skill DROP FOREIGN KEY FK_A3656437D89A93E4');
        $this->addSql('ALTER TABLE ground_crew_member_skill DROP FOREIGN KEY FK_A36564375585C142');
        $this->addSql('ALTER TABLE ground_crew_member_certification DROP FOREIGN KEY FK_9DCE5B1CD89A93E4');
        $this->addSql('ALTER TABLE ground_crew_member_certification DROP FOREIGN KEY FK_9DCE5B1CCB47068A');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2591F478C5');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE flight_ground_crew_member');
        $this->addSql('DROP TABLE ground_crew_member');
        $this->addSql('DROP TABLE ground_crew_member_skill');
        $this->addSql('DROP TABLE ground_crew_member_certification');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE task');
    }
}
