<?php

namespace App\Controller;

use Doctrine\DBAL\DriverManager;
use App\File\UploadService;
use Doctrine\DBAL\Connection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;



class HomeController extends AbstractController
{
    public function homepage(
        ResponseInterface $response,
         ServerRequestInterface $request, 
         UploadService $uploadService,
         Connection $connection)
    {
        
        $listFile = $request->getUploadedFiles();

        // Si le formulaire est envoyé
        if (isset($listFile['file'])) {
         /** @var UploadedFileInterface $file */
        $file = $listFile['file'];
        var_dump($file);

        //recuperer le nouveau nom du fichier
        $nouveauNom = $uploadService->saveFile($file);

        // not injection de dépendance
        // il faut faire un conteneur de service
        // $service = new UploadService();
        // $filename = $service->saveFile($file);
        
        //Enregistrer les infos du fichier en base de données
        
        $connection->insert('files', array('filename' => $nouveauNom, 'original_filename' => $file->getClientFilename()));

        

        //Afficher un message à l'utilisateur    
        
        

        
        } 

        return $this->template($response, 'home.html.twig');
    }

  
   public function download(ResponseInterface $response, int $id)
   {
        $response->getBody()->write(sprintf('Identifiant:: %d', $id));
        return $response;
   }

   
   
   }
