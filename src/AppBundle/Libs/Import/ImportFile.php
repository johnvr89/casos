<?php

namespace AppBundle\Libs\Import;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use UCI\Boson\ExcepcionesBundle\Exception\LocalException;

/**
 * Description of ImportCSV
 *
 * @author rene
 */
class ImportFile {

    private $routeKernel;
    private $allowMimeType;

    public function __construct($routeKernel) {
        $this->routeKernel = $routeKernel;

        $this->allowMimeType = array(
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg');
    }

    private function getDirectoryToImport($trace) {
        if ($trace) {
            return $this->routeKernel . '/../web/bundles/app/docs/';
        }
        return $this->routeKernel . '/../web/bundles/app/images/';
    }

    /**
     * Mueve el fichero del objeto request al directorio predeterminado
     * retorna una array con la ruta final del fichero y el nombre
     */
    public function moveFile(Request $request, $required = true, $trace = false) {
        try {
            $response = array('success' => true, 'convert' => '', 'originalName');
            if ($required) {
                $files = $request->files->all();
                $path = $this->getDirectoryToImport($trace);
                if (count($files) == 0) {
                    return array('success' => false, 'error' => 'No se encontraron ficheros a importar.');
                }
                $file = $files['import'];

                if (!$file->isValid()) {
                    return array('success' => false, 'error' => 'El fichero no es v&aacute;lido.');
                }
                /*
                if (!in_array($mimetype, $this->allowMimeType)) {
                    return array('success' => false, 'error' => 'Tipo de fichero no permitido.');
                }*/
                $extension = $file->getClientOriginalExtension();
                $fileName = uniqid() . '.' . $extension;

                $endPath = "$path/$fileName";
                $file->move($path, $fileName);
                $response = array('success' => true, 'convert' => $fileName, 'originalName' => $file->getClientOriginalName() );
            }
            return $response;
        } catch (\Exception $e) {
            // return array('success' => false, 'error' => 'Ocurri&oacute; un error al subir el fichero.');
            return array('success' => false, 'error' => $e->getMessage());
        }
    }

    private function imageToBase64($addressFile, $mimetype) {
        $data = file_get_contents($addressFile);
        $base64 = "data:$mimetype" . ';base64,' . base64_encode($data);
        return $base64;
    }

}
