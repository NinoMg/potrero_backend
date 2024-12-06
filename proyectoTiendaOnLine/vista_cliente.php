<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Importados</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">MagicTech</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="jumbotron jumbotron-fluid text-center text-white" style="background-image: url('hero-image.jpg'); background-size: cover;">
        <div class="container">
            <h1 class="display-4">Los Mejores Productos Importados</h1>
            <p class="lead">Calidad garantizada a precios que no encontrarás en ningún otro lugar.</p>
            <a href="#catalogo" class="btn btn-warning btn-lg">Ver Productos</a>
        </div>
    </div>

    <!-- Main Catalog Section -->
    <div class="container my-5" id="catalogo">
        <h2 class="text-center mb-4">Los más buscados</h2>
        <div class="row">
            <?php
            // Conexión a la base de datos
            $conexion = new mysqli('127.0.0.1', 'root', '123', 'proyecto_tienda');

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            // Consulta para obtener los productos
            $query = "SELECT nombre_producto, marca_producto, precio_producto, descripcion_producto, imagen_producto FROM productos";
            $resultado = $conexion->query($query);

            if ($resultado && $resultado->num_rows > 0) {
                while ($producto = $resultado->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '  <div class="card h-100">';
                    echo '      <img src="' . $producto['imagen_producto'] . '" class="card-img-top" alt="Producto">';
                    echo '      <div class="card-body">';
                    echo '          <h5 class="card-title">' . htmlspecialchars($producto['nombre_producto']) . '</h5>';
                    echo '          <p class="card-text">' . htmlspecialchars($producto['descripcion_producto']) . '</p>';
                    echo '          <p class="card-text text-success"><strong>ARS $' . htmlspecialchars($producto['precio_producto']) . '</strong></p>';
                    echo '          <a href="#" class="btn btn-primary btn-block">Comprar Ahora</a>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="text-center w-100">No hay productos disponibles.</p>';
            }

            $conexion->close();
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Nino-MagicTech. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
