<?php
class Auth extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
        if (isset($_SESSION['login'])) {
            header('Location:'.router().'dashboard');
            exit();
        }
    }

    /**
     * @throws Exception
     */
    public function login(): void
    {
        $data["pageName"] = "login";
        $this->views->getViews($this, 'login', $data);
    }

    public function setLogin(): void
    {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $FormData = [
            'userEmail' => $json['userEmail'] ?? '',
            'userPassword' => $json['userPassword'] ?? ''
        ];

        $FieldVerification = emptyFields($FormData);

        if (!empty($FieldVerification)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Algunos campos están vacíos.',
                'fields' => $FieldVerification,
                'redirect' => false
            ]);
            return;
        }

        $request = $this->model->setLogin($FormData);
        $response = json_decode($request, true);

        switch ($response["status"]) {
            case "SUCCESS_USER_VALID":
                if ($response['data']['userStatus'] == 1) {
                    $_SESSION['userId'] = $response['data']['userId'];
                    $_SESSION['login'] = true;

                    $this->model->sessionLogin($_SESSION['userId']);

                    echo json_encode([
                        'status' => 'login',
                        'message' => 'Acceso exitoso, lo estamos redireccionando...',
                        'redirect' => true
                    ]);
                }
                break;

            case "ERROR_USER_NOT_FOUND":
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Usuario no encontrado.',
                    'redirect' => false
                ]);
                break;

            case "ERROR_ACCOUNT_DISABLED":
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Usuario deshabilitado. Contacta al administrador.',
                    'redirect' => false
                ]);
                break;

            case "ERROR_INVALID_PASSWORD":
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Contraseña incorrecta.',
                    'redirect' => false
                ]);
                break;

            default:
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Error desconocido.',
                    'redirect' => false
                ]);
                break;
        }
    }

    public function signup(): void
    {
        $data["pageName"] = "signup";
        $this->views->getViews($this, 'signup', $data);
    }
}