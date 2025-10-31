# TLS 证书生成

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/tls-cert-generation.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-cert-generation)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/tls-cert-generation.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-cert-generation)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%205-brightgreen.svg?style=flat-square)](https://phpstan.org/)
[![PHP Version](https://img.shields.io/badge/PHP-%5E8.1-blue.svg?style=flat-square)](https://php.net/)
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE)
[![Code Coverage](https://img.shields.io/badge/Coverage-100%25-brightgreen.svg?style=flat-square)](https://phpunit.de/)

## 目录

- [功能特性](#功能特性)
- [系统要求](#系统要求)
- [安装](#安装)
- [快速开始](#快速开始)
  - [创建自签名证书](#创建自签名证书)
  - [创建证书颁发机构](#创建证书颁发机构)
  - [生成 CSR](#生成-csr)
- [API 参考](#api-参考)
  - [CertificateGenerator](#certificategenerator)
  - [CertificateAuthority](#certificateauthority)
  - [CSRGenerator](#csrgenerator)
- [开发状态](#开发状态)
- [贡献指南](#贡献指南)
- [许可证](#许可证)

一个用于 TLS/SSL 证书生成和管理的 PHP 库。该包提供了结构化的 API，用于创建自签名证书、管理证书颁发机构 (CA) 以及处理证书签名请求 (CSR)。

> **注意**：该包目前正在开发中。API 已完全设计完成，包含完整的类型定义和文档，但核心实现尚未完成。所有方法目前都会抛出 `CertificateGenerationException` 异常，消息为 "方法尚未实现"。

## 功能特性

- **自签名证书生成** - 创建自签名 X.509 证书
- **证书颁发机构 (CA) 管理** - 简单的 CA 创建和证书签发
- **证书签名请求 (CSR)** - 生成和处理 CSR 文件
- **证书续签** - 延长证书有效期
- **可扩展架构** - 支持自定义证书扩展
- **类型安全 API** - 完整的 PHP 8.1+ 类型声明

## 系统要求

- PHP 8.1 或更高版本
- 依赖包：
  - `tourze/tls-common`
  - `tourze/tls-crypto-asymmetric`
  - `tourze/tls-crypto-random`
  - `tourze/tls-x509-core`

## 安装

```bash
composer require tourze/tls-cert-generation
```

## 快速开始

> **重要说明**：以下示例展示了预期的 API 使用方式，但由于实现尚未完成，目前会抛出 `CertificateGenerationException` 异常。

### 创建自签名证书

```php
<?php

use Tourze\TLSCertGeneration\Generator\CertificateGenerator;
use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPair;

// 生成密钥对（实现待完成）
$keyPair = new KeyPair($privateKey, $publicKey);

// 设置证书主体信息
$subjectData = [
    'CN' => 'example.com',
    'O' => 'Example Organization',
    'OU' => 'IT Department',
    'C' => 'US',
];

// 设置有效期
$notBefore = new DateTimeImmutable();
$notAfter = $notBefore->modify('+1 year');

// 创建证书生成器
$generator = new CertificateGenerator();

// 生成自签名证书（实现完成前会抛出异常）
try {
    $certificate = $generator->createSelfSigned(
        $keyPair,
        $subjectData,
        $notBefore,
        $notAfter
    );
} catch (\Tourze\TLSCertGeneration\Exception\CertificateGenerationException $e) {
    echo "实现待完成：" . $e->getMessage();
}
```

### 创建证书颁发机构

```php
<?php

use Tourze\TLSCertGeneration\CA\CertificateAuthority;
use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPair;

// CA 主体信息
$caSubjectData = [
    'CN' => 'Example Root CA',
    'O' => 'Example Certificate Authority',
    'C' => 'US',
];

// CA 有效期（通常更长）
$notBefore = new DateTimeImmutable();
$notAfter = $notBefore->modify('+10 years');

// CA 扩展
$caExtensions = [
    'basicConstraints' => ['CA' => true, 'pathLength' => 3],
    'keyUsage' => ['keyCertSign', 'cRLSign'],
];

// 创建根 CA（实现完成前会抛出异常）
try {
    $ca = CertificateAuthority::createRootCA(
        $keyPair,
        $caSubjectData,
        $notBefore,
        $notAfter,
        $caExtensions
    );
} catch (\Tourze\TLSCertGeneration\Exception\CertificateGenerationException $e) {
    echo "实现待完成：" . $e->getMessage();
}
```

### 生成 CSR

```php
<?php

use Tourze\TLSCertGeneration\CSR\CSRGenerator;
use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPair;

$csrGenerator = new CSRGenerator();

$subjectData = [
    'CN' => 'api.example.com',
    'O' => 'Example Corp',
    'C' => 'US'
];

// 生成 CSR（实现完成前会抛出异常）
try {
    $csr = $csrGenerator->createCSR($keyPair, $subjectData);
    
    // 验证 CSR 格式（同样会抛出异常）
    if ($csrGenerator->verifyCSRSignature($csr)) {
        echo "CSR 签名有效";
    }
} catch (\Tourze\TLSCertGeneration\Exception\CertificateGenerationException $e) {
    echo "实现待完成：" . $e->getMessage();
}
```

## API 参考

### CertificateGenerator

- `createSelfSigned()` - 生成自签名证书
- `createFromCSR()` - 从 CSR 创建证书
- `renewCertificate()` - 续签现有证书

### CertificateAuthority

- `issueCertificate()` - 从 CSR 签发证书
- `createRootCA()` - 创建根 CA 证书
- `getCertificate()` - 获取 CA 证书
- `getKeyPair()` - 获取 CA 密钥对

### CSRGenerator

- `createCSR()` - 生成证书签名请求
- `extractSubject()` - 从 CSR 提取主体信息
- `verifyCSRSignature()` - 验证 CSR 签名

## 开发状态

**当前状态**：API 设计完成 - 实现待完成

该包目前提供：
- ✅ 完整的 API 设计和接口
- ✅ 类型安全的方法签名（PHP 8.1+ 特性）
- ✅ 全面的 PHPDoc 文档
- ✅ 异常处理结构
- ✅ 单元测试框架（11 个测试全部通过）
- ✅ PHPStan level 5 合规
- ⏳ **所有核心方法抛出 `CertificateGenerationException("方法尚未实现")`**
- ⏳ 核心证书操作的实现待完成

### 已完成的部分
- 包结构和自动加载
- 类型定义和接口
- 异常处理
- 所有类的基本实例化
- 开发工具配置（PHPStan、PHPUnit）

### 尚未实现的部分
- 证书生成（`createSelfSigned()`、`createFromCSR()`、`renewCertificate()`）
- CSR 操作（`createCSR()`、`extractSubject()`、`verifyCSRSignature()`）
- 证书颁发机构操作（`issueCertificate()`、`createRootCA()`）

### 实现依赖
该包依赖几个可能也在开发中的 TLS 包：
- `tourze/tls-common` - 通用 TLS 工具
- `tourze/tls-crypto-asymmetric` - 非对称加密操作
- `tourze/tls-crypto-random` - 随机数生成
- `tourze/tls-x509-core` - X.509 证书核心功能

## 贡献指南

欢迎贡献！请确保：

1. **遵循 PSR 标准** - PSR-4 自动加载、PSR-12 编码风格
2. **保持类型安全** - 使用严格类型和正确的类型提示
3. **编写测试** - 为新功能包含单元测试
4. **更新文档** - 保持 README 和 PHPDoc 最新

## 许可证

MIT 许可证。详细信息请查看 [License 文件](LICENSE)。