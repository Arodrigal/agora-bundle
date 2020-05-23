# Sharepoint Bundle

 Bundle para el manejo de sharepoint a través de su api.
 
 Instalación
 ============
 
 Step 1: Descarga el bundle
 ---------------------------
 
 Incluye el repositorio en tu fichero composer.json
 
 ```
 "repositories": [
     {
       "type": "vcs",
       "url": "https://gitlab.laliga.es/laliga-developers/sharepoint-bundle.git"
     }
   ]
 ```
Step 2: Activa el Bundle
-------------------------

Incluye el bundle en tu fichero `app/AppKernel.php` de tu proyecto

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

    	    new ThirdParts\AgoraBundle\LaligaSharepointBundle(),
        );

        // ...
    }

}
 ```
 Step 3: Configurar Parámetros
 -------------------------
   ```yml
SHAREPOINT_CONTAINER_ID=[VALOR DEL ID DEL CONTENEDOR DE SHAREPOINT]
AZURE_CLIENT_ID=[VALOR DEL ID DEL CLIENT DE AZURE]
AZURE_CLIENT_SECRET=[VALOR DEL SECRET DE AZURE]
```
 Step 4: Uso
 -------------------------    

Puedes importar el servicio:
```yml
    ThirdParts\AgoraBundle\Service\Api\SharepointApi:
        alias: laliga.sharepoint.api
 ```

####Metodos que proporciona el bundle:

- Obtiene el binario de un documento pasando el id del documento en sharepoint.
```php
    public function getDocumentContent(string $sharepointDocumentId): SharepointApiResponseInterface;
```
- Listar el contenido de una carpeta pasando el id de la carpeta de sharepont.
```php
    public function listFiles(string $sharepointFolderId): SharepointApiResponseInterface;
```
- Crea carpetas pasando una estructura concreta tipo carpeta1/carpeta2/carpeta3/carpetaN lo hace desde la raiz del contenedor de sharepoint.
```php
    public function createFolder(string $path): SharepointApiResponseInterface;
```
- Obtener los thumbnails de un documento pasando el id del documento. Devuelve un objeto con los thumbnail Large, Medium y Small
```php
    public function getThumbnail(string $sharepointDocumentId): SharepointApiResponseInterface;
```
- Borrar un documento pasando el id del documento en sharepoint.
```php
    public function deleteDocument(string $sharepointDocumentId): SharepointApiResponseInterface;
```
- Subir un documento pasando el id de la carpeta, el nombre del fichero y el contenido en binario del fichero.
```php
    public function uploadDocument(string $sharepointFolderId, string $filename, string $content): SharepointApiResponseInterface;
```
