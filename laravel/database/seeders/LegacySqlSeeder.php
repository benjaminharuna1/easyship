<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

abstract class LegacySqlSeeder extends Seeder
{
    /**
     * Subclasses provide a map of legacy table => Laravel column mapping
     * (dest column => source column). Source "__NOW__" uses the current time.
     */
    abstract protected function tables(): array;

    public function run(): void
    {
        $path = database_path('legacy/exprkfmf_easyship.sql');
        if (!is_file($path) && is_file(base_path('exprkfmf_easyship.sql'))) {
            $path = base_path('exprkfmf_easyship.sql');
        }

        if (!is_file($path)) {
            $this->command?->error("Legacy SQL file not found. Expected at: {$path}");
            return;
        }

        $content = file_get_contents($path);

        foreach ($this->tables() as $table => $columnMap) {
            $parsed = $this->extractInsert($content, $table);

            if ($parsed === null) {
                $this->command?->warn("No data found for table: {$table}");
                continue;
            }

            [$columns, $rows] = $parsed;

            $insertRows = [];
            foreach ($rows as $row) {
                $src = array_combine($columns, $row);
                $target = [];
                foreach ($columnMap as $destCol => $srcCol) {
                    if (is_string($srcCol) && str_starts_with($srcCol, '::LIT::')) {
                        $value = substr($srcCol, strlen('::LIT::'));
                    } elseif ($srcCol === '__NOW__') {
                        $value = Carbon::now();
                    } else {
                        $value = $src[$srcCol] ?? null;
                    }
                    $target[$destCol] = $value;
                }
                $insertRows[] = $target;
            }

            DB::table($table)->delete();
            DB::table($table)->insert($insertRows);

            $this->command?->info("Imported legacy data into: {$table} (" . count($insertRows) . " rows)");
        }
    }

    /**
     * Extract and parse the INSERT INTO `$table` ... VALUES ...;
     * Returns [columns, rows] or null when the table has no data.
     */
    protected function extractInsert(string $content, string $table): ?array
    {
        $needle = "INSERT INTO `{$table}`";

        $start = strpos($content, $needle);
        if ($start === false) {
            return null;
        }

        $open = strpos($content, '(', $start + strlen($needle));
        if ($open === false) {
            return null;
        }

        $valuesPos = strpos($content, 'VALUES', $open);
        if ($valuesPos === false) {
            return null;
        }

        $closeCol = strpos($content, ')', $open);
        $columnsText = substr($content, $open + 1, $closeCol - $open - 1);

        preg_match_all('/`([^`]+)`/', $columnsText, $m);
        $columns = $m[1];

        $valuesText = substr($content, $valuesPos + strlen('VALUES'));

        return [$columns, $this->parseRows($valuesText)];
    }

    protected function parseRows(string $values): array
    {
        $rows = [];
        $len = strlen($values);
        $i = 0;

        while ($i < $len) {
            while ($i < $len && (ctype_space($values[$i]) || $values[$i] === ',')) {
                $i++;
            }
            if ($i >= $len || $values[$i] !== '(') {
                break;
            }

            $i++;
            $fields = [];

            while ($i < $len) {
                while ($i < $len && (ctype_space($values[$i]) || $values[$i] === ',')) {
                    $i++;
                }
                if ($i >= $len || $values[$i] === ')') {
                    break;
                }
                $fields[] = $this->parseValue($values, $i);
            }

            $i++;
            $rows[] = $fields;
        }

        return $rows;
    }

    protected function parseValue(string $s, int &$i): ?string
    {
        $len = strlen($s);

        if ($s[$i] === "'") {
            $i++;
            $out = '';
            while ($i < $len) {
                $ch = $s[$i];
                if ($ch === '\\' && $i + 1 < $len) {
                    $out .= $s[$i + 1];
                    $i += 2;
                    continue;
                }
                if ($ch === "'") {
                    if ($i + 1 < $len && $s[$i + 1] === "'") {
                        $out .= "'";
                        $i += 2;
                        continue;
                    }
                    $i++;
                    break;
                }
                $out .= $ch;
                $i++;
            }
            return $out;
        }

        $start = $i;
        while ($i < $len && $s[$i] !== ',' && $s[$i] !== ')') {
            $i++;
        }

        $value = trim(substr($s, $start, $i - $start));

        return (strtoupper($value) === 'NULL' || $value === '') ? null : $value;
    }
}
