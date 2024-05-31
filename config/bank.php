<?php

return [
  'inter' => [
      'base_url' => 'https://cdpj.partners.bancointer.com.br/',
      'client_id' => env('INTER_CLIENT_ID'),
      'client_secret' => env('INTER_CLIENT_SECRET'),
      'certificate' => 'bank_certificate/inter_api_certificado.crt',
      'key' => 'bank_certificate/inter_api_chave.key',
  ]
];
