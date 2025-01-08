<?php require 'navbar.php';
function obtenerDatosProfesores($db){
        $query = "SELECT 
                    hs_catedras.*, 
                    profesor.*,
                    tipo_tabla.*
                FROM 
                    hs_catedras
                INNER JOIN profesor ON hs_catedras.id_profe = profesor.id_profe
                INNER JOIN tipo_tabla ON hs_catedras.tipo = tipo_tabla.id_tipo;
                ";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>
<head>

<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }
    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .dropdown-menu a {
        color: black;
        padding: 5px 10px;
        text-decoration: none;
        display: block;
    }
    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }
    .show {
        display: block;
    }
</style>

<section class="content mt-0">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0 " >
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Profesores</h5>                    
                    <div class="dropdown float-right mb-2">
                        <button onclick="toggleDropdown('headerDropdown')" class="btn btn-primary">Nuevo Dictamen</button>
                        <div id="headerDropdown" class="dropdown-menu">
                            <a href="hs_catedra_crea.php">Horas Catedra</a>
                            <a href="#">Horas Cargo</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive"style="background-color:#cccccc;">
                    <table id="example" class="table  table-striped table-hover table-sm  pb-4" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre y Apellido</th>
                                <th>DNI</th>
                                <th>Fecha Creación</th>
                                <th>Tipo Dictamen</th>
                                <th>Ver</th>
                                <th>Historial</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                            $profesores = obtenerDatosProfesores($db);
                            foreach ($profesores as $profesor) {
                                $fecha_db = $profesor['fecha_crea'];
                                $fecha = new DateTime($fecha_db);
                                $fecha_formateada = $fecha->format('d/m/Y');
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($profesor['id_profe'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($profesor['nombre'] . ' ' . $profesor['apellido'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($profesor['dni'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td><?php echo htmlspecialchars($fecha_formateada ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($profesor['nombre_tabla'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php if ($profesor['id_tipo'] === 1) { ?>
                                            <a class="btn btn-warning  ml-1" href="hs_catedra_lista.php?id=<?php echo $profesor['id_profe']; ?>">Ver </a>                                            
                                        <?php } 
                                        elseif (($profesor['id_tipo'] === 2)){ ?>
                                            <a class="btn btn-warning  ml-1" href="#hs_catedra_lista.php?id=<?php echo $profesor['id_profe']; ?>">Ver </a>
                                        <?php } ?>
                                    </td>                                    
                                    <td><a class="btn btn-info " href="historial.php?dni=<?php echo $profesor['dni']; ?>">Historial</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleDropdown(dropdownId) {
    // Close all dropdowns
    var dropdowns = document.getElementsByClassName('dropdown-menu');
    for (var i = 0; i < dropdowns.length; i++) {
        if (dropdowns[i].id !== dropdownId) {
            dropdowns[i].classList.remove('show');
        }
    }
    // Toggle the specific dropdown
    var dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('show');
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('button')) {
        var dropdowns = document.getElementsByClassName('dropdown-menu');
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
</script>
<?php require 'footer.php'; ?>