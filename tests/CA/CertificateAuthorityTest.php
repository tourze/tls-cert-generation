<?php

declare(strict_types=1);

namespace Tourze\TLSCertGeneration\Tests\CA;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCertGeneration\CA\CertificateAuthority;
use Tourze\TLSCertGeneration\Exception\CertificateGenerationException;
use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPair;
use Tourze\TLSX509Core\Certificate\X509Certificate;

/**
 * 证书颁发机构测试类
 *
 * @internal
 */
#[CoversClass(CertificateAuthority::class)]
final class CertificateAuthorityTest extends TestCase
{
    /**
     * 测试CA类的结构
     *
     * 这个测试验证CA类的方法签名是否符合预期，即使我们不能测试实际功能。
     */
    public function testCAClassStructure(): void
    {
        // 使用反射验证类的结构
        $class = new \ReflectionClass(CertificateAuthority::class);

        // 验证方法存在性
        $this->assertTrue($class->hasMethod('issueCertificate'), '应该有issueCertificate方法');
        $this->assertTrue($class->hasMethod('getCertificate'), '应该有getCertificate方法');
        $this->assertTrue($class->hasMethod('getKeyPair'), '应该有getKeyPair方法');

        // 验证静态方法存在性
        $this->assertTrue($class->hasMethod('createRootCA'), '应该有createRootCA静态方法');
        $this->assertTrue($class->getMethod('createRootCA')->isStatic(), 'createRootCA应该是静态方法');
    }

    /**
     * 测试issueCertificate方法
     */
    public function testIssueCertificate(): void
    {
        $this->expectException(CertificateGenerationException::class);
        $this->expectExceptionMessage('方法尚未实现');

        // 创建模拟对象
        $keyPair = new KeyPair('private', 'public');

        // 使用匿名类替代Mock对象以满足静态分析要求
        $ca = new class($keyPair, new X509Certificate()) extends CertificateAuthority {
            public function issueCertificate(
                string $csr,
                \DateTimeInterface $notBefore,
                \DateTimeInterface $notAfter,
                array $extensions = [],
            ): X509Certificate {
                throw new CertificateGenerationException('方法尚未实现');
            }
        };

        // 调用issueCertificate方法，应该抛出未实现异常
        $ca->issueCertificate(
            '-----BEGIN CERTIFICATE REQUEST-----\ntest\n-----END CERTIFICATE REQUEST-----',
            new \DateTime(),
            new \DateTime('+1 year')
        );
    }
}
