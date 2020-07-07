<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200707143302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delegation ADD from_member_id INT DEFAULT NULL, ADD to_member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delegation ADD CONSTRAINT FK_292F436D650B4644 FOREIGN KEY (from_member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE delegation ADD CONSTRAINT FK_292F436D4434048F FOREIGN KEY (to_member_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_292F436D650B4644 ON delegation (from_member_id)');
        $this->addSql('CREATE INDEX IDX_292F436D4434048F ON delegation (to_member_id)');
        $this->addSql('ALTER TABLE document ADD member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A767597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('CREATE INDEX IDX_D8698A767597D3FE ON document (member_id)');
        $this->addSql('ALTER TABLE online_form ADD member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE online_form ADD CONSTRAINT FK_5849FDE97597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5849FDE97597D3FE ON online_form (member_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delegation DROP FOREIGN KEY FK_292F436D650B4644');
        $this->addSql('ALTER TABLE delegation DROP FOREIGN KEY FK_292F436D4434048F');
        $this->addSql('DROP INDEX IDX_292F436D650B4644 ON delegation');
        $this->addSql('DROP INDEX IDX_292F436D4434048F ON delegation');
        $this->addSql('ALTER TABLE delegation DROP from_member_id, DROP to_member_id');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A767597D3FE');
        $this->addSql('DROP INDEX IDX_D8698A767597D3FE ON document');
        $this->addSql('ALTER TABLE document DROP member_id');
        $this->addSql('ALTER TABLE online_form DROP FOREIGN KEY FK_5849FDE97597D3FE');
        $this->addSql('DROP INDEX UNIQ_5849FDE97597D3FE ON online_form');
        $this->addSql('ALTER TABLE online_form DROP member_id');
    }
}
