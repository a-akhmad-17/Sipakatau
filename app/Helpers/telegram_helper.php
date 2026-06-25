<?php

if (!function_exists('telegram_send_message')) {
    /**
     * Kirim pesan teks ke grup/channel Telegram.
     *
     * @param string $message Pesan yang akan dikirim (format HTML didukung)
     * @return bool
     */
    function telegram_send_message(string $message): bool
    {
        $token = env('telegram.botToken') ?? env('TELEGRAM_BOT_TOKEN');
        $chatId = env('telegram.chatId') ?? env('TELEGRAM_CHAT_ID');

        if (empty($token) || empty($chatId)) {
            // Jika token/chatId tidak diisi, catat ke log CodeIgniter saja
            log_message('warning', 'Telegram Helper: Token atau Chat ID belum dikonfigurasi di .env');
            return false;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $data = [
            'chat_id'    => $chatId,
            'text'       => $message,
            'parse_mode' => 'HTML',
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err) {
                log_message('error', 'Telegram Helper Curl Error: ' . $err);
                return false;
            }

            $result = json_decode($response, true);
            if (isset($result['ok']) && $result['ok'] === true) {
                return true;
            }

            log_message('error', 'Telegram Helper API Error: ' . ($result['description'] ?? 'Unknown error'));
            return false;
        } catch (\Throwable $e) {
            log_message('error', 'Telegram Helper Exception: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('telegram_send_error')) {
    /**
     * Format dan kirim log kesalahan sistem (Throwable/Exception) ke Telegram.
     *
     * @param \Throwable $exception Objek exception/error
     * @return bool
     */
    function telegram_send_error(\Throwable $exception): bool
    {
        $env = env('CI_ENVIRONMENT') ?? 'production';
        $request = \Config\Services::request();
        $uri = $request->getUri() ? $request->getUri()->getPath() : 'CLI/Unknown';
        
        $message = "🚨 <b>SYSTEM ERROR DETECTED [SIPAKATAU]</b>\n";
        $message .= "------------------------------------------------\n";
        $message .= "<b>Env:</b> <code>{$env}</code>\n";
        $message .= "<b>URI:</b> <code>/{$uri}</code>\n";
        $message .= "<b>Exception:</b> <code>" . get_class($exception) . "</code>\n";
        $message .= "<b>Message:</b> <code>" . htmlspecialchars($exception->getMessage()) . "</code>\n";
        $message .= "<b>File:</b> <code>" . basename($exception->getFile()) . "</code>\n";
        $message .= "<b>Line:</b> <code>" . $exception->getLine() . "</code>\n";
        $message .= "------------------------------------------------\n";
        $message .= "<b>Stack Trace (Truncated):</b>\n";
        $message .= "<pre>" . htmlspecialchars(substr($exception->getTraceAsString(), 0, 500)) . "...</pre>";

        return telegram_send_message($message);
    }
}

if (!function_exists('telegram_send_transaction')) {
    /**
     * Kirim notifikasi log transaksi penting (misal: Pendaftaran Ormas baru).
     *
     * @param string $title Judul log transaksi
     * @param array $details Detail transaksi berupa key-value
     * @return bool
     */
    function telegram_send_transaction(string $title, array $details): bool
    {
        $message = "🔔 <b>SIPAKATAU TRANSACTION NOTIFICATION</b>\n";
        $message .= "<b>{$title}</b>\n";
        $message .= "------------------------------------------------\n";
        foreach ($details as $key => $value) {
            $message .= "• <b>{$key}:</b> {$value}\n";
        }
        $message .= "------------------------------------------------\n";
        $message .= "Tanggal: " . date('Y-m-d H:i:s');

        return telegram_send_message($message);
    }
}
