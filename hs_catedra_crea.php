
<?php require 'conn/connection.php';
if (isset($_POST['check_dni'])) {
    header('Content-Type: application/json');    
    try {
        if (!isset($db)) {
            throw new Exception('La conexión a la base de datos no está disponible');
        }        
        $dni = $_POST['dni'];        
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM profesor WHERE dni = :dni");
        $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);        
        echo json_encode([
            'exists' => $row['count'] > 0,
            'debug' => true
        ]);
    } catch (Exception $e) {
        error_log("Error en verificación de DNI: " . $e->getMessage());
        echo json_encode(['error' => $e->getMessage(), 'debug' => true]);
    }
    exit();
}

include 'navbar.php';
if (isset($_GET['dni']) && is_numeric($_GET['dni'])) {
    $dni = $_GET['dni'];    
        $query = "SELECT 
                hs_catedras.*, 
                profesor.*,
                tipo_tabla.*
            FROM 
                hs_catedras
            INNER JOIN profesor ON hs_catedras.id_profe = profesor.id_profe
            INNER JOIN tipo_tabla ON hs_catedras.tipo = tipo_tabla.id_tipo
            WHERE profesor.dni = :dni            
            ORDER BY profesor.id_profe DESC LIMIT 1
        ";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_INT);
        $stmt->execute();
        $profe = $stmt->fetch(PDO::FETCH_ASSOC);     
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data for profesor
    $nombre = mb_strtoupper($_POST['nombre']);
    $apellido = mb_strtoupper($_POST['apellido']);
    $dni = mb_strtoupper($_POST['dni']);     
    // Get form data for hs_catedras
    $num_exp = mb_strtoupper($_POST['num_exp']);
    $num_dictamen = mb_strtoupper($_POST['num_dictamen']);
    $escuela = mb_strtoupper($_POST['escuela']);
    $fecha_toma = mb_strtoupper($_POST['fecha_toma']);
    $fecha_crea = date('Y/m/d');
    $tipo = 1;

    $conexion->begin_transaction();    
    try {
        // Insert into profesor table
        $stmt = $conexion->prepare("INSERT INTO profesor (nombre, apellido, dni) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nombre, $apellido, $dni);
        $stmt->execute();        
        
        // Get the last inserted profesor ID
        $id_prof = $conexion->insert_id;        
        
        // Insert into hs_catedras table
        $stmt = $conexion->prepare("INSERT INTO hs_catedras (id_profe, num_exp, num_dictamen, escuela, fecha_toma, tipo, fecha_crea) VALUES (?, ?, ?, ?, ?,?, ?)");
        $stmt->bind_param("issssss", $id_prof, $num_exp, $num_dictamen, $escuela, $fecha_toma, $tipo, $fecha_crea);
        $stmt->execute();        
        $conexion->commit();       
        echo '<script>
                var id = ' . json_encode($id_prof) . ';
                window.location = "hs_catedra_lista.php?id=" + id;
            </script>';
    } catch (Exception $e) {
        // Rollback on error
        $conexion->rollback();
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>
<style>
    input.form-control {
        border: 1px solid #000;
    }
    .dni-warning {
        color: red;
        font-size: 0.9em;
        margin-top: 5px;
        display: none;
    }
</style>

<script>
let timeoutId = null;
function checkDNI(input) {
    clearTimeout(timeoutId);
    const warningElement = document.getElementById('dniWarning');
    const dniValue = input.value;
    
    // Validar el formato del DNI
    const dniPattern = /^[0-9]{8}$/;
    
    if (dniValue.length > 0) {
        if (!dniPattern.test(dniValue)) {
            warningElement.textContent = 'El DNI debe contener 8 dígitos';
            warningElement.style.display = 'block';
            input.style.borderColor = 'red';
            return;
        }
        
        timeoutId = setTimeout(() => {
            warningElement.innerHTML = 'Verificando...';
            warningElement.style.display = 'block';            
            fetch('hs_catedra_crea.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'check_dni=1&dni=' + encodeURIComponent(dniValue)
            })
            .then(async response => {
                const text = await response.text();
                console.log('Respuesta del servidor (texto):', text);                
                try {
                    const data = JSON.parse(text);
                    console.log('Datos parseados:', data);
                    
                    if (data.error) {
                        warningElement.textContent = 'Error: ' + data.error;
                    } else if (data.exists) {
                        warningElement.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-success">Este DNI ya existe</span>
                                <a href="hs_catedra_crea.php?dni=${dniValue}" 
                                   class="btn btn-info border border-dark">
                                    ¿Cargar?
                                </a>
                            </div>`;
                        warningElement.style.display = 'block';
                        input.style.borderColor = 'red';
                    } else {
                        warningElement.style.display = 'none';
                        input.style.borderColor = '#000';
                    }
                } catch (e) {
                    console.error('Error al parsear JSON:', e);
                    console.error('Respuesta recibida:', text);
                    warningElement.textContent = 'Error en la respuesta del servidor';
                }
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                warningElement.textContent = 'Error al verificar el DNI: ' + error.message;
            });
        }, 500);
    } else {
        warningElement.style.display = 'none';
        input.style.borderColor = '#000';
    }
}
</script>
<div class="container mt-0">
    <div class="row">
        <div class="col-md-12 ">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Registro de Profesor y Cátedra</h4>
                </div>
                <div class="card-body" style="background-color:#cccccc;">
                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> <?php echo $_SESSION['error_message']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                        <!-- Profesor Information -->
                        <h5 class="mb-3">Información del Profesor</h5>
                        <div class="row mb-3">                                
                            <div class="col-md-4">
                                <label class="form-label">DNI</label>
                                <input type="text" name="dni" class="form-control"
                                    id="dniInput"
                                    value="<?php echo htmlspecialchars($profe['dni'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    oninput="checkDNI(this)" pattern="[0-9]{8}" title="Ingresa exactamente 8 dígitos numéricos" required>
                                <div id="dniWarning" class="dni-warning" style="display: none;">Este DNI ya existe en la base de datos</div>
                            </div>

                            <script>
                                // Script para enfocar automáticamente el input al cargar la página
                                window.onload = function() {
                                    document.getElementById('dniInput').focus();
                                };
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
                                    <input type="text" name="num_exp" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Número de Dictamen</label>
                                    <input type="text" name="num_dictamen" class="form-control" required>
                                </div>                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Fecha de toma de posesión</label>
                                    <input type="date" name="fecha_toma" class="form-control" placeholder="DD/MM/YYYY" required>
                                </div>                               
                                <div class="col-md-8">
                                    <label class="form-label">Escuela</label>
                                    <input type="text" name="escuela" class="form-control" required>
                                </div>                                
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Registro</button>
                            <a class="btn btn-secondary ml-1 " href="index.php">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>