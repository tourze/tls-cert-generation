# TLS-Cert-Generation 开发文档

## 简介

`tls-cert-generation` 是负责 TLS 证书生成的专用模块。本模块提供完整的证书生成能力，包括自签名证书生成、证书签名请求(CSR)处理、CA功能等。

## 依赖关系

- `tls-common`: 提供基础数据结构和工具函数
- `tls-crypto-asymmetric`: 提供非对称加密支持，如RSA/ECDSA密钥对
- `tls-crypto-random`: 提供密码学安全的随机数生成器
- `tls-x509-core`: 提供X.509证书核心数据结构

## 核心模块设计

### 1. 证书生成器 (CertificateGenerator)

**职责**：
- 创建自签名证书
- 从CSR创建证书
- 证书续签
- 生成证书模板

### 2. CSR处理 (CSRGenerator)

**职责**：
- 创建证书签名请求(CSR)
- 解析CSR
- 验证CSR签名
- 从CSR提取信息

### 3. 证书颁发机构 (CertificateAuthority)

**职责**：
- 管理CA密钥和证书
- 签发和吊销证书
- 创建证书链
- 根证书管理

## 详细API设计

### CertificateGenerator

```php
public function createSelfSigned(
    KeyPair $keyPair,
    array $subjectData,
    \DateTimeInterface $notBefore,
    \DateTimeInterface $notAfter,
    array $extensions = []
): X509Certificate;

public function createFromCSR(
    string $csr,
    KeyPair $caKeyPair,
    X509Certificate $caCertificate,
    \DateTimeInterface $notBefore,
    \DateTimeInterface $notAfter,
    array $extensions = []
): X509Certificate;

public function renewCertificate(
    X509Certificate $certificate,
    KeyPair $caKeyPair,
    X509Certificate $caCertificate,
    \DateTimeInterface $notBefore,
    \DateTimeInterface $notAfter,
    array $extensions = []
): X509Certificate;
```

### CSRGenerator

```php
public function createCSR(
    KeyPair $keyPair,
    array $subjectData,
    array $extensions = []
): string;

public function extractSubject(string $csr): array;

public function verifyCSRSignature(string $csr): bool;
```

### CertificateAuthority

```php
public function __construct(
    KeyPair $keyPair,
    X509Certificate $certificate,
    ?CertificateGenerator $certificateGenerator = null
);

public function issueCertificate(
    string $csr,
    \DateTimeInterface $notBefore,
    \DateTimeInterface $notAfter,
    array $extensions = []
): X509Certificate;

public static function createRootCA(
    KeyPair $keyPair,
    array $subjectData,
    \DateTimeInterface $notBefore,
    \DateTimeInterface $notAfter,
    array $extensions = []
): self;

public function getCertificate(): X509Certificate;

public function getKeyPair(): KeyPair;
```

## 开发计划

1. 实现基础证书生成功能
   - 自签名证书生成
   - CSR创建和处理
   - 证书续签

2. 实现CA功能
   - 根CA证书创建
   - 中间CA证书链
   - 证书签发

3. 扩展支持
   - 标准X.509扩展支持
   - 自定义扩展支持
   - 证书约束实现

4. 高级功能
   - 吊销列表生成
   - 证书模板
   - 批量签发工具

## 测试计划

- 单元测试：测试每个核心类和方法
- 集成测试：测试完整的证书生成和签发流程
- 互操作性测试：确保生成的证书兼容主流SSL/TLS实现

## 注意事项

- 密码学操作需要使用加密安全的随机数源
- 遵循X.509标准和RFC规范
- 考虑兼容性和安全最佳实践 