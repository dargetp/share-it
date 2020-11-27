<?php

namespace App\Database;

use Doctrine\DBAL\Connection;

/**
 * Ce service est en charge de la gestion des données de la table "files"
 * Elle doit utiliser des objets de la classe Files
 */

 class FilesManager
 {
     private Connection $connection;

     /**
     * Les objets FichierManager pourront être demandés en argument dans les controlleurs
     * Pour les instancier, le conteneur de services va lire la liste d'arguments du constructeur
     * Ici, il va d'abord instancier le service Connection pour pouvoir instancier FichierManager
     */

     public function __construct(Connection $connection)
     {
         $this->connection = $connection;         
     }

     /**
      * Recuperer 1 Fichier par son id
      *
      * @param int $id l'identifiant en base de fichier
      * @return Fichier|null le fichier trouvé ou null en l'absence de *résultat
      */
      public function getById(int $id): ?Files
      {
        $query = $this->connection->prepare('SELECT * FROM files WHERE id = :id');
        $query->bindValue('id', $id);
        $result = $query->execute();

        //Tableau associatif contenant les données du fichier, ou false si aucun résultat
        $filesData = $result->fetchAssociative();

        if ($filesData === false) {
            return null;
        }

        return $this->createObject($filesData['id'], $filesData['filename'], $filesData['original_filename']);
        
      }

      /**
       * Enregistrer un nouveau fichier en base de données
       */
      public function createFile(string $filename, string $originalfilename): files
      {
          //Enregistrer en base de données (voir HomeController:homepage() )        
          
        $this->connection->insert('files', array('filename' => $filename, 'original_filename' => $originalfilename));

        //Récupérer l'identifiant généré du fichier enregistré

        $id = $this->connection->lastInsertId();

        //créer un objet fichier et le retourner: créer un méthode createObject()
        return $this->createObject($id, $filename, $originalfilename);              
        }

        /**
         * Créer un objet Fichier à partir de ses informations
         */
        private function createObject(int $id, string $filename, string $originalfilename): files
        {            
            $files = new Files();
            $files
                ->setId($id)
                ->setFilename($filename)
                ->setOriginalFilename($originalfilename)
            ;
        return $files;
        }
    
      
 }