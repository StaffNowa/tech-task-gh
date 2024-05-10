<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240511123309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "INSERT INTO `certification` (`id`, `name`, `valid_from`, `valid_until`, `expired`) VALUES
(1, 'Aircraft Marshaller Certification', '2024-05-10', '2024-05-17', NULL),
(2, 'Baggage Handling Safety Certification', '2024-05-10', '2024-05-17', NULL),
(3, 'Aircraft Refueler Certification', '2024-05-10', '2024-05-17', NULL),
(4, 'Aircraft Cleaning and Sanitization Certification', '2024-05-10', '2024-05-17', NULL),
(5, 'Ground Support Equipment (GSE) Operator Certification', '2024-05-10', '2024-05-17', NULL);"
        );

        $this->addSql(
            "INSERT INTO `flight` (`id`, `flight_number`, `flight_date`) VALUES
(1, 'BT341', '2024-05-11'),
(2, 'TK1407', '2024-05-11'),
(3, 'FR543', '2024-05-11');"
        );

        $this->addSql(
            "INSERT INTO `ground_crew_member` (`id`, `name`) VALUES
(1, 'Sarah Johnson'),
(2, 'David Martinez'),
(3, 'Emily Lee'),
(4, 'Michael Brown'),
(5, 'Alex Nguyen');"
        );

        $this->addSql(
            "INSERT INTO `ground_crew_member_certification` (`ground_crew_member_id`, `certification_id`) VALUES
(1, 4),
(2, 2),
(3, 3),
(4, 4),
(5, 5);"
        );

        $this->addSql(
            "INSERT INTO `skill` (`id`, `name`) VALUES
(1, 'Communication skills'),
(2, 'Spatial awareness'),
(3, 'Attention to details'),
(4, 'Physical strength and stamina'),
(5, 'Organization skills'),
(6, 'Technical knowledge'),
(7, 'Attention to safety'),
(8, 'Time management'),
(9, 'Operating equipment'),
(10, 'Coordination');"
        );

        $this->addSql(
            "INSERT INTO `ground_crew_member_skill` (`ground_crew_member_id`, `skill_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7),
(4, 3),
(4, 8),
(5, 9),
(5, 10);"
        );

        $this->addSql(
            "INSERT INTO `flight_ground_crew_member` (`flight_id`, `ground_crew_member_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5);"
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
