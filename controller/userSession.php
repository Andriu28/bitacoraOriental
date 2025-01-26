<?php


require_once(CONTROLLER_PATH."historys.php");

    class userSession {
 
        public function __construct(){
           if(session_status() !== PHP_SESSION_ACTIVE)     session_start();
            if(isset($_SESSION['timeSession']) && !isset($band))    $this->timeValidation();
            if(isset($_SESSION['timeSession']) && !isset($band))    $this->timeSession();
        }

        //Encriptado de los datos
       public function encryptData($data, $key) {
            $cipher = "aes-256-cbc"; // Algoritmo de encriptación
            $ivlen = openssl_cipher_iv_length($cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            $jsonData = json_encode($data); // Convertir array a JSON
            $ciphertext = openssl_encrypt($jsonData, $cipher, $key, $options=0, $iv);
            return base64_encode($iv . $ciphertext);
        }

        // Desencriptado de datos 
        public function decryptData($data, $key) {
            $cipher = "aes-256-cbc"; // Algoritmo de desencriptación
            $data = base64_decode($data);
            $ivlen = openssl_cipher_iv_length($cipher);
            $iv = substr($data, 0, $ivlen);
            $ciphertext = substr($data, $ivlen);
            $jsonData = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv);
            return json_decode($jsonData, true); // Convertir JSON a array
        }


            
        /*Inicializa la variable de user */
        public function setCurrentUser($user,$privilege){            
            $_SESSION['user'] = $this->encryptData($user, KEY_DECRYP);
            $_SESSION['privilege'] = $privilege;
        }
        /*Recupera una sesion si habia una anteriormente */
        public function recoverySession(){
            if(!isset($_SESSION['user'])){
                session_unset();
                session_destroy();
            }
        }
        /*Define el tiempo de sesion de un usuario */
        public function timeSession(){
            date_default_timezone_set('America/Caracas');// se establece la zona horaria
            $_SESSION['timeSession'] = date("Y-m-d H:i:s");//se capta la hora de ingreso del usuario
        }
        /*comprueba si el tiempo de sesion de un usuario a caducado */
        public function timeValidation(){
            date_default_timezone_set('America/Caracas');
            $dateExpire = date("Y-m-d H:i:s"); // Formato de fecha // si no esta asi Y-m-d H:i:s no funciona
            $seconds = strtotime($dateExpire) - strtotime($_SESSION['timeSession']) ;// determinado los segundos transcurridos
            $minutes = $seconds / 60;// convirtiendo a minutos
            if($minutes > LOGOUT_TIME) $this->finishedTime();
        }
        //funncion para resgitringir el acceso a los usuarios turistas
        public function sessionAccessTourist(){
            if( isset($_SESSION['privilege']) && $_SESSION['privilege'] === 'turista'){
                header('location: index.php?controller=home&action=homeInformation');
                exit();
            }
            
        }
        /*Permite el acceso solo a los usuarios administradores */
        public function sessionAccessAdmin(){// se comprueban las credenciales
            if(isset($_SESSION['privilege']) && $_SESSION['privilege'] !== 'admin'){
                //dependiendo del rol se redireciona 
                if($_SESSION['privilege'] === 'publicista'){
                    header('location: index.php?controller=dashboard&action=summary');
                    exit();
                }else{
                    header('location: index.php?controller=home&action=homeInformation');
                    exit();
                } 
            }
        }
               
        /*Funcion para validar si la sesion esta acitva */
        public function activeSessionValidation(){
            if (isset($_SESSION['user'])){//para restringir el acceso a ciertas funciones de user
                $this->closeSession(); 
            }else{
                session_unset();
                session_destroy();
            }
        }
        /*Redirige a los usauros a si el tiempo de sesion a caducado */
        public function finishedTime(){                                    
            header('location: index.php?controller=users&action=timeLoguot');            
        }
        /*Cierra la sesion y redirige al usuario */
        public function closeSession(){
            session_unset();
            session_destroy();
            header("location:". DEFAULT_ADDRESS_LOGOUT);
            exit();
        }
    }

?> 