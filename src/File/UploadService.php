<?php

//src/File/UploadService.php
namespace App\File;

use Psr\Http\Message\UploadedFileInterface;

/**
 * Service en charge de l'enregistrement de fichiers
 */
class UploadService
{
    /** @var string chemin vers le dossier ou enregistrer les fichiers */
    public const FILES_DIR = __DIR__ . '/../../files';

    /**
     * Enregistrer un fichier
     * 
     *  @param UploadedFileInterface $file le fichier chargé à enregistrer
     *  @return string le nouveau nom du fichier 
     */
    public function saveFile(UploadedFileInterface $file): string
    {
        //generer un nom de fichier unique :
        //horodatage + chaine de caractère aléatoires + extension
        
        $filename = $this->generateFilename($file);

        
        //construire le chemin de destination du fichier
        //chemin vers le dossier /files/ + nouveau nom de fichier
        $path = self::FILES_DIR . '/' . $filename;

               
        //déplacer le fichier
        $file->moveTo($path);
        return $filename;

    }

    /**
     * Générer un nom de fichier aléatoire et unique
     * 
     *  @param UploadedFileInterface $file le fichier à enregistrer
     *  @return string le nom unique généré
     */

    private function generateFilename(UploadedFileInterface $file): string
    {
        /**
         *  Ecrire le code de generateFilename()
         *  Utiliser la méthode generateFilename() dans la méthode saveFile()
         * Ajouter un argument UploadService dans le HomeController et utiliser saveFile()
         */

        $filename = date('YmdHis');
        $filename .= bin2hex(random_bytes(8));
        $filename .= '.' . pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
        return $filename;
    }
}

 