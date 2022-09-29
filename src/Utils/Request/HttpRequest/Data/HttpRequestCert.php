<?php


namespace App\Utils\Request\HttpRequest\Data;

/**
 * Class HttpRequestCert
 *
 * @package App\Utils\Request\HttpRequest\Data
 */
class HttpRequestCert
{
    /**
     * @var string|null
     */
    private $certificate;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @return string|null
     */
    public function getCertificate(): ?string
    {
        return $this->certificate;
    }

    /**
     * @param string|null $certificate
     * @return HttpRequestCert
     */
    public function setCertificate(?string $certificate): HttpRequestCert
    {
        $this->certificate = $certificate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return HttpRequestCert
     */
    public function setPassword(?string $password): HttpRequestCert
    {
        $this->password = $password;
        return $this;
    }
}