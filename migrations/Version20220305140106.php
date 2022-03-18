<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305140106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blood_group (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(4) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, name VARCHAR(255) NOT NULL, extension VARCHAR(10) NOT NULL, upload_at DATETIME NOT NULL, INDEX IDX_D8698A766B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drug (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gender (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE individual_visit (id INT NOT NULL, patient_id INT NOT NULL, tour_visit_id INT DEFAULT NULL, date DATE NOT NULL, subject VARCHAR(255) NOT NULL, INDEX IDX_11DEC9956B899279 (patient_id), INDEX IDX_11DEC995EF0556C1 (tour_visit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, gender_id INT NOT NULL, blood_group_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, social_number VARCHAR(15) NOT NULL, notes LONGTEXT DEFAULT NULL, height INT NOT NULL, weight INT NOT NULL, allergies VARCHAR(255) DEFAULT NULL, INDEX IDX_1ADAD7EB708A0E0 (gender_id), INDEX IDX_1ADAD7EB5F3AECE2 (blood_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE period (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `repeat` (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour_visit (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment (id INT AUTO_INCREMENT NOT NULL, duration_id INT NOT NULL, INDEX IDX_98013C3137B987D8 (duration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment_drug (treatment_id INT NOT NULL, drug_id INT NOT NULL, INDEX IDX_8028B62F471C0366 (treatment_id), INDEX IDX_8028B62FAABCA765 (drug_id), PRIMARY KEY(treatment_id, drug_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment_repeat (treatment_id INT NOT NULL, repeat_id INT NOT NULL, INDEX IDX_695CDD88471C0366 (treatment_id), INDEX IDX_695CDD88CD096AF4 (repeat_id), PRIMARY KEY(treatment_id, repeat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, start_time TIME NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A766B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE individual_visit ADD CONSTRAINT FK_11DEC9956B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE individual_visit ADD CONSTRAINT FK_11DEC995EF0556C1 FOREIGN KEY (tour_visit_id) REFERENCES tour_visit (id)');
        $this->addSql('ALTER TABLE individual_visit ADD CONSTRAINT FK_11DEC995BF396750 FOREIGN KEY (id) REFERENCES visit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB5F3AECE2 FOREIGN KEY (blood_group_id) REFERENCES blood_group (id)');
        $this->addSql('ALTER TABLE tour_visit ADD CONSTRAINT FK_7831F911BF396750 FOREIGN KEY (id) REFERENCES visit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C3137B987D8 FOREIGN KEY (duration_id) REFERENCES period (id)');
        $this->addSql('ALTER TABLE treatment_drug ADD CONSTRAINT FK_8028B62F471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE treatment_drug ADD CONSTRAINT FK_8028B62FAABCA765 FOREIGN KEY (drug_id) REFERENCES drug (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE treatment_repeat ADD CONSTRAINT FK_695CDD88471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE treatment_repeat ADD CONSTRAINT FK_695CDD88CD096AF4 FOREIGN KEY (repeat_id) REFERENCES `repeat` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB5F3AECE2');
        $this->addSql('ALTER TABLE treatment_drug DROP FOREIGN KEY FK_8028B62FAABCA765');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB708A0E0');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A766B899279');
        $this->addSql('ALTER TABLE individual_visit DROP FOREIGN KEY FK_11DEC9956B899279');
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C3137B987D8');
        $this->addSql('ALTER TABLE treatment_repeat DROP FOREIGN KEY FK_695CDD88CD096AF4');
        $this->addSql('ALTER TABLE individual_visit DROP FOREIGN KEY FK_11DEC995EF0556C1');
        $this->addSql('ALTER TABLE treatment_drug DROP FOREIGN KEY FK_8028B62F471C0366');
        $this->addSql('ALTER TABLE treatment_repeat DROP FOREIGN KEY FK_695CDD88471C0366');
        $this->addSql('ALTER TABLE individual_visit DROP FOREIGN KEY FK_11DEC995BF396750');
        $this->addSql('ALTER TABLE tour_visit DROP FOREIGN KEY FK_7831F911BF396750');
        $this->addSql('DROP TABLE blood_group');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE drug');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE individual_visit');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP TABLE `repeat`');
        $this->addSql('DROP TABLE tour_visit');
        $this->addSql('DROP TABLE treatment');
        $this->addSql('DROP TABLE treatment_drug');
        $this->addSql('DROP TABLE treatment_repeat');
        $this->addSql('DROP TABLE visit');
    }
}
