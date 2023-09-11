<?php
/**
 * Description of Module Model - AdminScheduler:
 *
 * This model was created for module: Admin
 * @author MiroJi
 * Created_at: 1694243205
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

use App\Core\DI\DIContainer;
use ZipArchive;

/**
*   Using main module Model
*/
use App\Modules\AdminModule\Model\Admin;

class AdminScheduler extends Admin
{
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
    }

    public function backupLogs(bool $force_backup = false)
    {
        $support_file = __DIR__."/../resources/support_files/scheduler_archive_logs";

        if($force_backup == false)
        {
            if(!file_exists($support_file))
            {
                $file = fopen($support_file, "w+");
                fwrite($file, strval(time()));
                fclose($file);
            }

            $scheduler_time = env("backup_log_days", false);            //from .env
            $get_support_file_content = file_get_contents($support_file);

            $get_datetime_from_support = DATE("d.m.Y H:i:s", intval($get_support_file_content));  // 20.9.2023 15:56:32

            $timestamp_log_day = strtotime($get_datetime_from_support. ' + '.$scheduler_time.' days');
            $get_log_datetime = date('d.m.Y H:i:s', $timestamp_log_day);

            if(time() >= $timestamp_log_day)
            {
                $this->scheduleBackupLogs($force_backup);
            }
        }
        else
        {
            $this->scheduleBackupLogs($force_backup);
        }
    }

    public function getSchedulerLogData(): Array
    {
        $log_history_lines = file(__DIR__."/../resources/support_files/log_history.log");

        $lines_reverse = array_reverse($log_history_lines);
        $last_log_line = $lines_reverse[0];

        $explode_line = explode(" Created", $last_log_line);
        $remove_brackets = str_replace(["[", "]"], "", $explode_line[0]);
        $strtotime = strtotime($remove_brackets);

        $log_history_string = "";
        //lines to string
        foreach ($lines_reverse as $line)
        {
            $explode_single_line = explode(" Created", $line);
            $remove_brackets_line = str_replace(["[", "]"], "", $explode_single_line[0]);
            $strtotime_line = strtotime($remove_brackets_line);
            $log_archive = "logs_".DATE("d_m_Y_H_i", intval($strtotime_line)).".zip";

            if(str_contains($line, "FORCE"))
            {
                $strategy = "<span class='t-warning'>FORCE</span>";
            }
            else
            {
                $strategy = "<span class='t-success'>SCHEDULE</span>";
            }


            $log_history_string .= "<div class='column-6 pd-1'>[$remove_brackets_line]-Created $strategy archive </div><div class='column-4 pd-1 content-right'><a class='t-info' href='./log/archives/$log_archive'>$log_archive</a></div>";

        }

        $future = intval(file_get_contents(__DIR__."/../resources/support_files/scheduler_archive_logs"));
        $timefromdb = time();
        $timeleft = $future-$timefromdb;
        $remaing_days = round((($timeleft/24)/60)/60); 

        return [
            "DAYS_REMAINING" => $remaing_days,
            "LAST_LOG_DATE" => $remove_brackets,
            "LAST_LOG_FILE" => "logs_".DATE("d_m_Y_H_i", intval($strtotime)).".zip",
            "LOG_HISTORY" => $log_history_string,
            "LOG_NEXT_ARCHIVATION_TIMESTAMP" => intval(file_get_contents(__DIR__."/../resources/support_files/scheduler_archive_logs")),
            "LOG_NEXT_ARCHIVATION_DATE" => DATE("d.m.Y H:i:s", intval(file_get_contents(__DIR__."/../resources/support_files/scheduler_archive_logs"))),
        ];
    }


    private function scheduleBackupLogs(bool $force_log = false)
    {
        $zipFileName = './log/archives/logs_'.DATE("d_m_Y_H_i").'.zip';

         // Adresář s logy
        $logDirectory = './log/';

        // Inicializace ZipArchive
        $zip = new ZipArchive();

        // Otevření zip souboru pro zápis
        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            // Funkce pro rekurzivní procházení adresáře a přidání souborů do zipu
            function addFilesToZip($dir, $zip, $exclude = array()) {
                $files = scandir($dir);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..' && !in_array($file, $exclude)) {
                        $filePath = $dir . $file;
                        if (is_dir($filePath)) {
                            // Pokud je to složka, rekurzivně ji projdeme
                            addFilesToZip($filePath . '/', $zip, $exclude);
                        } else {
                            // Pokud je to soubor, přidáme ho do zipu
                            $zip->addFile($filePath, str_replace($dir, '', $filePath));
                        }
                    }
                }
            }

            // Seznam souborů/složek, které chceme vyloučit z zipu
            $excludeFiles = array('archives', 'do-not-erase');

            // Přidání všech souborů a složek do zipu
            addFilesToZip($logDirectory, $zip, $excludeFiles);

            // Uzavření zip souboru
            $zip->close();

            // Smazání všech souborů s příponou .log v adresáři logs/
            foreach (glob($logDirectory . '*.log') as $logFile) {
                unlink($logFile);
            }


            //update support file
            $file_support = fopen(__DIR__."/../resources/support_files/scheduler_archive_logs", "w"); 
            $get_now_date = DATE("d.m.Y H:i:s", time());  // 20.9.2023 15:56:32
            $scheduler_time = env("backup_log_days", false);            //from .env
            $timestamp_next_log_day = strtotime($get_now_date. ' + '.$scheduler_time.' days');
            fwrite($file_support, strval($timestamp_next_log_day));

            //update log history
            $file = fopen(__DIR__."/../resources/support_files/log_history.log", "a+");
            if($force_log == false)
            {
                fwrite($file, "[".DATE("d.m.Y H:i:s")."] Created SCHEDULER log archive \"$zipFileName\" \n");
            }
            else
            {
                fwrite($file, "[".DATE("d.m.Y H:i:s")."] Created FORCE log archive \"$zipFileName\" by: ".$this->auth->user_name. "\n");
            }
           
            
            fclose($file);
        } else {
            echo 'Nepodařilo se otevřít zip soubor pro zápis.';
        }
        

        
    }

} 

