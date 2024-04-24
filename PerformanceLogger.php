<?php
declare(strict_types=1); //Mantenha se for útil

class PerformanceLogger {
    private static ?float $ultimaVez = null;
    private static array $logs = [];
    private static int $contadorConsulta = 0;  // Contador para o número de consultas SQL

    /**
     * Registra o tempo e o uso de memória entre chamadas e grava no log.
     *
     * @param string $descricao Descrição ou identificador da marcação.
     * @param bool $flush Força o flush do buffer de logs para o arquivo.
     */
    public static function logTime(string $descricao, bool $flush = false): void {
        $tempoAtual = microtime(true);

        if (self::$ultimaVez !== null) {
            $decorrido = $tempoAtual - self::$ultimaVez;
            $descricao .= " - Tempo gasto: " . sprintf("%.4f", $decorrido) . " segundos";
        }
        self::$ultimaVez = $tempoAtual;

        $memoriaAtual = memory_get_usage() / 1024; // Em KB
        $memoriaPico = memory_get_peak_usage() / 1024; // Em KB
        $usoMemoria = sprintf(
            " - Memória usada: %.3f KB, Pico de uso: %.3f KB", 
            $memoriaAtual, $memoriaPico
        );

        $logFormatado = "Descrição: $descricao" . $usoMemoria . " - Consultas SQL executadas: " . self::$contadorConsulta . "\n";
        self::$logs[] = $logFormatado;

        if ($flush || count(self::$logs) >= 5) { //Salva os logs no arquivo de log somente se essa função, neste caso, registrar 5 ou mais (>=) logs. Este valor pode ser alterado, conforme necessário.
            file_put_contents("performance_log.txt", implode('', self::$logs), FILE_APPEND);
            self::$logs = []; // Limpa o buffer após escrever
        }
    }

    /**
     * Incrementa o contador de consultas SQL.
     */
    public static function incrementQueryCount(): void {
        self::$contadorConsulta++;
    }
}

register_shutdown_function(function () {
    if (!empty(PerformanceLogger::$logs)) {
        file_put_contents("performance_log.txt", implode('', PerformanceLogger::$logs), FILE_APPEND); //Nome do arquivo que receberá os logs.
    }
});
?>
