<?php 
// Validar que los datos han sido enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre_producto = $_POST['nombre_producto'];
    $marca_producto = $_POST['marca_producto'];
    $precio_producto = $_POST['precio_producto'];
    $stock_producto = $_POST['stock_producto'];
    $descripcion_producto = $_POST['descripcion'];
    $imagen_producto = $_FILES['imagen_producto'];

    // Validar los campos
    if (empty($nombre_producto) || empty($marca_producto) || empty($precio_producto) || empty($stock_producto) || 
        empty($descripcion_producto) || !isset($imagen_producto['tmp_name']) || empty($imagen_producto['tmp_name'])) {
        die("Por favor, completa todos los campos.");
    }

    // Procesar la imagen
    $type = pathinfo($imagen_producto["name"], PATHINFO_EXTENSION);
    $data = file_get_contents($imagen_producto["tmp_name"]);
    $imagen_base64 = "data:image/" . $type . ";base64," . base64_encode($data);

    // Conectar a la base de datos
    $conexion = new mysqli('127.0.0.1', 'root', '123', 'proyecto_tienda');

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Insertar el producto en la base de datos
    $query = "INSERT INTO productos (nombre_producto, marca_producto, precio_producto, stock_producto, descripcion_producto, imagen_producto) 
              VALUES ('$nombre_producto', '$marca_producto', '$precio_producto', '$stock_producto', '$descripcion_producto', '$imagen_base64')";
    
    $resultado = $conexion->query($query);

    if ($resultado) {
        // Redirigir al panel de gestión
        header('Location: gestion_de_productos.php');
        exit();
    } else {
        echo "Ha ocurrido un error: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
} else {
    echo "Método de solicitud no válido.";
}
?>
