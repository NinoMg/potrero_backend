<?php
// Verificar si se recibió el ID del producto
if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Conectar a la base de datos
    $conexion = new mysqli('127.0.0.1', 'root', '123', 'proyecto_tienda');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener los datos del producto a editar
    $query_select = "SELECT * FROM productos WHERE id_producto = $id_producto";
    $resultado_select = $conexion->query($query_select);

    if ($resultado_select->num_rows > 0) {
        $producto = $resultado_select->fetch_assoc();
    } else {
        die("Producto no encontrado.");
    }

    // Cerrar la conexión temporal
    $conexion->close();
} else {
    die("ID del producto no especificado.");
}

// Procesar el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_producto = $_POST['nombre_producto'];
    $marca_producto = $_POST['marca_producto'];
    $precio_producto = $_POST['precio_producto'];
    $stock_producto = $_POST['stock_producto'];
    $descripcion_producto = $_POST['descripcion'];
    $imagen_producto = $_FILES['imagen_producto'];

    // Validar que los campos requeridos no estén vacíos
    if (empty($nombre_producto) || empty($marca_producto) || empty($precio_producto) || empty($stock_producto) || empty($descripcion_producto)) {
        die("Por favor, completa todos los campos obligatorios.");
    }

    // Conectar a la base de datos
    $conexion = new mysqli('127.0.0.1', 'root', '123', 'proyecto_tienda');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Procesar la imagen solo si se cargó una nueva
    if (!empty($imagen_producto['tmp_name'])) {
        $type = pathinfo($imagen_producto["name"], PATHINFO_EXTENSION);
        $data = file_get_contents($imagen_producto["tmp_name"]);
        $imagen_base64 = "data:image/" . $type . ";base64," . base64_encode($data);

        // Actualizar todos los campos, incluida la imagen
        $query_update = "UPDATE productos 
                         SET nombre_producto = '$nombre_producto', 
                             marca_producto = '$marca_producto', 
                             precio_producto = '$precio_producto', 
                             stock_producto = '$stock_producto', 
                             descripcion_producto = '$descripcion_producto', 
                             imagen_producto = '$imagen_base64'
                         WHERE id_producto = $id_producto";
    } else {
        // Actualizar los campos sin modificar la imagen
        $query_update = "UPDATE productos 
                         SET nombre_producto = '$nombre_producto', 
                             marca_producto = '$marca_producto', 
                             precio_producto = '$precio_producto', 
                             stock_producto = '$stock_producto', 
                             descripcion_producto = '$descripcion_producto'
                         WHERE id_producto = $id_producto";
    }

    // Ejecutar la actualización
    if ($conexion->query($query_update) === TRUE) {
        // Redirigir al panel de gestión
        header('Location: gestion_de_productos.php');
        exit();
    } else {
        echo "Error al actualizar el producto: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Producto</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre_producto">Nombre del Producto</label>
                <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" value="<?php echo $producto['nombre_producto']; ?>" required>
            </div>
            <div class="form-group">
                <label for="marca_producto">Marca</label>
                <input type="text" id="marca_producto" name="marca_producto" class="form-control" value="<?php echo $producto['marca_producto']; ?>" required>
            </div>
            <div class="form-group">
                <label for="precio_producto">Precio (ARS)</label>
                <input type="number" id="precio_producto" name="precio_producto" class="form-control" value="<?php echo $producto['precio_producto']; ?>" required>
            </div>
            <div class="form-group">
                <label for="stock_producto">Stock</label>
                <input type="number" id="stock_producto" name="stock_producto" class="form-control" value="<?php echo $producto['stock_producto']; ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required><?php echo $producto['descripcion_producto']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="imagen_producto">Imagen (dejar en blanco para conservar la actual)</label>
                <input type="file" id="imagen_producto" name="imagen_producto" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>


?>