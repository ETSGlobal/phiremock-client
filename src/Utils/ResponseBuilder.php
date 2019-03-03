<?php
/**
 * This file is part of Phiremock.
 *
 * Phiremock is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phiremock is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Phiremock.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Mcustiel\Phiremock\Client\Utils;

use Mcustiel\Phiremock\Domain\Http\BinaryBody;
use Mcustiel\Phiremock\Domain\Http\Body;
use Mcustiel\Phiremock\Domain\Http\Header;
use Mcustiel\Phiremock\Domain\Http\HeaderName;
use Mcustiel\Phiremock\Domain\Http\HeadersCollection;
use Mcustiel\Phiremock\Domain\Http\HeaderValue;
use Mcustiel\Phiremock\Domain\Http\StatusCode;
use Mcustiel\Phiremock\Domain\Options\Delay;
use Mcustiel\Phiremock\Domain\Options\ScenarioState;
use Mcustiel\Phiremock\Domain\Response;

class ResponseBuilder
{
    /**
     * @var \Mcustiel\Phiremock\Domain\Response
     */
    private $response;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $scenarioState;

    /**
     * @param int $statusCode
     */
    public function __construct(StatusCode $statusCode)
    {
        $this->headers = new HeadersCollection();
        $this->response = new Response();
        $this->response->setStatusCode($statusCode);
    }

    /**
     * @param int $statusCode
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public static function create($statusCode)
    {
        return new static(new StatusCode($statusCode));
    }

    /**
     * @param string $body
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andBody($body)
    {
        $this->response->setBody(new Body($body));

        return $this;
    }

    /**
     * @param string $body
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andBinaryBody($body)
    {
        $this->response->setBody(new BinaryBody($body));

        return $this;
    }

    /**
     * @param string $header
     * @param string $value
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andHeader($header, $value)
    {
        $this->response->getHeaders()
            ->setHeader(
                new Header(new HeaderName($header), new HeaderValue($value))
            );

        return $this;
    }

    /**
     * @param int $delay
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andDelayInMillis($delay)
    {
        $this->response->setDelayMillis(new Delay($delay));

        return $this;
    }

    /**
     * @param string $scenarioState
     *
     * @return \Mcustiel\Phiremock\Client\Utils\ResponseBuilder
     */
    public function andSetScenarioStateTo($scenarioState)
    {
        $this->scenarioState = new ScenarioState($scenarioState);

        return $this;
    }

    /**
     * @return ResponseBuilderResult
     */
    public function build()
    {
        return new ResponseBuilderResult($this->response, $this->scenarioState);
    }
}
