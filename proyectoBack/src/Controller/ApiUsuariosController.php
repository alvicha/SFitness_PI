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

        $correo = $data['correo'];
        $password = $data['password'];
        $usuario = $em->getRepository(Usuario::class)->findOneBy(['correo' => $correo]);

        if (!$usuario) {
            return 'Usuario no encontrado';
        }
        $em->persist($usuario);
        $em->flush($usuario);
        $usuario->comprobar($password);

        return new JsonResponse(['success' => 'datos correctos'], Response::HTTP_OK);
    }

    #[Route('/api/usuarios/addUsuarios', methods: ['POST'], name: 'register_user')]
    public function registrarUsuario(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nombre'], $data['apellido'], $data['email'], $data['password'], $data['telefono'], $data['rol'])) {
            return new JsonResponse(['error' => 'Datos incompletos'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $usuario = new Usuario();
        echo 'weroihkjhwfi';
        $usuario->setNombre($data['nombre']);
        $usuario->setApellido($data['apellido']);
        $usuario->setEmail($data['email']);
        $usuario->setPassword($data['password']);
        $usuario->encriptar();
        $usuario->setTelefono($data['telefono']);
        $usuario->setRol($data['rol']);

        $em->persist($usuario);
        $em->flush();

        return new JsonResponse(['message' => 'Usuario registrado correctamente'], JsonResponse::HTTP_CREATED);
    }
}
