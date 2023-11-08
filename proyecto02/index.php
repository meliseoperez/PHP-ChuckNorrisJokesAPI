<?php
session_start(); // Iniciar la sesión al comienzo del script

// Comprobar si se ha presionado el botón de reinicio
if (isset($_POST['reset'])) {
    // Vaciar el array de frases
    $_SESSION['frases'] = array();
    // Regenerar el ID de la sesión por seguridad
    session_regenerate_id(true);
    // Redirigir a la misma página para evitar el reenvío del formulario
    header('Location: index.php');
    exit;
}

// Obtener categoría de la API
$categorias_json = file_get_contents('https://api.chucknorris.io/jokes/categories');
$categorias = json_decode($categorias_json);

// Inicializar el array de frases si aún no está establecido
if (!isset($_SESSION['frases'])) {
    $_SESSION['frases'] = array();
}

// Obtener una nueva frase si se ha seleccionado una categoría
if (isset($_GET['category'])) {
    $selected_category = htmlspecialchars($_GET['category']);
    $random_joke_json = file_get_contents("https://api.chucknorris.io/jokes/random?category=$selected_category");
    $random_joke = json_decode($random_joke_json);
    $joke = htmlspecialchars($random_joke->value);

    // Añadir la nueva frase al array en la sesión
    $_SESSION['frases'][] = $joke;
}

// Resto del código HTML a continuación...
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chistes Chuck Norris</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <!-- Incluir tu hoja de estilos personalizados -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <div class="hero-section">
    <h1 class="mb-4">Seleccione una categoría de chistes</h1>
    <div class="form-container">
         <form action="index.php" method="get" class="mb-3">
            <div class="input-group">
                <select name="category" class="form-control">
                    <?php foreach ($categorias as $categoria) : ?>
                    <option value="<?php echo htmlspecialchars($categoria); ?>">
                        <?php echo htmlspecialchars($categoria); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">Obtener Frase</button>
            </div>
        </form>
    </div> 
    <div id="frases" class="frases-container">
            <h2 class="mb-3">Frases seleccionadas:</h2>
            <div class="scrollable-container">
            <ul class="list-group">
                <?php foreach ($_SESSION['frases'] as $frase) : ?>
                    <li class="list-group-item"><?php echo $frase; ?></li>
                <?php endforeach; ?>
            </ul>
            </div>
        </div>   
    </div>
    
    <div>
       
        <form action="index.php" method="post">
            <div class="form-group">
                <input type="submit" class="btn-reiniciar" value="Reiniciar" name="reset">
            </div>
        </form>
    </div>
    
    <!-- Incluir Bootstrap Bundle con Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
