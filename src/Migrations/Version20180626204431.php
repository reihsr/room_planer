<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180626204431 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room_default_reservation DROP FOREIGN KEY FK_1C95145D54177093');
        $this->addSql('ALTER TABLE room_default_reservation DROP FOREIGN KEY FK_1C95145DDEDCD6E4');
        $this->addSql('DROP INDEX IDX_1C95145D54177093 ON room_default_reservation');
        $this->addSql('DROP INDEX IDX_1C95145DDEDCD6E4 ON room_default_reservation');
        $this->addSql('ALTER TABLE room_default_reservation ADD user_id INT NOT NULL, DROP user_extension_id_id, CHANGE room_id room_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE room_default_reservation ADD user_extension_id_id INT DEFAULT NULL, DROP user_id, CHANGE room_id room_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room_default_reservation ADD CONSTRAINT FK_1C95145D54177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE room_default_reservation ADD CONSTRAINT FK_1C95145DDEDCD6E4 FOREIGN KEY (user_extension_id_id) REFERENCES user_extension (id)');
        $this->addSql('CREATE INDEX IDX_1C95145D54177093 ON room_default_reservation (room_id)');
        $this->addSql('CREATE INDEX IDX_1C95145DDEDCD6E4 ON room_default_reservation (user_extension_id_id)');
    }
}
