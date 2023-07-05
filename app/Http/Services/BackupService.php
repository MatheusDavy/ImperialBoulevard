<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Storage;

/**
 * This file contains the Backup_Database class wich performs
 * a partial or complete backup of any given MySQL database
 * @author Daniel López Azaña <daniloaz@gmail.com>
 * @version 1.0
 */

/**
 * The Backup_Database class
 */
class BackupService {
    /**
     * Host where the database is located
     */
    var $host;

    /**
     * Username used to connect to database
     */
    var $username;

    /**
     * Password used to connect to database
     */
    var $passwd;

    /**
     * Database to backup
     */
    var $dbName;

    /**
     * Database charset
     */
    var $charset;

    /**
     * Database connection
     */
    var $conn;

    /**
     * Backup directory where backup files are stored 
     */
    var $backupDir;

    /**
     * Output backup file
     */
    var $backupFile;

    /**
     * Use gzip compression on backup file
     */
    var $gzipBackupFile;

    /**
     * Content of standard output
     */
    var $output;

    /**
     * Disable foreign key checks
     */
    var $disableForeignKeyChecks;

    /**
     * Batch size, number of rows to process per iteration
     */
    var $batchSize;

    public $ignoreTables = [];

    /**
     * Constructor initializes database
     */
    public function __construct($charset = 'utf8', $gzipBackupFile = true, $disableForeignKeyChecks = true, $batchSize = 1000) {
        //define("TABLES", 'table1, table2, table3'); // Partial backup
        $this->host                    = env('DB_HOST');
        $this->username                = env('DB_USERNAME');
        $this->passwd                  = env('DB_PASSWORD');
        $this->dbName                  = env('DB_DATABASE');
        $this->charset                 = $charset;
        $this->conn                    = $this->initializeDatabase();
        $this->backupDir               = Storage::path('backups');
        $this->backupFile              = 'db_backup_' . date('y_m_d') . '.sql';
        $this->gzipBackupFile          = $gzipBackupFile;
        $this->disableForeignKeyChecks = $disableForeignKeyChecks;
        $this->batchSize               = $batchSize;
        $this->output                  = '';
        $this->ignoreTables            = ['tbl_token_auth', 'token_auth'];
    }

