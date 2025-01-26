<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="uft8_spanish2_ci">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora Oriental</title>
    <link rel="stylesheet" href="asset\css\styleModel.css">
    <link rel="stylesheet" href="asset\css\datatables.min.css">
    <link rel="stylesheet" href="asset\css\styleNew.css">
    <link rel="stylesheet" href="asset\css\sabrina.css">
    
    <link rel="stylesheet" href="asset/css/menuProfile.css">

    <link rel="stylesheet" href="asset\css\estilosBitacora.css">
    <link rel="stylesheet" href="asset\css\comments.css">

    <link rel="stylesheet" href="asset\css\stylePortal.css">
    <link rel="stylesheet" href="asset\css\styleSlider.css">
    <link rel="stylesheet" href="asset\css\Swiper-bundle.css">
    <!-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>  -->
    
    <link rel="icon" type="image/jpeg" href="asset\IconoBitacoraO\bitacora.jpg">
    
    <!-- Linking SwiperJS script -->
    <script src="asset\js\app\Swiper-bundle.js"></script>

    <!-- Libreria de Data Tabla -->
    <script src="asset\js\app\jquery-3.6.0.min.js"></script>
    <script src="asset\js\app\datatables.min.js"></script>
    <script src="asset\js\app\sweetAlert.js"></script>
    
    
  
</head>


<body id="body">
    
<!-- membrete, llama a menu -->
    
<!-- cabezera menbrete --> 
    
        <?php 

        

            if( (isset($_SESSION['user'])) && ($_SESSION['privilege'] === "admin" || $_SESSION['privilege'] === "publicista" )){?>
            <div class="icon__menu">
                <i class="fas fa-bars" id="btn_open"></i>
            </div>
            <?php 
                
                require_once VIEW_PATH .'template/sidebar.php'; 
                require_once VIEW_PATH .'template/headerEmployee.php'; 
            } else { 
                require_once VIEW_PATH .'template/headerTourist.php';
            }
        ?>

        
