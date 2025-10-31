<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPairGenerator;

// 本示例展示如何创建自签名证书
try {
    // 1. 生成密钥对（此实现尚未完成）
    // $keyPairGenerator = new KeyPairGenerator();
    // $keyPair = $keyPairGenerator->generateRSA(2048);

    // 暂时注释掉，等待实际实现
    echo "此示例需要实现密钥对生成和证书生成功能\n";
    echo "目前这些功能尚未实现，请等待后续更新\n";

    // 2. 设置主题信息
    $subjectData = [
        'CN' => 'example.com',
        'O' => 'Example Organization',
        'OU' => 'IT Department',
        'C' => 'US',
        'ST' => 'California',
        'L' => 'San Francisco',
    ];

    // 3. 设置有效期
    $notBefore = new DateTimeImmutable();
    $notAfter = $notBefore->modify('+1 year');

    // 4. 设置证书扩展
    $extensions = [
        'basicConstraints' => ['CA' => false],
        'keyUsage' => ['digitalSignature', 'keyEncipherment'],
        'extendedKeyUsage' => ['serverAuth', 'clientAuth'],
        'subjectAltName' => ['DNS:example.com', 'DNS:www.example.com'],
    ];

    // 5. 创建自签名证书
    // $generator = new CertificateGenerator();
    // $certificate = $generator->createSelfSigned($keyPair, $subjectData, $notBefore, $notAfter, $extensions);

    // 6. 输出PEM格式证书
    // echo $certificate->toPEM();
} catch (Throwable $e) {
    echo '错误: ' . $e->getMessage() . "\n";
}
