<?php
require "base64.php";

class JWT
{
    use Base64Url;

    protected $header;
    protected $signature;
    protected $payload;
    protected $secret;
    protected $expirationTime;

    public function __construct($payload = null)
    {
        $this
            ->setHeader()
            ->setPayload($payload)
            ->setSecretKey("secret")
            ->setExpirationTime()
            ->setSignature();
    }

    public function getExpirationTime()
    {
        return $this->expirationTime;
    }

    public function setExpirationTime($time = null)
    {
        $this->expirationTime = $time ?? time() + 3600; // 1 hour ( default ) 
        return $this;
    }

    public function getPayload()
    {
        return json_decode($this->base64UrlDecode($this->payload), true);
    }

    public function setPayload($payload)
    {
        $this->payload = $this->base64UrlEncode(json_encode($payload));
        return $this;
    }

    public function getSecretKey()
    {
        return $this->secret;
    }

    public function setSecretKey($secret)
    {
        $this->secret = $secret;
        return $this;
    }

    public function getHeader()
    {
        return json_decode($this->base64UrlDecode($this->header), true);
    }

    public function setHeader($payload = null)
    {
        $header = json_encode($payload ?? [
            "alg" => "HS256",
            "typ" => "JWT"
        ]);
        $this->header = $this->base64UrlEncode($header);
        return $this;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($hashMethod = null)
    {
        $data = $this->header . "." . $this->payload;
        $signature = hash_hmac($hashMethod ?? "sha256", $data, $this->secret, true);
        $this->signature = $this->base64UrlEncode($signature);
        return $this;
    }

    public function generateToken(): string
    {
        return $this->header . "." . $this->payload . "." . $this->signature;
    }

    public function verifyToken($token)
    {
        list($header64, $payload64, $signature64) = explode('.', $token);

        $signature = $this->base64UrlDecode($signature64);

        $data = $header64 . '.' . $payload64;
        $expectedSignature = hash_hmac('sha256', $data, $this->secret, true);

        return hash_equals($signature, $expectedSignature);
    }

    public function decodeToken($token)
    {
        list(, $payload64,) = explode('.', $token);

        $payload = json_decode($this->base64UrlDecode($payload64), true);

        return $payload;
    }
}
