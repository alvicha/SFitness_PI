<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Clases;
use App\Entity\Usuarios;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class ApiUsuariosController extends AbstractController
{
    #[Route('/api/usuarios', name: 'app_api_usuarios')]
    public function index(): Response
    {
        return $this->render('api_usuarios/index.html.twig', [
            'controller_name' => 'ApiUsuariosController',
        ]);
    }
    #[Route('/api/usuarios/addClase', methods: ['POST'], name: 'add_clase')]
    public function addClaseUsuario(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuarioId = $data['usuario_id'];
        $claseId = $data['clase_id'];
        $usuario = $em->getRepository(Usuarios::class)->find($usuarioId);
        $clase = $em->getRepository(Clases::class)->find($claseId);

        $usuario->addClasesApuntada($clase);

        $em->persist($usuario);
        $em->persist($clase);
        $em->flush();
        return new JsonResponse(['success' => 'Clase agregada al usuario'], Response::HTTP_OK);

    }


    #[Route('/api/usuarios/login', methods: ['POST'], name: 'add_clase')]
    public function iniciarSesion(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $correo = $data['correo'] ?? null;
        $password = $data['password'] ?? null;

        if (!$correo || !$password) {
            return new JsonResponse(['error' => 'Correo y contraseña son obligatorios'], Response::HTTP_BAD_REQUEST);
        }

        $usuario = $em->getRepository(Usuarios::class)->findOneBy(['email' => $correo]);

        if (!$usuario) {
            return new JsonResponse(['error' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
        }

        if (!$usuario->comprobar($password)) {
            return new JsonResponse(['error' => 'Contraseña incorrecta'], Response::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse(['success' => 'Datos correctos'], Response::HTTP_OK);
    }



    #[Route('/api/usuarios/fotoPerfil', methods: ['POST'])]
    public function subirImagen(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        if (!isset($data['imagen']) || !isset($data['id'])) {
            return new JsonResponse(['error' => 'Faltan datos: imagen o id'], 400);
        }

        $base64String = $data['imagen'];
        $usuarioId = $data['id'];

        $imagenData = base64_decode($base64String);
        if ($imagenData === false) {
            return new JsonResponse(['error' => 'Formato de imagen inválido'], 400);
        }


        $usuario = $em->getRepository(Usuarios::class)->find($usuarioId);
        if (!$usuario) {
            return new JsonResponse(['error' => 'Usuario no encontrado'], 404);
        }


        $carpetaImagenes = $this->getParameter('kernel.project_dir') . '/public/img/';


        if (!is_dir($carpetaImagenes) && !mkdir($carpetaImagenes, 0775, true) && !is_dir($carpetaImagenes)) {
            return new JsonResponse(['error' => 'No se pudo crear la carpeta de imágenes'], 500);
        }

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes, 0777, true); // Crea la carpeta con permisos adecuados
        }


        $nombreArchivo = uniqid('img_', true) . '.png';
        $rutaImagen = $carpetaImagenes . $nombreArchivo;


        if (!file_put_contents($rutaImagen, $imagenData)) {
            return new JsonResponse(['error' => 'No se pudo guardar la imagen'], 500);
        }

        // Copiar la imagen al contenedor Nginx
        $copiarImagenCommand = "docker cp " . $rutaImagen . " symfony_nginx:/var/www/html/public/img/" . $nombreArchivo;
        exec($copiarImagenCommand);

        $usuario->setFotoPerfil('/img/' . $nombreArchivo);
        $em->persist($usuario);
        $em->flush();


        return new JsonResponse(['ruta' => '/img/' . $nombreArchivo], 201);
    }

}
