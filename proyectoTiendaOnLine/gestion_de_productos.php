<?php
// Datos de la conexión
$host = '127.0.0.1';
$user = 'root';
$password = '123';
$dbname = 'proyecto_tienda';

// Crear la conexión con mysqli
$conexion = new mysqli($host, $user, $password, $dbname);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para seleccionar todos los productos
$query_select = "SELECT * FROM productos";
$resultado_select = $conexion->query($query_select);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - MagicTech</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">MagicTech - Admin</a>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Gestión de Productos</h2>

        <!-- Formulario para agregar productos -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">Agregar Nuevo Producto</div>
            <div class="card-body">
               <form action="agregar_producto.php" method="POST" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="nombre_producto">Nombre del Producto</label>
            <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
            <label for="precio_producto">Precio (ARS)</label>
            <input type="number" id="precio_producto" name="precio_producto" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
            <label for="marca_producto">Marca del Producto</label>
            <input type="text" id="marca_producto" name="marca_producto" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
            <label for="stock_producto">Stock</label>
            <input type="number" id="stock_producto" name="stock_producto" class="form-control" required>
        </div>
        <div class="form-group col-md-6">
            <label for="imagen_producto">Imagen</label>
            <input type="file" id="imagen_producto" name="imagen_producto" class="form-control" required>
        </div>
        <div class="form-group col-md-12">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-success btn-block">Agregar Producto</button>
</form>

            

        </div>

        <!-- Tabla de productos -->
        <div class="card">
            <div class="card-header bg-info text-white">Listado de Productos</div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        if ($resultado_select && $resultado_select->num_rows > 0) {
                            while ($una_fila = mysqli_fetch_assoc($resultado_select)) {
                                echo "<tr>";
                                //echo "<td>" . $una_fila['id_producto'] . "</td>";
                                echo "<td>" . $una_fila['nombre_producto'] . "</td>";
                                echo "<td>" . $una_fila['marca_producto'] . "</td>";
                                echo "<td>" . $una_fila['precio_producto'] . "</td>";
                                echo "<td>" . $una_fila['stock_producto'] . "</td>";
                                echo "<td>" . $una_fila['descripcion_producto'] . "</td>";
                                echo "<td><img src='" . $una_fila['imagen_producto'] . "' class='img-thumbnail' style='width: 100px;'></td>";

                                echo "<td>
                                        <a href='editar_producto.php?id=" . $una_fila['id_producto'] . "' class='btn btn-warning btn-sm'>Editar</a>
                                        <a href='eliminar_producto.php?id=" . $una_fila['id_producto'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('¿Estás seguro de eliminar este producto?')\">Eliminar</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No hay productos disponibles.</td></tr>";
                        }
                        $conexion->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
     </div>
</body>
</html>
