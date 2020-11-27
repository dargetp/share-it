<?php

namespace App\Controller;

use App\Database\Files;
use App\Database\FilesManager;
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
        FilesManager $filesManager)
    {
        
        $listFile = $request->getUploadedFiles();

        // Si le formulaire est envoyé
        if (isset($listFile['file'])) {
         /** @var UploadedFileInterface $file */
        $file = $listFile['file'];
        //var_dump($file);

        //recuperer le nouveau nom du fichier
        //$nouveauNom = $uploadService->saveFile($file); 
        $newFilename = $uploadService->saveFile($file);        
        
        //Enregistrer les infos du fichier en base de données
        
        //  $connection->insert('files', array('filename' => $nouveauNom, 'original_filename' => $file->getClientFilename()));
        
        $file = $filesManager->createFile($newFilename, $file->getClientFilename());
        var_dump($file); 
                
        // Redirection vers la page de succès
        
        return $this->redirect('success', ['id' => $file->getId()
        ]);
        
                
        } 
        

        return $this->template($response, 'home.html.twig');
    }

    //vérifier que l'identifiant (argument $id) correspond à un fichier existant
    //si ce n'est pas le cas, rediriger vers une route qui affichera un message d'erreur

   public function success(ResponseInterface $response, int $id, FilesManager $filesManager)
    {
        $files = $filesManager->getById($id);

        if ($files === null) {
            return $this->redirect('file-error');
        }
        return $this->template($response, 'success.html.twig', [
            'files' => $files
        ]);
        
    }

    public function fileError(ResponseInterface $response)
    {
        return $this->template($response, 'file_error.html.twig');
    }

  
   public function download(ResponseInterface $response, int $id)
   {
        $response->getBody()->write(sprintf('Identifiant:: %d', $id));
        return $response;
   }

   
   
   }
