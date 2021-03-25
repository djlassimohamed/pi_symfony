<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210319115302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nutritionist_id INT DEFAULT NULL, coach_id INT DEFAULT NULL, duree INT NOT NULL, date_debut DATE NOT NULL, INDEX IDX_351268BBA76ED395 (user_id), INDEX IDX_351268BBBE035A4B (nutritionist_id), INDEX IDX_351268BB3C105691 (coach_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, channel VARCHAR(255) NOT NULL, discussion JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coach (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, speciality VARCHAR(255) NOT NULL, salary DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_3F596DCCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, user_id INT NOT NULL, date DATE NOT NULL, description VARCHAR(2000) NOT NULL, INDEX IDX_67F068BC4B89032C (post_id), INDEX IDX_67F068BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entrainement (id INT AUTO_INCREMENT NOT NULL, coach_id INT NOT NULL, titre VARCHAR(255) NOT NULL, jour VARCHAR(255) NOT NULL, heure INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_A27444E53C105691 (coach_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_user_nutrition (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, programmenutrition_id INT DEFAULT NULL, abonnement_id INT NOT NULL, nutritionist_id INT NOT NULL, ojectif VARCHAR(1000) NOT NULL, blessure VARCHAR(1000) NOT NULL, mangezpas VARCHAR(1000) NOT NULL, supplementali VARCHAR(1000) NOT NULL, probleme VARCHAR(1000) NOT NULL, age INT NOT NULL, taille INT NOT NULL, poids DOUBLE PRECISION NOT NULL, sexe VARCHAR(255) NOT NULL, INDEX IDX_4ED2AD91A76ED395 (user_id), UNIQUE INDEX UNIQ_4ED2AD913D5B5DEC (programmenutrition_id), INDEX IDX_4ED2AD91F1D74413 (abonnement_id), INDEX IDX_4ED2AD91BE035A4B (nutritionist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutritionist (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, diet VARCHAR(255) NOT NULL, salary DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_38AB5750A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutritionn (id INT AUTO_INCREMENT NOT NULL, nutritionist_id INT NOT NULL, description VARCHAR(255) NOT NULL, kcal INT NOT NULL, fats INT NOT NULL, salt INT NOT NULL, proteins INT NOT NULL, carbs INT NOT NULL, sugars INT NOT NULL, INDEX IDX_B205A238BE035A4B (nutritionist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_produit (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, user_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_D31F28A6F347EFB (produit_id), INDEX IDX_D31F28A6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, sujet VARCHAR(255) NOT NULL, description VARCHAR(5000) NOT NULL, date DATE NOT NULL, categorie VARCHAR(255) NOT NULL, INDEX IDX_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_users (post_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_839829064B89032C (post_id), INDEX IDX_8398290667B3B43D (users_id), PRIMARY KEY(post_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, prix INT NOT NULL, type VARCHAR(255) NOT NULL, labelle VARCHAR(255) NOT NULL, quantite INT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programmenutrition (id INT AUTO_INCREMENT NOT NULL, info_user_nutrition_id INT NOT NULL, user_id INT NOT NULL, nutritionist_id INT NOT NULL, repas1 VARCHAR(1000) NOT NULL, repas2 VARCHAR(1000) NOT NULL, repas3 VARCHAR(1000) NOT NULL, repas4 VARCHAR(255) NOT NULL, repas5 VARCHAR(1000) NOT NULL, duree INT NOT NULL, jourrepot VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E3B2DC74E9E466E5 (info_user_nutrition_id), INDEX IDX_E3B2DC74A76ED395 (user_id), INDEX IDX_E3B2DC74BE035A4B (nutritionist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT NULL, description VARCHAR(1000) NOT NULL, date DATE NOT NULL, INDEX IDX_CE606404A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, activation_token VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, datenaissance DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBBE035A4B FOREIGN KEY (nutritionist_id) REFERENCES nutritionist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BB3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coach ADD CONSTRAINT FK_3F596DCCA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrainement ADD CONSTRAINT FK_A27444E53C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user_nutrition ADD CONSTRAINT FK_4ED2AD91A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user_nutrition ADD CONSTRAINT FK_4ED2AD913D5B5DEC FOREIGN KEY (programmenutrition_id) REFERENCES programmenutrition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user_nutrition ADD CONSTRAINT FK_4ED2AD91F1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user_nutrition ADD CONSTRAINT FK_4ED2AD91BE035A4B FOREIGN KEY (nutritionist_id) REFERENCES nutritionist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nutritionist ADD CONSTRAINT FK_38AB5750A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nutritionn ADD CONSTRAINT FK_B205A238BE035A4B FOREIGN KEY (nutritionist_id) REFERENCES nutritionist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_produit ADD CONSTRAINT FK_D31F28A6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_produit ADD CONSTRAINT FK_D31F28A6A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_users ADD CONSTRAINT FK_839829064B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_users ADD CONSTRAINT FK_8398290667B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programmenutrition ADD CONSTRAINT FK_E3B2DC74E9E466E5 FOREIGN KEY (info_user_nutrition_id) REFERENCES info_user_nutrition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programmenutrition ADD CONSTRAINT FK_E3B2DC74A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programmenutrition ADD CONSTRAINT FK_E3B2DC74BE035A4B FOREIGN KEY (nutritionist_id) REFERENCES nutritionist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE info_user_nutrition DROP FOREIGN KEY FK_4ED2AD91F1D74413');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BB3C105691');
        $this->addSql('ALTER TABLE entrainement DROP FOREIGN KEY FK_A27444E53C105691');
        $this->addSql('ALTER TABLE programmenutrition DROP FOREIGN KEY FK_E3B2DC74E9E466E5');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBBE035A4B');
        $this->addSql('ALTER TABLE info_user_nutrition DROP FOREIGN KEY FK_4ED2AD91BE035A4B');
        $this->addSql('ALTER TABLE nutritionn DROP FOREIGN KEY FK_B205A238BE035A4B');
        $this->addSql('ALTER TABLE programmenutrition DROP FOREIGN KEY FK_E3B2DC74BE035A4B');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC4B89032C');
        $this->addSql('ALTER TABLE post_users DROP FOREIGN KEY FK_839829064B89032C');
        $this->addSql('ALTER TABLE panier_produit DROP FOREIGN KEY FK_D31F28A6F347EFB');
        $this->addSql('ALTER TABLE info_user_nutrition DROP FOREIGN KEY FK_4ED2AD913D5B5DEC');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBA76ED395');
        $this->addSql('ALTER TABLE coach DROP FOREIGN KEY FK_3F596DCCA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE info_user_nutrition DROP FOREIGN KEY FK_4ED2AD91A76ED395');
        $this->addSql('ALTER TABLE nutritionist DROP FOREIGN KEY FK_38AB5750A76ED395');
        $this->addSql('ALTER TABLE panier_produit DROP FOREIGN KEY FK_D31F28A6A76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE post_users DROP FOREIGN KEY FK_8398290667B3B43D');
        $this->addSql('ALTER TABLE programmenutrition DROP FOREIGN KEY FK_E3B2DC74A76ED395');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE entrainement');
        $this->addSql('DROP TABLE info_user_nutrition');
        $this->addSql('DROP TABLE nutritionist');
        $this->addSql('DROP TABLE nutritionn');
        $this->addSql('DROP TABLE panier_produit');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_users');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE programmenutrition');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE users');
    }
}
