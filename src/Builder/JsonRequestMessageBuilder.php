<?php

declare(strict_types=1);

namespace Lilith\Http\Builder;

use JsonException;
use Lilith\Http\Message\Request;
use Lilith\Http\Message\RequestInterface;

use function Lilith\Common\Functions\json_encode;

class JsonRequestMessageBuilder extends HttpRequestMessageBuilder
{
    /**
     * @throws JsonException
     */
    public function create(): RequestInterface
    {
        $method = $this->method;
        $url = $this->url;
        $body = $this->body;

        if ($this->query !== null) {
            $url .= '?' . http_build_query($this->query);
        }

        if ($this->body !== null) {
            $body = json_encode($this->body);
        }

        if ($this->files !== null) {
            //@TODO multiple/form-data
        }

        $requestMessage = new Request($method, $url, $this->headers, $body, $this->protocolVersion);
        $this->clear();

        return $requestMessage;
    }
}
