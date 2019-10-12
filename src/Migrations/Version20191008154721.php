<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191008154721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9474526CB281BE2E (trick_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, trick_id INT NOT NULL, url LONGTEXT NOT NULL, une TINYINT(1) NOT NULL, INDEX IDX_C53D045FB281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, url LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_14B78418A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trick (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_D8F0A91E12469DE2 (category_id), INDEX IDX_D8F0A91EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, sign_up_at DATETIME NOT NULL, reset_query_at DATETIME DEFAULT NULL, validated TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, trick_id INT DEFAULT NULL, url LONGTEXT NOT NULL, INDEX IDX_7CC7DA2CB281BE2E (trick_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('INSERT INTO `category` (`id`, `title`) VALUES
            (1, \'Grabs\'),
            (2, \'Rotations\'),
            (3, \'Flips\'),
            (4, \'Rotations désaxées\'),
            (5, \'Slides\'),
            (6, \'One foot tricks\')');
        $this->addSql('INSERT INTO `trick` (`id`, `title`, `description`, `created_at`, `updated_at`, `category_id`) VALUES
            (3, \'Mute\', \'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant.\', \'2019-09-24 00:00:00\', NULL, 1),
            (4, \'Sad/Melancholie/Style-Week\', \'saisie de la carre backside de la planche, entre les deux pieds, avec la main avant \', \'2019-09-24 00:00:00\', NULL, 1),
            (5, \'Indy\', \'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière\', \'2019-09-24 00:00:00\', NULL, 1),
            (6, \'Stalefish\', \'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière \', \'2019-09-24 00:00:00\', NULL, 1),
            (7, \'Tail Grab\', \'Saisie de la partie arrière de la planche, avec la main arrière\', \'2019-09-24 00:00:00\', NULL, 1),
            (8, \'Nose Grab\', \'Saisie de la partie avant de la planche, avec la main avant\', \'2019-09-24 00:00:00\', NULL, 1),
            (9, \'Japan Air\', \'Saisie de l avant de la planche, avec la main avant, du côté de la carre frontside . \', \'2019-09-24 00:00:00\', NULL, 1),
            (10, \'Seat Belt\', \'Saisie du carre frontside à l arrière avec la main avant . \', \'2019-09-24 00:00:00\', NULL, 1),
            (11, \'Truck Driver\', \'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)\', \'2019-09-24 00:00:00\', NULL, 1),
            (12, \'Rotations\', \'- un 180 désigne un demi-tour, soit 180 degrés d angle;\r\n - 360, trois six pour un tour complet;\r\n - 540, cinq quatre pour un tour et demi;\r\n - 720, sept deux pour deux tours complets;\r\n - 900 pour deux tours et demi;\r\n - 1080 ou big foot pour trois tours;\r\netc . \', \'2019-09-24 00:00:00\', NULL, 2),
            (13, \'Front Flip\', \'Rotation en avant\', \'2019-09-24 00:00:00\', NULL, 3),
            (14, \'Back Flip\', \'Rotations en arrière\', \'2019-09-24 00:00:00\', NULL, 3),
            (15, \'Corkscrew/Cork\', \'Une rotation désaxée est une rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la rotation.\', \'2019-09-24 00:00:00\', NULL, 4),
            (16, \'Rodeo\', \'Certaines de ces rotations, bien qu initialement horizontales, font passer la tête en bas . \', \'2019-09-24 00:00:00\', NULL, 4),
            (17, \'Misty\', \'Bien que certaines de ces rotations soient plus faciles à faire sur un certain nombre de tours (ou de demi-tours) que d autres, il est en théorie possible de d attérir n importe quelle rotation désaxée avec n importe quel nombre de tours, en jouant sur la quantité de désaxage afin de se retrouver à la position verticale au moment voulu.\', \'2019-09-24 00:00:00\', NULL, 4),
            (18, \'Nose Slide\', \'L avant de la planche sur la barre\', \'2019-09-24 00:00:00\', NULL, 5),
            (19, \'Tail Slide\', \'L arrière de la planche sur la barre\', \'2019-09-24 00:00:00\', NULL, 5),
            (20, \'Test\', \'Ceci est un test\', \'2014-01-01 00:00:00\', NULL, 3),
            (24, \'Test1\', \'Ceci est un test\', \'2014-01-01 00:00:00\', NULL, 2)');
        $this->addSql('INSERT INTO `image` (`id`, `trick_id`, `url`, `une`) VALUES
            (2, 3, \'img/tricks/mute1.jpg\', 1),
            (3, 3, \'img/tricks/mute2.jpg\', 0),
            (4, 4, \'img/tricks/sad1.jpg\', 1),
            (5, 4, \'img/tricks/sad2.jpg\', 0),
            (6, 5, \'img/tricks/indy.jpg\', 1),
            (7, 6, \'img/tricks/stalefish1.jpg\', 1),
            (8, 6, \'img/tricks/stalefish2.jpg\', 0),
            (9, 7, \'img/tricks/tailgrab1.jpg\', 1),
            (10, 7, \'img/tricks/tailgrab2.jpg\', 0),
            (11, 8, \'img/tricks/nosegrab1.jpg\', 1),
            (12, 8, \'img/tricks/nosegrab2.jpg\', 0),
            (13, 9, \'img/tricks/japanair1.jpg\', 1),
            (14, 9, \'img/tricks/japanair2.jpeg\', 0),
            (15, 10, \'img/tricks/seatbelt1.jpg\', 1),
            (16, 10, \'img/tricks/seatbelt2.jpg\', 0),
            (17, 11, \'img/tricks/truckdriver1.jpg\', 1),
            (18, 11, \'img/tricks/truckdriver2.jpg\', 0),
            (19, 12, \'img/tricks/rotations.jpg\', 1),
            (20, 13, \'img/tricks/frontflip.jpg\', 1),
            (21, 14, \'img/tricks/backflip.jpg\', 1),
            (22, 15, \'img/tricks/cork.jpg\', 1),
            (23, 16, \'img/tricks/rodeo.jpg\', 1),
            (24, 17, \'img/tricks/misty.jpg\', 1),
            (25, 18, \'img/tricks/noseslide.jpg\', 1),
            (26, 19, \'img/tricks/tailslide.jpg\', 1),
            (40, 20, \'img/tricks/test1.png\', 0),
            (44, 24, \'img/tricks/default.jpg\', 0)');
        $this->addSql('INSERT INTO `video` (`id`, `trick_id`, `url`) VALUES
            (2, 3, \'https://www.youtube.com/embed/M5NTCfdObfs\'),
            (3, 20, \'https://www.youtube.com/embed/M5NTCfdObfs\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E12469DE2');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB281BE2E');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FB281BE2E');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CB281BE2E');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418A76ED395');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE trick');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
    }
}
