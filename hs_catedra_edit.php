<?php include 'navbar.php';
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];    
    try {
        $query = "SELECT 
                hs_catedras.*, 
                profesor.*,
                tipo_tabla.*
            FROM 
                hs_catedras
            INNER JOIN profesor ON hs_catedras.id_profe = profesor.id_profe
            INNER JOIN tipo_tabla ON hs_catedras.tipo = tipo_tabla.id_tipo
            WHERE hs_catedras.id_profe = :id
        ";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $profe = $stmt->fetch(PDO::FETCH_ASSOC);        
        if (!$profe) {
            echo "<div class='alert alert-danger'>No se encontró el registro</div>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error al recuperar datos: " . $e->getMessage() . "</div>";
        exit();
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data for profesor
    $id_profe = $_POST['id_profe'];
    $nombre = mb_strtoupper($_POST['nombre']);
    $apellido = mb_strtoupper($_POST['apellido']);
    $dni = mb_strtoupper($_POST['dni']);    
    // Get form data for hs_catedras
    $num_exp = mb_strtoupper($_POST['num_exp']);
    $num_dictamen = mb_strtoupper($_POST['num_dictamen']);
    $escuela = mb_strtoupper($_POST['escuela']);
    $fecha_toma = mb_strtoupper($_POST['fecha_toma']);    
    $conexion->begin_transaction();
    
    try {
        $stmt = $conexion->prepare("UPDATE profesor SET nombre = ?, apellido = ?, dni = ? WHERE id_profe = ?");
        $stmt->bind_param("ssii", $nombre, $apellido, $dni, $id_profe);
        $stmt->execute();        
        // Update hs_catedras table
        $stmt = $conexion->prepare("UPDATE hs_catedras SET num_exp = ?, num_dictamen = ?, escuela = ?, fecha_toma = ? WHERE id_profe = ?");
        $stmt->bind_param("ssssi", $num_exp, $num_dictamen, $escuela, $fecha_toma, $id_profe);
        $stmt->execute();        
        $conexion->commit();        
        echo '<script>
                var id = ' . json_encode($id_profe) . ';
                window.location = "hs_catedra_lista.php?id=" + id;
            </script>';
    } catch (Exception $e) {
        $conexion->rollback();
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>
<style>
    input.form-control {
        border: 1px solid #000;
    }
</style>
<div class="container mt-0">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Modificar Profesor y Cátedra</h4>
                </div>
                <div class="card-body" style="background-color:#cccccc;">
                    <form method="POST" action="">
                        <input type="hidden" name="id_profe" value="<?php echo htmlspecialchars($profe['id_profe'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        
                        <!-- Profesor Information -->
                        <h5 class="mb-3">Información del Profesor</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">DNI</label>
                                <input type="text" name="dni" class="form-control"
                                    pattern="[0-9]{8}" title="Ingresa exactamente 8 dígitos numéricos"
                                    value="<?php echo htmlspecialchars($profe['dni'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    oninput="validarInput(this)" required>
                            </div>
                            <script>
                                function validarInput(input) {
                                input.value = input.value.replace(/[^0-9]/g, ''); // Elimina no números
                                if (input.value.length > 8) {
                                    input.value = input.value.slice(0, 8); // Limita a 8 dígitos
                                }
                                }
                            </script>
                            <div class="col-md-4">
                                <label class="form-label">Apellido/s</label>
                                <input type="text" name="apellido" class="form-control" value="<?php echo htmlspecialchars($profe['apellido'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nombre/s</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($profe['nombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>                            
                        </div>                        
                        <!-- Cátedra Information -->
                        <h5 class="mb-3 mt-4">Información de la Cátedra</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Número de Expediente</label>
                                <input type="text" name="num_exp" class="form-control" value="<?php echo htmlspecialchars($profe['num_exp'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Número de Dictamen</label>
                                <input type="text" name="num_dictamen" class="form-control" value="<?php echo htmlspecialchars($profe['num_dictamen'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Fecha de toma de posesión</label>
                                <input type="date" name="fecha_toma" class="form-control" value="<?php echo htmlspecialchars($profe['fecha_toma'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Escuela</label>
                                <input type="text" name="escuela" class="form-control" value="<?php echo htmlspecialchars($profe['escuela'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <a class="btn btn-secondary ml-1 border " href="hs_catedra_lista.php?id=<?php echo $id; ?>">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>