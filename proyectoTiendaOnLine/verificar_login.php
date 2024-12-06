<?php
// Obtener datos del formulario
$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Validar credenciales
if ($usuario === 'admin' && $password === '123') {
    // Redirigir al panel de gestión si las credenciales son correctas
    header("Location: gestion_de_productos.php");
    exit();
} else {
    // Redirigir a la vista del cliente si las credenciales son incorrectas
    header("Location: vista_cliente.php");
    exit();
}
?>
