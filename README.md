# TLS Cert Generation

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/tls-cert-generation.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-cert-generation)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/tls-cert-generation.svg?style=flat-square)](https://packagist.org/packages/tourze/tls-cert-generation)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%205-brightgreen.svg?style=flat-square)](https://phpstan.org/)
[![PHP Version](https://img.shields.io/badge/PHP-%5E8.1-blue.svg?style=flat-square)](https://php.net/)
[![License](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE)
[![Code Coverage](https://img.shields.io/badge/Coverage-100%25-brightgreen.svg?style=flat-square)](https://phpunit.de/)

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start)
  - [Creating a Self-Signed Certificate](#creating-a-self-signed-certificate)
  - [Creating a Certificate Authority](#creating-a-certificate-authority)
  - [Generating CSR](#generating-csr)
- [API Reference](#api-reference)
  - [CertificateGenerator](#certificategenerator)
  - [CertificateAuthority](#certificateauthority)
  - [CSRGenerator](#csrgenerator)
- [Development Status](#development-status)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

A PHP library for TLS/SSL certificate generation and management. This package provides a structured API for creating self-signed certificates, managing Certificate Authorities (CA), and handling Certificate Signing Requests (CSR).

> **Note**: This package is currently in development. The API is defined but implementation is pending.

## Features

- **Self-signed Certificate Generation** - Create self-signed X.509 certificates
- **Certificate Authority (CA) Management** - Simple CA creation and certificate issuance
- **Certificate Signing Request (CSR)** - Generate and process CSR files
- **Certificate Renewal** - Extend certificate validity periods
- **Extensible Architecture** - Support for custom certificate extensions
- **Type-safe API** - Full PHP 8.1+ type declarations with strict typing
- **Comprehensive Error Handling** - Dedicated exception classes for different failure scenarios
- **Modular Design** - Integrates seamlessly with other TLS-related packages

## Requirements

- **PHP**: 8.1 or higher
- **Dependencies**:
  - `tourze/tls-common` - Common TLS utilities and constants
  - `tourze/tls-crypto-asymmetric` - Asymmetric cryptography operations
  - `tourze/tls-crypto-random` - Cryptographically secure random number generation
  - `tourze/tls-x509-core` - X.509 certificate core structures
- **Development Dependencies**:
  - `phpstan/phpstan` ^2.1 - Static analysis
  - `phpunit/phpunit` ^11.5 - Unit testing framework

## Installation

```bash
composer require tourze/tls-cert-generation
```

## Quick Start

> **Important**: The examples below show the intended API usage, but will currently throw `CertificateGenerationException` as the implementation is not yet complete.

### Creating a Self-Signed Certificate

```php
<?php

use Tourze\TLSCertGeneration\Generator\CertificateGenerator;
use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPair;

// Generate a key pair (requires tls-crypto-asymmetric implementation)
$keyPair = new KeyPair($privateKey, $publicKey);

// Set certificate subject information
$subjectData = [
    'CN' => 'example.com',
    'O' => 'Example Organization',
    'OU' => 'IT Department',
    'C' => 'US',
];

// Set validity period
$notBefore = new DateTimeImmutable();
$notAfter = $notBefore->modify('+1 year');

// Create certificate generator
$generator = new CertificateGenerator();

// Generate self-signed certificate
// Note: This will throw CertificateGenerationException("方法尚未实现") until implementation is complete
try {
    $certificate = $generator->createSelfSigned(
        $keyPair,
        $subjectData,
        $notBefore,
        $notAfter
    );
} catch (CertificateGenerationException $e) {
    // Handle implementation pending status
    echo "Implementation pending: " . $e->getMessage();
}
```

### Creating a Certificate Authority

```php
<?php

use Tourze\TLSCertGeneration\CA\CertificateAuthority;
use Tourze\TLSCryptoAsymmetric\KeyPair\KeyPair;

// CA subject information
$caSubjectData = [
    'CN' => 'Example Root CA',
    'O' => 'Example Certificate Authority',
    'C' => 'US',
];

// CA validity period (typically longer)
$notBefore = new DateTimeImmutable();
$notAfter = $notBefore->modify('+10 years');

// CA extensions
$caExtensions = [
    'basicConstraints' => ['CA' => true, 'pathLength' => 3],
    'keyUsage' => ['keyCertSign', 'cRLSign'],
];

// Create root CA
$ca = CertificateAuthority::createRootCA(
    $keyPair,
    $caSubjectData,
    $notBefore,
    $notAfter,
    $caExtensions
);
```

### Generating CSR

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

// Generate CSR
$csr = $csrGenerator->createCSR($keyPair, $subjectData);

// Validate CSR format
if ($csrGenerator->verifyCSRSignature($csr)) {
    echo "CSR signature is valid";
}
```

## API Reference

### CertificateGenerator

- `createSelfSigned()` - Generate self-signed certificates
- `createFromCSR()` - Create certificates from CSR
- `renewCertificate()` - Renew existing certificates

### CertificateAuthority

- `issueCertificate()` - Issue certificates from CSR
- `createRootCA()` - Create root CA certificates
- `getCertificate()` - Get CA certificate
- `getKeyPair()` - Get CA key pair

### CSRGenerator

- `createCSR()` - Generate certificate signing requests
- `extractSubject()` - Extract subject information from CSR
- `verifyCSRSignature()` - Validate CSR signatures

## Development Status

**Current Status**: API Design Phase

This package currently provides:
- ✅ Complete API design and interfaces
- ✅ Type-safe method signatures with PHP 8.1+ features
- ✅ Comprehensive PHPDoc documentation
- ✅ Exception handling structure
- ✅ Unit test framework (11 tests, 19 assertions)
- ✅ PHPStan Level 5 compliance
- ✅ PSR-4 autoloading configuration
- ⏳ Implementation pending for core certificate operations

**Implementation Notes**:
- All core methods currently throw `CertificateGenerationException` with message "方法尚未实现"
- The package structure and interfaces are production-ready
- Tests verify proper exception handling and class instantiation

## Testing

Run the test suite:

```bash
# Run all tests
./vendor/bin/phpunit packages/tls-cert-generation/tests

# Run PHPStan analysis
php -d memory_limit=2G ./vendor/bin/phpstan analyse packages/tls-cert-generation
```

**Test Coverage**:
- Basic class instantiation
- Exception handling for unimplemented methods
- CSR format validation
- Constructor parameter validation

## Contributing

Contributions are welcome! Please ensure:

1. **Follow PSR standards** - PSR-4 autoloading, PSR-12 coding style
2. **Maintain type safety** - Use strict types (`declare(strict_types=1)`)
3. **Write tests** - Include unit tests for new functionality
4. **Update documentation** - Keep README and PHPDoc current
5. **PHPStan compliance** - Ensure Level 5 static analysis passes
6. **Chinese comments** - Core implementation uses Chinese comments for consistency

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.