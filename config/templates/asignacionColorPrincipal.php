<?php 
// Color para las letras y hover del menu
$colorDepartamento = isset($_SESSION['llegada_colorDepartamento']) ? trim($_SESSION['llegada_colorDepartamento']) : '#0d6efd';

// Función PHP para aclarar el color (hacerlo más ligero)
function aclararTono($hexColor, $percent) {
    $hexColor = str_replace('#', '', $hexColor);
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));

    $r = round($r + (255 - $r) * ($percent / 100));
    $g = round($g + (255 - $g) * ($percent / 100));
    $b = round($b + (255 - $b) * ($percent / 100));

    return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT)
               . str_pad(dechex($g), 2, '0', STR_PAD_LEFT)
               . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}

// Color para todo lo demás del template del menu 
// Si se usa el color por defecto, usamos un color claro fijo
if ($colorDepartamento === '#0d6efd') {
    $colorClaro = '#ffffff'; // Azul claro fijo si es el color por defecto
} else {
    $colorClaro = aclararTono($colorDepartamento, 93); // Aclarar más si es personalizado
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Pasamos ambos colores a CSS variables
    document.documentElement.style.setProperty('--color-principal', '<?php echo $colorDepartamento; ?>');
    document.documentElement.style.setProperty('--color-principal-claro', '<?php echo $colorClaro; ?>');

    console.log('Color principal:', getComputedStyle(document.documentElement).getPropertyValue('--color-principal'));
    console.log('Color principal claro:', getComputedStyle(document.documentElement).getPropertyValue('--color-principal-claro'));
</script>
