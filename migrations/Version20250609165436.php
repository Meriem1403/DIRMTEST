<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250609165436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, submission_id INT NOT NULL, value LONGTEXT DEFAULT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), INDEX IDX_DADD4A25E1FD4933 (submission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cerbere_habilitation (id INT AUTO_INCREMENT NOT NULL, tool_name VARCHAR(255) NOT NULL, application_code VARCHAR(255) NOT NULL, profile VARCHAR(255) NOT NULL, role_label VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, submission_id INT NOT NULL, file_name VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL, uploaded_at DATETIME NOT NULL, INDEX IDX_D8698A76E1FD4933 (submission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `log` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, submission_id INT DEFAULT NULL, action_type VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8F3F68C5A76ED395 (user_id), INDEX IDX_8F3F68C5E1FD4933 (submission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, recipient_id INT NOT NULL, submission_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, sent_at DATETIME NOT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_BF5476CAE92F8F78 (recipient_id), INDEX IDX_BF5476CAE1FD4933 (submission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, depends_on_question_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, required TINYINT(1) NOT NULL, order_index INT DEFAULT NULL, submission_type VARCHAR(255) NOT NULL, options JSON DEFAULT NULL, depends_on_value VARCHAR(255) DEFAULT NULL, INDEX IDX_B6F7494E530D515 (depends_on_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE requested_access (id INT AUTO_INCREMENT NOT NULL, cerbere_habilitation_id INT NOT NULL, submission_id INT NOT NULL, custom_profile VARCHAR(255) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_1D8FC8E894F75E87 (cerbere_habilitation_id), INDEX IDX_1D8FC8E8E1FD4933 (submission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, hierarchy JSON DEFAULT NULL, UNIQUE INDEX UNIQ_ROLE_NAME (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(50) NOT NULL, category VARCHAR(100) NOT NULL, location VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_E19D9AD277153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE submission (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, filled_by_id INT NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_DB055AF33414710B (agent_id), INDEX IDX_DB055AF390409A66 (filled_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT DEFAULT NULL, service_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone_number VARCHAR(20) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, zip_code VARCHAR(20) DEFAULT NULL, country VARCHAR(100) DEFAULT NULL, job_title VARCHAR(255) DEFAULT NULL, status VARCHAR(20) DEFAULT NULL, category VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_active TINYINT(1) DEFAULT 0 NOT NULL, is_verified TINYINT(1) DEFAULT 0 NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649D60322AC (role_id), INDEX IDX_8D93D649ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE validation_step (id INT AUTO_INCREMENT NOT NULL, validated_by_id INT DEFAULT NULL, submission_id INT NOT NULL, step_name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, validated_at DATETIME DEFAULT NULL, INDEX IDX_E868DE7BC69DE5E5 (validated_by_id), INDEX IDX_E868DE7BE1FD4933 (submission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25E1FD4933 FOREIGN KEY (submission_id) REFERENCES submission (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE document ADD CONSTRAINT FK_D8698A76E1FD4933 FOREIGN KEY (submission_id) REFERENCES submission (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `log` ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `log` ADD CONSTRAINT FK_8F3F68C5E1FD4933 FOREIGN KEY (submission_id) REFERENCES submission (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAE92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAE1FD4933 FOREIGN KEY (submission_id) REFERENCES submission (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question ADD CONSTRAINT FK_B6F7494E530D515 FOREIGN KEY (depends_on_question_id) REFERENCES question (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE requested_access ADD CONSTRAINT FK_1D8FC8E894F75E87 FOREIGN KEY (cerbere_habilitation_id) REFERENCES cerbere_habilitation (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE requested_access ADD CONSTRAINT FK_1D8FC8E8E1FD4933 FOREIGN KEY (submission_id) REFERENCES submission (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE submission ADD CONSTRAINT FK_DB055AF33414710B FOREIGN KEY (agent_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE submission ADD CONSTRAINT FK_DB055AF390409A66 FOREIGN KEY (filled_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE validation_step ADD CONSTRAINT FK_E868DE7BC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE validation_step ADD CONSTRAINT FK_E868DE7BE1FD4933 FOREIGN KEY (submission_id) REFERENCES submission (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25E1FD4933
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE document DROP FOREIGN KEY FK_D8698A76E1FD4933
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `log` DROP FOREIGN KEY FK_8F3F68C5A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `log` DROP FOREIGN KEY FK_8F3F68C5E1FD4933
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAE92F8F78
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAE1FD4933
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E530D515
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE requested_access DROP FOREIGN KEY FK_1D8FC8E894F75E87
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE requested_access DROP FOREIGN KEY FK_1D8FC8E8E1FD4933
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE submission DROP FOREIGN KEY FK_DB055AF33414710B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE submission DROP FOREIGN KEY FK_DB055AF390409A66
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649ED5CA9E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE validation_step DROP FOREIGN KEY FK_E868DE7BC69DE5E5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE validation_step DROP FOREIGN KEY FK_E868DE7BE1FD4933
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE answer
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cerbere_habilitation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE document
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `log`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE notification
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE requested_access
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE role
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE submission
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE validation_step
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
