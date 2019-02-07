<?php
    
    $path = $_SERVER['DOCUMENT_ROOT'] . "/web/";
    include($path."components/shop/model/DAOShopProducts.php");
    if (!isset($_GET['op'])) {
        $_GET['op'] = "list_home";
    }
    switch ($_GET['op']) {
        case 'list':
            include($path."components/shop/view/list_shop.php");
            break;
        case 'redirect':
            $_SESSION['fromhome'] = $_POST;
            break;
        case 'autocomplete':
            if (isset($_SESSION['fromhome'])) {
                $_POST = $_SESSION['fromhome'];
                $_POST['toAutoComplete'] = "*";
                session_unset();
            }
            try {
                $daoshoprod = new DAOShopProduct();
                $rt = $daoshoprod->select_prod_autocomp($_POST);
            }catch (Exception $e){
                
                $callback = 'index.php?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }
            if(!$rt){
                $callback = 'index.php?page=503';
                die('<script>window.location.href="'.$callback .'";</script>');
            }else{
                echo json_encode($rt->fetch_all());
            }

            break;
        default:
            echo "default";
            break;
    }
