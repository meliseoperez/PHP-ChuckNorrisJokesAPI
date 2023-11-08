<?php
    $categorias_json=file_get_contents('https://api.chucknorris.io/jokes/categories');
    $categorias=json_decode($categorias_json);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chuck Norris Frases</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1>Selecciona una categoría</h1>
    <form action="index.php" method="get">
        <select name="category">
            <?php foreach($categorias as $categoria): ?>
                <option value="<?php echo $categoria; ?>">
                    <?php echo $categoria; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Obtener Frase">        
    </form>
    <?php
    if(isset($_GET['category'])){
        $selected_category=$_GET['category'];
        $random_joke_json=file_get_contents("https://api.chucknorris.io/jokes/random?category=$selected_category");
        $random_joke=json_decode($random_joke_json);
        $joke=$random_joke->value;
        echo "<p>$joke</p>";
    }
?>
</body>
</html>
