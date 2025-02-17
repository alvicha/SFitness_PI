<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211202929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clases (id INT AUTO_INCREMENT NOT NULL, id_entrenador_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, fecha DATE NOT NULL, capacidad INT DEFAULT NULL, estado VARCHAR(255) NOT NULL, ubicacion VARCHAR(255) DEFAULT NULL, INDEX IDX_67CBBF10F1C1DDBE (id_entrenador_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clases_usuarios (clases_id INT NOT NULL, usuarios_id INT NOT NULL, INDEX IDX_58CBB07B158CCF68 (clases_id), INDEX IDX_58CBB07BF01D3B25 (usuarios_id), PRIMARY KEY(clases_id, usuarios_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notificaciones (id INT AUTO_INCREMENT NOT NULL, id_usuario_id INT DEFAULT NULL, titulo VARCHAR(255) NOT NULL, mensaje VARCHAR(255) NOT NULL, fecha_envio DATE NOT NULL, estado VARCHAR(255) NOT NULL, INDEX IDX_6FFCB217EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE progreso (id INT AUTO_INCREMENT NOT NULL, id_miembro_id INT DEFAULT NULL, fecha DATE NOT NULL, descripcion VARCHAR(255) NOT NULL, archivo VARCHAR(255) DEFAULT NULL, INDEX IDX_3600AE09DCD835ED (id_miembro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, telefono INT DEFAULT NULL, rol VARCHAR(255) NOT NULL, fecha_registro DATE NOT NULL, foto_perfil VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clases ADD CONSTRAINT FK_67CBBF10F1C1DDBE FOREIGN KEY (id_entrenador_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE clases_usuarios ADD CONSTRAINT FK_58CBB07B158CCF68 FOREIGN KEY (clases_id) REFERENCES clases (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clases_usuarios ADD CONSTRAINT FK_58CBB07BF01D3B25 FOREIGN KEY (usuarios_id) REFERENCES usuarios (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notificaciones ADD CONSTRAINT FK_6FFCB217EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES usuarios (id)');
        $this->addSql('ALTER TABLE progreso ADD CONSTRAINT FK_3600AE09DCD835ED FOREIGN KEY (id_miembro_id) REFERENCES usuarios (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clases DROP FOREIGN KEY FK_67CBBF10F1C1DDBE');
        $this->addSql('ALTER TABLE clases_usuarios DROP FOREIGN KEY FK_58CBB07B158CCF68');
        $this->addSql('ALTER TABLE clases_usuarios DROP FOREIGN KEY FK_58CBB07BF01D3B25');
        $this->addSql('ALTER TABLE notificaciones DROP FOREIGN KEY FK_6FFCB217EB2C349');
        $this->addSql('ALTER TABLE progreso DROP FOREIGN KEY FK_3600AE09DCD835ED');
        $this->addSql('DROP TABLE clases');
        $this->addSql('DROP TABLE clases_usuarios');
        $this->addSql('DROP TABLE notificaciones');
        $this->addSql('DROP TABLE progreso');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
