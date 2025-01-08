<?php require 'conn/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
} else {
    die('El parámetro ID no está definido.');
}
$fecha = new DateTime($profe['fecha_toma']);
$fecha_formateada = $fecha->format('d/m/Y');
?>

<html style="background: #666666;" lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINISTERIO DE EDUCACIÓN SAN JUAN</title>
    <link rel="shortcut icon" href="img/LOGO.png" />
    
    <style>
       @media print {
            @page {
                margin: 0;
                padding: 0px 30px 0px 30px;
                }
            header, footer, a, button{
                display: none;
            }
            .btn, .navbar, .footer {
                display: none;
            }
            body {
                font-size: 15px;
            }               
        }
        p {
            text-indent: 20%;
            margin: 0px;
            padding: 0px;
            line-height: 1.3; /* Reduce el espacio vertical dentro del párrafo */
        }
        body {
            font-family: 'Andalus', sans-serif;
            margin: 15px 20px 0px 20px;
            line-height: 1.5;
            padding: 0px 20px 0px 40px;
            background:#eeeeee;     
            padding-bottom: 20px;           
            }       
        .encabezado {
            text-align: right;
            font-size: 0.9em;
            margin-bottom: 20px;            
        }
        .content {
            text-align: justify;
        }
        .nota {
            font-style: italic;
        }
        button{
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 0.375rem; /* Bordes redondeados estándar */
            text-decoration: none; /* Sin subrayado */
        }
        a{
            padding: 10px 20px;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 0.375rem; /* Bordes redondeados estándar */
            text-decoration: none; /* Sin subrayado */
        }
        .button-container {
        display: flex;
        flex-direction: column; /* Para que botón y enlaces estén verticalmente */
        align-items: center;
        width: 90%;
        margin: 20px auto;
        }

        .enlaces { /* Estilos para el contenedor de enlaces */
        display: flex; /* Habilita Flexbox para los enlaces */
        justify-content: center; /* Centra los enlaces horizontalmente */
        width: 100%; /* Ocupa todo el ancho disponible */
        margin-top: 5px; /* Espacio entre el botón y los enlaces */
        }
        a {
            margin: 0 3px; /* Espacio entre los enlaces */
            padding: 10px 25px;
        }

        @media (max-width: 375px) {
            .button-container {
                padding: 10px;
            }
        a, button {
            padding: 10px 20px;
            font-size: 15px;
            margin-bottom: 5px;
            box-sizing: border-box;
        }
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<?php $anio_actual = date('Y'); ?>
<?php $mes_actual = date('m'); 
$mes = '';
if ($mes_actual === 1) { $mes = 'ENERO';}
elseif ($mes_actual == 2) {$mes = 'FEBRERO';}
elseif ($mes_actual == 3) {$mes = 'MARZO';}
elseif ($mes_actual == 4) {$mes = 'ABRIL';}
elseif ($mes_actual == 5) {$mes = 'MAYO';}
elseif ($mes_actual == 6) {$mes = 'JUNIO';}
elseif ($mes_actual == 7) {$mes = 'JULIO';}
elseif ($mes_actual == 8) {$mes = 'AGOSTO';}
elseif ($mes_actual == 9) {$mes = 'SEPTIEMBRE';}
elseif ($mes_actual == 10) {$mes = 'OCTUBRE';}
elseif ($mes_actual == 11) {$mes = 'NOVIEMBRE';}
elseif ($mes_actual == 12) {$mes = 'DICIEMBRE';}
?>

<body class="content">    
    <div class="encabezado">
        <p><strong>Corresponde a Exp.</strong> N° 300-<span><?php echo htmlspecialchars($profe['num_exp']);?></span>-<?php echo $anio_actual;?></strong>-EXP.</p>
        <p><strong>Extracto:</strong> S/Designación Hs.CÁTEDRA.</p>
        <p style="margin-top: 10px; margin-right: 80px;font-size: 17px;"><strong>DICTAMEN N° <span><?php echo htmlspecialchars($profe['num_dictamen']); ?></span>/<?php echo $anio_actual;?></strong></p>
    </div>       
    <div style="text-align: center;display: inline-block; margin-bottom: 0px;" >
        MINISTERIO DE EDUCACIÓN
        <br><u>SAN JUAN</u>
    </div>
    <h3 style="margin-top: 0px; padding-top: 0px; margin-bottom: 0px;"><strong>DIVISIÓN PERSONAL DOCENTE</strong></h3>
    <h5>S.__________ / __________D</h5>
    <div class="">
        <p>
            Vienen a consideración de este Servicio Jurídico las presentes actuaciones mediante las cuales tramita la 
            designación de el/la Sr/Sra. <span><?php echo htmlspecialchars($profe['apellido']); ?></span> <span><?php echo htmlspecialchars($profe['nombre']); ?></span>
             D.N.I. N° <span><?php echo htmlspecialchars($profe['dni']); ?></span>, en la situación de revista consignada en la solicitud obrante a fs. 01.
        </p>
        <p>
            Que la designación surge del acto de ofrecimiento, efectuado por <span><?php echo htmlspecialchars($profe['escuela']); ?></span>.
        </p>
        <p>
            Se observa que ha tomado debida intervención Interinatos y Suplencias certificando que 
            se ha incorporado la documentación correspondiente y se ha seguido el procedimiento pertinente, de acuerdo 
            con lo dispuesto en la Resolución N° 12401-ME-16 y en la Resolución N° 2550-ME-2023.
        </p>
        <p>
            De conformidad con lo establecido por la Ley N° 2476-I, Art. 126, inc. 1) y su Decreto Reglamentario N° 
            0009-2022, este Servicio Jurídico entiende que corresponde dar curso al presente procedimiento de designación, 
            en conformidad con la Ley N° 1116-A, Art. 23 y Resoluciones N° 12401-ME-2016, N° 2550-ME-2023, debiendo darse intervención 
            a Departamento Contable a los fines presupuestarios, luego la Dirección del Área deberá emitir la pertinente Disposición por 
            medio de la cual se designa a el/la Sr/Sra.
            <span><?php echo htmlspecialchars($profe['apellido']); ?></span> <span><?php echo htmlspecialchars($profe['nombre']); ?></span> 
            desde el <span><?php echo htmlspecialchars($fecha_formateada); ?></span>, que en relación a ello, la Asesoría Letrada de 
            Gobierno de la Provincia, se expidió en respuesta a la consulta efectuada por este Ministerio de Educación en 
            Expediente N° 300-004752-2023, a través del Dictamen N° 146, el que en su parte pertinente reza" 
            (...) la Disposición que prescribe la cobertura de cargos con fecha que se retrotrae al momento de la toma de posesión reúne 
            las condiciones y produce los efectos que en los referidos Artículos tiene legislada la Ley de Procedimiento Administrativo, 
            sin perjuicio a que, con posterioridad sea ratificado en los términos de la Ley N° 1116-A.”
        </p>
        <p>
            Es cuanto dictamina. Sirva la presente de atenta nota.-
        </p>
        <p>
            Asesoría Letrada del Ministerio de Educación<br>            
        </p>
        <p>
            San Juan, <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> de <?php echo $mes;?> de <?php echo $anio_actual;?>.
        </p>
    </div>
    <div class="button-container" >
        <button onclick="window.print()">Imprimir Documento</button>
        <div class="enlaces">
            <a style="background-color:rgb(100, 106, 100);" href="index.php">Atrás</a>
            <a style="background-color:#ffc107; color:#000;" href="hs_catedra_edit.php?id=<?php echo $profe['id_profe']; ?>">Editar</a>
        </div>
    </div>  
</body>
</html>
