<?php

declare(strict_types=1);

namespace Tourze\TLSCertGeneration\Tests\CSR;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\TLSCertGeneration\CSR\CSRGenerator;
use Tourze\TLSCertGeneration\Exception\CertificateGenerationException;
use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPair;

/**
 * CSR生成器测试类
 *
 * @internal
 */
#[CoversClass(CSRGenerator::class)]
final class CSRGeneratorTest extends TestCase
{
    /**
     * 测试实例化
     */
    public function testInstantiation(): void
    {
        $generator = new CSRGenerator();
        $this->assertInstanceOf(CSRGenerator::class, $generator);
    }

    /**
     * 测试createCSR方法
     */
    public function testCreateCSR(): void
    {
        $this->expectException(CertificateGenerationException::class);
        $this->expectExceptionMessage('方法尚未实现');

        $generator = new CSRGenerator();
        $keyPair = new KeyPair('private', 'public');

        $generator->createCSR(
            $keyPair,
            ['CN' => 'example.com', 'O' => 'Test Organization']
        );
    }

    /**
     * 测试从CSR提取主题信息 - 异常处理
     */
    public function testExtractSubject(): void
    {
        $this->expectException(CertificateGenerationException::class);
        $this->expectExceptionMessage('方法尚未实现');

        $csr = '-----BEGIN CERTIFICATE REQUEST-----\nMIICXTCCAUUCAQAwGDEWMBQGA1UEAwwNZXhhbXBsZS5sb2NhbDCCASIwDQYJKoZI\nhvcNAQEBBQADggEPADCCAQoCggEBALyIAYL/D2yjQnN33lI/LWn9jA9TYfoJ+Y3X\n-----END CERTIFICATE REQUEST-----';

        $generator = new CSRGenerator();
        $generator->extractSubject($csr);
    }

    /**
     * 测试验证CSR签名 - 异常处理
     */
    public function testVerifyCSRSignature(): void
    {
        $this->expectException(CertificateGenerationException::class);
        $this->expectExceptionMessage('方法尚未实现');

        $csr = '-----BEGIN CERTIFICATE REQUEST-----\nMIICXTCCAUUCAQAwGDEWMBQGA1UEAwwNZXhhbXBsZS5sb2NhbDCCASIwDQYJKoZI\nhvcNAQEBBQADggEPADCCAQoCggEBALyIAYL/D2yjQnN33lI/LWn9jA9TYfoJ+Y3X\n-----END CERTIFICATE REQUEST-----';

        $generator = new CSRGenerator();
        $generator->verifyCSRSignature($csr);
    }

    /**
     * 测试无效CSR格式
     */
    public function testInvalidCSRFormat(): void
    {
        $this->expectException(CertificateGenerationException::class);

        $invalidCsr = 'NOT A VALID CSR FORMAT';

        $generator = new CSRGenerator();
        $generator->extractSubject($invalidCsr);
    }
}
