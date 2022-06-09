<?php

declare(strict_types=1);

namespace Lilith\Http;

use CurlHandle;
use Lilith\Http\Message\RequestInterface;
use Lilith\Http\Message\Response;
use Lilith\Http\Message\ResponseInterface;

class RequestSender implements RequestSenderInterface
{
    public function send(RequestInterface $request): ResponseInterface
    {
        $handle = curl_init($request->getUri());
        $noResponseBodyMode = in_array($request->getMethod(), [HttpMethods::HEAD, HttpMethods::TRACE], true);

        $headers = [];
        $headerParser = function (CurlHandle $curl, string $header) use (&$headers) {
            $headerList = explode(':', $header, 2);

            if (count($headerList) < 2) {
                return strlen($header);
            }

            $headers[strtolower(trim($headerList[0]))] = trim($headerList[1]);

            return strlen($header);
        };

        $options = [
            CURLOPT_CUSTOMREQUEST => $request->getMethod(),
            CURLOPT_URL => $request->getUri(),
            CURLOPT_HEADEROPT => $request->getHeaders(),
            CURLOPT_HTTP_VERSION => $this->getCurlProtocolVersion($request->getProtocolVersion()),
            CURLOPT_HEADERFUNCTION => $headerParser,
            CURLOPT_RETURNTRANSFER => true,
        ];

        if ($request->getBody() !== null) {
            $options[CURLOPT_POSTFIELDS] = $request->getBody();
        }

        if ($noResponseBodyMode) {
            $options[CURLOPT_NOBODY] = true;
            $options[CURLOPT_RETURNTRANSFER] = false;
        }

        curl_setopt_array($handle, $options);
        $responseBody = curl_exec($handle);
        $responseCode = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);

        if ($noResponseBodyMode) {
            $responseBody = null;
        }

        if(curl_errno($handle) !== 0) {
            throw new CurlRequestError('Error curl: ' . curl_error($handle));
        }

        unset($handle);

        return new Response($responseCode, $headers, $responseBody);
    }

    protected function getCurlProtocolVersion(string $protocolVersion): int
    {
        return match ($protocolVersion) {
            '1.0' => CURL_HTTP_VERSION_1_0,
            '2.0' => CURL_HTTP_VERSION_2_0,
            default => CURL_HTTP_VERSION_1_1,
        };
    }
}
