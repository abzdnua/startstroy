<?
//echo $_SERVER['SERVER_NAME'];
	/** добавляем папки в include_path */
	$path = array('lib');
	if (phpversion()<5.3){
		define('__DIR__',dirname(__FILE__));
	}
    $path = get_include_path().PATH_SEPARATOR.__DIR__.'/'.implode(PATH_SEPARATOR.__DIR__.'/',$path);
    set_include_path($path);
	require_once 'class.page.php';
    //require_once 'class.dll.php';
    require_once 'class.controller.php';
	/*require_once 'class.invis.db.php';
    require_once 'class.db.php'; */
    //require_once 'uservar.php';
	
    
    $page = Page :: getInstance();
    $controller = new controller();
    //$db = new MyDB(const_hostName,const_userName,const_password,const_dbName);
	//$db=db :: getInstance();
    
    $controller -> getView();
    $page -> setDoctype(Page :: $XHTML);
   	//if ($_SERVER['REMOTE_ADDR'] != "127.0.0.1") $page -> addMetric("metrics/yandex.inc","metrics/google.inc");
    if($controller->getController()=='admin')
    {
        $controller -> getView('admin');
        $admin='views/admin/';
    }
    else
    {
        $admin='views/';
    }
    $root = $_SERVER['DOCUMENT_ROOT'];
	if (is_file($controller -> view))
				{  
    
				    if($controller->getController()=='admin' AND $controller->view!='views/admin/adminIn.phtml' AND $controller->view!='views/admin/adminLogin.phtml')
                    {
                        require_once "include.php";
                        require_once "lock.php";
                    }
                        require_once $admin.'_header.phtml';
    					require_once $controller -> view;
    					require_once $admin.'_footer.phtml';
				    
			
	} else {
	
		require_once $admin.'_header.phtml';
		require_once $admin."404.phtml";
		require_once $admin.'_footer.phtml';
		
	}
?>
