<?php  
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Validar el ID para evitar problemas de seguridad
    $id = intval($_GET['id']); // Convierte el valor a un número entero seguro
    
    // Conectar a la base de datos
    $conexion = new mysqli('127.0.0.1', 'root', '123', 'proyecto_tienda');
    
    // Comprobar conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    // Consulta para eliminar el producto
    $query_delete = "DELETE FROM productos WHERE id_producto = $id";
    $resultado = $conexion->query($query_delete);
    
    // Verificar si se eliminó correctamente
    if ($resultado && $conexion->affected_rows > 0) {
        echo "Producto eliminado correctamente.";
        header('Location: gestion_de_productos.php');
        exit(); // Asegura que no se ejecute más código después del redireccionamiento
    } else {
        echo "No se pudo eliminar el producto. Verifica que exista.";
    }
    
    // Cerrar conexión
    $conexion->close();
} else {
    echo "Error: ID no proporcionado o vacío.";
}

?>