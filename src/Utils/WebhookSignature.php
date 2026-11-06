<?php

namespace Nelsius\Utils;

class WebhookSignature
{
    /**
     * Vérifie la validité d'une signature de Webhook Nelsius
     *
     * @param string $payload Le corps brut (raw body) de la requête JSON (ex: file_get_contents('php://input'))
     * @param string $signature La signature reçue dans le header X-Nelsius-Signature
     * @param string $secretKey Votre clé secrète de Webhook
     * @return bool
     */
    public static function verify(string $payload, string $signature, string $secretKey): bool
    {
        if (empty($payload) || empty($signature) || empty($secretKey)) {
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $payload, $secretKey);

        // Protection contre les attaques temporelles (timing attacks)
        return hash_equals($expectedSignature, $signature);
    }
}
