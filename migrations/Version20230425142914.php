<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425142914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, type INT NOT NULL, ordre INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ecoles (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emailsubscription (id INT AUTO_INCREMENT NOT NULL, id_membre INT DEFAULT NULL, actif TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, type INT DEFAULT NULL, date_add DATE NOT NULL, UNIQUE INDEX UNIQ_EBBBAA9AD0834EC4 (id_membre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonctions (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, titre VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_AED700EFBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_offres (id INT AUTO_INCREMENT NOT NULL, membres_id INT DEFAULT NULL, categories_id INT DEFAULT NULL, fonctions_id INT DEFAULT NULL, departements_id INT DEFAULT NULL, villes_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, langue_offres VARCHAR(255) NOT NULL, nombre_stagiaire INT NOT NULL, date_debut_stage DATE NOT NULL, date_fin_stage DATE NOT NULL, date_inscri DATE NOT NULL, type_contrat VARCHAR(255) NOT NULL, remuneration VARCHAR(255) NOT NULL, description_offres LONGTEXT NOT NULL, niveau_etude VARCHAR(255) NOT NULL, formations_requises VARCHAR(255) NOT NULL, permis TINYINT(1) NOT NULL, competences LONGTEXT NOT NULL, langue_parlee LONGTEXT NOT NULL, actif TINYINT(1) NOT NULL, a_la_une TINYINT(1) NOT NULL, date_depo DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_F7DD407F71128C5C (membres_id), INDEX IDX_F7DD407FA21214B7 (categories_id), INDEX IDX_F7DD407FDC481574 (fonctions_id), INDEX IDX_F7DD407F1DB279A6 (departements_id), INDEX IDX_F7DD407F286C17BC (villes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membres (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, fonction_id INT DEFAULT NULL, departement_id INT NOT NULL, ville_id INT NOT NULL, type INT NOT NULL, civilite INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, autre_fonction VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) NOT NULL, fax VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, siren_entreprise VARCHAR(255) DEFAULT NULL, siret_entreprise VARCHAR(255) DEFAULT NULL, raison_social VARCHAR(255) DEFAULT NULL, effectifs_entreprise INT DEFAULT NULL, chiffre_affaire DOUBLE PRECISION DEFAULT NULL, adresse VARCHAR(255) NOT NULL, site_web VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, date_naissance DATE DEFAULT NULL, nationalite VARCHAR(255) DEFAULT NULL, tel_principal VARCHAR(255) DEFAULT NULL, tel_secondaire VARCHAR(255) DEFAULT NULL, complement_adresse VARCHAR(255) DEFAULT NULL, permis TINYINT(1) NOT NULL, code_postal VARCHAR(255) NOT NULL, programme_ecole LONGTEXT DEFAULT NULL, inscrit_nl TINYINT(1) NOT NULL, date_add DATE DEFAULT NULL, INDEX IDX_594AE39C12469DE2 (category_id), INDEX IDX_594AE39C57889920 (fonction_id), INDEX IDX_594AE39CCCF9E01E (departement_id), INDEX IDX_594AE39CA73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE navigation (id INT AUTO_INCREMENT NOT NULL, actif TINYINT(1) NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE navigation_liste (id INT AUTO_INCREMENT NOT NULL, navigation_id INT DEFAULT NULL, actif TINYINT(1) NOT NULL, titre VARCHAR(255) NOT NULL, type_de_page VARCHAR(255) NOT NULL, target VARCHAR(255) NOT NULL, no_follow TINYINT(1) NOT NULL, INDEX IDX_42CEBA3139F79D6D (navigation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE villes (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, titre VARCHAR(255) NOT NULL, INDEX IDX_19209FD8CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emailsubscription ADD CONSTRAINT FK_EBBBAA9AD0834EC4 FOREIGN KEY (id_membre) REFERENCES membres (id)');
        $this->addSql('ALTER TABLE fonctions ADD CONSTRAINT FK_AED700EFBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE liste_offres ADD CONSTRAINT FK_F7DD407F71128C5C FOREIGN KEY (membres_id) REFERENCES membres (id)');
        $this->addSql('ALTER TABLE liste_offres ADD CONSTRAINT FK_F7DD407FA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE liste_offres ADD CONSTRAINT FK_F7DD407FDC481574 FOREIGN KEY (fonctions_id) REFERENCES fonctions (id)');
        $this->addSql('ALTER TABLE liste_offres ADD CONSTRAINT FK_F7DD407F1DB279A6 FOREIGN KEY (departements_id) REFERENCES departements (id)');
        $this->addSql('ALTER TABLE liste_offres ADD CONSTRAINT FK_F7DD407F286C17BC FOREIGN KEY (villes_id) REFERENCES villes (id)');
        $this->addSql('ALTER TABLE membres ADD CONSTRAINT FK_594AE39C12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE membres ADD CONSTRAINT FK_594AE39C57889920 FOREIGN KEY (fonction_id) REFERENCES fonctions (id)');
        $this->addSql('ALTER TABLE membres ADD CONSTRAINT FK_594AE39CCCF9E01E FOREIGN KEY (departement_id) REFERENCES departements (id)');
        $this->addSql('ALTER TABLE membres ADD CONSTRAINT FK_594AE39CA73F0036 FOREIGN KEY (ville_id) REFERENCES villes (id)');
        $this->addSql('ALTER TABLE navigation_liste ADD CONSTRAINT FK_42CEBA3139F79D6D FOREIGN KEY (navigation_id) REFERENCES navigation (id)');
        $this->addSql('ALTER TABLE villes ADD CONSTRAINT FK_19209FD8CCF9E01E FOREIGN KEY (departement_id) REFERENCES departements (id)');
        $this->addSql('ALTER TABLE admin CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emailsubscription DROP FOREIGN KEY FK_EBBBAA9AD0834EC4');
        $this->addSql('ALTER TABLE fonctions DROP FOREIGN KEY FK_AED700EFBCF5E72D');
        $this->addSql('ALTER TABLE liste_offres DROP FOREIGN KEY FK_F7DD407F71128C5C');
        $this->addSql('ALTER TABLE liste_offres DROP FOREIGN KEY FK_F7DD407FA21214B7');
        $this->addSql('ALTER TABLE liste_offres DROP FOREIGN KEY FK_F7DD407FDC481574');
        $this->addSql('ALTER TABLE liste_offres DROP FOREIGN KEY FK_F7DD407F1DB279A6');
        $this->addSql('ALTER TABLE liste_offres DROP FOREIGN KEY FK_F7DD407F286C17BC');
        $this->addSql('ALTER TABLE membres DROP FOREIGN KEY FK_594AE39C12469DE2');
        $this->addSql('ALTER TABLE membres DROP FOREIGN KEY FK_594AE39C57889920');
        $this->addSql('ALTER TABLE membres DROP FOREIGN KEY FK_594AE39CCCF9E01E');
        $this->addSql('ALTER TABLE membres DROP FOREIGN KEY FK_594AE39CA73F0036');
        $this->addSql('ALTER TABLE navigation_liste DROP FOREIGN KEY FK_42CEBA3139F79D6D');
        $this->addSql('ALTER TABLE villes DROP FOREIGN KEY FK_19209FD8CCF9E01E');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE ecoles');
        $this->addSql('DROP TABLE emailsubscription');
        $this->addSql('DROP TABLE fonctions');
        $this->addSql('DROP TABLE liste_offres');
        $this->addSql('DROP TABLE membres');
        $this->addSql('DROP TABLE navigation');
        $this->addSql('DROP TABLE navigation_liste');
        $this->addSql('DROP TABLE villes');
        $this->addSql('ALTER TABLE admin CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