    protected function initializeDatabase() {
        // $pathCa = __DIR__ . '/../../../public/bam.pem';
        try {
            $conn = mysqli_init();
            if (env('APP_ENV') == 'production') {
                // $conn->ssl_set(null, null, $pathCa, null, null);
            }
            $conn->real_connect($this->host, $this->username, $this->passwd, $this->dbName, 3306);
            if (mysqli_connect_errno()) {
                throw new Exception('ERROR connecting database: ' . mysqli_connect_error());
                die();
            }
            if (!mysqli_set_charset($conn, $this->charset)) {
                mysqli_query($conn, 'SET NAMES '.$this->charset);
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
            die();
        }

        return $conn;
    }

    /**
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     * @param string $tables
     */
    public function backupTables($tables = '*') {
        try {
            /**
             * Tables to export
             */
            if($tables == '*') {
                $tables = array();
                $result = mysqli_query($this->conn, 'SHOW TABLES');
                while($row = mysqli_fetch_row($result)) {
                    $tables[] = $row[0];
                }
            } else {
                $tables = is_array($tables) ? $tables : explode(',', str_replace(' ', '', $tables));
            }

            $sql = '';

            /**
             * Disable foreign key checks 
             */
            if ($this->disableForeignKeyChecks === true) {
                $sql .= "SET foreign_key_checks = 0;\n\n";
            }
            /**
             * Iterate tables
             */
            foreach($tables as $table) {
                if( in_array($table, $this->ignoreTables) )
                    continue;
                $this->obfPrint("Backing up `".$table."` table...".str_repeat('.', 50-strlen($table)), 0, 0);

                /**
                 * CREATE TABLE
                 */
                $sql .= 'DROP TABLE IF EXISTS `'.$table.'`;';
                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SHOW CREATE TABLE `'.$table.'`'));
                $sql .= "\n\n".$row[1].";\n\n";

                /**
                 * INSERT INTO
                 */

                $row = mysqli_fetch_row(mysqli_query($this->conn, 'SELECT COUNT(*) FROM `'.$table.'`'));
                $numRows = $row[0];

                // Split table in batches in order to not exhaust system memory 
                $numBatches = intval($numRows / $this->batchSize) + 1; // Number of while-loop calls to perform

                for ($b = 1; $b <= $numBatches; $b++) {
                    
                    $query = 'SELECT * FROM `' . $table . '` LIMIT ' . ($b * $this->batchSize - $this->batchSize) . ',' . $this->batchSize;
                    $result = mysqli_query($this->conn, $query);
                    $realBatchSize = mysqli_num_rows ($result); // Last batch size can be different from $this->batchSize
                    $numFields = mysqli_num_fields($result);

                    if ($realBatchSize !== 0) {
                        $sql .= 'INSERT INTO `'.$table.'` VALUES ';

                        for ($i = 0; $i < $numFields; $i++) {
                            $rowCount = 1;
                            while($row = mysqli_fetch_row($result)) {
                                $sql.='(';
                                for($j=0; $j<$numFields; $j++) {
                                    if (isset($row[$j])) {
                                        $row[$j] = addslashes($row[$j]);
                                        $row[$j] = str_replace("\n","\\n",$row[$j]);
                                        $row[$j] = str_replace("\r","\\r",$row[$j]);
                                        $row[$j] = str_replace("\f","\\f",$row[$j]);
                                        $row[$j] = str_replace("\t","\\t",$row[$j]);
                                        $row[$j] = str_replace("\v","\\v",$row[$j]);
                                        $row[$j] = str_replace("\a","\\a",$row[$j]);
                                        $row[$j] = str_replace("\b","\\b",$row[$j]);
                                        if ($row[$j] == 'true' or $row[$j] == 'false' or preg_match('/^-?[1-9][0-9]*$/', $row[$j]) or $row[$j] == 'NULL' or $row[$j] == 'null') {
                                            $sql .= $row[$j];
                                        } else {
                                            $sql .= '"'.$row[$j].'"' ;
                                        }
                                    } else {
                                        $sql.= 'NULL';
                                    }
    
                                    if ($j < ($numFields-1)) {
                                        $sql .= ',';
                                    }
                                }
    
                                if ($rowCount == $realBatchSize) {
                                    $rowCount = 0;
                                    $sql.= ");\n"; //close the insert statement
                                } else {
                                    $sql.= "),\n"; //close the row
                                }
    
                                $rowCount++;
                            }
                        }
    
                        $this->saveFile($sql);
                        $sql = '';
                    }
                }

                /**
                 * CREATE TRIGGER
                 */

                // Check if there are some TRIGGERS associated to the table
                /*$query = "SHOW TRIGGERS LIKE '" . $table . "%'";
                $result = mysqli_query ($this->conn, $query);
                if ($result) {
                    $triggers = array();
                    while ($trigger = mysqli_fetch_row ($result)) {
                        $triggers[] = $trigger[0];
                    }
                    
                    // Iterate through triggers of the table
                    foreach ( $triggers as $trigger ) {
                        $query= 'SHOW CREATE TRIGGER `' . $trigger . '`';
                        $result = mysqli_fetch_array (mysqli_query ($this->conn, $query));
                        $sql.= "\nDROP TRIGGER IF EXISTS `" . $trigger . "`;\n";
                        $sql.= "DELIMITER $$\n" . $result[2] . "$$\n\nDELIMITER ;\n";
                    }

                    $sql.= "\n";

                    $this->saveFile($sql);
                    $sql = '';
                }*/
 
                $sql.="\n\n";

                $this->obfPrint('OK');
            }

            /**
             * Re-enable foreign key checks 
             */
            if ($this->disableForeignKeyChecks === true) {
                $sql .= "SET foreign_key_checks = 1;\n";
            }

            $this->saveFile($sql);

            if ($this->gzipBackupFile) {
                $this->gzipBackupFile();
            } else {
                $this->obfPrint('Backup file succesfully saved to ' . $this->backupDir.'/'.$this->backupFile, 1, 1);
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Save SQL to file
     * @param string $sql
     */
    protected function saveFile(&$sql) {
        if (!$sql) return false;

        try {

            if (!file_exists($this->backupDir)) {
                mkdir($this->backupDir, 0777, true);
            }

            file_put_contents($this->backupDir.'/'.$this->backupFile, $sql, FILE_APPEND | LOCK_EX);

        } catch (Exception $e) {
            print_r($e->getMessage());
            return false;
        }

        return true;
    }

    /*
     * Gzip backup file
     *
     * @param integer $level GZIP compression level (default: 9)
     * @return string New filename (with .gz appended) if success, or false if operation fails
     */
    protected function gzipBackupFile($level = 9) {
        if (!$this->gzipBackupFile) {
            return true;
        }

        $source = $this->backupDir . '/' . $this->backupFile;
        $dest =  $source . '.gz';

        $this->obfPrint('Gzipping backup file to ' . $dest . '... ', 1, 0);

        $mode = 'wb' . $level;
        if ($fpOut = gzopen($dest, $mode)) {
            if ($fpIn = fopen($source,'rb')) {
                while (!feof($fpIn)) {
                    gzwrite($fpOut, fread($fpIn, 1024 * 256));
                }
                fclose($fpIn);
            } else {
                return false;
            }
            gzclose($fpOut);
            if(!unlink($source)) {
                return false;
            }
        } else {
            return false;
        }
        
        $this->obfPrint('OK');
        return $dest;
    }

    /**
     * Prints message forcing output buffer flush
     *
     */
    public function obfPrint ($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1) {
        if (!$msg) {
            return false;
        }

        if ($msg != 'OK' and $msg != 'KO') {
            $msg = date("Y-m-d H:i:s") . ' - ' . $msg;
        }
        $output = '';

        if (php_sapi_name() != "cli") {
            $lineBreak = "<br />";
        } else {
            $lineBreak = "\n";
        }

        if ($lineBreaksBefore > 0) {
            for ($i = 1; $i <= $lineBreaksBefore; $i++) {
                $output .= $lineBreak;
            }                
        }

        $output .= $msg;

        if ($lineBreaksAfter > 0) {
            for ($i = 1; $i <= $lineBreaksAfter; $i++) {
                $output .= $lineBreak;
            }                
        }


        // Save output for later use
        $this->output .= str_replace('<br />', '\n', $output);

        echo $output;


        if (php_sapi_name() != "cli") {
            if( ob_get_level() > 0 ) {
                ob_flush();
            }
        }

        $this->output .= " ";

        flush();
    }

    /**
     * Returns full execution output
     *
     */
    public function getOutput() {
        return $this->output;
    }
    /**
     * Returns name of backup file
     *
     */
    public function getBackupFile() {
        if ($this->gzipBackupFile) {
            return $this->backupDir.'/'.$this->backupFile.'.gz';
        } else
        return $this->backupDir.'/'.$this->backupFile;
    }

    /**
     * Returns backup directory path
     *
     */
    public function getBackupDir() {
        return $this->backupDir;
    }

    /**
     * Returns array of changed tables since duration
     *
     */
    public function getChangedTables($since = '1 day') {
        $query = "SELECT TABLE_NAME,update_time FROM information_schema.tables WHERE table_schema='" . $this->dbName . "'";

        $result = mysqli_query($this->conn, $query);
        while($row=mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
            }		
        if(empty($resultset))
            return false;
        $tables = [];
        for ($i=0; $i < count($resultset); $i++) {
            if( in_array($resultset[$i]['TABLE_NAME'], $this->ignoreTables) ) // ignore this table
                continue;
            if(strtotime('-' . $since) < strtotime($resultset[$i]['update_time']))
                $tables[] = $resultset[$i]['TABLE_NAME'];
        }
        return ($tables) ? $tables : false;
    }

    private function setFileName($tables, $cron = false)
    {
        if ($tables == '*') {
            $tables = 'all';
        }

        if ($cron) {
            $name = 'db_backup_' . date('y_m_d') . '.sql';
        } else {
            $name = 'db_backup_' . $tables . '_' . date('y_m_d') . '.sql';
        }

        $this->backupFile = $name;
        return $this;
    }

    public static function backupDB($tables = '*', $cron = false)
    {
        try {
            $class = new BackupService();
            $class->setFileName($tables, $cron);
            $backup = $class->backupTables($tables) ? 'OK' : 'KO';
            error_reporting(E_ALL);
            set_time_limit(900); // 15 minutes
            if (php_sapi_name() != "cli") {
                echo '<div style="font-family: monospace;">';
            }
    
            $class->obfPrint('Backup result: ' . $backup, 1);
    
            // Use $output variable for further processing, for example to send it by email
            // $output = $class->getOutput();
    
            if (php_sapi_name() != "cli") {
                echo '</div>';
            }
        } catch (\Throwable $th) {
            logger($th);
        }
    }

    public static function getFileForCms($file)
    {
        Storage::download('backups/' . $file);
    }

    public static function saveFileForCms($file, $content)
    {
        Storage::append('backups/' . $file, $content);
    }
}