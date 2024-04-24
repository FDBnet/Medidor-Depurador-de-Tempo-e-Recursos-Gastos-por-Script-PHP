# Medidor (Depurador) de Tempo e Recursos Gastos em PHP
Uma função em PHP (8.1) que serve como Medidor (Depurador) do Tempo (em segundos) e Recursos (Memória [KB] e consultas SQL) Gastos dentro de um Script. Essa função pode ser chamada várias vezes em um mesmo código para encontrar erros ou gargalos dentro de sua execução.

## Como funciona?

A função logTime() é uma ferramenta valiosa para monitorar o desempenho de um código PHP, medindo tempo de execução, uso de memória e outras métricas. A decisão de quando chamá-la depende da necessidade de uso pelo desenvolvedor. Aqui estão algumas dicas e exemplos de como e quando você pode chamá-la eficazmente:

### Quando Chamar a Função logTime()
**Antes e Depois de Blocos de Código Críticos**
*Ideal para seções de código que você suspeita que podem estar causando lentidão ou consumindo muitos recursos. Isso pode incluir operações pesadas de banco de dados, processamento de arquivos grandes, chamadas de API externas, ou qualquer operação intensiva em CPU ou memória.*

**Durante Eventos de Ciclo de Vida de Aplicativos**
*Em pontos específicos durante o ciclo de vida de uma requisição ou transação, como após a inicialização, antes e depois de operações de middleware, e antes de enviar a resposta ao cliente.*

**Em Tratadores de Eventos**
*Se seu aplicativo é orientado a eventos (por exemplo, em aplicações que usam sockets ou ouvintes de eventos), você pode inserir chamadas de log em tratadores de eventos para medir o impacto de cada evento processado.*

**Para Monitoramento de Saúde Periódico**
*Em sistemas com longos processos em execução ou serviços de fundo, você pode configurar um timer ou cron job para executar logTime() em intervalos regulares para obter um snapshot contínuo do estado do sistema.*

### Exemplos de Chamada da Função
*Suponha que você tenha um script PHP que processa dados de entrada e salva resultados em um banco de dados. Aqui estão exemplos de como usar logTime() para monitorar diferentes partes do script:*

```php
require_once 'PerformanceLogger.php'; //Chamar o arquivo onde está a função.
// Início do script
PerformanceLogger::logTime("Início do processamento", "Inicio"); //Primeira chamada obrigatória

if ($r1) {
    // Após receber dados e fazer alguma operação
    PerformanceLogger::logTime("Dados recebidos para processamento", "RecebimentoDados");

    // Continuação do código (por exemplo: após um INSERT em um banco de dados MySQL)...
    if ($resultado) {
        PerformanceLogger::logTime("Dados inseridos com sucesso", "InsercaoSucesso");
    } else {
        PerformanceLogger::logTime("Falha na inserção de dados", "FalhaInsercao");
    }
} else {
    PerformanceLogger::logTime("Falha ao processar dados iniciais", "FalhaProcessamentoInicial");
}

// Final do script
PerformanceLogger::logTime("Final do processamento", "Final", true); //Obrigatório! Forçar flush 
```
**Chamada da função um pouco mais explicada**
```php
PerformanceLogger::logTime("DESCRIÇÃO DO MOTIVO DO USO DA FUNÇÃO", "ALGUM IDENTIFICADOR");
```
