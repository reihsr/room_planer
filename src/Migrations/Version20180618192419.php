<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180618192419 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room_default_reservation DROP FOREIGN KEY FK_1C95145DA76ED395');
        $this->addSql('DROP INDEX IDX_1C95145DA76ED395 ON room_default_reservation');
        $this->addSql('ALTER TABLE room_default_reservation CHANGE user_id user_extension_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room_default_reservation ADD CONSTRAINT FK_1C95145DDEDCD6E4 FOREIGN KEY (user_extension_id_id) REFERENCES user_extension (id)');
        $this->addSql('CREATE INDEX IDX_1C95145DDEDCD6E4 ON room_default_reservation (user_extension_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room_default_reservation DROP FOREIGN KEY FK_1C95145DDEDCD6E4');
        $this->addSql('DROP INDEX IDX_1C95145DDEDCD6E4 ON room_default_reservation');
        $this->addSql('ALTER TABLE room_default_reservation CHANGE user_extension_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room_default_reservation ADD CONSTRAINT FK_1C95145DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1C95145DA76ED395 ON room_default_reservation (user_id)');
    }
}
