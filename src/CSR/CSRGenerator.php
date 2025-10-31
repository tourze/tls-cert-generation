<?php

declare(strict_types=1);

namespace Tourze\TLSCertGeneration\CSR;

use Tourze\TLSCertGeneration\Exception\CertificateGenerationException;
use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPair;

/**
 * CSR生成器 - 创建证书签名请求
 */
class CSRGenerator
{
    /**
     * 创建CSR
     *
     * @param KeyPair $keyPair     密钥对
     * @param array<string, string> $subjectData 主题信息数组，包含常见的DN字段(CN,O,OU等)
     * @param array<string, mixed> $extensions  可选的CSR扩展请求
     *
     * @return string PEM格式的CSR
     *
     * @throws CertificateGenerationException 如果CSR生成失败
     */
    public function createCSR(
        KeyPair $keyPair,
        array $subjectData,
        array $extensions = [],
    ): string {
        // 实现CSR生成逻辑
        // 暂留空实现，等待实际代码
        throw new CertificateGenerationException('方法尚未实现');
    }

    /**
     * 从CSR中提取主题信息
     *
     * @param string $csr PEM格式的CSR
     *
     * @return array<string, string> 主题信息数组
     *
     * @throws CertificateGenerationException 如果CSR解析失败
     */
    public function extractSubject(string $csr): array
    {
        // 验证CSR格式
        $this->validateCSRFormat($csr);

        // 实现从CSR提取主题信息的逻辑
        // 暂留空实现，等待实际代码
        throw new CertificateGenerationException('方法尚未实现');
    }

    /**
     * 验证CSR签名
     *
     * @param string $csr PEM格式的CSR
     *
     * @return bool 签名有效返回true，否则返回false
     *
     * @throws CertificateGenerationException 如果CSR解析失败
     */
    public function verifyCSRSignature(string $csr): bool
    {
        // 验证CSR格式
        $this->validateCSRFormat($csr);

        // 实现CSR签名验证逻辑
        // 暂留空实现，等待实际代码
        throw new CertificateGenerationException('方法尚未实现');
    }

    /**
     * 验证CSR格式
     *
     * @param string $csr PEM格式的CSR
     *
     * @throws CertificateGenerationException 如果CSR格式无效
     */
    private function validateCSRFormat(string $csr): void
    {
        if (!str_starts_with(trim($csr), '-----BEGIN CERTIFICATE REQUEST-----')) {
            throw new CertificateGenerationException('无效的CSR格式：缺少CSR头部');
        }

        if (!str_contains($csr, '-----END CERTIFICATE REQUEST-----')) {
            throw new CertificateGenerationException('无效的CSR格式：缺少CSR尾部');
        }
    }
}
