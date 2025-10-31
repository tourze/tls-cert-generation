<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPairGenerator;

// 本示例展示如何创建CA证书并使用CA签发证书
try {
    // 1. 生成CA密钥对（此实现尚未完成）
    // $keyPairGenerator = new KeyPairGenerator();
    // $caKeyPair = $keyPairGenerator->generateRSA(4096);

    // 暂时注释掉，等待实际实现
    echo "此示例需要实现密钥对生成和证书生成功能\n";
    echo "目前这些功能尚未实现，请等待后续更新\n";

    // 2. 设置CA证书主题信息
    $caSubjectData = [
        'CN' => 'Example Root CA',
        'O' => 'Example Certificate Authority',
        'OU' => 'Certificate Management',
        'C' => 'US',
    ];

    // 3. 设置有效期（CA证书通常有较长的有效期）
    $notBefore = new DateTimeImmutable();
    $notAfter = $notBefore->modify('+10 years');

    // 4. 设置CA证书扩展
    $caExtensions = [
        'basicConstraints' => ['CA' => true, 'pathLength' => 3],
        'keyUsage' => ['keyCertSign', 'cRLSign'],
        'subjectKeyIdentifier' => 'hash',
    ];

    // 5. 创建根CA
    // $ca = CertificateAuthority::createRootCA($caKeyPair, $caSubjectData, $notBefore, $notAfter, $caExtensions);

    // 6. 输出CA证书
    // echo "CA证书:\n";
    // echo $ca->getCertificate()->toPEM();

    // 7. 使用CA签发服务器证书 - 先生成CSR
    // $serverKeyPair = $keyPairGenerator->generateRSA(2048);
    // $csrGenerator = new CSRGenerator();
    // $serverSubjectData = [
    //     'CN' => 'api.example.com',
    //     'O' => 'Example Corp',
    //     'C' => 'US'
    // ];
    // $csr = $csrGenerator->createCSR($serverKeyPair, $serverSubjectData);

    // 8. 设置服务器证书扩展
    // $serverExtensions = [
    //     'basicConstraints' => ['CA' => false],
    //     'keyUsage' => ['digitalSignature', 'keyEncipherment'],
    //     'extendedKeyUsage' => ['serverAuth'],
    //     'subjectAltName' => ['DNS:api.example.com', 'DNS:api-backup.example.com']
    // ];

    // 9. 签发服务器证书
    // $serverCertificate = $ca->issueCertificate(
    //     $csr,
    //     new \DateTimeImmutable(),
    //     (new \DateTimeImmutable())->modify('+1 year'),
    //     $serverExtensions
    // );

    // 10. 输出服务器证书
    // echo "\n服务器证书:\n";
    // echo $serverCertificate->toPEM();
} catch (Throwable $e) {
    echo '错误: ' . $e->getMessage() . "\n";
}
