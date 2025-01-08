<?php
require '../../conn/connection.php';

if (isset($_GET['id'])) {
    $id_alumno = $_GET['id'];
    $consulta_alumno = $db->prepare("SELECT `id_persona`, `nombre`, `apellido`, `fecha_nacimiento`, `DNI`, `celular`, `email_correo`, `direccion`, `fecha_ingreso`, `pais`, `ciudad` 
    FROM persona WHERE id_persona = :id AND id_rol=1 AND estado='activo'");
    $consulta_alumno->bindParam(':id', $id_alumno, PDO::PARAM_INT);
    $consulta_alumno->execute();
    $alumno = $consulta_alumno->fetch();

    if (!$alumno) {
        die('No se encontró el alumno con el ID proporcionado o no está activo.');
    }
} else {
    die('Ha ocurrido un error');
}
require 'navbar.php';
?>

    <style>
        @media print {
            @page {
                margin: 10mm;
            }

            body {
                font-size: 12px;
                margin: 0;
                padding: 0;
            }

            .btn, .navbar, .footer {
                display: none;
            }

            .container {
                width: 100%;
            }

            .card {
                border: none;
            }
        }

        .form-title {
            text-align: center;
            margin-top: 20px;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .signature {
            border-top: 1px solid #000;
            width: 45%;
            text-align: center;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<section class="content mt-3">
    <div class="container">
        <div class="card rounded-2 border-0">
            <div class="card-header pb-0 bg-white text-black">
              
        <div class="text-center">
        <h5>INSTITUTO SUPERIOR </h5>
            <img src="../../img/LOGO.png" alt="Logo" style="max-width: 80px;">
            <h5>VIDA SILVESTRE Y NATURALEZA</h5>
            <P>Resolución N° 535DEP-2020</P>
            <h6>Formulario de pre-inscripción a la Carrera de "Técnico Superior en Manejo y Conservación en Areas Protegidas"</h6>
           
        </div>
        <div class="mt-4">
        <p class="text-black float-right"> San juan <?php echo date('d F Y'); ?></p><br>
        <div class="mb-3">
        <strong> EL SR/A CON DNI: </strong>   
                <span><?php echo htmlspecialchars($alumno['DNI']); ?></span> <strong>DECLARA LOS SIGUIENTES DATOS.</strong> 
            </div>
           
            <div class="row">
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                            <strong> Nombres:</strong>
                                <span><?php echo htmlspecialchars($alumno['nombre']); ?></span>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                            <strong> Apellidos:</strong> 
                                <span><?php echo htmlspecialchars($alumno['apellido']); ?></span>
                            </div>
            
            <div class="mb-3">
                <strong>Fecha de Nacimiento:</strong>
                <span><?php echo htmlspecialchars($alumno['fecha_nacimiento']); ?></span>
            </div>
            <div class="mb-3">
            <div class="row">
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                            <strong> Nacionalidad:</strong>
                                <span><?php echo htmlspecialchars($alumno['pais']); ?></span>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                            <strong> Localidad:</strong> 
                                <span><?php echo htmlspecialchars($alumno['ciudad']); ?></span>
                            </div>
            
            <div class="mb-3">
                <strong>Dirección:</strong>
                <span><?php echo htmlspecialchars($alumno['direccion']); ?></span>
            </div>
            <div class="mb-3">
                <strong>Teléfono:</strong>
                <span><?php echo htmlspecialchars($alumno['celular']); ?></span>
            </div>
            <div class="mb-3">
                <strong>Correo Electrónico:</strong>
                <span><?php echo htmlspecialchars($alumno['email_correo']); ?></span>
            </div>
            <div class="mb-3">
                <strong>Ciudad:</strong>
                <span><?php echo htmlspecialchars($alumno['ciudad']); ?></span>
            </div>
            <div class="mb-3">
                <strong>País:</strong>
                <span><?php echo htmlspecialchars($alumno['pais']); ?></span>
            </div>
            <div class="mb-3">
                <strong>Año en que se inscribe:</strong>
                <span><?php echo htmlspecialchars(date('Y', strtotime($alumno['fecha_ingreso']))); ?></span>
            </div>
            <div class="mb-3">
                <strong>¿Toma algún medicamento?:</strong>
                <span>________________________________________</span>
            </div>
            <div class="mb-3">
                <strong>¿Es alérgico?:</strong>
                <span>__________________________________________________________</span>
            </div>
            <div class="mb-3">
                <strong>Detalles de salud:</strong>
                <span>_____________________________________________________</span>
            </div><br>
            <p>El Instituto Superior Vida Silvestre Naturaleza y Aventura agradece su pre-inscripción a la Carrera de Técnico Superior en Manejo y Conservación en Areas Protegidas, estos datos consignados por Ud. Se consideran una Declaración Jurada de los mismos. Una vez pre-inscripto y abonada la misma no se harán reembolsos. Gracias</p>
            <br><br>
            <div class="signature-section">
                <div class="signature">Firma del Alumno</div>
                <div class="signature">Firma y Validación</div>
            </div>
            <br>
        </div>
        <div class="mt-4 text-center">
            <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
            <a href="alumno_index.php" class="btn btn-warning">Regresar</a>
            <p> 

            </p>
            <br>
        </div>
    </div>
    </div>
    </div>
    </div>   
</body>

