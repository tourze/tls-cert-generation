<?php

declare(strict_types=1);

namespace Tourze\TLSCertGeneration\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use Tourze\TLSCertGeneration\Exception\CertificateGenerationException;

/**
 * @internal
 */
#[CoversClass(CertificateGenerationException::class)]
final class CertificateGenerationExceptionTest extends AbstractExceptionTestCase
{
    public function testIsException(): void
    {
        $exception = new CertificateGenerationException();

        $this->assertInstanceOf(\Exception::class, $exception);
    }

    public function testCanBeCreatedWithMessage(): void
    {
        $message = 'Certificate generation failed';
        $exception = new CertificateGenerationException($message);

        $this->assertSame($message, $exception->getMessage());
    }

    public function testCanBeCreatedWithMessageAndCode(): void
    {
        $message = 'Certificate generation failed';
        $code = 100;
        $exception = new CertificateGenerationException($message, $code);

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
    }

    public function testCanBeCreatedWithPreviousException(): void
    {
        $previous = new \Exception('Previous error');
        $exception = new CertificateGenerationException('Certificate error', 0, $previous);

        $this->assertSame($previous, $exception->getPrevious());
    }
}
