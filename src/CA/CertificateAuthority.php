<?php

declare(strict_types=1);

namespace Tourze\TLSCertGeneration\CA;

use Tourze\TLSCertGeneration\Exception\CertificateGenerationException;
use Tourze\TLSCertGeneration\Generator\CertificateGenerator;
use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPair;
use Tourze\TLSX509Core\Certificate\X509Certificate;

/**
 * 证书颁发机构(CA) - 管理CA并签发证书
 */
class CertificateAuthority
{
    /**
     * @var CertificateGenerator 证书生成器
     */
    private CertificateGenerator $certificateGenerator;

    /**
     * 构造函数
     *
     * @param KeyPair                   $keyPair              CA密钥对
     * @param X509Certificate           $certificate          CA证书
     * @param CertificateGenerator|null $certificateGenerator 可选的证书生成器
     */
    public function __construct(
        private readonly KeyPair $keyPair,
        private readonly X509Certificate $certificate,
        ?CertificateGenerator $certificateGenerator = null,
    ) {
        $this->certificateGenerator = $certificateGenerator ?? new CertificateGenerator();
    }

    /**
     * 从CSR签发证书
     *
     * @param string             $csr        PEM格式的CSR
     * @param \DateTimeInterface $notBefore  证书有效期开始时间
     * @param \DateTimeInterface $notAfter   证书有效期结束时间
     * @param array<string, mixed> $extensions 可选的证书扩展
     *
     * @return X509Certificate 签发的证书
     *
     * @throws CertificateGenerationException 如果签发失败
     */
    public function issueCertificate(
        string $csr,
        \DateTimeInterface $notBefore,
        \DateTimeInterface $notAfter,
        /** @param array<string, mixed> $extensions */
        array $extensions = [],
    ): X509Certificate {
        return $this->certificateGenerator->createFromCSR(
            $csr,
            $this->keyPair,
            $this->certificate,
            $notBefore,
            $notAfter,
            $extensions
        );
    }

    /**
     * 创建自签名根CA证书
     *
     * @param KeyPair            $keyPair     密钥对
     * @param array<string, string> $subjectData 主题信息数组
     * @param \DateTimeInterface $notBefore   证书有效期开始时间
     * @param \DateTimeInterface $notAfter    证书有效期结束时间
     * @param array<string, mixed> $extensions  可选的证书扩展
     *
     * @return CertificateAuthority 创建的CA对象
     *
     * @throws CertificateGenerationException 如果生成失败
     */
    public static function createRootCA(
        KeyPair $keyPair,
        /** @param array<string, string> $subjectData */
        array $subjectData,
        \DateTimeInterface $notBefore,
        \DateTimeInterface $notAfter,
        /** @param array<string, mixed> $extensions */
        array $extensions = [],
    ): self {
        $generator = new CertificateGenerator();

        // 确保扩展包含CA标志
        $extensions['basicConstraints'] ??= ['CA' => true];

        $rootCert = $generator->createSelfSigned(
            $keyPair,
            $subjectData,
            $notBefore,
            $notAfter,
            $extensions
        );

        return new self($keyPair, $rootCert, $generator);
    }

    /**
     * 获取CA证书
     */
    public function getCertificate(): X509Certificate
    {
        return $this->certificate;
    }

    /**
     * 获取CA密钥对
     */
    public function getKeyPair(): KeyPair
    {
        return $this->keyPair;
    }
}
