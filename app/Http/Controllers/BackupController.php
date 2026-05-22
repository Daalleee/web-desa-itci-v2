<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    public function index()
    {
        return view('backup.index');
    }

    public function download()
    {
        LogAktivitas::catat("Melakukan backup database manual");

        $callback = function() {
            $tables = [];
            // Query untuk mendapatkan semua tabel di database saat ini
            $results = DB::select('SHOW TABLES');
            $dbNameKey = 'Tables_in_' . config('database.connections.mysql.database');

            foreach ($results as $row) {
                $tables[] = $row->$dbNameKey;
            }

            $out = fopen('php://output', 'w');
            
            fwrite($out, "-- Backup Database Desa ITCI\n");
            fwrite($out, "-- Tanggal: " . date('Y-m-d H:i:s') . "\n\n");
            fwrite($out, "SET FOREIGN_KEY_CHECKS=0;\n\n");

            foreach ($tables as $table) {
                // Jangan mem-backup data cache atau sessions jika terlalu besar
                if (in_array($table, ['sessions', 'cache', 'cache_locks'])) {
                    continue;
                }

                // Dapatkan skema pembuatan tabel
                $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
                $createTableKey = 'Create Table';
                $sqlCreate = $createTable[0]->$createTableKey;

                fwrite($out, "-- -----------------------------------------------------\n");
                fwrite($out, "-- Struktur tabel `{$table}`\n");
                fwrite($out, "-- -----------------------------------------------------\n");
                fwrite($out, "DROP TABLE IF EXISTS `{$table}`;\n");
                fwrite($out, $sqlCreate . ";\n\n");

                // Ambil semua data tabel
                $rows = DB::table($table)->get();
                if ($rows->count() > 0) {
                    fwrite($out, "-- Data untuk tabel `{$table}`\n");
                    foreach ($rows as $row) {
                        $arrayRow = (array)$row;
                        $keys = array_keys($arrayRow);
                        $escapedKeys = array_map(fn($k) => "`{$k}`", $keys);
                        
                        $values = array_values($arrayRow);
                        $escapedValues = array_map(function($v) {
                            if (is_null($v)) return 'NULL';
                            return "'" . addslashes($v) . "'";
                        }, $values);

                        $insertSql = "INSERT INTO `{$table}` (" . implode(', ', $escapedKeys) . ") VALUES (" . implode(', ', $escapedValues) . ");\n";
                        fwrite($out, $insertSql);
                    }
                    fwrite($out, "\n");
                }
            }

            fwrite($out, "SET FOREIGN_KEY_CHECKS=1;\n");
            fclose($out);
        };

        $filename = 'backup_desa_itci_' . date('Ymd_His') . '.sql';

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
