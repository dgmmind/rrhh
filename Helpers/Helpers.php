<?php
function router(): string
{
    return ROUTER;
}

function files(): string
{
    return ROUTER . 'Assets/';
}

function generateCsrfToken($length, $prefix, $hash): string
{
    return token($length, $prefix, $hash);
}

function token($length = 32, $prefix = '', $hash = false): string
{
    try
    {
        $randomBytes = random_bytes($length);
    }
    catch (Exception $e)
    {
        $randomBytes = '';
        for ($i = 0; $i < $length; $i++)
        {
            $randomBytes .= chr(mt_rand(0, 255));
        }
    }

    $token = bin2hex($randomBytes);

    if ($hash)
    {
        $token = hash('sha256', $token);
    }

    if (!empty($prefix))
    {
        $token = $prefix . $token;
    }

    return $token;
}

function debug($data): void
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function verifyId(string $table, string $column, int $id): array
{
    require_once("Models/HelpersModel.php");
    $request = new HelpersModel();
    return $request->verifyId($table, $column, $id);
}

function handleError(): void
{
    require_once 'Controllers/Errors.php';
}

function validateId(mixed $id): bool
{
    if (filter_var($id, FILTER_VALIDATE_INT) === false || $id <= 0)
    {
        return false;
    }
    return true;
}

function getPermissions(int $moduleId): void
{
    try
    {
        require_once("Models/PermissionsModel.php");
        $objPermissions = new PermissionsModel();
        $roleId = $_SESSION['userData']['roleId'] ?? 0;
        $arrayPermissions = $objPermissions->permissionsModule($roleId);
        $_SESSION['permissions'] = $arrayPermissions;
        $_SESSION['permissionsModule'] = $arrayPermissions[$moduleId] ?? '';
    }
    catch (Exception $e)
    {
        error_log("Error al obtener permisos: " . $e->getMessage());
        $_SESSION['permissions'] = [];
        $_SESSION['permissionsModule'] = '';
    }
}

function adminHeader($data=""): void
{
    require_once "Views/Template/adminHeader.php";
}

function adminNav($data=""): void
{
    require_once "Views/Template/adminNav.php";
}

function adminFooter($data=""): void
{
    require_once "Views/Template/adminFooter.php";
}

function adminSidebar($data=""): void
{
    require_once "Views/Template/adminSidebar.php";
}

function emptyFields(array $fields): array
{
    $emptyFields = [];
    foreach ($fields as $name => $value)
    {
        if (empty($value))
        {
            $emptyFields[] = $name;
        }
    }
    return $emptyFields;
}